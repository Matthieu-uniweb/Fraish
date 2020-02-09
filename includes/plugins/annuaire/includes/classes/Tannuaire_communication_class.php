<?
/**
* Classe permetant la gestion des moyens de communication dans l'annuaire
*
* @author  Thomas Vendé <thomas.vende@laetis.fr>
* @see T_LAETIS_site::modifierAttributs()
*/
class Tannuaire_communication extends T_LAETIS_site
	{
	/** 
	* @var int $ID ID de l'element en base de donnée
	* @access  private 
	*/
	var $ID;
	
	/** 
	* @var string $libelle Descriptif du moyen de communication
	* @access  private 
	*/
	var $libelle;
	
	/** 
	* @var string $numero Numéro du moyen de communication
	* @access  private 
	*/
	var $numero;

	/** 
	* @var int $ID_communication Type du moyen de communication
	* @access  private 
	*/
	var $ID_communication;
	
	/** 
	* Constructeur de l'objet
	* @param int $ID (facultatif) ID de l'element à initialiser (si non renseigné, aucune initialisation)
	* @return Tannuaire_communication l'objet créé
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
			$sql = "SELECT * FROM annuaire_obj_communication WHERE ID = '".$ID."'";
			$result = $this->query($sql);
			$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
			$this->libelle = $row['libelle'];
			$this->numero = $row['numero'];
			$this->ID_communication = $row['ID_communication'];
			}
		}
	
	/** 
	* Alias du constructeur (compatibilité PHP4)
	* @param int $ID (facultatif) ID de l'element à initialiser (si non renseigné, aucune initialisation)
	* @return Tannuaire_communication l'objet créé
	* @see Tannuaire_communication::__construct()
	* @access  public 
	*/
	function Tannuaire_communication($ID = 0)
		{
		$this->__construct($ID);
		}
	
	/** 
	* Enregistre l'objet en base de donnée
	* Si l'ID est renseigné ==> modification
	* Sinon ==> insertion
	* @access  public 
	*/
	function enregistrer()
		{
		//si l'ID est renseigné, on modifie, sinon, on insere
		if($this->ID == 0)
			{
			$sql = "INSERT INTO annuaire_obj_communication ( ID , libelle , numero , ID_communication ) 
							VALUES ('', '".$this->libelle."', '".$this->numero."', '".$this->ID_communication."');";
			$result = $this->query($sql);
			$this->ID = $this->last_insert_id();
			}
		else //on modifie
			{
			$sql = "UPDATE annuaire_obj_communication SET 
							libelle = '".$this->libelle."',
							numero = '".$this->numero."',
							ID_communication = '".$this->ID_communication."'
							WHERE ID = '".$this->ID."'";
			$result = $this->query($sql);
			}
		}
	
	/** 
	* Supprime l'objet en base de donnée (mais ne détruit pas l'objet PHP)
	* Cette méthode remet l'ID à 0, pour une re-enregistrement éventuel
	* @access  public 
	*/
	function supprimer()
		{
		$sql = "DELETE FROM annuaire_obj_communication WHERE ID = '".$this->ID."'";
		$result = $this->query($sql);
		$sql = "DELETE FROM annuaire_rel_contact_communication WHERE ID_communication = '".$this->ID."'";
		$result = $this->query($sql);
		$sql = "DELETE FROM annuaire_rel_service_communication WHERE ID_communication = '".$this->ID."'";
		$result = $this->query($sql);
		$this->ID = 0;
		}

	/** 
	* Nettoyer les éléments non utilisés dans les table annuaire_rel_contact_communication et annuaire_rel_service_communication
	* @access  public 
	*/
	function nettoyerLiensCommunications()
		{
		// SUPPRESSION DES COMMUNICATIONS ET LIENS COMMUNICATIONS NON UTILISES
		$sql = "SELECT DISTINCT annuaire_rel_contact_communication.ID_communication FROM annuaire_rel_contact_communication";
		$result = $this->query($sql);
		while($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
			{	$listeIDCommunication[] = $row['ID_communication'];	}

		$sql2 = "SELECT DISTINCT annuaire_rel_service_communication.ID_communication FROM annuaire_rel_service_communication";
		$result2 = $this->query($sql2);
		while($row2 = $result2->fetchRow(DB_FETCHMODE_ASSOC))
			{	$listeIDCommunication2[] = $row2['ID_communication'];	}
		
		$listeIDCommunication = array_merge($listeIDCommunication, $listeIDCommunication2);
		array_unique($listeIDCommunication);

		for ($i=0; $i<count($listeIDCommunication); $i++)
			{
			$sql = "SELECT ID FROM annuaire_obj_communication 
							WHERE ID = '".$listeIDCommunication[$i]."'";
			$result = $this->query($sql);
			
			if ($result->numRows() == '0')
				{
				//echo "Suppresion de ID = ".$listeIDCommunication[$i]."<br>";
				$adresse = new Tannuaire_communication($listeIDCommunication[$i]);
				$adresse->supprimer();
				}
			} // FIN for ($i=0; $i<count($listeIDCommunication); $i++)

		// SUPPRESSION DES COMMUNICATIONS QUI NE SONT PLUS LIEES A UN CONTACT OU UN SERVICE
		$sql = "SELECT DISTINCT annuaire_obj_communication.ID FROM annuaire_obj_communication";
		$result = $this->query($sql);
		
		while($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
			{
			$sql1 = "SELECT COUNT(*) FROM annuaire_rel_service_communication	
							WHERE annuaire_rel_service_communication.ID_communication = '".$row['ID']."'";
			$result1 = $this->query($sql1);
			$row1 = $result1->fetchRow();

			$sql2 = "SELECT COUNT(*) FROM annuaire_rel_contact_communication 
							WHERE annuaire_rel_contact_communication.ID_communication = '".$row['ID']."'";
			$result2 = $this->query($sql2);
			$row2 = $result2->fetchRow();

			if ( ($row1[0]+$row2[0]) == '0')
				{
				//echo "Suppression de ID = ".$row['ID']."<br>";
				$adresse = new Tannuaire_communication($row['ID']);
				$adresse->supprimer();				
				}
			} // FIN while($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
		}

	/** 
	* Renvoie la liste des types de communications pris en charge
	* @return Array composé des ID et libellés des moyens de communication ($tab[0]['ID'] et $tab[0]['type'])
	* @access  public 
	*/
	function listerTypeCommunication()
		{
		$sql = "SELECT * FROM annuaire_typ_communication ORDER BY ordre ASC";
		$result = $this->query($sql);
		while($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
			{
			$retour[] = $row;
			}
		return $retour;
		}
		
	/** 
	* Affichage global des communications
	* @param string $styleLien Style du lien
	* @param bool $affichageDescriptif (facultatif) Si on souhaite afficher le type de la communication
	* @return string La chaine qui sera afficher
	* @access  public 
	*/
	function afficherCommunication($styleLien, $affichageComInterne = false, $affichageDescriptif = true)
		{
		$sql = "SELECT * FROM annuaire_typ_communication WHERE ID = '".$this->ID_communication."'";
		$result = $this->query($sql);
		$row = $result->fetchRow(DB_FETCHMODE_ASSOC);

		//if ( ($affichageDescriptif) && ($row['ID'] != '10') && ($row['ID'] != '11') )
			//{ $html = "<b>".$row['type']."</b> : "; }

		switch ($row['ID'])
			{
			case 1:
				$html = "Courriel : ";
				$html .= "<a href='mailto:".$this->numero."' class='".$styleLien."'>".$this->numero."</a>";
				break;
			case 2:
				$html = "Site Internet : ";
				if(substr($this->numero,0,7) != 'http://')
					{
					$this->numero = 'http://'.$this->numero;
					}
				$html .= "<a href='".$this->numero."' class='".$styleLien."' target=\"_blank\" >".$this->numero."</a>";
				break;
			case 3:
				$html = "Fax. ";
				$html .= $this->numero;
				break;			
			case 4:
				$html = "Port. ";
				$html .= $this->numero;
				break;			
			case 5:
				$html = "Tel/Fax. ";
				$html .= $this->numero;
				break;			
			case 6:
				$html = "Tel. ";
				$html .= $this->numero;
				break;			
			case 7:
				$html = "Num. spécial. ";
				$html .= $this->numero;
				break;			
			case 8:
				$html = "Minitel : ";
				$html .= $this->numero;
				break;			
			case 9:
				$html = "Autre : ";
				$html .= $this->numero;
				break;
			// Téléphone interne
			// On ne souhaite pas qu'il soit affiché sur le front
			case 10:
				if ($affichageComInterne)
					{
					$html = "Tél. Interne : ";
					$html .= $this->numero;
					}
				break;
			// Téléphone interne
			// On ne souhaite pas qu'il soit affiché sur le front
			case 11:
				if ($affichageComInterne)
					{
					$html = "Courriel Interne : ";
					$html .= $this->numero;
					}
				break;
			case 12:
				$html = "Page : ";
				$html .= "<a href='".$this->numero."' class='".$styleLien."' target='fenetrePrincipale'>".$this->numero."</a>";
				break;				
			}
			
		// Un saut de ligne après l'affichage d'une communication
		if ($html)
			{ $html .= '<br>'; }

		return $html;
		}

	/** 
	* Rechercher un email : la recherche se fait sur les contacts ou les services
	* @param string $email Email recherché
	* @return array Un tableau avec l'ID du contact et l'ID_typ_contact correspondant à l'email recherché
	* @access  public 
	*/
	function rechercherEmail($email)
		{
		$sql = "SELECT ID FROM annuaire_obj_communication 
						WHERE numero = '".$email."' AND ID_communication = '1'";
		$result = $this->query($sql);
		$row = $result->fetchRow(DB_FETCHMODE_ASSOC);

		if ($row['ID'])
			{
			$sql = "SELECT ID_service FROM annuaire_rel_service_communication 
							WHERE ID_communication = '".$row['ID']."'";
			$result = $this->query($sql);
			$rowService = $result->fetchRow(DB_FETCHMODE_ASSOC);
			
			if ($rowService['ID_service'])
				{
				$retour['ID_contact'] = $rowService['ID_service'];
				$retour['ID_typ_contact'] = '2';
				return ($retour);
				}
			else
				{
				$sql = "SELECT ID_contact FROM annuaire_rel_contact_communication 
								WHERE ID_communication = '".$row['ID']."'";
				$result = $this->query($sql);
				$rowContact = $result->fetchRow(DB_FETCHMODE_ASSOC);
				
				if ($rowContact['ID_contact'])
					{
					$retour['ID_contact'] = $rowContact['ID_contact'];
					$retour['ID_typ_contact'] = '1';
					return ($retour);
					}
				} // FIN else if ($rowService['ID_service'])
			} // FIN if ($row['ID'])
		} // FIN function rechercherEmail($email)


	/** 
	* lister les communications correspondantes aux types ID_typ_communication
	* @param int $ID_typ_communication Types des communications recherchées
	* @return array Un tableau avec les informations sur les communications
	* @access  public 
	*/
	function listerCommunications($ID_typ_communication)
		{
		$sql = "SELECT * FROM annuaire_obj_communication 
						WHERE ID_communication IN ( '".$ID_typ_communication."' ) ORDER BY ID";
		$result = $this->query($sql);
		while($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
			{
			$retour[] = $row;
			}
		return($retour);
		}

	}
?>