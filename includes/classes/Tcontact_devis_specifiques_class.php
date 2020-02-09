<?
/**
   *  Classe de gestion des devis
   *
   * Permet de créer, modifier, supprimer des devis, en intéraction 
   * avec la base de données
   *
   * @author Christophe Raffy
   * @version 1.0
   * @access public
   * @copyright Laëtis Créations Multimédias
   */

class Tcontact_devis_specifiques extends Tcontact_devis
	{
	/** 
	* @var int $ID ID de l'element en base de donnée
	* @access  private 
	*/
	var $ID;
	
	/** 
	* @var int $ID_devis ID du devis correspondant dans contact_obj_devis
	* @access  private 
	*/
	var $ID_devis;
	
	/** 
	* @var string $sujet Sujet du message inscrit par le contact 
	* @access  private 
	*/
	var $sujet;
			
	/** 
	* @var int $domaine1 Domaine de la Borie - senergues
	* @access  private 
	*/
	var $domaine1;
			
	/** 
	* @var int $domaine2 Domaine de l'Oustal - Pont-les-Bains
	* @access  private 
	*/
	var $domaine2;

	/** 
	* @var int $astronomie demande d'info sur le sejour Astronomie
	* @access  private 
	*/
	var $astronomie;
	
	/** 
	* @var int $musique demande d'info sur le sejour Musique
	* @access  private 
	*/
	var $musique;
	
	/** 
	* @var int $cirque demande d'info sur le sejour cirque
	* @access  private 
	*/
	var $cirque;
	
	/** 
	* @var int $moyenAge demande d'info sur le sejour moyenAge
	* @access  private 
	*/
	var $moyenAge;
	
	/** 
	* @var int $theatre demande d'info sur le sejour theatre
	* @access  private 
	*/
	var $theatre;
	
	/** 
	* @var int $nature demande d'info sur le sejour nature
	* @access  private 
	*/
	var $nature;
	
	/** 
	* @var string $autre demande d'info sur divers sur les sejours
	* @access  private 
	*/
	var $autre;
	
	/** 
	* @var string $nbrEleve Nombre d'Eleve du sejour
	* @access  private 
	*/
	var $nbrEleve;
	
	/** 
	* @var string $duree Duree du sejour
	* @access  private 
	*/
	var $duree;
	
	/** 
	* @var string $date Dates du sejour
	* @access  private 
	*/
	var $dates;
	
	/** 
	* @var string $niveau Niveau de la classe
	* @access  private 
	*/
	var $niveau;
																	
	/** 
	* @var dateTime $dateInscription Date d'Inscription
	* @access  private 
	*/
	var $dateInscription;

	/** 
	* @var string $mailGenere Texte du mail généré
	* @access  private 
	*/
	var $mailGenere;

	/** 
	* Constructeur de l'objet
	* @param int $ID (facultatif) ID de l'element à initialiser (si non renseigné, aucune initialisation)
	* @return Tcontact_devis_specifiques l'objet créé
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
		if ($ID != 0)
			{
			$sql = "SELECT * FROM contact_obj_devis_specifiques WHERE ID_devis = ".$ID;
			$result = $this->query($sql);
			$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
			//$this->ID_devis = $row['ID_devis'];
			$this->ID = $row['ID'];
			$this->sujet = $row['sujet'];
			$this->domaine1 = $row['domaine1'];
			$this->domaine2 = $row['domaine2'];
			$this->astronomie = $row['astronomie'];
			$this->musique = $row['musique'];
			$this->cirque = $row['cirque'];
			$this->moyenAge = $row['moyenAge'];
			$this->theatre = $row['theatre'];
			$this->nature = $row['nature'];
			$this->autre = $row['autre'];
			$this->nbrEleve = $row['nbrEleve'];
			$this->duree = $row['duree'];
			$this->dates = $row['dates'];
			$this->niveau = $row['niveau'];
			$this->dateInscription = $row['dateInscription'];
			$this->mailGenere = stripslashes($row['mailGenere']);
			}
		}
	
	/** 
	* Alias du constructeur (compatibilité PHP4)
	* @param int $ID (facultatif) ID de l'element à initialiser (si non renseigné, aucune initialisation)
	* @return Tcontact_devis_specifiques l'objet créé
	* @see Tcontact_devis_specifiques::__construct()
	* @access  public 
	*/
	function Tcontact_devis_specifiques($ID = 0)
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
		//si l'ID est renseigné, on modifie, sinon, on insere
		if ($this->ID == 0)
			{
			$ID_devis = Tcontact_devis::enregistrer($valeurs);
		
			$sql = "INSERT INTO contact_obj_devis_specifiques (ID, ID_devis, sujet, domaine1, domaine2, astronomie, musique, cirque, moyenAge, theatre, nature, autre, nbrEleve, duree, dates, niveau, dateInscription, mailGenere) 
							VALUES ('', '".$ID_devis."', '".$valeurs['sujet']."', '".$valeurs['domaine1']."', '".$valeurs['domaine2']."', '".$valeurs['astronomie']."', '".$valeurs['musique']."', '".$valeurs['cirque']."', '".$valeurs['moyenAge']."', '".$valeurs['theatre']."', '".$valeurs['nature']."', '".$valeurs['autre']."', '".$valeurs['nbrEleve']."', '".$valeurs['duree']."', '".$valeurs['dates']."', '".$valeurs['niveau']."', NOW(), '".addslashes($valeurs['mailGenere'])."');";
			$result = $this->query($sql);
			$this->ID = $ID_devis;
			}
		else //on modifie
			{
			Tcontact_devis::enregistrer($valeurs);

			$sql = "UPDATE contact_obj_devis_specifiques SET 
							sujet = '".$valeurs['sujet']."',
							domaine1 = '".$valeurs['domaine1']."',
							domaine2 = '".$valeurs['domaine2']."', 
							astronomie = '".$valeurs['astronomie']."',
							musique = '".$valeurs['musique']."',
							cirque = '".$valeurs['cirque']."',
							moyenAge = '".$valeurs['moyenAge']."',
							theatre = '".$valeurs['theatre']."',
							nature = '".$valeurs['nature']."',
							autre = '".$valeurs['autre']."',
							nbrEleve = '".$valeurs['nbrEleve']."',
							duree = '".$valeurs['duree']."',
							dates = '".$valeurs['dates']."',
							niveau = '".$valeurs['niveau']."',
							mailGenere = '".addslashes($valeurs['mailGenere'])."'
							WHERE ID_devis = ".$this->ID;
			$result = $this->query($sql);
			}
		return $this->ID;
		}

	/** 
	* Supprime l'objet en base de donnée
	* @access  public 
	*/
	function suppressionDevis($ID)
		{
		Tcontact_devis::suppressionDevis($ID);

		$query = "DELETE FROM contact_obj_devis_specifiques WHERE ID_devis ='".$ID."';";
		$res=$this->query($query);
		}

	function selectionDevisSpecifique($IDdevis)
		{		
		$query = "SELECT * FROM contact_obj_devis_specifiques WHERE ID_devis = '$IDdevis'";
		$res=$this->query($query);
		return $res->fetchRow(DB_FETCHMODE_ASSOC);
		}

	function listerDevis()
		{
		$query = "SELECT contact_obj_devis.*, contact_obj_devis_specifiques.* 
				  FROM contact_obj_devis, contact_obj_devis_specifiques 
				  WHERE contact_obj_devis.ID = contact_obj_devis_specifiques.ID_devis
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