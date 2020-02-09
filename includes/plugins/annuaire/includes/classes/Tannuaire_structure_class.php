<?
/**
* Classe permetant la gestion des structures dans l'annuaire
*
* @author  Thomas Vendé <thomas.vende@laetis.fr>
* @see T_LAETIS_site::modifierAttributs()
*/
class Tannuaire_structure extends Tannuaire_moteur_recherche
	{
	/** 
	* @var int $ID ID de l'element en base de donnée
	* @access  private 
	*/
	var $ID;
	
	/** 
	* @var string $nom Nom de la structure
	* @access  private 
	*/
	var $nom;
	
	/** 
	* @var string $formeJuridique Forme juridique de la structure
	* @access  private 
	*/
	var $formeJuridique;
	
	/** 
	* @var int $anneeCreation Année de création de la structure
	* @access  private 
	*/
	var $anneeCreation;
	
	/** 
	* @var string $ID_typ_classement ID du classement de l'entreprise de la structure (si assoc ou entreprise)
	* @access  private 
	*/
	var $ID_typ_classement;
	
	/** 
	* @var string $siret Numéro SIRET de la structure (si entreprise)
	* @access  private 
	*/
	var $siret;
	
	/** 
	* @var int $ID_typ_structure Type de structure
	* @access  private 
	*/
	var $ID_typ_structure;
	
	/** 
	* @var int $effectifTotal Effectif total de la structure
	* @access  private 
	*/
	var $effectifTotal;
	
	/** 
	* @var string $descriptif Descripti de la structure
	* @access  private 
	*/
	var $descriptif;
	
	/** 
	* @var Array $listeServices Liste des services de la structure
	* @access  private 
	*/
	var $listeServices;
	
	/** 
	* @var int $ID_serviceDefaut ID du service par defaut de la structure
	* @access  private 
	*/
	var $ID_serviceDefaut;
	
	/** 
	* Constructeur de l'objet
	* Initialise aussi la liste de services
	* @param int ID (facultatif) ID de l'element à initialiser (si non renseigné, aucune initialisation)
	* @return Tannuaire_structure l'objet créé
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
			$sql = "SELECT * FROM annuaire_obj_structure WHERE ID = ".$ID;
			$result = $this->query($sql);
			$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
			$this->nom = stripslashes($row['nom']);
			$this->formeJuridique = $row['formeJuridique'];
			$this->anneeCreation = $row['anneeCreation'];
			$this->ID_typ_classement = $row['ID_typ_classement'];
			$this->siret = $row['siret'];
			$this->descriptif = $row['descriptif'];
			$this->ID_typ_structure = $row['ID_typ_structure'];
			$this->effectifTotal = $row['effectifTotal'];

			// Récupération de la liste des ID des services	
			$sql = "SELECT DISTINCT annuaire_rel_structure_service.*
							FROM annuaire_rel_structure_service, annuaire_obj_service
							WHERE ID_structure = ".$ID."
							AND annuaire_rel_structure_service.ID_service = annuaire_obj_service.ID
							ORDER BY annuaire_rel_structure_service.parDefaut DESC, annuaire_obj_service.nom ASC";
			$result = $this->query($sql);
			while($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
				{
				if($row['parDefaut'] == 1)
					{
					$this->ID_serviceDefaut = $row['ID_service'];
					}
				$this->listeServices[]=$row;
				}
			}
		}
	
	/** 
	* Alias du constructeur (compatibilité PHP4)
	* @param int $ID (facultatif) ID de l'element à initialiser (si non renseigné, aucune initialisation)
	* @return Tannuaire_structure l'objet créé
	* @see Tannuaire_structure::__construct()
	* @access  public 
	*/
	function Tannuaire_structure($ID = 0)
		{
		$this->__construct($ID);
		}
	
	/** 
	* Enregistre l'objet en base de donnée
	* Effectue aussi la liaison avec le service par defaut
	* Si l'ID est renseigné ==> modification
	* Sinon ==> insertion
	* @access  public 
	*/
	function enregistrer()
		{
		//si l'ID est renseigné, on modifie, sinon, on insere
		if($this->ID == 0)
			{
			$sql = "INSERT INTO annuaire_obj_structure 
							(ID , nom , formeJuridique, anneeCreation, ID_typ_classement, siret, ID_typ_structure, effectifTotal, descriptif) 
							VALUES ('', '".$this->nom."', '".$this->formeJuridique."', '".$this->anneeCreation."', '".$this->ID_typ_classement."', 
							'".$this->siret."', '".$this->ID_typ_structure."', '".$this->effectifTotal."', '".$this->descriptif."');";
			$result = $this->query($sql);
			$this->ID = $this->last_insert_id();
			}
		else //on modifie
			{
			$sql = "UPDATE annuaire_obj_structure SET 
					nom = '".$this->nom."', 
					formeJuridique = '".$this->formeJuridique."', 
					anneeCreation = '".$this->anneeCreation."', 
					ID_typ_classement = '".$this->ID_typ_classement."', 
					siret = '".$this->siret."', 
					descriptif = '".$this->descriptif."', 
					ID_typ_structure = '".$this->ID_typ_structure."', 
					effectifTotal = '".$this->effectifTotal."'
					WHERE ID = ".$this->ID;
			$result = $this->query($sql);
			}
		//gestion du service par defaut
		if($this->ID_serviceDefaut)
			{
			$this->lierService($this->ID_serviceDefaut, 1);
			}
		}
		
	/** 
	* Supprime l'objet en base de donnée (mais ne détruit pas l'objet PHP)
	* Cette méthode remet l'ID à 0, pour une re-enregistrement éventuel
	* @access  public 
	*/
	function supprimer()
		{
		$sql = "DELETE FROM annuaire_obj_structure WHERE ID = ".$this->ID;
		$result = $this->query($sql);
		
		for ($i=0; $i<count($this->listeServices); $i++)
			{
			$service = new Tannuaire_service($this->listeServices[$i]['ID_service']);
			$service->supprimer();
			}

		$this->ID = 0;
		}

	/** 
	* Nettoyer les éléments non utilisés dans les table annuaire_rel_structure_service
	* @access  public 
	*/
	function nettoyerLiensStructures()
		{
		// Suppression du lien si la structure n'existe plus
		$sql = "SELECT ID_structure FROM annuaire_rel_structure_service";
		$result = $this->query($sql);
		while($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
			{
			$sql2 = "SELECT ID FROM annuaire_obj_structure WHERE ID = '".$row['ID_structure']."'";
			$result2 = $this->query($sql2);
			
			if ($result2->numRows() == '0')
				{
				//echo "Suppression de la structure ".$row['ID_structure']."<br>";
				$structure = new Tannuaire_structure($row['ID_structure']);
				$structure->supprimer();
				}
			} // while($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
		}

	/** 
	* Exporte dans un fichier les informations sur les structures
	* @param int $nomFichier Nom du fichier renvoyé
	* @access  public 
	*/
	function exporter($nomFichier)
		{
		$sql = "SELECT * INTO OUTFILE '".$nomFichier."'
						FIELDS TERMINATED BY '\;' ENCLOSED BY '\\\"' ESCAPED BY '\\\\' LINES TERMINATED BY '\\r\\n' 
						FROM annuaire_obj_structure";		
		$result = $this->query($sql);		
		}

	/** 
	* Renvoie la liste des codes NAF pris en charge
	* @return Array composé des code NAF et des libellés correspondants ($tab[0]['ID'] et $tab[0]['type'])
	* @access  public 
	*/
	function listerCodesNaf()
		{
		$sql = "SELECT * FROM annuaire_typ_naf ORDER BY type";
		$result = $this->query($sql);
		while($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
			{
			$retour[] = $row;
			}
		return $retour;
		}
	
	/** 
	* Renvoie la liste des codes associations pris en charge
	* @return Array composé des code associations et des libellés correspondants ($tab[0]['ID'] et $tab[0]['type'])
	* @access  public 
	*/
	function listerCodesAssociations()
		{
		$sql = "SELECT * FROM annuaire_typ_association ORDER BY type";
		$result = $this->query($sql);
		while($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
			{
			$retour[] = $row;
			}
		return $retour;
		}
		
	/** 
	* Renvoie la liste des types de structures pris en charge
	* @return Array composé des ID et des libellés correspondants ($tab[0]['ID'] et $tab[0]['type'])
	* @access  public 
	*/
	function listerTypeStructure()
		{
		$sql = "SELECT * FROM annuaire_typ_structure ORDER BY ID";
		$result = $this->query($sql);
		while($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
			{
			$retour[] = $row;
			}
		return $retour;
		}

	/** 
	* Renvoie le type de la structures correspondant à ID_typ_structure
	* @param int $ID_typ_structure L'ID du type de structure
	* @return string Le type de la structure
	* @access  public 
	*/
	function getTypeStructure($ID_typ_structure)
		{
		$sql = "SELECT type FROM annuaire_typ_structure WHERE ID = '".$ID_typ_structure."'";
		$result = $this->query($sql);
		$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
		return $row['type'];
		}

	/** 
	* Renvoie le type de la structures correspondant à ID_typ_structure
	* @param int $ID_typ_structure L'ID du type de structure
	* @return string Le type de la structure
	* @access  public 
	*/
	function getTypeClassement($ID_typ_classement)
		{
		$sql = "SELECT annuaire_typ_association.type AS type_asso, annuaire_typ_naf.type AS type_naf
						FROM annuaire_typ_association, annuaire_typ_naf 
						WHERE annuaire_typ_association.ID = '".$ID_typ_classement."' OR annuaire_typ_naf.ID = '".$ID_typ_classement."'";
		$result = $this->query($sql);
		$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
		return $row;
		}

	/** 
	* Détermine si le service passé en argument est le service par défaut de la structure
	* @param int $ID_service L'ID du service
	* @return boolean 
	* @access  public 
	*/
	function getServiceDefaut($ID_service)
		{
		if ($this->ID_serviceDefaut == $ID_service)
			{ return true; }
		return false;
		}


	/** 
	* Permet de lier un service à une structure
	* @param int $ID_service ID du service à lier à la structure
	* @param int $defaut (facultatif) Le service est il le service par defaut de la structure, 0 ou 1, 0 si non renseigné
	* @access  public 
	*/
	function lierService($ID_service,$defaut = 0)
		{
		if($defaut==1)
			{
			//on supprime le service par defaut s'il est différent du notre
			$sql = "UPDATE annuaire_rel_structure_service SET parDefaut = 0 
							WHERE ID_structure = ".$this->ID." 
							AND parDefaut = 1
							AND ID_service <> ".$ID_service;
			$result = $this->query($sql);
			}
		//le service par defaut a été modifié, maintenant on mets le nouveau
		$sql = "SELECT * FROM annuaire_rel_structure_service WHERE ID_structure = '".$this->ID."' AND ID_service = ".$ID_service;
		$result = $this->query($sql);
		//on update
		if($result->numRows() != 0)
			{
			$sql = "UPDATE annuaire_rel_structure_service SET parDefaut = ".$defaut." 
							WHERE ID_structure = ".$this->ID." AND ID_service = ".$ID_service;
			}
		else //on insere
			{
			$sql = "INSERT INTO annuaire_rel_structure_service (ID_structure,ID_service,parDefaut) 
							VALUES (".$this->ID.",".$ID_service.",".$defaut.")";
			}
		$result = $this->query($sql);
		}

	/** 
	* Renvoie la liste des structures
	* @return Array composé des ID et des libellés correspondants
	* @access  public 
	*/
	function listerStructures()
		{
		$sql = "SELECT * FROM annuaire_obj_structure ORDER BY ID";
		$result = $this->query($sql);
		while($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
			{
			$retour[] = $row;
			}
		return $retour;
		}

	/** 
	* Renvoie la liste des structures ayant un ID_typ_structure = $ID_typ_structure
	* @return Array composé des ID et des libellés correspondants
	* @access  public 
	*/
	function listerStructuresIDTypStructure($ID_typ_structure)
		{
		$sql = "SELECT * FROM annuaire_obj_structure WHERE ID_typ_structure = '".$ID_typ_structure."' ORDER BY ID";
		$result = $this->query($sql);
		while($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
			{
			$retour[] = $row;
			}
		return $retour;
		}

	/** 
	* Dupliquer l'adresse par défaut du service par défaut de la structure 
	* au service passé en argument ou à tous les autres services de la structure si pas d'argument
	* @access  public 
	*/
	function dupliquerServiceAdresse($ID_service = '')
		{
		if ($ID_service)
			{
			$service = new Tannuaire_service($this->ID_serviceDefaut);
			$serviceAModifier = new Tannuaire_service($ID_service);
			$serviceAModifier->supprimerAdresses();
			$serviceAModifier->lierAdresse($service->ID_adresseDefaut, 1);
			}
		else
			{
			$service = new Tannuaire_service($this->ID_serviceDefaut);
			for ($i=0; $i<count($this->listeServices); $i++)
				{
				$serviceAModifier = new Tannuaire_service($this->listeServices[$i]['ID_service']);
				$serviceAModifier->supprimerAdresses();
				$serviceAModifier->lierAdresse($service->ID_adresseDefaut, 1);
				} // for ($i=0; $i<count($this->listeServices); $i++)
			} // FIN else
		}

	/** 
	* Dupliquer les communications du service par défaut de la structure à tous les autres services de la structure
	* @access  public 
	*/
	function dupliquerServiceCommunication()
		{
		$service = new Tannuaire_service($this->ID_serviceDefaut);
		$communications = $service->listerCommunications();

		for ($i=0; $i<count($this->listeServices); $i++)
			{
			$serviceAModifier = new Tannuaire_service($this->listeServices[$i]['ID_service']);
			for ($j=0; $j<count($communications); $j++)
				{
				$serviceAModifier->lierCommunication($communications[$j]['ID_communication'], $communications[$j]['parDefaut']);
				}
			} // for ($i=0; $i<count($this->listeServices); $i++)
		}

	/** 
	* Dupliquer les contacts du service par défaut de la structure à tous les autres services de la structure
	* @access  public 
	*/
	function dupliquerServiceContact()
		{
		$service = new Tannuaire_service($this->ID_serviceDefaut);
		$contacts = $service->listerContacts();

		for ($i=0; $i<count($this->listeServices); $i++)
			{
			$serviceAModifier = new Tannuaire_service($this->listeServices[$i]['ID_service']);
			for ($j=0; $j<count($contacts); $j++)
				{
				$serviceAModifier->lierContact($contacts[$j]['ID_contact'], $contacts[$j]['role'], $contacts[$j]['parDefaut']);
				}
			} // for ($i=0; $i<count($this->listeServices); $i++)
		}

	}
?>