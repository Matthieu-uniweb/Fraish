<?
/**
* Classe permettant d'administrer les contacts dans l'annuaire
*
* @author  Christophe Raffy <christophe.raffy@laetis.fr>
*/
class Tannuaire_contact_recherche extends Tannuaire_contact
	{

	/** 
	* Alias du constructeur (compatibilité PHP4)
	* @param int $ID (facultatif) ID de l'element à initialiser (si non renseigné, aucune initialisation)
	* @return Tannuaire_contact_recherche l'objet créé
	* @see Tannuaire_contact_recherche::__construct()
	* @access  public 
	*/
	function Tannuaire_contact_recherche($ID = 0)
		{
		$this->__construct($ID);
		}

	/** 
	* Constructeur de l'objet
	* @param int $ID (facultatif) ID de l'element à initialiser (si non renseigné, aucune initialisation)
	* @return Tannuaire_contact_recherche l'objet créé
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
	* Recherche des contacts - recherche sur le nom
	* @param string $requete Requete de recherche
	* @return array de Tannuaire_contact Les contacts trouvés
	* @access  public 
	*/
	function rechercherContact($valeurs)
		{
		$sql = "SELECT ID FROM annuaire_obj_contact 
						WHERE LOWER(nom) 
						LIKE LOWER('".trim($valeurs['recherche'])."%')
						ORDER BY nom, prenom ASC";
		$sql.=$this->creerLimite($valeurs, $sql);
		$result = $this->query($sql);
		while($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
			{
			$retour[] = new Tannuaire_contact_recherche($row['ID']);
			}
		return($retour);
		}

	/** 
	* Lister les structures et services auquels est lié un contact
	* @return array Tableau contenant les ID des services 
	* @access  public 
	*/
	function listerStructuresServices()
		{
		$sql = "SELECT annuaire_obj_structure.nom AS nom_structure, annuaire_obj_service.nom AS nom_service
						FROM annuaire_rel_contact_service, annuaire_rel_structure_service, annuaire_obj_structure, annuaire_obj_service
						WHERE annuaire_rel_contact_service.ID_contact = '".$this->ID."'
						AND annuaire_rel_contact_service.ID_service = annuaire_rel_structure_service.ID_service
						AND annuaire_obj_structure.ID = annuaire_rel_structure_service.ID_structure
						AND annuaire_obj_service.ID = annuaire_rel_structure_service.ID_service
						GROUP BY annuaire_obj_structure.ID";
		$result = $this->query($sql);
		while($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
			{
			$retour[] = $row;
			}
		return($retour);
		}

	}
?>