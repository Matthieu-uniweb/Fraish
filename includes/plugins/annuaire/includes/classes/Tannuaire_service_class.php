<?
/**
* Classe permetant la gestion des services dans l'annuaire
*
* @author  Thomas Vendé <thomas.vende@laetis.fr>
* @see T_LAETIS_site::modifierAttributs()
*/
class Tannuaire_service extends Tannuaire_moteur_recherche
	{
	/** 
	* @var int $ID ID de l'element en base de donnée
	* @access  private 
	*/
	var $ID;
	
	/** 
	* @var string $nom Nom du service 
	* @access  private 
	*/
	var $nom;
	
	/** 
	* @var string $descriptif Descriptif du service 
	* @access  private 
	*/
	var $descriptif;
	
	/** 
	* @var int $ID_contactDefaut ID de son contact par défaut
	* @access  private 
	*/
	var $ID_contactDefaut;
	
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
	* @var string $repertoireImagesAnnuaireService Répertoire contenant les images des services de l'annuaire
	* @access  private 
	*/
	var $repertoireImagesAnnuaireService = "../images/services/";
	
	/** 
	* @var int $imageContactHauteurMax Taille hauteur max de l'image
	* @access  private 
	*/
	var $imageHauteurMax = 150;

	/** 
	* @var int $imageContactLargeurMax Taille largeur max de l'image
	* @access  private 
	*/
	var $imageLargeurMax = 180;
	
	/** 
	* Constructeur de l'objet
	* @param int $ID (facultatif) ID de l'element à initialiser (si non renseigné, aucune initialisation)
	* @return Tannuaire_service l'objet créé
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
			$sql = "SELECT * FROM annuaire_obj_service WHERE ID = ".$ID;
			$result = $this->query($sql);
			$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
			$this->nom = stripslashes($row['nom']);
			$this->descriptif = stripslashes($row['descriptif']);

			//contact par defaut
			$sql = "SELECT * FROM annuaire_rel_contact_service WHERE parDefaut = 1 AND ID_service = ".$ID;
			$result = $this->query($sql);
			if($result->numRows() != 0)
				{
				$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
				$this->ID_contactDefaut = $row['ID_contact'];
				}
				
			//communication par defaut
			$sql = "SELECT * FROM annuaire_rel_service_communication WHERE parDefaut = 1 AND ID_service = ".$ID;
			$result = $this->query($sql);
			if($result->numRows() != 0)
				{
				$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
				$this->ID_communicationDefaut = $row['ID_communication'];
				}
				
			//adresse par defaut
			$sql = "SELECT * FROM annuaire_rel_service_adresse WHERE parDefaut = 1 AND ID_service = ".$ID;
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
	* @return Tannuaire_service l'objet créé
	* @see Tannuaire_service::__construct()
	* @access  public 
	*/
	function Tannuaire_service($ID = 0)
		{
		$this->__construct($ID);
		}
	
	/** 
	* Enregistre l'objet en base de donnée
	* Effectue aussi les liaisons avec le contact, le moyen de communication et l'adresse par defaut
	* Si l'ID est renseigné ==> modification
	* Sinon ==> insertion
	* @access  public 
	*/
	function enregistrer()
		{
		//si l'ID est renseigné, on modifie, sinon, on insere
		if($this->ID == 0)
			{
			$sql = "INSERT INTO annuaire_obj_service ( ID , nom , descriptif) 
							VALUES ('', '".addslashes($this->nom)."', '".addslashes($this->descriptif)."');";
			$result = $this->query($sql);
			$this->ID = $this->last_insert_id();
			}
		else //on modifie
			{
			$sql = "UPDATE annuaire_obj_service SET 
					nom = '".addslashes($this->nom)."', 
					descriptif = '".addslashes($this->descriptif)."'
					WHERE ID = ".$this->ID;
			$result = $this->query($sql);
			}

		//gestion du contact par defaut
		if($this->ID_contactDefaut)
			{
			$this->lierContact($this->ID_contactDefaut, $this->getRole($this->ID_contactDefaut), 1);
			}
			
		//gestion de l'adresse par defaut
		if($this->ID_adresseDefaut)
			{
			$this->lierAdresse($this->ID_adresseDefaut,1);
			}
			
		//gestion de la communication par defaut
		if($this->ID_communicationDefaut)
			{
			$this->lierCommunication($this->ID_communicationDefaut,1);
			}
		}
	
	/** 
	* Supprime l'objet en base de données (mais ne détruit pas l'objet PHP)
	* Cette méthode remet l'ID à 0, pour une re-enregistrement éventuel
	* @access  public 
	*/
	function supprimer()
		{
		$sql = "DELETE FROM annuaire_rel_categorie_service WHERE ID_service = '".$this->ID."'";
		$result = $this->query($sql);
		
		$this->supprimerCommunications();
		$this->supprimerAdresses();
		$this->supprimerContact();

		$sql = "DELETE FROM annuaire_obj_service WHERE ID = '".$this->ID."'";
		$result = $this->query($sql);
		$sql = "DELETE FROM annuaire_rel_structure_service WHERE ID_service = '".$this->ID."'";
		$result = $this->query($sql);
		$this->ID = 0;
		}

	/** 
	* Exporte dans un fichier les informations sur les services
	* @param int $nomFichier Nom du fichier renvoyé
	* @access  public 
	*/
	function exporter($nomFichier)
		{
		$sql = "SELECT * INTO OUTFILE '".$nomFichier."'
						FIELDS TERMINATED BY '\;' ENCLOSED BY '\\\"' ESCAPED BY '\\\\' LINES TERMINATED BY '\\r\\n' 
						FROM annuaire_obj_service";		
		$result = $this->query($sql);		
		}

	/** 
	* Supprime les communications correspondantes au service
	* Supprime totalement la communication de la base si celle-ci correspond uniquement au service
	* @access  public 
	*/
	function supprimerCommunications()
		{
		// Suppression des communications du service
		$sql2 = "SELECT ID_communication FROM annuaire_rel_service_communication WHERE ID_service = '".$this->ID."'";
		$result2 = $this->query($sql2);
		while($row2 = $result2->fetchRow(DB_FETCHMODE_ASSOC))
			{
			$sql3 = "SELECT ID_communication FROM annuaire_rel_service_communication 
							WHERE ID_communication = '".$row2['ID_communication']."'
							AND ID_service != '".$this->ID."'";
			$result3 = $this->query($sql3);

			if ($result3->numRows() == '0')
				{
				$communication = new Tannuaire_communication($row2['ID_communication']);
				$communication->supprimer();
				}
			}

		$sql = "DELETE FROM annuaire_rel_service_communication WHERE ID_service = '".$this->ID."'";
		$result = $this->query($sql);
		}

	/** 
	* Supprime les adresses correspondantes au service
	* Supprime totalement l'adresse de la base si celle-ci correspond uniquement au service
	* @access  public 
	*/
	function supprimerAdresses()
		{
		// Suppression des adresses du service
		$sql2 = "SELECT ID_adresse FROM annuaire_rel_service_adresse WHERE ID_service = '".$this->ID."'";
		$result2 = $this->query($sql2);
		while($row2 = $result2->fetchRow(DB_FETCHMODE_ASSOC))
			{
			$sql3 = "SELECT ID_adresse FROM annuaire_rel_service_adresse 
							WHERE ID_adresse = '".$row2['ID_adresse']."'
							AND ID_service != '".$this->ID."'";
			$result3 = $this->query($sql3);

			if ($result3->numRows() == '0')
				{
				$adresse = new Tannuaire_adresse($row2['ID_adresse']);
				$adresse->supprimer();
				}
			} // FIN while($row2 = $result2->fetchRow(DB_FETCHMODE_ASSOC))

		$sql = "DELETE FROM annuaire_rel_service_adresse WHERE ID_service = '".$this->ID."'";
		$result = $this->query($sql);
		}

	/** 
	* Supprime les contacts correspondants au service
	* Supprime totalement le contact de la base si celui-ci est lié uniquement au service
	* @access  public 
	*/
	function supprimerContact()
		{
		// Suppression des contacts du service
		$sql2 = "SELECT ID_contact FROM annuaire_rel_contact_service WHERE ID_service = '".$this->ID."'";
		$result2 = $this->query($sql2);
		while($row2 = $result2->fetchRow(DB_FETCHMODE_ASSOC))
			{
			$sql3 = "SELECT ID_contact FROM annuaire_rel_contact_service 
							WHERE ID_contact = '".$row2['ID_contact']."'
							AND ID_service != '".$this->ID."'";
			$result3 = $this->query($sql3);
			
			if ($result3->numRows() == '0')
				{
				$contact = new Tannuaire_contact($row2['ID_contact']);
				$contact->supprimer();
				}
			} // FIN while($row2 = $result2->fetchRow(DB_FETCHMODE_ASSOC))

		$sql = "DELETE FROM annuaire_rel_contact_service WHERE ID_service = '".$this->ID."'";
		$result = $this->query($sql);
		}

	/** 
	* Permet de supprimer un contact correspondant au service
	* @param int $ID_contact ID du contact à supprimer
	* @access  public 
	*/
	function supprimerUnContact($ID_contact)
		{
		// Suppression du contact ID_contact du service
		$sql = "SELECT ID_contact FROM annuaire_rel_contact_service 
						WHERE ID_contact = '".$ID_contact."'
						AND ID_service != '".$this->ID."'";
		$result = $this->query($sql);
			
		if ($result->numRows() == '0')
			{
			$contact = new Tannuaire_contact($ID_contact);
			$contact->supprimer();
			}

		$sql = "DELETE FROM annuaire_rel_contact_service WHERE ID_service = '".$this->ID."' AND ID_contact = '".$ID_contact."'";
		$result = $this->query($sql);
		}

	/** 
	* Permet de supprimer une communication correspondant au service
	* @param int $ID_communication ID de la communication à supprimer
	* @access  public 
	*/
	function supprimerUneCommunication($ID_communication)
		{
		$sql = "SELECT ID_communication FROM annuaire_rel_service_communication
						WHERE ID_communication = '".$ID_communication."'
						AND ID_service != '".$this->ID."'";
		$result = $this->query($sql);
		$nbS = $result->numRows();

		$sql = "SELECT ID_communication FROM annuaire_rel_contact_communication
						WHERE ID_communication = '".$ID_communication."'";
		$result = $this->query($sql);
		$nbC = $result->numRows();
		
		// Cette communication n'est utilisée qu'avec ce service
		if ($nbS+$nbC == '0')
			{
			$communication = new Tannuaire_communication($ID_communication);
			$communication->supprimer();
			}

		$sql = "DELETE FROM annuaire_rel_service_communication 
						WHERE ID_service = '".$this->ID."' AND ID_communication = '".$ID_communication."'";
		$result = $this->query($sql);
		}

	/** 
	* Nettoyer les éléments non utilisés dans les table annuaire_rel_structure_service
	* @access  public 
	*/
	function nettoyerLiensServices()
		{
		$sql = "SELECT ID_service FROM annuaire_rel_structure_service";
		$result = $this->query($sql);
		while($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
			{
			$sql2 = "SELECT ID FROM annuaire_obj_service WHERE ID = '".$row['ID_service']."'";
			$result2 = $this->query($sql2);
			
			if ($result2->numRows() == '0')
				{
				//echo "Suppression du service ".$row['ID_service']."<br>";
				$service = new Tannuaire_service($row['ID_service']);
				$service->supprimer();
				}
			} // FIN while($row = $result->fetchRow(DB_FETCHMODE_ASSOC))

		$sql = "SELECT * FROM annuaire_obj_service ORDER BY ID";
		$result = $this->query($sql);
		while($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
			{
			$sql2 = "SELECT * FROM annuaire_rel_categorie_service WHERE ID_service = '".$row['ID']."'";
			$result2 = $this->query($sql2);
			
			$sql3 = "SELECT * FROM annuaire_rel_structure_service WHERE ID_service = '".$row['ID']."'";
			$result3 = $this->query($sql3);

			if ( ($result2->numRows() == '0') && ($result3->numRows() == '0') )
				{
				$service = new Tannuaire_service($row['ID']);
				//echo "Supprimer ID=".$service->ID." - ".$service->nom."<br>";
				$service->supprimer();
				}	
			}
		} // FIN function nettoyerLiensServices()

	/** 
	* Permet de lier un contact au service
	* @param int $ID_contact ID du contact à lier au service
	* @param string $role role du contact dans le service
	* @param int $defaut (facultatif) Le contact est il le contact par défaut du service, 0 ou 1, 0 si non renseigné
	* @access  public 
	*/
	function lierContact($ID_contact,$role,$defaut = 0)
		{
		if($defaut==1)
			{
			//on supprime le contact par defaut s'il est différent du notre
			$sql = "UPDATE annuaire_rel_contact_service SET parDefaut = 0 
							WHERE ID_service = ".$this->ID." 
							AND parDefaut = 1
							AND ID_contact != ".$ID_contact;
			$result = $this->query($sql);
			}
		//le contact par defaut a été modifié, maintenant on mets le nouveau
		$sql = "SELECT * FROM annuaire_rel_contact_service WHERE ID_service = ".$this->ID." AND ID_contact = '".$ID_contact."'";
		$result = $this->query($sql);
		//on update
		if($result->numRows() != 0)
			{
			$sql = "UPDATE annuaire_rel_contact_service 
							SET parDefaut = ".$defaut.", role = '".$role."' 
							WHERE ID_service = ".$this->ID." AND ID_contact = ".$ID_contact;
			}
		else //on insere
			{
			$sql = "INSERT INTO annuaire_rel_contact_service (ID_service,ID_contact,parDefaut,role) 
							VALUES (".$this->ID.",".$ID_contact.",".$defaut.",'".$role."')";
			}
		$result = $this->query($sql);
		}	
	
	/** 
	* Permet de lier une adresse à un service
	* @param int $ID_adresse ID de l'adresse à lier au service
	* @param int $defaut (facultatif) L'adresse est elle l'adresse par défaut du service, 0 ou 1, 0 si non renseigné
	* @access  public 
	*/
	function lierAdresse($ID_adresse,$defaut = 0)
		{
		if($defaut==1)
			{
			//on supprime l'adresse par defaut si elle est différente du notre
			$sql = "UPDATE annuaire_rel_service_adresse SET parDefaut = 0 
							WHERE ID_service = ".$this->ID." 
							AND parDefaut = 1
							AND ID_adresse != '".$ID_adresse."'";
			$result = $this->query($sql);
			}
		//l'adresse par defaut a été modifiée, maintenant on mets la nouvelle
		$sql = "SELECT * FROM annuaire_rel_service_adresse WHERE ID_service = '".$this->ID."' AND ID_adresse = '".$ID_adresse."'";
		$result = $this->query($sql);
		//on update
		if($result->numRows() != 0)
			{
			$sql = "UPDATE annuaire_rel_service_adresse SET parDefaut = '".$defaut."' WHERE ID_service = '".$this->ID."' AND ID_adresse = '".$ID_adresse."'";
			}
		else //on insere
			{
			$sql = "INSERT INTO annuaire_rel_service_adresse (ID_service,ID_adresse,parDefaut) VALUES ('".$this->ID."','".$ID_adresse."','".$defaut."')";
			}
		$result = $this->query($sql);
		}	

	/** 
	* Permet de delier les adresses à un service
	* @access  public 
	*/
	function delierAdresses()
		{
		$sql = "DELETE FROM annuaire_rel_service_adresse WHERE ID_service = '".$this->ID."'";
		$result = $this->query($sql);
		}	

	/** 
	* Permet de lier un moyen de communication à un service
	* @param int $ID_communication ID de le moyen de communication à lier au service
	* @param int $defaut (facultatif) Le moyen de communication est il le moyen de communication par défaut 
	* du service, 0 ou 1, 0 si non renseigné
	* @access  public 
	*/
	function lierCommunication($ID_communication,$defaut = 0)
		{
		if($defaut==1)
			{
			//on supprime le moyen de communication par defaut s'il est différent du notre
			$sql = "UPDATE annuaire_rel_service_communication SET parDefaut = 0 
							WHERE ID_service = ".$this->ID." 
							AND parDefaut = 1
							AND ID_communication <> ".$ID_communication;
			$result = $this->query($sql);
			}
		//le moyen de communication par defaut a été modifié, maintenant on mets le nouveau
		$sql = "SELECT * FROM annuaire_rel_service_communication WHERE ID_service = ".$this->ID." AND ID_communication = ".$ID_communication;
		$result = $this->query($sql);
		//on update
		if($result->numRows() != 0)
			{
			$sql = "UPDATE annuaire_rel_service_communication SET parDefaut = ".$defaut." WHERE ID_service = ".$this->ID." AND ID_communication = ".$ID_communication;
			}
		else //on insere
			{
			$sql = "INSERT INTO annuaire_rel_service_communication (ID_service,ID_communication,parDefaut) VALUES (".$this->ID.",".$ID_communication.",".$defaut.")";
			}
		$result = $this->query($sql);
		}	
	
	/** 
	* Lie les catégories à l'objet en cours
	* @param array $valeur tableau contenant les inputs (value=on)
	* @param int $ID_support ID du support concerné
	* @access  public 
	*/
	function lierServiceCategories($valeurs)
		{
		// On supprime les liens catégorie-service existants
		$sql = "DELETE FROM annuaire_rel_categorie_service WHERE ID_service = '".$this->ID."'";
		$result = $this->query($sql);

		$support = new Tannuaire_support();
		$supports = $support->listerSupport();
		for ($i=0; $i<count($supports); $i++)
			{
			$ID_support = $supports[$i]['ID'];
			if ($valeurs['categories'][$ID_support])
				{
				//pour tous les checkboxes existantes
				while(list ($ID_categorie, $checked) = each ($valeurs['categories'][$ID_support])) 
					{
					//on regarde si en base, c'est lié
					$sql = "SELECT * FROM annuaire_rel_categorie_service WHERE ID_categorie = ".$ID_categorie." AND ID_service = ".$this->ID;
					$result = $this->query($sql);
		
					//si c'est lié en base, et que la case n'est pas cochée, on délie
					if($result->numRows() != 0 && $checked != 'on')
						{
						$sql = "DELETE FROM annuaire_rel_categorie_service WHERE ID_categorie = ".$ID_categorie." AND ID_service = ".$this->ID;
						$result = $this->query($sql);
						}
					//si ce n'est pas lié en base, et que la case est cochée, on lie
					if($result->numRows() == 0 && $checked == 'on')
						{						
						$sql = "INSERT INTO annuaire_rel_categorie_service (ID_categorie,ID_service,visible,descriptif) 
										VALUES(".$ID_categorie.",".$this->ID.", '1', '".$valeurs['descriptif'][$ID_support][$ID_categorie]."')";
						$result = $this->query($sql);
						}
					} // FIN while(list ($ID_categorie, $checked) = each ($valeurs[$i])) 
				} // FIN if ($valeurs[$i])
			} // FIN for ($i=0; $i<count($supports); $i++)
		} // FIN function lierServiceCategories($valeurs)
	
	/** 
	* Lister tous les services, triés par ID
	* @return array Tableau contenant les informations sur les services
	* @access  public 
	*/
	function listerServices()
		{
		$sql = "SELECT * FROM annuaire_obj_service ORDER BY ID";
		$result = $this->query($sql);
		while($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
			{
			$retour[] = $row;
			}
		return($retour);
		}

	/** 
	* Lister les adresses d'un service
	* @return array Tableau contenant les ID des adresses 
	* @access  public 
	*/
	function listerAdresses()
		{
		$sql = "SELECT ID_adresse FROM annuaire_rel_service_adresse WHERE ID_service = ".$this->ID;
		$result = $this->query($sql);
		while($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
			{
			$retour[] = $row['ID_adresse'];
			}
		return($retour);
		}

	/** 
	* Lister les contacts d'un service
	* @return array Tableau contenant les infos des contacts
	* @access  public 
	*/
	function listerContacts()
		{
		$sql = "SELECT * FROM annuaire_rel_contact_service 
						WHERE ID_service = '".$this->ID."' 
						ORDER BY ordre ASC, parDefaut DESC, ID_contact ASC";
		$result = $this->query($sql);
		while($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
			{
			$retour[] = $row;
			}
		return($retour);
		}
	
	/** 
	* Lister les communications d'un service
	* @return array Tableau contenant les infos des communications 
	* @access  public 
	*/
	function listerCommunications()
		{
		$sql = "SELECT annuaire_rel_service_communication.* 
						FROM annuaire_rel_service_communication, annuaire_obj_communication, annuaire_typ_communication 
						WHERE ID_service = '".$this->ID."' 
						AND annuaire_obj_communication.ID = annuaire_rel_service_communication.ID_communication
						AND annuaire_obj_communication.ID_communication = annuaire_typ_communication.ID
						ORDER BY annuaire_typ_communication.ordre ASC, annuaire_obj_communication.numero ASC";
		$result = $this->query($sql);
		while($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
			{
			$retour[] = $row;
			}
		return($retour);
		}

	/** 
	* Renvoie la structure correspondante au service
	* @param int $ID_contact L'ID du contact
	* @return string Le rôle
	* @access  public 
	*/
	function getStructure()
		{
		$sql = "SELECT ID_structure	FROM annuaire_rel_structure_service 
						WHERE ID_service = '".$this->ID."'";
		$result = $this->query($sql);
		$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
		return($row['ID_structure']);
		}

	/** 
	* Renvoie les numéros de communication correspondants au type ID_typ_communication
	* et appartenant au service instancié
	* @param int $ID_typ_communication Le type de communication
	* @return string Le numéro
	* @access  public 
	*/
	function getCommunication($ID_typ_communication)
		{
		$sql = "SELECT annuaire_obj_communication.numero
						FROM annuaire_rel_service_communication, annuaire_obj_communication 
						WHERE ID_service = '".$this->ID."'
						AND annuaire_obj_communication.ID_communication = '".$ID_typ_communication."'
						AND annuaire_rel_service_communication.ID_communication = annuaire_obj_communication.ID";
		$result = $this->query($sql);
		$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
		return($row['numero']);
		}

	/** 
	* Renvoie le rôle d'un contact dans un service
	* @param int $ID_contact L'ID du contact
	* @return string Le rôle
	* @access  public 
	*/
	function getRole($ID_contact)
		{
		$sql = "SELECT role	FROM annuaire_rel_contact_service 
						WHERE ID_service = '".$this->ID."'
						AND ID_contact = '".$ID_contact."'";
		$result = $this->query($sql);
		$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
		return(stripslashes($row['role']));
		}

	function verifierServiceNonLie()
		{
		$listeServices = array();
		$sql = "SELECT * FROM annuaire_obj_service ORDER BY ID";
		$result = $this->query($sql);
		while($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
			{
			$sql2 = "SELECT * FROM annuaire_rel_categorie_service WHERE ID_service = '".$row['ID']."'";
			$result2 = $this->query($sql2);
			
			if ($result2->numRows() == '0')
				{
				$listeServices[] = $row['ID'];
				}	
			}
		return $listeServices;
		}


	/** 
	* Modifie l'ordre des contacts dans un service
	* @param array $valeurs POST
	* @access  public 
	*/
	function enregistrerOrdreContact($valeurs)
		{
		while(list ($ID_contact) = each ($_POST['ordre'])) 
				{
				$sql = "UPDATE annuaire_rel_contact_service 
												SET ordre = '".$_POST['ordre'][$ID_contact]."' 
												WHERE ID_contact = '".$ID_contact."' 
												AND ID_service = '".$_POST['ID_service']."'";
				$result = $this->query($sql);
				}
		} // FIN function enregistrerOrdreContact($valeurs)

		
	/** 
	* Nommer la photo correspondante au service
	* @return string Le nom de la photo
	* @access  public 
	*/
	function nommerPhoto()
		{
		/* $structure = new Tannuaire_structure($this->getStructure());
		$nom = $this->filtrerCaracteresSpeciaux($structure->nom.'_-_'.$this->nom.'_'.$this->ID);
		$nomPhoto = $this->repertoireImagesAnnuaireService.$nom;

		$nomPhoto = $this->supprimerAccents(strtolower(trim($nomPhoto.'.jpg')));
		$nomPhoto = str_replace(' ', '_', $nomPhoto);
		$nomPhoto = str_replace('___', '_', $nomPhoto);
		$nomPhoto = str_replace('__', '_', $nomPhoto);
		return $nomPhoto; */
		
		$nomPhoto = $this->repertoireImagesAnnuaireService.$this->ID.'.jpg';
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