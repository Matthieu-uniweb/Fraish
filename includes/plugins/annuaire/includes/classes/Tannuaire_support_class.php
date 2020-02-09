<?
/**
* Classe permetant la gestion des supports de l'annuaire
*
* @author  Thomas Vendé <thomas.vende@laetis.fr>
* @see T_LAETIS_site::modifierAttributs()
*/

class Tannuaire_support extends Tannuaire_moteur_recherche
	{
	/** 
	* @var int $ID ID de l'element en base de donnée
	* @access  private 
	*/
	var $ID;
	
	/** 
	* @var string $libelle Libelle de la catégorie
	* @access  private 
	*/
	var $libelle;
	
	/** 
	* Constructeur de l'objet
	* @param int $ID (facultatif) ID de l'element à initialiser (si non renseigné, aucune initialisation)
	* @return Tannuaire_support l'objet créé
	* @access  public 
	*/
	function __construct($ID = 0)
		{
		$this->ID = $ID;
		$this->initialiser($ID);
		}

	/** 
	* Initialisation de l'objet
	* @param int $ID (facultatif) ID de l'element à initialiser (si non renseigné, aucune initialisation)
	* @return Tannuaire_categorie l'objet créé
	* @access  public 
	*/
	function initialiser($ID)
		{
		//si on a donné un parametre, on instancie par rapport à la base
		if($ID != 0)
			{
			$sql = "SELECT * FROM annuaire_obj_support WHERE ID = ".$ID;
			$result = $this->query($sql);
			$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
			$this->libelle = $row['libelle'];
			}
		}
		
	/** 
	* Alias du constructeur (compatibilité PHP4)
	* @param int $ID (facultatif) ID de l'element à initialiser (si non renseigné, aucune initialisation)
	* @return Tannuaire_support l'objet créé
	* @see Tannuaire_support::__construct()
	* @access  public 
	*/
	function Tannuaire_support($ID = 0)
		{
		$this->__construct($ID);
		}
	
	/** 
	* Enregistre l'objet en base de donnée
	* Si l'ID est renseigné ==> modification
	* Sinon ==> insertion
	* @access  public 
	*/
	function enregistrer()
		{
		//si l'ID est renseigné, on modifie, sinon, on insere
		if($this->ID == 0)
			{
			$sql = "INSERT INTO annuaire_obj_support ( ID , libelle ) 
					VALUES ('', '".$this->libelle."');";
			$result = $this->query($sql);
			$this->ID = $this->last_insert_id();
			}
		else //on modifie
			{
			$sql = "UPDATE annuaire_obj_support SET 
					libelle = '".$this->libelle."'
					WHERE ID = ".$this->ID;
			$result = $this->query($sql);
			}
		}
	
	/** 
	* Supprime l'objet en base de donnée (mais ne détruit pas l'objet PHP)
	* Le support et toutes ses catégories sont supprimées.
	* Cette méthode remet l'ID à 0, pour une re-enregistrement éventuel
	* @access  public 
	*/
	function supprimer()
		{
		$sql = "DELETE FROM annuaire_obj_support WHERE ID = ".$this->ID;
		$result = $this->query($sql);
		
		$categories = $this->listerToutesCategoriesFille();
		for ($i=0; $i<count($categories); $i++)
			{
			$categorie = new Tannuaire_categorie($categories[$i]);
			$categorie->supprimer();
			}

		$this->ID = 0;
		}

	/** 
	* Nettoyer les supports non utilisés
	* @access  public 
	*/
	function nettoyerLiensSupports()
		{
		$sql = "SELECT ID FROM annuaire_obj_support";
		$result = $this->query($sql);
		while($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
			{
			$sql2 = "SELECT ID_support FROM annuaire_rel_categorie_support WHERE ID_support = '".$row['ID']."'";
			$result2 = $this->query($sql2);
			
			if ($result2->numRows() == '0')
				{
				//echo "Suppression du support ".$row['ID']."<br>";
				$support = new Tannuaire_support($row['ID']);
				$support->supprimer();
				}
			}

		$sql = "SELECT ID_support FROM annuaire_rel_categorie_support";
		$result = $this->query($sql);
		while($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
			{
			$sql2 = "SELECT ID FROM annuaire_obj_support WHERE ID = '".$row['ID_support']."'";
			$result2 = $this->query($sql2);
			
			if ($result2->numRows() == '0')
				{
				//echo "Suppression du support ".$row['ID']."<br>";
				$support = new Tannuaire_support($row['ID_support']);
				$support->supprimer();
				}
			}
		}

	/** 
	* Permet de lier une catégorie à un support
	* @param int $ID_categorie ID de la catégorie à lier au support
	* @param int $ordre Ordre de la catégorie pour ce support
	* @access  public 
	*/
	function lierCategorie($ID_categorie, $ordre)
		{
		$sql = "SELECT * FROM annuaire_rel_categorie_support 
						WHERE ID_support = '".$this->ID."' AND ID_categorie = '".$ID_categorie."'";
		$result = $this->query($sql);

		//on update
		if($result->numRows() != 0)
			{
			$sql = "UPDATE annuaire_rel_categorie_support 
							SET ordre = '".$ordre."' 
							WHERE ID_support = '".$this->ID."' AND ID_categorie = '".$ID_categorie."'";
			}
		else //on insere
			{
			$sql = "INSERT INTO annuaire_rel_categorie_support (ID_support,ID_categorie,ordre) 
							VALUES ('".$this->ID."','".$ID_categorie."','".$ordre."')";
			}
		$result = $this->query($sql);
		}	

	/** 
	* Renvoie la liste des catégories directement filles
	* @return Array composé des ID et libellés des catégories filles
	* @access  public 
	*/
	function listerSupport()
		{
		$sql = "SELECT * FROM annuaire_obj_support ORDER BY ID";
		$result = $this->query($sql);
		while($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
			{
			$retour[] = $row;
			}
		return $retour;
		}

	/** 
	* Renvoie la liste des catégories directement filles
	* @return Array composé des ID et libellés des catégories filles
	* @access  public 
	*/
	function listerCategoriesFille()
		{
		$sql = "SELECT * FROM annuaire_rel_categorie_support WHERE ID_support = ".$this->ID." ORDER BY ordre";
		$result = $this->query($sql);
		while($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
			{
			$retour[] = $row;
			}
		return $retour;
		}
	
	/** 
	* Renvoie la liste de toutes les catégories filles
	* @return Array composé des ID
	* @access  public 
	*/
	function listerToutesCategoriesFille()
		{
		$sql = "SELECT * FROM annuaire_rel_categorie_support WHERE ID_support = '".$this->ID."' ORDER BY ordre";
		$result = $this->query($sql);
		while($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
			{
			$categorie = new Tannuaire_categorie($row['ID_categorie']);
			$retour = array_merge($retour,$categorie->listerToutesCategoriesFille());
			}
		if ($retour)
			{ return array_unique($retour); }
		else
			{ return 0; }
		}
	
	/** 
	* Renvoie le code html permetant d'afficher l'arbre des catégories
	* @return string html généré
	* @param string $nomTableau nom du tableau contenant les inputs
	* @access  public 
	*/
	function genererHtml($nomTableau)
		{
		$html = '';
		$liste = $this->listerCategoriesFille();
		for($i = 0; $i < sizeof($liste); $i++)
			{
			$categorie = new Tannuaire_categorie($liste[$i]['ID_categorie']);
			$html .= $categorie->genererHtml($nomTableau);
			}
		return $html;
		}

	/** 
	* Renvoie le code html permetant d'afficher l'arbre des catégories
	* @return string html généré
	* @param string $nomTableau nom du tableau contenant les inputs
	* @access  public 
	*/
	function genererHtmlAdminBack()
		{
		$html = '';
		$html .= '<table width="100%" border="0" align="center" cellpadding="0">';
		$liste = $this->listerCategoriesFille();
		for($i = 0; $i < sizeof($liste); $i++)
			{
			$categorie = new Tannuaire_categorie($liste[$i]['ID_categorie']);
			$cpt = 0;
			$html .= $categorie->genererHtmlAdminBack($cpt, 0, $liste[$i]['ordre']);
			}
		$html .= '</table>';
		return $html;
		}

	/** 
	* Renvoie le code html permettant d'afficher l'arbre des catégories
	* @param $guide nom du guide (CSS)
	* @return string html généré
	* @access  public 
	*/
	function genererHtmlBack($guide,$couleur,$nomTableau,$ID_service,$ID_support,$ouvert)
		{
		$html = '';
		$liste = $this->listerCategoriesFille();
		for($i = 0; $i < sizeof($liste); $i++)
			{
			$categorie = new Tannuaire_categorie($liste[$i]['ID_categorie']);
			$html .= $categorie->genererHtmlBack($guide,$couleur,$nomTableau,$ID_service,$ID_support,$ouvert);
			}
		return $html;
		}

	/** 
	* Renvoie le code html permettant d'afficher la liste des catégories
	* @param $guide nom du guide (CSS)
	* @return string html généré
	* @access  public 
	*/
	function genererHtmlListe($ID_service)
		{
		$html = '';
		$liste = $this->listerCategoriesFille();
		for($i = 0; $i < sizeof($liste); $i++)
			{
			$categorie = new Tannuaire_categorie($liste[$i]['ID_categorie']);
			$html .= $categorie->genererHtmlListe($ID_service);
			}
		return $html;
		}

	/** 
	* Renvoie le code html permetant d'afficher l'arbre des catégories
	* @param $guide nom du guide (CSS)
	* @return string html généré
	* @access  public 
	*/
	function genererHtmlFront($guide,$couleur,$ID_categorie='')
		{
		$html = '';
		$liste = $this->listerCategoriesFille();

		for($i = 0; $i < sizeof($liste); $i++)
			{
			if ( ($ID_categorie) && (!(in_array($liste[$i]['ID_categorie'], $ID_categorie))) )
				{	}
			else
				{
				$categorie = new Tannuaire_categorie($liste[$i]['ID_categorie']);
				$html .= $categorie->genererHtmlFront($guide,$couleur,$ID_categorie);
				} // FIN else
			}			
		return $html;
		}

	/** 
	* Renvoie le code html permetant d'afficher l'arbre des catégories
	* @param $guide nom du guide (CSS)
	* @return string html généré
	* @access  public 
	*/
	function genererHtmlSupportEntier($option='')
		{
		$html = '';
		$liste = $this->listerCategoriesFille();
		for($i = 0; $i < sizeof($liste); $i++)
			{
			$categorie = new Tannuaire_categorie($liste[$i]['ID_categorie']);
			$html .= $categorie->genererHtmlSupportEntier($option);
			}
		return $html;
		}

	/** 
	* Renvoie le code html permetant d'afficher l'arbre des catégories
	* @return array retour
	* @access  public 
	*/
	function genererSupportEntier()
		{
		$retour = array();
		$liste = $this->listerCategoriesFille();
		for($i = 0; $i < sizeof($liste); $i++)
			{
			$categorie = new Tannuaire_categorie($liste[$i]['ID_categorie']);
			$retour = array_merge($retour, $categorie->genererSupportEntier());
			}
		return $retour;
		}

	}
?>