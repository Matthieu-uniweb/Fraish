<?
/**
   *  Classe de gestion des menus du jour
   *
   * Permet de créer, modifier, supprimer des menus du jour, en intéraction 
   * avec la base de données
   *
   * @author Christophe Raffy
   * @version 1.0
   * @access public
   * @copyright Laëtis Créations Multimédias
	 * @date 2007-11-12
   */

class Tbq_menu
	{	

	/** 
	* @var int $ID ID de l'element en base de donnée
	* @access  private 
	*/
	var $ID;
	var $salade;
	var $soupe;
	var $boisson;
	var $dessert;
	var $pain;
	var $eau;
	var $taille;
	/*var $prix;*/
	var $visible;


	/** 
	* Constructeur de l'objet
	* @param int $ID (facultatif) ID de l'element à initialiser (si non renseigné, aucune initialisation)
	* @return Tbq_menujour l'objet créé
	* @access  public 
	*/
	function __construct($ID = 0)
		{
		$this->ID = $ID;
		$this->initialiser($ID);
		}


	function initialiser($ID)
		{
		//si on a donné un parametre, on instancie par rapport à la base
		if ( $this->ID>0 )
			{
			// initialisation de l'objet
			$requete = "SELECT * FROM boutique_obj_menu WHERE ID='".$this->ID."'";
			$resultats = T_LAETIS_site::requeter($requete);
			if ($resultats[0])
				{
				foreach ($resultats[0] as $nomChamp => $valeur)
					{
					$this->$nomChamp = stripslashes($valeur);
					}
				}
			}
		}


	/** 
	* Alias du constructeur (compatibilité PHP4)
	* @param int $ID (facultatif) ID de l'element à initialiser (si non renseigné, aucune initialisation)
	* @return Tbq_menujour l'objet créé
	* @see Tbq_menujour::__construct()
	* @access  public 
	*/
	function Tbq_menu($ID = 0)
		{
		$this->__construct($ID);
		}


	/** 
	* Enregistre l'objet en base de donnée
	* Si l'ID est renseigné ==> modification
	* Sinon ==> insertion
	* @access  public 
	*/
	function enregistrer($valeurs)
		{
		T_LAETIS_site::modifierAttributs($valeurs);
		
		//si l'ID est renseigné, on modifie, sinon, on insere
		$attributs = get_object_vars($this);
		// on donne les champs à mettre à jour (meme syntaxe pour le UPDATE et le INSERT)
		$contenuRequete = "";
		$champsNonEnregistres = array( );
		
		foreach ($attributs as $nom=>$valeur)
			{
			if ( !in_array( $nom, $champsNonEnregistres ) )
				{
				$valeur = "\"".addslashes($valeur)."\"";
				$contenuRequete .= " ,".$nom."=".$valeur;
				}
			}
		
		// on enlève l'espace et la virgule du début
		
		$contenuRequete = substr($contenuRequete,2);
		if ($this->ID>0)
			{
			// c'est un objet qui existe déjà en BD
			$requete = "UPDATE boutique_obj_menu SET ";
			$requete .= $contenuRequete." WHERE ID=".$this->ID;
			$resSql = T_LAETIS_site::requeter($requete);
			}
		else
			{
			// c'est un objet qui n'existe pas en BD
			$requete = "INSERT INTO boutique_obj_menu SET ";
			$requete .= $contenuRequete;
			T_LAETIS_site::requeter($requete);
			$this->ID = T_LAETIS_site::last_insert_id();
			}
		} // FIN function enregistrer()


	/** 
	* Supprime l'objet en base de donnée
	* @access  public 
	*/
	function supprimer()
		{		
		$requete = "DELETE FROM boutique_obj_menujour_v2 WHERE ID='".$this->ID."'";
		T_LAETIS_site::requeter($requete);
		$this->ID = 0;
		}


	/** 
	* Liste les rubriques
	* @access  public 
	*/   
	function lister()
		{		
		$resultats = array();
		$requete = "SELECT ID FROM boutique_obj_menu
					WHERE visible=1";
		$resSql = T_LAETIS_site::requeter($requete);
		foreach ($resSql as $ligne)
			{
			$resultats[] = new Tbq_menu($ligne['ID']);
			}			
		return ($resultats);
		}
	function listerSaufDoublon()
		{
		$resultats = array();
		$requete = "SELECT ID FROM boutique_obj_menu
					WHERE visible=1
					AND ID!='6'";
		$resSql = T_LAETIS_site::requeter($requete);
		foreach ($resSql as $ligne)
			{
			$resultats[] = new Tbq_menu($ligne['ID']);
			}			
		return ($resultats);
		}
	
	/*function getNomFormule()
		{
		if($this->salade)
			{
			$nom = 'salade/';
			}
		if($this->soupe)
			{
			$nom.='soupe/';
			}
		if($this->boisson)
			{
			$nom.='boisson/';
			}
		if($this->dessert)
			{
			$nom.='dessert/';
			}
		if($this->pain)
			{
			$nom.='pain/';
			}
		if($this->eau)
			{
			$nom.='eau/';
			}
		$nom = substr($nom,0,-1);
		return($nom);
		}*/
	function listerFormules()
		{
		$requete = "SELECT *
					FROM typ_formule";
		$resSql = T_LAETIS_site::requeter($requete);
		foreach($resSql as $ligne)
			{
			$resultats[] = $ligne;
			}
		return($resultats);
		}
	function getLibelle()
		{
		//$retour = 'Menu ';
		if($this->salade)
			{
			$retour.='salade, ';
			}
		if($this->soupe)
			{
			$retour.='soupe, ';
			}
		if($this->boisson)
			{
			$retour.='boisson,';
			}
		if($this->dessert)
			{
			$retour.='dessert, ';
			}
		if($this->eau)
			{
			$retour.='eau';
			}
		return($retour);
		}
	}
?>