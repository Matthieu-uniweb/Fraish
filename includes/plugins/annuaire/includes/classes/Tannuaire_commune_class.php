<?
/**
* Classe permetant la gestion des communes dans l'annuaire
*
* @author  Thomas Vendé <thomas.vende@laetis.fr>
* @see T_LAETIS_site::modifierAttributs()
*/
class Tannuaire_commune extends T_LAETIS_site
	{
	/** 
	* @var int $ID ID de l'element en base de donnée
	* @access  private 
	*/
	var $ID;
		
	/** 
	* @var string $nom Nom de la commune
	* @access  private 
	*/
	var $nom;

	/** 
	* @var string $inseeCommune Code insee de la commune
	* @access  private 
	*/
	var $inseeCommune;

	/** 
	* @var string $inseeCommune Code insee de la commune
	* @access  private 
	*/
	var $codePostalDefaut;

	/** 
	* Constructeur de l'objet
	* @param int $ID (facultatif) ID de l'element à initialiser (si non renseigné, aucune initialisation)
	* @return Tannuaire_commune l'objet créé
	* @access  public 
	*/
	function __construct($ID = 0)
		{
		$this->ID = $ID;
		//si on a donné un parametre, on instancie par rapport à la base
		if($ID != 0)
			{
			$sql = "SELECT * FROM obj_commune WHERE ID = ".$ID;
			$result = $this->query($sql);
			$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
			$this->nom = $row['nom'];
			$this->inseeCommune = $row['inseeCommune'];
			$this->codePostalDefaut = $row['codePostalDefaut'];
			}
		}
	
	/** 
	* Alias du constructeur (compatibilité PHP4)
	* @param int $ID (facultatif) ID de l'element à initialiser (si non renseigné, aucune initialisation)
	* @return Tannuaire_commune l'objet créé
	* @see Tannuaire_commune::__construct()
	* @access  public 
	*/
	function Tannuaire_commune($ID = 0)
		{
		$this->__construct($ID);
		}
		
	/** 
	* Lister les communes
	* @param
	* @access  public 
	*/
	function listerCommune()
		{
		$query = "SELECT * FROM obj_commune ORDER BY nom ASC";
		$res=$this->query($query);
		while ($row=$res->fetchRow(DB_FETCHMODE_ASSOC))
			{
			$result[] = new Tannuaire_commune($row['ID']);
			}
		$res->free(DB_Result);
		return $result;
		}

	/** 
	* Lister les communes
	* @param
	* @access  public 
	*/
	function listerCommunes()
		{
		$query = "SELECT * FROM obj_commune ORDER BY nom ASC";
		$res=$this->query($query);
		while ($row=$res->fetchRow(DB_FETCHMODE_ASSOC))
			{
			$result[] = $row;
			}
		$res->free(DB_Result);
		return $result;
		}

	/** 
	* Lister les communes pour la cartographie
	* @return array La liste des communes avec leur nom  et leur code insee
	* @access  public 
	*/
	function listerCommuneCarto()
		{
		$listeCommunes = array();

		$listesCommunes[0]['commune'] = 'Toutes les communes';
		$listesCommunes[0]['inseeCommune'] = '9999';
		
		$commune = new Tcommune();
		$communes = $commune->listerCommune();
		for ($j=0; $j<count($communes); $j++)
			{
			$k = $j+1;
			$listesCommunes[$k]['commune'] = $communes[$j]->nom;
			$listesCommunes[$k]['inseeCommune'] = $communes[$j]->inseeCommune;
			}
		
		return $listesCommunes;
		} // FIN function listerCommuneCarto()

	function traiterNom($chaine) 
		{ 
		return $this->supprimerAccents($chaine); 
		} 
	}
