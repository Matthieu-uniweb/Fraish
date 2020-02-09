<?
/**
   *  Classe de gestion des contacts
   *
   * Permet de créer, modifier, supprimer des contacts, en intéraction 
   * avec la base de données
   *
   * @author Christophe Raffy
   * @version 1.0
   * @access public
   * @copyright Laëtis Créations Multimédias
   */

class Tcontact_contact extends T_LAETIS_site
	{
	/** 
	* @var int $ID ID de l'element en base de donnée
	* @access  private 
	*/
	var $ID;
	
	/** 
	* @var string $nom Nom du contact 
	* @access  private 
	*/
	var $nom;
	
	/** 
	* @var string $prenom Prénom du contact 
	* @access  private 
	*/
	var $prenom;

	/** 
	* @var string $email Email du contact
	* @access  private 
	*/
	var $email;

	/** 
	* @var string $organisme organisme-société du contact
	* @access  private 
	*/
	var $organisme;
	
	/** 
	* @var string $telephone Téléphone du contact
	* @access  private 
	*/
	var $telephone;

	/** 
	* @var string $fax Fax du contact
	* @access  private 
	*/
	var $fax;

	/** 
	* @var string $adresse1 Adresse1 du contact
	* @access  private 
	*/
	var $adresse1;

	/** 
	* @var string $adresse2 Adresse2 du contact
	* @access  private 
	*/
	var $adresse2;

	/** 
	* @var string $adresse3 Adresse3 du contact
	* @access  private 
	*/
	var $adresse3;

	/** 
	* @var string $codePostal Code Postal du contact
	* @access  private 
	*/
	var $codePostal;

	/** 
	* @var string $ville Ville du contact
	* @access  private 
	*/
	var $ville;

	/** 
	* @var string $pays Pays du contact
	* @access  private 
	*/
	var $pays;


	/** 
	* Constructeur de l'objet
	* @param int $ID (facultatif) ID de l'element à initialiser (si non renseigné, aucune initialisation)
	* @return Tcontact_contact l'objet créé
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
		if($ID != 0)
			{
			$sql = "SELECT * FROM contact_obj_contact WHERE ID = ".$ID;
			$result = $this->query($sql);
			$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
			$this->nom = $row['nom'];
			$this->prenom = $row['prenom'];
			$this->email = $row['email'];
			$this->organisme = $row['organisme'];
			$this->telephone = $row['telephone'];
			$this->fax = $row['fax'];
			$this->adresse1 = $row['adresse1'];
			$this->adresse2 = $row['adresse2'];
			$this->adresse3 = $row['adresse3'];
			$this->codePostal = $row['codePostal'];
			$this->ville = $row['ville'];
			$this->pays = $row['pays'];
			}
		}
	
	/** 
	* Alias du constructeur (compatibilité PHP4)
	* @param int $ID (facultatif) ID de l'element à initialiser (si non renseigné, aucune initialisation)
	* @return Tcontact_contact l'objet créé
	* @see Tcontact_contact::__construct()
	* @access  public 
	*/
	function Tcontact_contact($ID = 0)
		{
		$this->__construct($ID);
		}

	/** 
	* Enregistre l'objet en base de donnée
	* Effectue aussi les liaisons avec le moyen de communication et l'adresse par defaut
	* Si l'ID est renseigné ==> modification
	* Sinon ==> insertion
	* @access  public 
	*/
	function enregistrer($valeurs)
		{
		$valeurs['email'] = $this->supprimerAccents($valeurs['email']);

		//si l'ID est renseigné, on modifie, sinon, on insere
		if ($this->ID == 0)
			{
			$sql = "INSERT INTO contact_obj_contact ( ID, nom, prenom, email, organisme, telephone, fax, adresse1, adresse2, adresse3, codePostal, ville, pays) 
							VALUES ('', '".strtoupper($valeurs['nom'])."', '".ucfirst($valeurs['prenom'])."', '".$valeurs['email']."', 
							'".strtoupper($valeurs['organisme'])."', '".$valeurs['telephone']."', '".$valeurs['fax']."', 
							'".ucfirst($valeurs['adresse1'])."', '".ucfirst($valeurs['adresse2'])."', '".ucfirst($valeurs['adresse3'])."', 
							'".$valeurs['codePostal']."', '".$valeurs['ville']."', '".$valeurs['pays']."');";
			$result = $this->query($sql);
			$this->ID = $this->last_insert_id();
			}
		else //on modifie
			{
			$sql = "UPDATE contact_obj_contact SET 
							nom = '".strtoupper($valeurs['nom'])."',
							prenom = '".$valeurs['prenom']."', 
							email = '".$valeurs['email']."', 
							organisme = '".strtoupper($valeurs['organisme'])."', 
							telephone = '".$valeurs['telephone']."', 
							fax = '".$valeurs['fax']."', 
							adresse1 = '".ucfirst($valeurs['adresse1'])."', 
							adresse2 = '".ucfirst($valeurs['adresse2'])."', 
							adresse3 = '".ucfirst($valeurs['adresse3'])."', 
							codePostal = '".$valeurs['codePostal']."', 
							ville = '".$valeurs['ville']."', 
							pays = '".$valeurs['pays']."'
							WHERE ID = ".$this->ID;
			$result = $this->query($sql);
			}
		return $this->ID;
		}

	/** 
	* Supprime l'objet en base de donnée
	* @access  public 
	*/
	function suppressionContact($ID_contact)
		{		
		$query = "DELETE FROM contact_obj_contact WHERE ID='".$ID_contact."';";
		$res=$this->query($query);
		}
   
	function selectionContact($IDcontact)
		{		
		$query = "SELECT * FROM contact_obj_contact WHERE ID = '$IDcontact'";
		$res=$this->query($query);
		return $res->fetchRow(DB_FETCHMODE_ASSOC);
		}

	function listerContacts()
		{		
		$query = "SELECT * FROM contact_obj_contact ORDER BY nom ASC, prenom ASC";
		$res=$this->query($query);
		while ($row=$res->fetchRow(DB_FETCHMODE_ASSOC))
			{
			$result[]=$row;
			}
		$res->free(DB_Result);
		return $result;
		}		
	}
?>