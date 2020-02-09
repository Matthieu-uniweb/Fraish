<?
/**
   *  Classe de gestion des contacts
   *
   * Permet de cr�er, modifier, supprimer des contacts, en int�raction 
   * avec la base de donn�es
   *
   * @author Christophe Raffy
   * @version 1.0
   * @access public
   * @copyright La�tis Cr�ations Multim�dias
   */

class Tcontact_criteres_specifiques extends Tcontact_contact
	{
	/** 
	* @var int $ID ID de l'element en base de donn�e
	* @access  private 
	*/
	var $ID;
	
	/** 
	* @var int $ID_contact ID du contact correspondant dans contact_obj_contact
	* @access  private 
	*/
	var $ID_contact;

	/** 
	* @var string $sujet Sujet du message inscrit par le contact 
	* @access  private 
	*/
	var $sujet;

	/** 
	* @var string $message Message inscrit par le contact 
	* @access  private 
	*/
	var $message;

	/** 
	* @var string $langue Langue du site (suivant la page du formulaire ou s'est inscrit le contact)
	* @access  private 
	*/
	var $langue;

	/** 
	* @var int $mailing Si le contact d�sire s'inscrire � la liste de diffusion
	* @access  private 
	*/
	var $mailing;
	
	/** 
	* @var dateTime $dateInscription Date d'Inscription
	* @access  private 
	*/
	var $dateInscription;

	/** 
	* @var string $mailGenere Texte du mail g�n�r�
	* @access  private 
	*/
	var $mailGenere;

	/** 
	* Constructeur de l'objet
	* @param int $ID (facultatif) ID de l'element � initialiser (si non renseign�, aucune initialisation)
	* @return Tcontact_criteres_specifiques l'objet cr��
	* @access  public 
	*/
	function __construct($ID = 0)
		{
		$this->ID = $ID;
		$this->initialiser($ID);
		}
	
	function initialiser($ID)
		{
		//si on a donn� un parametre, on instancie par rapport � la base
		if ($ID != 0)
			{
			$sql = "SELECT * FROM contact_obj_criteres_specifiques WHERE ID_contact = ".$ID;
			$result = $this->query($sql);
			$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
			//$this->ID_contact = $row['ID_contact'];
			$this->ID = $row['ID'];
			$this->sujet = $row['sujet'];
			$this->message = $row['message'];
			$this->langue = $row['langue'];
			$this->mailing = $row['mailing'];
			$this->dateInscription = $row['dateInscription'];
			$this->mailGenere = stripslashes($row['mailGenere']);
			}
		}
	
	/** 
	* Alias du constructeur (compatibilit� PHP4)
	* @param int $ID (facultatif) ID de l'element � initialiser (si non renseign�, aucune initialisation)
	* @return Tcontact_criteres_specifiques l'objet cr��
	* @see Tcontact_criteres_specifiques::__construct()
	* @access  public 
	*/
	function Tcontact_criteres_specifiques($ID = 0)
		{
		$this->__construct($ID);
		}

	/** 
	* Enregistre l'objet en base de donn�e
	* Effectue aussi les liaisons avec le moyen de communication et l'adresse par defaut
	* Si l'ID est renseign� ==> modification
	* Sinon ==> insertion
	* @access  public 
	*/
	function enregistrer($valeurs)
		{
		//si l'ID est renseign�, on modifie, sinon, on insere
		if ($this->ID == 0)
			{
			$ID_contact = Tcontact_contact::enregistrer($valeurs);
		
			$sql = "INSERT INTO contact_obj_criteres_specifiques (ID, ID_contact, sujet, message, langue, mailing, dateInscription, mailGenere) 
							VALUES ('', '".$ID_contact."', '".$valeurs['sujet']."', '".$valeurs['message']."', '".$valeurs['langue']."', 
							'".$valeurs['mailing']."', NOW(), '".addslashes($valeurs['mailGenere'])."');";
			$result = $this->query($sql);
			$this->ID = $ID_contact;
			}
		else //on modifie
			{
			Tcontact_contact::enregistrer($valeurs);

			$sql = "UPDATE contact_obj_criteres_specifiques SET 
							sujet = '".$valeurs['sujet']."',
							message = '".$valeurs['message']."',
							langue = '".$valeurs['langue']."', 
							mailing = '".$valeurs['mailing']."',
							mailGenere = '".addslashes($valeurs['mailGenere'])."'
							WHERE ID_contact = ".$this->ID;
			$result = $this->query($sql);
			}
		return $this->ID;
		}

	/** 
	* Supprime l'objet en base de donn�e
	* @access  public 
	*/
	function suppressionContact($ID)
		{
		Tcontact_contact::suppressionContact($ID);

		$query = "DELETE FROM contact_obj_criteres_specifiques WHERE ID_contact ='".$ID."';";
		$res=$this->query($query);
		}

	function selectionContactSpecifique($IDcontact)
		{		
		$query = "SELECT * FROM contact_obj_criteres_specifiques WHERE ID_contact = '$IDcontact'";
		$res=$this->query($query);
		return $res->fetchRow(DB_FETCHMODE_ASSOC);
		}

	function listerContacts()
		{
		$query = "SELECT contact_obj_contact.*, contact_obj_criteres_specifiques.* 
				  FROM contact_obj_contact, contact_obj_criteres_specifiques 
				  WHERE contact_obj_contact.ID = contact_obj_criteres_specifiques.ID_contact
				  ORDER BY nom ASC, prenom ASC";
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