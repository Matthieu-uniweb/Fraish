<?
/**
* Classe permettant d'administrer les structures dans l'annuaire
*
* @author  Christophe Raffy <christophe.raffy@laetis.fr>
*/
class Tannuaire_structure_recherche extends Tannuaire_structure
	{
	/** 
	* Alias du constructeur (compatibilité PHP4)
	* @param int $ID (facultatif) ID de l'element à initialiser (si non renseigné, aucune initialisation)
	* @return Tannuaire_structure_recherche l'objet créé
	* @see Tannuaire_structure_recherche::__construct()
	* @access  public 
	*/
	function Tannuaire_structure_recherche($ID = 0)
		{
		$this->__construct($ID);
		}

	/** 
	* Constructeur de l'objet
	* @param int $ID (facultatif) ID de l'element à initialiser (si non renseigné, aucune initialisation)
	* @return Tannuaire_structure_recherche l'objet créé
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
	* Recherche des structures - recherche sur le nom
	* @param string $requete Requete de recherche
	* @return array de Tannuaire_structure Les structures trouvées
	* @access  public 
	*/
	function rechercherStructure($valeurs)
		{
		$options = explode(',', $valeurs['options']);
		
		$conditionRechercheNom = '1';
		if ($valeurs['recherche'])
			{
			$conditionRechercheNom = " LOWER(annuaire_obj_structure.nom) LIKE LOWER('%".$valeurs['recherche']."%') ";
			}

		$conditionService = '1';
		if ($valeurs['ID_service'])
			{
			$conditionService = " annuaire_rel_structure_service.ID_service IN (".$valeurs['ID_service'].") ";
			/*$conditionService = '0';
			$tabServices = explode(',', $valeurs['ID_service']);
			for ($i=0; $i<count($tabServices); $i++)
				{
				$conditionService .= " OR annuaire_rel_structure_service.ID_service = '".$tabServices[$i]."' ";
				}*/
			}

		$conditionStructure = '1';
		if ($valeurs['ID_structure'])
			{
			$conditionStructure = " annuaire_obj_structure.ID IN (".$valeurs['ID_structure'].") ";
			/*$conditionStructure = '0';
			$tabStructures = explode(',', $valeurs['ID_structure']);
			for ($i=0; $i<count($tabStructures); $i++)
				{
				$conditionStructure .= " OR annuaire_obj_structure.ID = '".$tabStructures[$i]."' ";
				}*/
			}

		$sql = "SELECT annuaire_obj_structure.ID AS ID_structure, annuaire_rel_structure_service.* 
						FROM annuaire_obj_structure, annuaire_rel_structure_service, annuaire_obj_service
						WHERE annuaire_rel_structure_service.ID_structure = annuaire_obj_structure.ID
						AND annuaire_obj_service.ID = annuaire_rel_structure_service.ID_service
						AND (".$conditionRechercheNom.")
						AND (".$conditionStructure.")
						AND (".$conditionService.")
						ORDER BY annuaire_obj_structure.nom ASC, annuaire_obj_service.nom ASC";

		if (! in_array('unePage', $options) )
			{
			$sql.=$this->creerLimite($valeurs, $sql);
			}
		//echo $sql;
		$result = $this->query($sql);
		while($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
			{
			$retour[] = $row;
			}
		return($retour);
		}

	/** 
	* Recherche de structures ou services correspondants aux éléments de recherche
	* @param array $valeurs Les éléments de recherches (sortent d'un formulaire)
	* @return array Les informations sur les éléments trouvés
	* @access  public 
	*/
	function rechercherStructureCriteres($valeurs)
		{
		$conditionWhereCommunes = '1';
		$tablesCommunes = '';
		
		$options = explode(',', $valeurs['options']);

		if ( ($valeurs['commune'] == '9999') )
			{			
			//$conditionWhereCommunes =  " (codeInsee IN ('12202', '12176', '12174', '12090', '12133', '12146', '12264', '12241') )";
			}
		else if ($valeurs['commune'])
			{
			$tablesCommunes = ", annuaire_rel_service_adresse, annuaire_obj_adresse";
			$conditionWhereCommunes = "annuaire_obj_service.ID = annuaire_rel_service_adresse.ID_service
																AND annuaire_obj_adresse.ID = annuaire_rel_service_adresse.ID_adresse 
																AND codeInsee IN (".$valeurs['commune'].")";
			}

		$motCles = explode(' ', $valeurs['motCle']);
		$conditionWhereMotCle = '1';
		for($i = 0; $i < sizeof($motCles); $i++)
			{
			$conditionWhereMotCle .= " AND (annuaire_obj_service.nom LIKE '%".$motCles[$i]."%' OR annuaire_obj_structure.nom LIKE '%".$motCles[$i]."%')";
			}
		
		$conditionJuridique = '1';
		if ($valeurs['formeJuridique'])
			{ 
			$conditionJuridique = "formeJuridique = '".$valeurs['formeJuridique']."'";
			}

		$conditionAnneeCreation = '1';
		if ($valeurs['anneeCreation'])
			{ 
			$conditionAnneeCreation = "anneeCreation ".$valeurs['opAnneeCreation']." '".$valeurs['anneeCreation']."'";
			}

		$conditionTypClassement = '1';
		if ($valeurs['ID_typ_classement'])
			{ 
			$conditionTypClassement = "ID_typ_classement = '".$valeurs['ID_typ_classement']."'";
			}

		$conditionSiret = '1';
		if ($valeurs['siret'])
			{ 
			$conditionSiret = "(siret = '".$valeurs['siret']."')";
			}

		$conditionTypStructure = '1';
		if ($valeurs['typStructure'])
			{ 
			$conditionTypStructure = "ID_typ_structure = '".$valeurs['typStructure']."'";
			}

		$conditionTypAsso = '1';
		if ($valeurs['typAsso'])
			{ 
			$conditionTypAsso = "ID_typ_classement = '".$valeurs['typAsso']."'";
			}

		$conditionTypNaf = '1';
		if ($valeurs['typNaf'])
			{ 
			$conditionTypNaf = "ID_typ_classement = '".$valeurs['typNaf']."'";
			}

		$conditionEffectif = '1';
		if ($valeurs['effectifTotal'])
			{ 
			$conditionEffectif = "effectifTotal ".$valeurs['opEffectifTotal']." '".$valeurs['effectifTotal']."'";
			}

		$conditionDescriptif = '1';
		if ($valeurs['descriptif'])
			{ 
			$descriptifs = explode(' ', $valeurs['descriptif']);			
			for($i = 0; $i < sizeof($descriptifs); $i++)
				{
				$conditionDescriptif .= " AND (annuaire_obj_service.nom LIKE '%".$descriptifs[$i]."%' OR annuaire_obj_structure.nom LIKE '%".$descriptifs[$i]."%')";
				}
			} 

		//maintenant, requete pour récuperer les services
		$sql = "SELECT DISTINCT annuaire_obj_structure.ID AS ID_structure, annuaire_obj_structure.nom, 
						annuaire_obj_service.ID AS ID_service  
						FROM annuaire_obj_service, annuaire_obj_structure, annuaire_rel_structure_service
						".$tablesCommunes."
						WHERE annuaire_obj_structure.ID = annuaire_rel_structure_service.ID_structure
						AND annuaire_obj_service.ID = annuaire_rel_structure_service.ID_service
						AND (".$conditionWhereCommunes.")
						AND (".$conditionWhereMotCle.")
						AND (".$conditionJuridique.")
						AND (".$conditionAnneeCreation.")
						AND (".$conditionTypClassement.")
						AND (".$conditionSiret.")
						AND (".$conditionTypStructure.")
						AND (".$conditionTypNaf.")
						AND (".$conditionTypAsso.")
						AND (".$conditionEffectif.")
						AND (".$conditionDescriptif.")
						GROUP BY annuaire_obj_service.ID
						ORDER BY annuaire_obj_structure.nom, annuaire_obj_service.nom";

		if (! in_array('unePage', $options) )
			{
			$sql.=$this->creerLimite($valeurs, $sql);
			}
		//echo $sql;
		$result = $this->query($sql);
		while($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
			{
			$retour[] = $row;
			}
		return $retour;
		} // FIN function rechercherStructure($valeurs)


	/** 
	* Recherche des services - recherche sur le nom
	* @param string $requete Requete de recherche
	* @return array de Tannuaire_service Les services trouvés
	* @access  public 
	*/
	function rechercherStructureLettre($valeurs)
		{
		$sql = "SELECT ID FROM annuaire_obj_structure 
						WHERE LOWER(nom) 
						LIKE LOWER('".$valeurs['recherche']."%')
						ORDER BY nom ASC";
		$sql.=$this->creerLimite($valeurs, $sql);
		$result = $this->query($sql);
		while($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
			{
			$retour[] = new Tannuaire_structure_recherche($row['ID']);
			}
		return($retour);
		}
	
	
	/** 
	* Recherche des structures - recherche sur le nom
	* @param string $requete Requete de recherche
	* @return array de Tannuaire_structure Les structures trouvées
	* @access  public 
	*/
	function rechercherToutesStructures($valeurs)
		{
		$options = explode(',', $valeurs['options']);
		
		$sql = "SELECT annuaire_obj_structure.ID AS ID_structure, annuaire_rel_structure_service.* 
						FROM annuaire_obj_structure, annuaire_rel_structure_service, annuaire_obj_service
						WHERE annuaire_rel_structure_service.ID_structure = annuaire_obj_structure.ID
						AND annuaire_obj_service.ID = annuaire_rel_structure_service.ID_service
						ORDER BY annuaire_obj_structure.ID ASC, annuaire_obj_service.ID ASC";

		if (! in_array('unePage', $options) )
			{
			$sql.=$this->creerLimite($valeurs, $sql);
			}
		//echo $sql;
		$result = $this->query($sql);
		while($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
			{
			$retour[] = $row;
			}
		return($retour);
		}

	/** 
	* Lister les services de la structure
	* @param array $valeurs Valeurs POST
	* @return array de Tannuaire_structure Les structures trouvées
	* @access  public 
	*/
	function listerServices($valeurs)
		{
		$sql = "SELECT annuaire_obj_service.* 
						FROM annuaire_rel_structure_service, annuaire_obj_service 
						WHERE ID_structure = '".$this->ID."'
						AND annuaire_rel_structure_service.ID_service = annuaire_obj_service.ID
						ORDER BY annuaire_rel_structure_service.parDefaut DESC, annuaire_obj_service.nom ASC";
						
		// Pour se placer au bon endroit, sur le service concerné.
		if ($valeurs['ID_service'])
			{ 			
			$resultRang = $this->query($sql);
			while($rowRang = $resultRang->fetchRow(DB_FETCHMODE_ASSOC))
				{	$retourRang[] = $rowRang;	}
			for ($i=0; $i<count($retourRang); $i++)
				{
				if ($retourRang[$i]["ID"] == $valeurs["ID_service"])
					{	
					$valeurs['numeroPage'] = ceil(($i+1)/$this->nombreReponseParPage); 
					} // FIN if ($retourRang[$i]["ID"] == $valeurs["ID_service"])
				}	// FIN for ($i=0; $i<count($retourRang); $i++)
			} // FIN if ($valeurs['ID_service'])

		$sql.=$this->creerLimite($valeurs, $sql);
		$result = $this->query($sql);
		while($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
			{
			$retour[]=$row;
			}
		return $retour;
		}


	/** 
	* Générer le html à afficher pour les critères de recherche
	* @param array $valeurs Les éléments de recherches (sortent d'un formulaire)
	* @return string Le code html à afficher
	* @access  public 
	*/	
	function genererCriteresRecherche($valeurs)
		{
		$votreRecherche = '';
		$nomCategorie = '';

		if ($valeurs['motCle'])
			{ $votreRecherche .= 'Nom : '.$valeurs['motCle'].'<br>'; }
		if ($valeurs['formeJuridique'])
			{ $votreRecherche .= 'Forme juridique : '.$valeurs['formeJuridique'].'<br>'; }
		if ($valeurs['anneeCreation'])
			{ $votreRecherche .= 'Année de création : '.$valeurs['anneeCreation'].'<br>'; }
		if ($valeurs['ID_typ_classement'])
			{ $votreRecherche .= 'Type de classement : '.$valeurs['ID_typ_classement'].'<br>'; }
		if ($valeurs['typAsso'])
			{ 
			$typ = $this->getTypeClassement($valeurs['typAsso']);
			$votreRecherche .= 'Type Asso : '.$typ['type_asso'].'<br>'; 
			}
		if ($valeurs['typNaf'])
			{ 
			$typ = $this->getTypeClassement($valeurs['typNaf']);
			$votreRecherche .= 'Type NAF: '.$typ['type_naf'].'<br>'; 
			}
		if ($valeurs['siret'])
			{ $votreRecherche .= 'Numéro Siret : '.$valeurs['siret'].'<br>'; }
		if ($valeurs['typStructure'])
			{ $votreRecherche .= 'Type de structure : '.$valeurs['typStructure'].'<br>'; }
		if ($valeurs['effectifTotal'])
			{ $votreRecherche .= 'Effectif total : '.$valeurs['effectifTotal'].'<br>'; }
		if ($valeurs['descriptif'])
			{ $votreRecherche .= 'Descriptif : '.$valeurs['descriptif'].'<br>'; }
		if ($valeurs['commune'] == '9999')
			{ $votreRecherche .= 'Toutes les communes <br>'; }
		else if ($valeurs['commune'])
			{ $votreRecherche .= 'Commune : '.$valeurs['commune'].' <br>'; }
		if ($valeurs['ID_categorie_consulte'])
			{
			$categorieConsulte = new Tannuaire_categorie($valeurs['ID_categorie_consulte']);
			$votreRecherche .= ' dans la catégorie ';
			$votreRecherche .= $categorieConsulte->libelle;
			$nomCategorie .= $categorieConsulte->libelle;
			}

		$criteres = array('votreRecherche'=>$votreRecherche, 'nomCategorie'=>$nomCategorie);
		
		return $criteres;
		} // FIN function genererCriteresRecherche($valeurs)

	}
?>