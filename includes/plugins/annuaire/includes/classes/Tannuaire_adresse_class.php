<?
/**
* Classe permetant la gestion des adresses dans l'annuaire, en incluant les parametres de géocodage
*
* @author  Thomas Vendé <thomas.vende@laetis.fr>
* @see T_LAETIS_site::modifierAttributs()
*/

class Tannuaire_adresse extends T_LAETIS_site
	{
	/** 
	* @var int $ID ID de l'element en base de donnée
	* @access  private 
	*/
	var $ID;
	
	/** 
	* @var int $numeroVoie Numéro de la voie de l'adresse
	* @access  private 
	*/
	var $numeroVoie = 0;
	
	/** 
	* @var string $voie Nom de la voie de l'adresse
	* @access  private 
	*/
	var $voie;
	
	/** 
	* @var string $complement Complement d'adresse (BP, batiment, etc...)
	* @access  private
	*/
	var $complement; 
	
	/** 
	* @var string $codePostal Code postal de l'adresse
	* @access  private 
	*/
	var $codePostal;
	
	/** 
	* @var string $ville Nom de la ville de l'adresse
	* @access  private 
	*/
	var $ville;

	/** 
	* @var string $complementVille Complément de la ville de l'adresse
	* @access  private 
	*/
	var $complementVille;
	
	/** 
	* @var int $codeInsee Code insee de la ville de l'adresse
	* @access  private 
	*/
	var $codeInsee = 0;
	
	/** 
	* @var int $x Positionnement géocodage (longitude) de l'adresse
	* @access  private 
	*/
	var $x = 0;
	
	/** 
	* @var int $y Positionnement géocodage (latitude) de l'adresse
	* @access  private 
	*/
	var $y = 0;
	
	/** 
	* @var int $ID_geocodage Type de géocodage utilisé pour les attributs x et y
	* @access  private 
	*/
	var $ID_geocodage = 0;
	
	/** 
	* Constructeur de l'objet
	* @param int $ID (facultatif) ID de l'element à initialiser (si non renseigné, aucune initialisation)
	* @return Tannuaire_adresse l'objet créé
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
			$sql = "SELECT * FROM annuaire_obj_adresse WHERE ID = '".$ID."'";
			$result = $this->query($sql);
			$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
			$this->numeroVoie = $row['numeroVoie'];
			$this->voie = $row['voie'];
			$this->complement = $row['complement'];
			$this->codePostal = $row['codePostal'];
			$this->ville = $row['ville'];
			$this->complementVille = $row['complementVille'];			
			$this->codeInsee = $row['codeInsee'];
			$this->x = $row['x'];
			$this->y = $row['y'];
			$this->ID_geocodage = $row['ID_geocodage'];
			}
		}
		
	/** 
	* Alias du constructeur (compatibilité PHP4)
	* @param int $ID (facultatif) ID de l'element à initialiser (si non renseigné, aucune initialisation)
	* @return Tannuaire_adresse l'objet créé
	* @see Tannuaire_adresse::__construct()
	* @access  public 
	*/
	function Tannuaire_adresse($ID = 0)
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
			$sql = "INSERT INTO annuaire_obj_adresse 
							(ID, numeroVoie, voie, complement, codePostal, ville, complementVille, codeInsee, x, y, ID_geocodage) 
							VALUES ('', '".$this->numeroVoie."', '".$this->voie."', '".$this->complement."', '".$this->codePostal."', 
							'".$this->ville."', '".$this->complementVille."', '".$this->codeInsee."', '".$this->x."', '".$this->y."', 
							'".$this->ID_geocodage."');";
			$result = $this->query($sql);
			$this->ID = $this->last_insert_id();
			}
		else //on modifie
			{
			$sql = "UPDATE annuaire_obj_adresse SET 
							numeroVoie = '".$this->numeroVoie."',
							voie = '".$this->voie."',
							complement = '".$this->complement."',
							codePostal = '".$this->codePostal."',
							ville = '".$this->ville."',
							complementVille = '".$this->complementVille."',
							codeInsee = '".$this->codeInsee."',
							x = '".$this->x."',
							y = '".$this->y."',
							ID_geocodage = '".$this->ID_geocodage."'
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
		$sql = "DELETE FROM annuaire_obj_adresse WHERE ID = '".$this->ID."'";
		$result = $this->query($sql);
		$sql = "DELETE FROM annuaire_rel_contact_adresse WHERE ID_adresse = '".$this->ID."'";
		$result = $this->query($sql);
		$sql = "DELETE FROM annuaire_rel_service_adresse WHERE ID_adresse = '".$this->ID."'";
		$result = $this->query($sql);
		$this->ID = 0;
		}

	/** 
	* Nettoyer les éléments non utilisés dans les table annuaire_rel_contact_adresse et annuaire_rel_service_adresse
	* @access  public 
	*/
	function nettoyerLiensAdresses()
		{
		// SUPPRESSION DES ADRESSES ET LIENS ADRESSES NON UTILISES
		$sql = "SELECT DISTINCT annuaire_rel_service_adresse.ID_adresse FROM annuaire_rel_service_adresse";
		$result = $this->query($sql);
		while($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
			{	$listeIDAdresse[] = $row['ID_adresse'];	}

		$sql2 = "SELECT DISTINCT annuaire_rel_contact_adresse.ID_adresse FROM annuaire_rel_contact_adresse";
		$result2 = $this->query($sql2);
		while($row2 = $result2->fetchRow(DB_FETCHMODE_ASSOC))
			{	$listeIDAdresse2[] = $row2['ID_adresse'];	}
		
		$listeIDAdresse = array_merge($listeIDAdresse, $listeIDAdresse2);
		array_unique($listeIDAdresse);

		for ($i=0; $i<count($listeIDAdresse); $i++)
			{
			$sql = "SELECT ID FROM annuaire_obj_adresse 
							WHERE ID = '".$listeIDAdresse[$i]."'";
			$result = $this->query($sql);
			
			if ($result->numRows() == '0')
				{
				//echo "Suppresion de ID = ".$listeIDAdresse[$i]."<br>";
				$adresse = new Tannuaire_adresse($listeIDAdresse[$i]);
				$adresse->supprimer();
				}
			} // FIN for ($i=0; $i<count($listeIDAdresse); $i++)
			
		// SUPPRESSION DES ADRESSES QUI NE SONT PLUS LIEES A UN CONTACT OU UN SERVICE
		$sql = "SELECT DISTINCT annuaire_obj_adresse.ID FROM annuaire_obj_adresse";
		$result = $this->query($sql);
		
		while($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
			{
			$sql1 = "SELECT COUNT(*) FROM annuaire_rel_service_adresse	WHERE annuaire_rel_service_adresse.ID_adresse = '".$row['ID']."'";
			$result1 = $this->query($sql1);
			$row1 = $result1->fetchRow();

			$sql2 = "SELECT COUNT(*) FROM annuaire_rel_contact_adresse WHERE annuaire_rel_contact_adresse.ID_adresse = '".$row['ID']."'";
			$result2 = $this->query($sql2);
			$row2 = $result2->fetchRow();

			if ( ($row1[0]+$row2[0]) == '0')
				{
				//echo "Suppression de ID = ".$row['ID']."<br>";
				$adresse = new Tannuaire_adresse($row['ID']);
				$adresse->supprimer();				
				}
			} // FIN while($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
		}

	/** 
	* Optimisation des tables
	* @access  public 
	*/
	function optimiserTables()
		{
		$sql = "OPTIMIZE TABLE `annuaire_obj_adresse` , `annuaire_obj_categorie` , `annuaire_obj_communication` , `annuaire_obj_contact` , `annuaire_obj_service` , `annuaire_obj_structure` , `annuaire_obj_support` , `annuaire_rel_categorie_categorie` , `annuaire_rel_categorie_service` , `annuaire_rel_categorie_support` , `annuaire_rel_contact_adresse` , `annuaire_rel_contact_communication` , `annuaire_rel_contact_service` , `annuaire_rel_service_adresse` , `annuaire_rel_service_communication` , `annuaire_rel_structure_service` , `annuaire_typ_association` , `annuaire_typ_communication` , `annuaire_typ_geocodage` , `annuaire_typ_naf` , `annuaire_typ_structure` ";
		$this->query($sql);
		}

	/** 
	* Reparer les tables
	* @access  public 
	*/
	function reparerTables()
		{
		$sql = "REPAIR TABLE `annuaire_obj_adresse` , `annuaire_obj_categorie` , `annuaire_obj_communication` , `annuaire_obj_contact` , `annuaire_obj_service` , `annuaire_obj_structure` , `annuaire_obj_support` , `annuaire_rel_categorie_categorie` , `annuaire_rel_categorie_service` , `annuaire_rel_categorie_support` , `annuaire_rel_contact_adresse` , `annuaire_rel_contact_communication` , `annuaire_rel_contact_service` , `annuaire_rel_service_adresse` , `annuaire_rel_service_communication` , `annuaire_rel_structure_service` , `annuaire_typ_association` , `annuaire_typ_communication` , `annuaire_typ_geocodage` , `annuaire_typ_naf` , `annuaire_typ_structure` ";
		$this->query($sql);
		}

	/** 
	* Renvoie la liste des possibilités de géocodages
	* @return Array composé des ID et libellés des géocodages ($tab[0]['ID'] et $tab[0]['type'])
	* @access  public 
	*/
	function listerTypeGeocodage()
		{
		$sql = "SELECT * FROM annuaire_typ_geocodage ORDER BY type";
		$result = $this->query($sql);
		while($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
			{
			$retour[] = $row;
			}
		return $retour;
		}

	/** 
	* Renvoie la liste des adresses triées par ID
	* @return Array composé des informations sur les adresses ($tab[0]['ID'] et $tab[0]['voie'])
	* @access  public 
	*/
	function listerAdresses()
		{
		$sql = "SELECT * FROM annuaire_obj_adresse ORDER BY ID";
		$result = $this->query($sql);
		while($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
			{
			$retour[] = $row;
			}
		return($retour);
		}

	/** 
	* affichage de l'adresse
	* @return string Le texte à afficher
	* @access  public 
	*/
	function afficherAdresse()
		{
		$html = '';
		if ( ($this->codeInsee != '0') && ($this->codeInsee != '100000') )
			{
			if ($this->ville != '')
				{ 
				if ($this->numeroVoie != 0)
					{ $html .= $this->numeroVoie;	}
				if ($this->voie)
					{ $html .= ' '.$this->voie; }
				if ($this->complement)
					{ $html .= ' - '.nl2br($this->complement); }
				if ( ($this->voie) || ($this->complement) )
					{ $html .= '<br>'; }
				
				$html .= $this->codePostal.' '.$this->ville;
				if ($this->complementVille)
					{ $html .= ' '.$this->complementVille; }
				} // FIN if($adresse->ville != '')
			} // FIN if ( ($this->codeInsee != '0') && ($this->codeInsee != '100000') )
		return $html;
		} // FIN function afficherAdresse();

	/** 
	* affichage de l'adresse
	* @return string Le texte à afficher
	* @access  public 
	*/
	function afficherRue()
		{
		$html = '';
		if ($this->ville != '')
			{ 
			if ($this->numeroVoie != 0)
				{ $html .= $this->numeroVoie;	}
			if ($this->voie)
				{ $html .= ' '.$this->voie; }
			if ($this->complement)
				{ $html .= ' - '.nl2br($this->complement); }
			$html .= '<br>';
			} // FIN if($adresse->ville != '')
		return $html;
		} // FIN function afficherAdresse();


	function supprimerToutHorsRodez()
		{
		$sql = "SELECT DISTINCT ID FROM annuaire_obj_adresse WHERE codeInsee != '12202' ";
		$result = $this->query($sql);

		while($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
			{	
			$sql2 = "SELECT DISTINCT ID_service FROM annuaire_rel_service_adresse 
							WHERE ID_adresse = '".$row['ID']."'";
			$result2 = $this->query($sql2);
			
			while($row2 = $result2->fetchRow(DB_FETCHMODE_ASSOC))
				{
				$sql3 = "SELECT DISTINCT ID_service FROM annuaire_rel_service_adresse 
								WHERE ID_service = '".$row2['ID_service']."' AND ID_adresse != '".$row['ID']."'";
				$result3 = $this->query($sql3);

				if ($result3->numRows() == '0')
					{
					$service = new Tannuaire_service($row2['ID_service']);
					//echo "Suppression service =".$service->nom."<br>";
					$service->supprimer();
					}
				} // while($row2 = $result2->fetchRow(DB_FETCHMODE_ASSOC))

			$sql4 = "SELECT DISTINCT ID_contact FROM annuaire_rel_contact_adresse 
							WHERE ID_adresse = '".$row['ID']."'";
			$result4 = $this->query($sql4);
			
			while($row4 = $result4->fetchRow(DB_FETCHMODE_ASSOC))
				{
				$sql5 = "SELECT DISTINCT ID_contact FROM annuaire_rel_contact_adresse 
								WHERE ID_contact = '".$row4['ID_contact']."' AND ID_adresse != '".$row['ID']."'";
				$result5 = $this->query($sql5);

				if ($result5->numRows() == '0')
					{
					$contact = new Tannuaire_contact($row4['ID_contact']);
					//echo "Suppression contact =".$contact->nom."<br>";
					$contact->supprimer();
					}
				} // while($row2 = $result2->fetchRow(DB_FETCHMODE_ASSOC))

			$adresse = new Tannuaire_adresse($row['ID']);
			//echo "Suppression adresse =".$adresse->ID."<br>";
			$adresse->supprimer();
			} // while($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
			
		// Suppression des structures qui n'ont plus de service
		$sql = "SELECT DISTINCT ID FROM annuaire_obj_structure";
		$result = $this->query($sql);
		while($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
			{
			$sql2 = "SELECT ID_service FROM annuaire_rel_structure_service WHERE ID_structure = '".$row['ID']."'";
			$result2 = $this->query($sql2);
			
			if ($result2->numRows() == '0')
				{
				//echo "Suppression de la structure ".$row['ID']."<br>";
				$structure = new Tannuaire_structure($row['ID']);
				$structure->supprimer();
				}
			} // while($row = $result->fetchRow(DB_FETCHMODE_ASSOC))

		} // function supprimerToutHorsRodez()

	}
?>