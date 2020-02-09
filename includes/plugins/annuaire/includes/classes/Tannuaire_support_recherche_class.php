<?
/**
* Classe permettant d'administrer les supports dans l'annuaire
*
* @author  Christophe Raffy <christophe.raffy@laetis.fr>
*/
class Tannuaire_support_recherche extends Tannuaire_support
	{

	/** 
	* Alias du constructeur (compatibilité PHP4)
	* @param int $ID (facultatif) ID de l'element à initialiser (si non renseigné, aucune initialisation)
	* @return Tannuaire_support_recherche l'objet créé
	* @see Tannuaire_support_recherche::__construct()
	* @access  public 
	*/
	function Tannuaire_support_recherche($ID = 0)
		{
		$this->__construct($ID);
		}

	/** 
	* Constructeur de l'objet
	* @param int $ID (facultatif) ID de l'element à initialiser (si non renseigné, aucune initialisation)
	* @return Tannuaire_support_recherche l'objet créé
	* @access  public 
	*/
	function __construct($ID = 0)
		{
		if ($ID)
			{
			$this->ID=$ID;
			$this->initialiser($ID);
			}
		}


	/** 
	* Recherche de structures ou services correspondants aux éléments de recherche
	* @param array $valeurs Les éléments de recherches (sortent d'un formulaire)
	* @return array Les informations sur les éléments trouvés
	* @access  public 
	*/	
	function rechercherCategorie($valeurs)
		{
		$conditionWhereInsee = '1';
		$conditionWhereCategorie = '1';
		$conditionWhereMotCle = '1';		

		$listeCategories = array();
		
		$options = explode(',',$valeurs['options']);

		// Recherche selon le code INSEE de la commune
		if ($valeurs['inseeCommune'])
			{
			// codeInsee 100000 correspond aux "adresses génériques" qui sont affichées tous le temps
			$conditionWhereInsee = "annuaire_obj_adresse.codeInsee IN (".$valeurs['inseeCommune'].",100000)";
			} // if ($valeurs['inseeCommune'])
		
		// Recherche selon la categorie consulte
		// on a traité les communes, maintentant on traite les catégories
		if ($valeurs['ID_categorie_consulte'] != '')
			{
			$listeCategoriesConsultes = explode(',', $valeurs['ID_categorie_consulte']);
			
			for ($k=0; $k<count($listeCategoriesConsultes); $k++)
				{
				$cat = new Tannuaire_categorie($listeCategoriesConsultes[$k]);
				$listeCategories = array_merge($listeCategories, $cat->listerToutesCategoriesFille());
				}
			$listeCategories = array_unique($listeCategories);
			}
		else
			{
			$listeCategories = $this->listerToutesCategoriesFille();
			}

		$requeteCategorie = '';
		for ($i = 0; $i < sizeof($listeCategories); $i++)
			{
			$requeteCategorie .= "'".$listeCategories[$i]."',";
			}
			
		$conditionWhereCategorie = "annuaire_obj_categorie.ID IN (".substr($requeteCategorie, 0, strlen($requeteCategorie)-1).")";
		
		// Recherche selon un mot clé
		if ($valeurs['motCle'])
			{
			$valeurs['motCle'] = trim($this->filtrerCaracteresSpeciaux($valeurs['motCle']));
			$motCles = explode(' ', $valeurs['motCle']);
			for($i = 0; $i < sizeof($motCles); $i++)
				{
				$conditionWhereMotCle .= " AND (annuaire_obj_service.nom LIKE '%".$motCles[$i]."%' OR annuaire_obj_structure.nom LIKE '%".$motCles[$i]."%')";
				}
			}
		
		//maintenant, requete pour récuperer les services
		$sql = "SELECT DISTINCT annuaire_obj_structure.ID AS ID_structure, 
						annuaire_obj_service.ID AS ID_service, 
						annuaire_rel_categorie_service.descriptif AS descriptifCatService,
						annuaire_rel_categorie_service.ID_categorie
						FROM annuaire_obj_service, ";
						
		if ($valeurs['inseeCommune'])
			{
			$sql .= "annuaire_rel_service_adresse, annuaire_obj_adresse, "; 
			}

		$sql .= "annuaire_obj_structure, annuaire_rel_structure_service, 
						annuaire_rel_categorie_service, annuaire_obj_categorie, 
						annuaire_rel_categorie_categorie, annuaire_rel_categorie_support";
						
		$sql .= " WHERE 1 
						AND (".$conditionWhereInsee.") ";

		if ($valeurs['inseeCommune'])
			{
			$sql .= "AND annuaire_obj_service.ID = annuaire_rel_service_adresse.ID_service
						AND annuaire_obj_adresse.ID = annuaire_rel_service_adresse.ID_adresse ";
			}
				
		$sql .= " AND (".$conditionWhereMotCle.") 
						AND annuaire_obj_service.ID = annuaire_rel_structure_service.ID_service
						AND annuaire_obj_structure.ID = annuaire_rel_structure_service.ID_structure
						AND (".$conditionWhereCategorie.")
						AND annuaire_rel_categorie_service.visible = '1' 
						AND annuaire_rel_categorie_service.ID_service = annuaire_obj_service.ID 
						AND annuaire_obj_categorie.ID = annuaire_rel_categorie_service.ID_categorie
						AND ( annuaire_obj_categorie.ID = annuaire_rel_categorie_categorie.ID_categorieFille
						OR annuaire_obj_categorie.ID = annuaire_rel_categorie_support.ID_categorie )
						ORDER BY annuaire_rel_categorie_support.ID_categorie, annuaire_rel_categorie_categorie.ordre, 
						annuaire_obj_categorie.libelle, annuaire_obj_structure.nom, annuaire_obj_service.nom";

		if (! in_array('unePage', $options) )
			{
			$sql.=$this->creerLimite($valeurs, $sql);
			}
			
		//echo $sql;
		
		$result = $this->query($sql);
		while($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
			{
			$retour[] = $row;
			}
		return $retour;
		}


	/** 
	* Générer le html à afficher pour les critères de recherche
	* @param array $valeurs Les éléments de recherches (sortent d'un formulaire)
	* @return string Le code html à afficher
	* @access  public 
	*/	
	function genererCriteresRecherche($valeurs)
		{
		$votreRecherche = '';
		$nomCategorie = '';		
		
		if ($valeurs['motCle'])
			{ $votreRecherche .= "<i>".stripslashes($valeurs['motCle'])."</i><br>"; }
		if($valeurs['ID_categorie_consulte'])
			{
			$votreRecherche .= '<b> dans la (les) catégorie(s) : </b>';
		
			$listeCategoriesConsultes = explode(',', $valeurs['ID_categorie_consulte']);
		
			for ($k=0; $k<count($listeCategoriesConsultes); $k++)
				{
				$categorie = new Tannuaire_categorie($listeCategoriesConsultes[$k]);
				$votreRecherche .= $categorie->libelle.', ';
				$nomCategorie .= $categorie->libelle.', ';
				}
			$votreRecherche = substr($votreRecherche, 0, strlen($votreRecherche)-2);
			$votreRecherche .= '<br>';
			$nomCategorie = substr($nomCategorie, 0, strlen($nomCategorie)-2);
			}
		else if ($_POST['rubrique'] == 'toutes')
			{
			$votreRecherche .= 'dans toutes les catégories<br>';
			}
		
		if ($valeurs['inseeCommune'])
			{
			$commune = new Tcommune();
			$votreRecherche.= '<b>commune(s) : </b>';
			$communes = explode(',', $valeurs['inseeCommune']);
			for ($j=0; $j<count($communes); $j++)
				{
				if ($communes[$j] == '99999')
					{ $votreRecherche.= 'Hors Grand Rodez, '; }
				else
					{
					$resCommune = $commune->getCommune($communes[$j]);
					$votreRecherche.= $resCommune['nom'].', ';
					}
				}
			$votreRecherche= substr($votreRecherche, 0, strlen($votreRecherche)-2);
			}
		else 
			{
			$votreRecherche.= 'sur toutes les communes';
			}
		
		$criteres = array('votreRecherche'=>$votreRecherche, 'nomCategorie'=>$nomCategorie);
		
		return $criteres;
		} // FIN function genererCriteresRecherche($valeurs)
		
	}
?>