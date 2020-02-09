<?
/**
* Classe permettant d'administrer les contacts dans l'annuaire
*
* @author  Christophe Raffy <christophe.raffy@laetis.fr>
*/
class Tannuaire_service_recherche extends Tannuaire_service
	{

	/** 
	* Alias du constructeur (compatibilité PHP4)
	* @param int $ID (facultatif) ID de l'element à initialiser (si non renseigné, aucune initialisation)
	* @return Tannuaire_service_recherche l'objet créé
	* @see Tannuaire_service_recherche::__construct()
	* @access  public 
	*/
	function Tannuaire_service_recherche($ID = 0)
		{
		$this->__construct($ID);
		}

	/** 
	* Constructeur de l'objet
	* @param int $ID (facultatif) ID de l'element à initialiser (si non renseigné, aucune initialisation)
	* @return Tannuaire_service_recherche l'objet créé
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
	* Recherche des services - recherche sur le nom
	* @param string $requete Requete de recherche
	* @return array de Tannuaire_service Les services trouvés
	* @access  public 
	*/
	function rechercherService($valeurs)
		{
		$sql = "SELECT ID FROM annuaire_obj_service 
						WHERE LOWER(nom) 
						LIKE LOWER('".$valeurs['recherche']."%')
						ORDER BY nom ASC";
		$sql.=$this->creerLimite($valeurs, $sql);
		$result = $this->query($sql);
		while($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
			{
			$retour[] = new Tannuaire_service_recherche($row['ID']);
			}
		return($retour);
		}

	}
?>