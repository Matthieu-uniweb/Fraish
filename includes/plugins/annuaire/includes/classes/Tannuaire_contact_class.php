<?
/**
* Classe permetant la gestion des contacts dans l'annuaire
* Les contacts sont des personnes physiques uniquement
*
* @author  Thomas Vendé <thomas.vende@laetis.fr>
* @see T_LAETIS_site::modifierAttributs()
*/
class Tannuaire_contact extends Tannuaire_moteur_recherche
	{
	/** 
	* @var int $ID ID de l'element en base de donnée
	* @access  private 
	*/
	var $ID;
	
	/** 
	* @var string $civilite Civilité du contact (Monsieur, Madame, Mademoiselle)
	* @access  private 
	*/
	var $civilite;
	
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
	* @var string $descriptif Descriptif du contact 
	* @access  private 
	*/
	//vince 30/12
	var $descriptif;

	/** 
	* @var int $ID_serviceDefaut ID de son service par défaut
	* @access  private 
	*/
	var $ID_serviceDefaut;

	/** 
	* @var string $roleDefaut Role du contact dans le service par défaut
	* @access  private 
	*/
	var $roleDefaut;

	/** 
	* @var int $ID_communicationDefaut ID de son moyen de communication par défaut
	* @access  private 
	*/
	var $ID_communicationDefaut;
	
	/** 
	* @var int $ID_adresseDefaut ID de son adresse par défaut
	* @access  private 
	*/
	var $ID_adresseDefaut;

	/** 
	* @var string $repertoireImagesAnnuaireContact Répertoire contenant les images des contacts de l'annuaire
	* @access  private 
	*/
	var $repertoireImagesAnnuaireContact = "../images/contacts/";
	
	/** 
	* @var int $imageContactHauteurMax Taille hauteur max de l'image
	* @access  private 
	*/
	var $imageHauteurMax = 130;

	/** 
	* @var int $imageContactLargeurMax Taille largeur max de l'image
	* @access  private 
	*/
	var $imageLargeurMax = 100;

	/** 
	* Constructeur de l'objet
	* @param int $ID (facultatif) ID de l'element à initialiser (si non renseigné, aucune initialisation)
	* @return Tannuaire_contact l'objet créé
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
			$sql = "SELECT * FROM annuaire_obj_contact WHERE ID = ".$ID;
			$result = $this->query($sql);
			$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
			$this->civilite = $row['civilite'];
			$this->nom = $row['nom'];
			$this->prenom = $row['prenom'];
			//vince 30/12
			$this->descriptif = $row['descriptif'];

			//service par defaut
			$sql = "SELECT * FROM annuaire_rel_contact_service WHERE parDefaut = 1 AND ID_contact = ".$ID;
			$result = $this->query($sql);
			if($result->numRows() != 0)
				{
				$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
				$this->ID_serviceDefaut = $row['ID_service'];
				$this->roleDefaut = stripslashes($row['role']);
				}

			//communication par defaut
			$sql = "SELECT * FROM annuaire_rel_contact_communication WHERE parDefaut = 1 AND ID_contact = ".$ID;
			$result = $this->query($sql);
			if($result->numRows() != 0)
				{
				$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
				$this->ID_contactDefaut = $row['ID_communication'];
				}
				
			//adresse par defaut
			$sql = "SELECT * FROM annuaire_rel_contact_adresse WHERE parDefaut = 1 AND ID_contact = ".$ID;
			$result = $this->query($sql);
			if($result->numRows() != 0)
				{
				$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
				$this->ID_adresseDefaut = $row['ID_adresse'];
				}
			}
		}
	
	/** 
	* Alias du constructeur (compatibilité PHP4)
	* @param int $ID (facultatif) ID de l'element à initialiser (si non renseigné, aucune initialisation)
	* @return Tannuaire_contact l'objet créé
	* @see Tannuaire_contact::__construct()
	* @access  public 
	*/
	function Tannuaire_contact($ID = 0)
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
	function enregistrer()
		{
		//si l'ID est renseigné, on modifie, sinon, on insere
		if($this->ID == 0)
			{
			//vince 30/12
			$sql = "INSERT INTO annuaire_obj_contact ( ID , civilite , nom , prenom, descriptif ) 
					VALUES ('', '".$this->civilite."', '".$this->nom."', '".$this->prenom."', '".$this->descriptif."');";
			$result = $this->query($sql);
			$this->ID = $this->last_insert_id();
			}
		else //on modifie
			{
			//vince 30/12
			$sql = "UPDATE annuaire_obj_contact SET 
					civilite = '".$this->civilite."',
					nom = '".$this->nom."',
					prenom = '".$this->prenom."',
					descriptif = '".$this->descriptif."'
					WHERE ID = ".$this->ID;
			$result = $this->query($sql);
			}
		//gestion du service par defaut
		if($this->ID_serviceDefaut)
			{
			$this->lierService($this->ID_serviceDefaut, addslashes($this->roleDefaut), 1);
			}

		//gestion de l'adresse par defaut
		if($this->ID_adresseDefaut)
			{
			$this->lierAdresse($this->ID_adresseDefaut, 1);
			}
			
		//gestion de la communication par defaut
		if($this->ID_communicationDefaut)
			{
			$this->lierComunication($this->ID_communicationDefaut, 1);
			}
		}
	
	/** 
	* Supprime l'objet en base de donnée (mais ne détruit pas l'objet PHP)
	* Cette méthode remet l'ID à 0, pour une re-enregistrement éventuel
	* @access  public 
	*/
	function supprimer()
		{
		$this->supprimerCommunications();
		$this->supprimerAdresses();

		$sql = "DELETE FROM annuaire_obj_contact WHERE ID = '".$this->ID."'";
		$result = $this->query($sql);
		$sql = "DELETE FROM annuaire_rel_contact_service WHERE ID_contact = '".$this->ID."'";
		$result = $this->query($sql);
		$this->ID = 0;
		}

	/** 
	* Nettoyer les éléments non utilisés dans les table annuaire_rel_contact_service
	* @access  public 
	*/
	function nettoyerLiensContacts()
		{
		$sql = "SELECT DISTINCT annuaire_rel_contact_service.ID_contact FROM annuaire_rel_contact_service";
		$result = $this->query($sql);

		while($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
			{
			$sql2 = "SELECT ID FROM annuaire_obj_contact WHERE ID = '".$row['ID_contact']."'";
			$result2 = $this->query($sql2);
			
			if ($result2->numRows() == '0')
				{
				//echo "Suppresion de ID = ".$row['ID_contact']."<br>";
				$contact = new Tannuaire_contact($row['ID_contact']);
				$contact->supprimer();
				}
			} // FIN for ($i=0; $i<count($listeIDAdresse); $i++)
			
		$sql = "SELECT DISTINCT annuaire_obj_contact.ID FROM annuaire_obj_contact";
		$result = $this->query($sql);
		
		while($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
			{
			$sql1 = "SELECT COUNT(*) FROM annuaire_rel_contact_service 
							WHERE annuaire_rel_contact_service.ID_contact = '".$row['ID']."'";
			$result1 = $this->query($sql1);
			$row1 = $result1->fetchRow();

			if ($row1[0] == '0')
				{
				//echo "Suppression de ID = ".$row['ID']."<br>";
				$contact = new Tannuaire_contact($row['ID']);
				$contact->supprimer();
				}
			} // FIN while($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
		}

	/** 
	* Exporte dans un fichier les informations sur les contacts
	* @param int $nomFichier Nom du fichier renvoyé
	* @access  public 
	*/
	function exporter($nomFichier)
		{
		$sql = "SELECT * INTO OUTFILE '".$nomFichier."'
						FIELDS TERMINATED BY '\;' ENCLOSED BY '\\\"' ESCAPED BY '\\\\' LINES TERMINATED BY '\\r\\n' 
						FROM annuaire_obj_contact";		
		$result = $this->query($sql);		
		}

	/** 
	* Supprime les communications correspondantes au contact
	* Supprime totalement la communication de la base si celle-ci correspond uniquement au contact
	* @access  public 
	*/
	function supprimerCommunications()
		{
		// Suppression des communications du contact
		$sql = "SELECT ID_communication FROM annuaire_rel_contact_communication WHERE ID_contact = '".$this->ID."'";
		$result = $this->query($sql);
		while($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
			{
			$sql2 = "SELECT ID_communication FROM annuaire_rel_contact_communication 
							WHERE ID_communication = '".$row['ID_communication']."'
							AND ID_contact != '".$this->ID."'";
			$result2 = $this->query($sql2);
			
			if ($result2->numRows() == '0')
				{
				$communication = new Tannuaire_communication($row['ID_communication']);
				$communication->supprimer();
				}
			}
		$sql = "DELETE FROM annuaire_rel_contact_communication WHERE ID_contact = '".$this->ID."'";
		$result = $this->query($sql);
		}

	/** 
	* Supprime les adresses correspondantes au contact
	* Supprime totalement l'adresse de la base si celle-ci correspond uniquement au contact
	* @access  public 
	*/
	function supprimerAdresses()
		{
		// Suppression des adresses du contact
		$sql = "SELECT ID_adresse FROM annuaire_rel_contact_adresse WHERE ID_contact = '".$this->ID."'";
		$result = $this->query($sql);
		while($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
			{
			$sql2 = "SELECT ID_adresse FROM annuaire_rel_contact_adresse 
							WHERE ID_adresse = '".$row['ID_adresse']."'
							AND ID_contact != '".$this->ID."'";
			$result2 = $this->query($sql2);
			
			if ($result2->numRows() == '0')
				{
				$adresse = new Tannuaire_adresse($row['ID_adresse']);
				$adresse->supprimer();
				}
			}
		$sql = "DELETE FROM annuaire_rel_contact_adresse WHERE ID_contact = '".$this->ID."'";
		$result = $this->query($sql);
		}

	/** 
	* Permet de supprimer une communication correspondant au contact
	* @param int $ID_communication ID de la communication à supprimer
	* @access  public 
	*/
	function supprimerUneCommunication($ID_communication)
		{
		$sql = "SELECT ID_communication FROM annuaire_rel_contact_communication
						WHERE ID_communication = '".$ID_communication."'
						AND ID_contact != '".$this->ID."'";
		$result = $this->query($sql);
		$nbC = $result->numRows();

		$sql = "SELECT ID_communication FROM annuaire_rel_service_communication
						WHERE ID_communication = '".$ID_communication."'";
		$result = $this->query($sql);
		$nbS = $result->numRows();
		
		// Cette communication n'est utilisée qu'avec ce service
		if ($nbS+$nbC == '0')
			{
			$communication = new Tannuaire_communication($ID_communication);
			$communication->supprimer();
			}

		$sql = "DELETE FROM annuaire_rel_contact_communication 
						WHERE ID_contact = '".$this->ID."' AND ID_communication = '".$ID_communication."'";
		$result = $this->query($sql);
		}

	/** 
	* Permet de lier un service au contact
	* @param int $ID_contact ID du contact à lier au service
	* @param string $role role du contact dans le service
	* @param int $defaut (facultatif) Le contact est il le contact par défaut du service, 0 ou 1, 0 si non renseigné
	* @access  public 
	*/
	function lierService($ID_service, $role, $defaut = 0)
		{
		if($defaut==1)
			{
			//on supprime le service par defaut s'il est différent du notre
			$sql = "UPDATE annuaire_rel_contact_service SET parDefaut = 0 
							WHERE ID_contact = ".$this->ID." 
							AND parDefaut = 1
							AND ID_service <> ".$ID_service;
			$result = $this->query($sql);
			}
		//le service par defaut a été modifié, maintenant on mets le nouveau
		$sql = "SELECT * FROM annuaire_rel_contact_service WHERE ID_contact = ".$this->ID." AND ID_service = ".$ID_service;
		$result = $this->query($sql);
		//on update
		if($result->numRows() != 0)
			{
			$sql = "UPDATE annuaire_rel_contact_service 
							SET parDefaut = ".$defaut.", role = '".$role."' 
							WHERE ID_contact = ".$this->ID." AND ID_service = ".$ID_service;
			}
		else //on insere
			{
			$sql = "INSERT INTO annuaire_rel_contact_service (ID_service,ID_contact,parDefaut,role) 
							VALUES (".$ID_service.",".$this->ID.", ".$defaut.", '".$role."')";
			}
		$result = $this->query($sql);
		}	

	/** 
	* Permet de lier une adresse à un contact
	* @param int $ID_adresse ID de l'adresse à lier au contact
	* @param int $defaut (facultatif) L'adresse est elle l'adresse par défaut du contact, 0 ou 1, 0 si non renseigné
	* @access  public 
	*/
	function lierAdresse($ID_adresse,$defaut = 0)
		{
		if($defaut==1)
			{
			//on supprime l'adresse par defaut si elle est différente de la notre
			$sql = "UPDATE annuaire_rel_contact_adresse SET parDefaut = 0 
							WHERE ID_contact = ".$this->ID." 
							AND parDefaut = 1
							AND ID_adresse <> ".$ID_adresse;
			$result = $this->query($sql);
			}
		//l'adresse par defaut a été modifiée, maintenant on mets la nouvelle
		$sql = "SELECT * FROM annuaire_rel_contact_adresse WHERE ID_contact = ".$this->ID." AND ID_adresse = ".$ID_adresse;
		$result = $this->query($sql);
		//on update
		if($result->numRows() != 0)
			{
			$sql = "UPDATE annuaire_rel_contact_adresse SET parDefaut = ".$defaut." WHERE ID_contact = ".$this->ID." AND ID_adresse = ".$ID_adresse;
			}
		else //on insere
			{
			$sql = "INSERT INTO annuaire_rel_contact_adresse (ID_contact,ID_adresse,parDefaut) VALUES (".$this->ID.",".$ID_adresse.",".$defaut.")";
			}
		$result = $this->query($sql);
		}	
	
	/** 
	* Permet de lier un moyen de communication à un contact
	* @param int $ID_communication ID de le moyen de communication à lier au contact
	* @param int $defaut (facultatif) Le moyen de communication est il le moyen de communication 
	* par défaut du contact, 0 ou 1, 0 si non renseigné
	* @access  public 
	*/
	function lierCommunication($ID_communication,$defaut = 0)
		{
		if($defaut==1)
			{
			//on supprime le moyen de communication par defaut s'il est différent du notre
			$sql = "UPDATE annuaire_rel_contact_communication SET parDefaut = 0 
							WHERE ID_contact = ".$this->ID." 
							AND parDefaut = 1
							AND ID_communication <> ".$ID_communication;
			$result = $this->query($sql);
			}
		//le moyen de communication par defaut a été modifié, maintenant on mets le nouveau
		$sql = "SELECT * FROM annuaire_rel_contact_communication WHERE ID_contact = ".$this->ID." AND ID_communication = ".$ID_communication;
		$result = $this->query($sql);
		//on update
		if($result->numRows() != 0)
			{
			$sql = "UPDATE annuaire_rel_contact_communication SET parDefaut = ".$defaut." WHERE ID_contact = ".$this->ID." AND ID_communication = ".$ID_communication;
			}
		else //on insere
			{
			$sql = "INSERT INTO annuaire_rel_contact_communication (ID_contact,ID_communication,parDefaut) VALUES (".$this->ID.",".$ID_communication.",".$defaut.")";
			}
		$result = $this->query($sql);
		}	

	/** 
	* Affichage global du contact Ex: Monsieur Thomas Vendu
	* @return string La chaine à afficher
	* @access  public 
	*/
	function afficherContact()
		{
		return $this->civilite.' '.$this->prenom.' '.strtoupper($this->nom);
		} 

	/** 
	* Lister tous les contacts, triés par ID
	* @return array Tableau contenant les informations sur les contacts
	* @access  public 
	*/
	function listerContacts()
		{
		$sql = "SELECT * FROM annuaire_obj_contact ORDER BY ID";
		$result = $this->query($sql);
		while($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
			{
			$retour[] = $row;
			}
		return($retour);
		}

	/** 
	* Lister les adresses d'un contact
	* @return array Tableau contenant les ID des adresses 
	* @access  public 
	*/
	function listerAdresses()
		{
		$sql = "SELECT ID_adresse FROM annuaire_rel_contact_adresse WHERE ID_contact = '".$this->ID."'";
		$result = $this->query($sql);
		while($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
			{
			$retour[] = $row['ID_adresse'];
			}
		return($retour);
		}

	/** 
	* Lister les services auquels est lié un contact
	* @return array Tableau contenant les ID des services 
	* @access  public 
	*/
	function listerServices()
		{
		$sql = "SELECT ID_service FROM annuaire_rel_contact_service WHERE ID_contact = '".$this->ID."'";
		$result = $this->query($sql);
		while($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
			{
			$retour[] = $row['ID_service'];
			}
		return($retour);
		}

	/** 
	* Lister les communications d'un contact
	* @return array Tableau contenant les ID des communications 
	* @access  public 
	*/
	function listerCommunications()
		{
		$sql = "SELECT annuaire_rel_contact_communication.ID_communication  
						FROM annuaire_rel_contact_communication, annuaire_obj_communication, annuaire_typ_communication 
						WHERE ID_contact = '".$this->ID."' 
						AND annuaire_obj_communication.ID = annuaire_rel_contact_communication.ID_communication
						AND annuaire_obj_communication.ID_communication = annuaire_typ_communication.ID
						ORDER BY annuaire_typ_communication.ordre ASC, annuaire_obj_communication.numero ASC";
		$result = $this->query($sql);
		while($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
			{
			$retour[] = $row['ID_communication'];
			}
		return($retour);
		}

	/** 
	* Renvoie les numéros de communication correspondants au type ID_typ_communication
	* et appartenant au contact instancié
	* @param int $ID_typ_communication Le type de communication
	* @return string Le numéro
	* @access  public 
	*/
	function getCommunication($ID_typ_communication)
		{
		$sql = "SELECT annuaire_obj_communication.numero 
						FROM annuaire_obj_communication,annuaire_rel_contact_communication 
						WHERE annuaire_obj_communication.ID_communication = '".$ID_typ_communication."' 
						AND annuaire_rel_contact_communication.ID_communication = annuaire_obj_communication.ID
						AND ID_contact = ".$this->ID;
		$result = $this->query($sql);
		$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
		return $row['numero'];
		}

	/** 
	* Affichage global du mail
	* @param string $style Le style a affecter au lien mailto
	* @return string La chaine à afficher
	* @access  public 
	*/
	function recupererLienMail($style)
		{
		$sql = "SELECT annuaire_obj_communication.numero FROM annuaire_obj_communication,annuaire_rel_contact_communication 
				WHERE annuaire_obj_communication.ID_communication = 1 AND annuaire_rel_contact_communication.ID_communication = annuaire_obj_communication.ID
				AND ID_contact = ".$this->ID;
		$result = $this->query($sql);
		$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
		return '<a href="mailto:'.$row['numero'].'" class="'.$style.'">@couriel</a>';
		}

	/** 
	* Rechercher le numéro de réléphone d'un contact
	* @param string $style Le style a affecter au lien mailto
	* @return string Le numéro de réléphone
	* @access  public 
	*/
	function recupererTelephone()
		{
		$sql = "SELECT annuaire_obj_communication.numero FROM annuaire_obj_communication,annuaire_rel_contact_communication 
						WHERE (annuaire_obj_communication.ID_communication = 4 OR annuaire_obj_communication.ID_communication = 6) 
						AND annuaire_rel_contact_communication.ID_communication = annuaire_obj_communication.ID
						AND ID_contact = ".$this->ID;
		$result = $this->query($sql);
		$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
		return $row['numero'];
		}

	/** 
	* Nommer la photo correspondante au contact
	* @return string Le nom de la photo
	* @access  public 
	*/
	function nommerPhoto()
		{
		/*$nom = $this->filtrerCaracteresSpeciaux($this->nom.'_'.$this->prenom.'_'.$this->ID);
		$nomPhoto = $this->repertoireImagesAnnuaireContact.$nom;

		$nomPhoto = $this->supprimerAccents(strtolower(trim($nomPhoto.'.jpg')));
		$nomPhoto = str_replace(' ', '_', $nomPhoto);
		$nomPhoto = str_replace('___', '_', $nomPhoto);
		$nomPhoto = str_replace('__', '_', $nomPhoto);
		return $nomPhoto;*/

		$nomPhoto = $this->repertoireImagesAnnuaireContact.$this->ID.'.jpg';
		return $nomPhoto;		
		}

	/** 
	* Enregistrer la photo correspondante au service
	* @param array valeursPost Les variables POST
	* @param array valeursFiles Les variables FILES
	* @access public 
	*/
	function enregistrerPhoto($valeursPost, $valeursFiles)
		{
		if (!empty($valeursFiles['file1']['name']) )
			{
			$nomPhoto = $this->nommerPhoto();	
			
			if( is_uploaded_file($valeursFiles['file1']['tmp_name']) )
				{		
				if( @file_exists($nomPhoto) )
					{ @unlink($nomPhoto);	}
				$res = @move_uploaded_file($valeursFiles['file1']['tmp_name'], $nomPhoto);
				chmod($nomPhoto,0777);
				
				$imageOriginale = str_replace('.jpg', '_originale.jpg', $nomPhoto);
				@unlink($imageOriginale);
				copy($nomPhoto, $imageOriginale);
				
				//Récupération des infos sur le fichier
				$taille=getimagesize($nomPhoto);
				
				//Format de la photo
				$width = $taille[0];
				$height = $taille[1];
				
				if ( ($height/$width) >= ($valeursPost['imageHauteurMax']/$valeursPost['imageLargeurMax']) )
					{							
					$width = ($width * ($valeursPost['imageHauteurMax'] / $height));
					$height = $valeursPost['imageHauteurMax'];
					}
				else
					{							
					$height = ($height * ($valeursPost['imageLargeurMax'] / $width));
					$width = $valeursPost['imageLargeurMax'];
					}
				
				//$extension = explode('.', $nomPhoto);
				//Enregistrement de la vignette dans le dossier
				/*if ($extension[1] == "jpg")
				{ */
				$src=imagecreatefromjpeg($nomPhoto);
				$img=imagecreatetruecolor($width,$height);
				imagecopyresized($img,$src,0,0,0,0,$width,$height,$taille[0],$taille[1]);
				imagejpeg($img,$nomPhoto,100);
				/*}
				else if ($extension[1] == "gif")
				{
				$src=imagecreatefromgif($nomPhoto);
				$img=imagecreate($width,$height);
				imagecopyresized($img,$src,0,0,0,0,$width,$height,$taille[0],$taille[1]);
				imagejpeg($img,$nomPhoto,100);
				}*/
				}
				} // Fin if( !empty($valeursFiles['join']['name']) )
		} // FIN function enregistrerPhoto($valeursPost, $valeursFiles)
		

	}
?>