<?
/**
* Classe permetant la gestion des catégories de l'annuaire
*
* @author  Thomas Vendé <thomas.vende@laetis.fr>
* @see T_LAETIS_site::modifierAttributs()
*/

class Tannuaire_categorie extends T_LAETIS_site
	{
	/** 
	* @var int $ID ID de l'element en base de donnée
	* @access  private 
	*/
	var $ID;
	
	/** 
	* @var string $libelle Libelle de la catégorie
	* @access  private 
	*/
	var $libelle;
	
	/** 
	* Constructeur de l'objet
	* @param int $ID (facultatif) ID de l'element à initialiser (si non renseigné, aucune initialisation)
	* @return Tannuaire_categorie l'objet créé
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
			$sql = "SELECT * FROM annuaire_obj_categorie WHERE ID = '".$ID."'";
			$result = $this->query($sql);
			$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
			$this->libelle = $row['libelle'];
			}
		}
		
	/** 
	* Alias du constructeur (compatibilité PHP4)
	* @param int $ID (facultatif) ID de l'element à initialiser (si non renseigné, aucune initialisation)
	* @return Tannuaire_categorie l'objet créé
	* @see Tannuaire_categorie::__construct()
	* @access  public 
	*/
	function Tannuaire_categorie($ID = 0)
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
			$sql = "INSERT INTO annuaire_obj_categorie ( ID , libelle ) 
							VALUES ('', '".$this->libelle."');";
			$result = $this->query($sql);
			$this->ID = $this->last_insert_id();
			}
		else //on modifie
			{
			$sql = "UPDATE annuaire_obj_categorie SET 
							libelle = '".$this->libelle."'
							WHERE ID = ".$this->ID;
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
		$sql = "DELETE FROM annuaire_obj_categorie WHERE ID = '".$this->ID."'";
		$result = $this->query($sql);
		$categoriesFilles = $this->listerCategoriesFille();
		for ($i=0; $i<count($categoriesFilles); $i++)
			{
			$categorieASup = new Tannuaire_categorie($categoriesFilles[$i]['ID_categorieFille']);
			$categorieASup->supprimer();
			}

		$sql = "DELETE FROM annuaire_rel_categorie_service WHERE ID_categorie = '".$this->ID."'";
		$result = $this->query($sql);
		$sql = "DELETE FROM annuaire_rel_categorie_support WHERE ID_categorie = '".$this->ID."'";
		$result = $this->query($sql);
		$sql = "DELETE FROM annuaire_rel_categorie_categorie WHERE ID_categorieMere = '".$this->ID."' OR ID_categorieFille = '".$this->ID."'";
		$result = $this->query($sql);
		$this->ID = 0;
		}

	function setVisibilite($ID_service, $visible = 1)
		{
		$sql = "UPDATE annuaire_rel_categorie_service 
						SET visible = '".$visible."'
						WHERE ID_service = '".$ID_service."'
						AND ID_categorie = '".$this->ID."'";
		$result = $this->query($sql);		 
		}

	/** 
	* Nettoyer les catégories non utilisées
	* @access  public 
	*/
	function nettoyerLiensCategories()
		{
		$sql1 = "SELECT DISTINCT annuaire_rel_categorie_service.ID_categorie FROM annuaire_rel_categorie_service";
		$result1 = $this->query($sql1);
		while($row1 = $result1->fetchRow(DB_FETCHMODE_ASSOC))
			{	$listeIDCategorie1[] = $row1['ID_categorie'];	}

		$sql2 = "SELECT DISTINCT annuaire_rel_categorie_support.ID_categorie FROM annuaire_rel_categorie_support";
		$result2 = $this->query($sql2);
		while($row2 = $result2->fetchRow(DB_FETCHMODE_ASSOC))
			{	$listeIDCategorie2[] = $row2['ID_categorie'];	}

		$sql3 = "SELECT DISTINCT annuaire_rel_categorie_categorie.ID_categorieMere FROM annuaire_rel_categorie_categorie";
		$result3 = $this->query($sql3);
		while($row3 = $result3->fetchRow(DB_FETCHMODE_ASSOC))
			{	$listeIDCategorie3[] = $row3['ID_categorieMere'];	}

		$sql4 = "SELECT DISTINCT annuaire_rel_categorie_categorie.ID_categorieFille FROM annuaire_rel_categorie_categorie";
		$result4 = $this->query($sql4);
		while($row4 = $result4->fetchRow(DB_FETCHMODE_ASSOC))
			{	$listeIDCategorie4[] = $row4['ID_categorieFille']; }

		$listeIDCategorie = array_merge($listeIDCategorie1, $listeIDCategorie2, $listeIDCategorie3, $listeIDCategorie4);
		array_unique($listeIDCategorie);

		for ($i=0; $i<count($listeIDCategorie); $i++)
			{
			$sql = "SELECT ID FROM annuaire_obj_categorie	WHERE ID = '".$listeIDCategorie[$i]."'";
			$result = $this->query($sql);
			if ($result->numRows() == '0')
				{
				//echo "Suppresion de ID = ".$listeIDCategorie[$i]."<br>";
				$categorie = new Tannuaire_categorie($listeIDCategorie[$i]);
				$categorie->supprimer();
				}
			} // FIN for ($i=0; $i<count($listeIDAdresse); $i++)
			
		// SUPPRESSION DES CATEGORIES QUI NE SONT PLUS LIEES
		$sql = "SELECT DISTINCT annuaire_obj_categorie.ID FROM annuaire_obj_categorie";
		$result = $this->query($sql);
		
		while($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
			{
			$sql1 = "SELECT COUNT(*) FROM annuaire_rel_categorie_service WHERE ID_categorie = '".$row['ID']."'";
			$result1 = $this->query($sql1);
			$row1 = $result1->fetchRow();
	
			$sql2 = "SELECT COUNT(*) FROM annuaire_rel_categorie_support WHERE ID_categorie = '".$row['ID']."'";
			$result2 = $this->query($sql2);
			$row2 = $result2->fetchRow();
	
			$sql3 = "SELECT COUNT(*) FROM annuaire_rel_categorie_categorie WHERE ID_categorieMere = '".$row['ID']."'";
			$result3 = $this->query($sql3);
			$row3 = $result3->fetchRow();
	
			$sql4 = "SELECT COUNT(*) FROM annuaire_rel_categorie_categorie WHERE ID_categorieFille = '".$row['ID']."'";
			$result4 = $this->query($sql4);
			$row4 = $result4->fetchRow();

			if ( ($row1[0]+$row2[0]+$row3[0]+$row4[0]) == '0')
				{
				//echo "Suppression de ID = ".$row['ID']."<br>";
				$categorie = new Tannuaire_categorie($row['ID']);
				$categorie->supprimer();
				}
			} // FIN while($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
		}

	/** 
	* Permet de lier une catégorie (fille) à une catégorie (mère)
	* @param int $ID_categorie ID de la catégorie à lier à la catégorie mère
	* @param int $ordre Ordre de la catégorie pour ce support
	* @access  public 
	*/
	function lierCategorie($ID_categorie, $ordre)
		{
		$sql = "SELECT * FROM annuaire_rel_categorie_categorie 
						WHERE ID_categorieMere = '".$this->ID."' AND ID_categorieFille = '".$ID_categorie."'";
		$result = $this->query($sql);

		//on update
		if($result->numRows() != 0)
			{
			$sql = "UPDATE annuaire_rel_categorie_categorie 
							SET ordre = '".$ordre."' 
							WHERE ID_categorieMere = '".$this->ID."' AND ID_categorieFille = '".$ID_categorie."'";
			}
		else //on insere
			{
			$sql = "INSERT INTO annuaire_rel_categorie_categorie (ID_categorieMere,ID_categorieFille,ordre) 
							VALUES ('".$this->ID."','".$ID_categorie."','".$ordre."')";
			}
		$result = $this->query($sql);
		}	

	/** 
	* Délie le service à l'objet en cours
	* @param int $ID_service ID du service
	* @access  public 
	*/
	function delierServiceCategories($ID_service)
		{
		// On supprime les liens catégorie-service existants
		$sql = "DELETE FROM annuaire_rel_categorie_service 
						WHERE ID_categorie = '".$this->ID."' AND ID_service = '".$ID_service."'";
		$this->query($sql);
		} // FIN function delierServiceCategories($valeurs)

	/** 
	* Renvoie les catégories filles
	* @return Array composé des ID et libellés des catégories filles
	* @access  public 
	*/
	function listerCategoriesFille()
		{
		$sql = "SELECT * FROM annuaire_rel_categorie_categorie WHERE ID_categorieMere = '".$this->ID."' ORDER BY ordre";
		$result = $this->query($sql);
		while($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
			{
			$retour[] = $row;
			}
		return $retour;
		}
	
	/** 
	* Renvoie la liste de toutes les catégories filles
	* @return Array composé des ID
	* @access  public 
	*/
	function listerToutesCategoriesFille()
		{
		$sql = "SELECT * FROM annuaire_rel_categorie_categorie WHERE ID_categorieMere = '".$this->ID."' ORDER BY ordre";
		$result = $this->query($sql);
		$retour[] = $this->ID;
		while($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
			{
			$categorie = new Tannuaire_categorie($row['ID_categorieFille']);
			$retour = array_merge($retour,$categorie->listerToutesCategoriesFille());
			}
		return array_unique($retour);
		}

	/** 
	* Renvoie le code html permetant d'afficher l'arbre des catégories
	* Fonction utilisée dans l'administration de l'annuaire, lors de la création/modification/suppression 
	* des catégories.
	* @return string html généré
	* @param $cpt Compteur pour connaitre à quel niveau se trouve la catégorie (pour l'affichage)
	* @param $ID_categorieMere ID de la catégorie mère à la catégorie courante
	* @param $ordre Ordre de la catégorie mère à la catégorie courante
	* @access  public 
	*/
	function genererHtmlAdminBack($cpt, $ID_categorieMere, $ordre)
		{
		$liste = $this->listerCategoriesFille();
		
		$cpt++;
		for ($j=0; $j<$cpt; $j++)
			{ $htmlEspaceur .= "&nbsp;&nbsp;&nbsp;"; }
		
		$htmlActions = '<td><a href="javascript:;" onClick="enregistrerCategorie('.$this->ID.', '.$ID_categorieMere.');return false;" class="textecourant"><img src="../images/back/enregistrer.gif" alt="Enregistrer cette catégorie" border="0"></a>&nbsp;<a href="javascript:;" onClick="supprimerCategorieSupport('.$this->ID.');return false;" class="textecourant"><img src="../images/back/supprimer.gif" alt="Supprimer cette catégorie" border="0"></a>&nbsp;<a href="javascript:;" onClick="afficheTexteareaCategorieFille('.$this->ID.');return false;" class="textecourant"><img src="../images/back/ajouter.gif" alt="Ajouter une catégorie fille" border="0"></a>';
		
		if(sizeof($liste) == 0)
			{ 		
			$htmlActions .= '&nbsp;<a href="javascript:;" onClick="lierServices('.$this->ID.');return false;" class="textecourant"><img src="../images/back/ajouter.gif" alt="Lier cette catégorie à des services" border="0"></a>';
			}
		$htmlActions .= '</td></tr>'; 

		$htmlActions .= '<tr><td colspan="2"><div id="categorieFille'.$this->ID.'" class="divInvisible"><table width="100%" border="0" align="center" cellpadding="5"><tr><td class="texte" valign="top">';
		$htmlActions .= $htmlEspaceur;
		$htmlActions .= 'Libellé : <textarea name="categorieFille['.$this->ID.'][libelle]" class="inputTextearea"></textarea>&nbsp;&nbsp;&nbsp; Ordre :<input type="text" name="categorieFille['.$this->ID.'][ordre]" value="'.(sizeof($liste)+1).'" class="input50" onKeyPress="return verifierSaisieChiffres();">&nbsp;&nbsp;&nbsp; <a href="javascript:;" onClick="ajouterCategorieFille('.$this->ID.');return false;" class="textecourant">Ajouter</a></td></tr></table></div></td></tr>';

		if(sizeof($liste) == 0)
			{
			$html .= '<tr><td>';
			$html .= $htmlEspaceur;
			$html .= '<img src="../images/e.gif" width="12"><input type="text" name="categorie['.$this->ID.'][libelle]" value="'.$this->libelle.'" class="input300">&nbsp;<input type="text" name="categorie['.$this->ID.'][ordre]" value="'.$ordre.'" class="input50" onKeyPress="return verifierSaisieChiffres();"></td>';
			$html .= $htmlActions;
			}
		else
			{
			$html .= '<tr><td>';
			$html .= $htmlEspaceur;
			$html .= '<img src="../images/back/clic_moins.gif">&nbsp;<input type="text" name="categorie['.$this->ID.'][libelle]" value="'.$this->libelle.'" class="input300">&nbsp;<input type="text" name="categorie['.$this->ID.'][ordre]" value="'.$ordre.'" class="input50" onKeyPress="return verifierSaisieChiffres();"></td>';
			$html .= $htmlActions;

			for($i = 0; $i < sizeof($liste); $i++)
				{
				$categorie = new Tannuaire_categorie($liste[$i]['ID_categorieFille']);
				$html .= $categorie->genererHtmlAdminBack($cpt, $this->ID, $liste[$i]['ordre']);
				}
			}
		return ($html);
		} // FIN function genererHtmlAdminBack($cpt, $ID_categorieMere, $ordre)

	/** 
	* Renvoie le code html permetant d'afficher l'arbre des catégories
	* Fonction utilisée dans l'administration de l'annuaire, lors de la liaison entre un service et 
	* des catégories (saisir_structure_support.php).
	* @return string html généré
	* @param $guide nom du guide (CSS)	
	* @param $couleur Couleur utilisée pour l'affichage
	* @param $nomTableau Nom des inputs
	* @param $ID_service ID du service à affecter aux catégories
	* @param $ID_support ID du support
	* @param $ouvert Désigne si l'arbre est ouvert ou fermé
	* @access  public 
	*/
	function genererHtmlBack($guide, $couleur, $nomTableau, $ID_service, $ID_support, $ouvert)
		{
		if ($ouvert)
			{ 
			$classeVisibilite = 'divVisible'; 
			$classeGuide = 'Ouverte';
			}
		else
			{ 
			$classeVisibilite = 'divInvisible'; 
			$classeGuide = 'Fermee';
			}

		$classeVisibiliteDescription = 'divInvisible';

		$liste = $this->listerCategoriesFille();
		if (sizeof($liste) == 0)
			{
			$categorieService = $this->getCategorieService($ID_service);
			if (sizeof($categorieService) != 0)
				{ 
				$check = "checked"; 
				$classeVisibiliteDescription = 'divVisible';
				}

			$temp = $nomTableau.'['.$ID_support.']['.$this->ID.']';
			$temp2 = "descriptif".'['.$ID_support.']['.$this->ID.']';

			$html .= '<div onClick="guideSelectionnerBack(this,'.$this->ID.','.$ID_support.',\''.$couleur.'\',\''.$temp.'\');" class="rubriqueGuide'.$guide.'Finale">';
			$html .= '<input name="'.$temp.'" value="on" type="checkbox" '.$check.' class="checkbox" onClick="cocher(this)">';
			$html .= '&nbsp;&nbsp;'.$this->libelle.chr(10).'</div>';
			$html .= '<div id="textearea'.$ID_support.$this->ID.'" class='.$classeVisibiliteDescription.'><textarea name="'.$temp2.'" class="inputTextearea">'.$categorieService['descriptif'].'</textarea></div>';
			}
		else
			{
			$html = '<div class="rubriqueGuide'.$guide.$classeGuide.'" id="dossier'.$ID_support.$this->ID.'" onMouseOver="mouseOverMenuBack(this);" onMouseOut="mouseOuTportail_menuBack(this);" onClick="guideMenuCategorieBack('.$ID_support.$this->ID.');">';
			$html .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$this->libelle.chr(10);
			$html .= '</div><div class='.$classeVisibilite.' id="div'.$ID_support.$this->ID.'">';
			for($i = 0; $i < sizeof($liste); $i++)
				{
				$categorie = new Tannuaire_categorie($liste[$i]['ID_categorieFille']);
				$html .= $categorie->genererHtmlBack($guide,$couleur,$nomTableau,$ID_service,$ID_support,$ouvert);
				}
			$html .= '</div>';
			}
		return ($html);
		} // FIN function genererHtmlBack($guide,$couleur,$nomTableau,$ID_service,$ID_support,$ouvert)

	/** 
	* Renvoie le code html permetant d'afficher l'arbre des catégories filles
	* @return string html généré
	* @param $ID_service ID du service
	* @access  public 
	*/
	function genererHtmlListe($ID_service)
		{
		$liste = $this->listerCategoriesFille();
		if(sizeof($liste) == 0)
			{
			$catService = $this->getCategorieService($ID_service);
			if (sizeof($catService) != 0)
				{
				if ($catService['visible'])
					{ $check = ' checked'; }
				else
					{ $check = ''; }

				$html .= ' - '.$this->libelle.'<input type="checkbox" name="visible" value="1"'.$check.' 
onClick="if (this.checked) { fonctionVisible('.$this->ID.', '.$ID_service.'); } else {
fonctionVisible('.$this->ID.', '.$ID_service.'); };"><br>';
				}
			}
		else
			{
			for($i = 0; $i < sizeof($liste); $i++)
				{
				$categorie = new Tannuaire_categorie($liste[$i]['ID_categorieFille']);
				$html .= $categorie->genererHtmlListe($ID_service);
				}
			}
		return ($html);
		}

	/** 
	* Renvoie le code html permettant d'afficher l'arbre des catégories filles
	* Utilisé pour le front du site
	* @return string html généré
	* @param $guide nom du guide (CSS)
	* @access  public 
	*/
	function genererHtmlFront($guide,$couleur,$ID_categorie='')
		{
		$liste = $this->listerCategoriesFille();
		if(sizeof($liste) == 0)
			{
			$html .= '<div onClick="guideSelectionner(this,'.$this->ID.',\''.$couleur.'\');parent.redimmensionnerFrame(window.name,\'\',getHauteurDocument());" class="rubriqueGuide'.$guide.'Finale">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$this->libelle.'</div>'.chr(10);
			}
		else
			{
			if ( ($ID_categorie) && (!(in_array($this->ID, $ID_categorie))) )
				{	return; }
			else
				{
				$html = '<div class="rubriqueGuide'.$guide.'Fermee" id="dossier'.$this->ID.'" onMouseOver="mouseOverMenu(this);" onMouseOut="mouseOuTportail_menu(this);" onClick="guideMenuCategorie('.$this->ID.');guideSelectionner(this,'.$this->ID.',\''.$couleur.'\');parent.redimmensionnerFrame(window.name,\'\',getHauteurDocument());">';
				$html .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$this->libelle.chr(10);
				$html .= '</div><div class="divInvisible" id="div'.$this->ID.'">';
			
				for($i = 0; $i < sizeof($liste); $i++)
					{
					$categorie = new Tannuaire_categorie($liste[$i]['ID_categorieFille']);
					$html .= $categorie->genererHtmlFront($guide,$couleur,$ID_categorie);
					}
				$html .= '</div>';
				} // FIN else
			} // FIN else
		return ($html);
		}

	/** 
	* Renvoie le code html permettant d'afficher l'arbre des catégories filles
	* Utilisé pour le front du site
	* @return string html généré
	* @param $guide nom du guide (CSS)
	* @access  public 
	*/
	function genererHtmlSupportEntier($option)
		{
		$liste = $this->listerCategoriesFille();
		if(sizeof($liste) == 0)
			{
			switch ($option)
				{
				case 'lierCategorie':
					$htmlOption = '&nbsp;<a href="javascript:;" onClick="rechercherCategorie('.$this->ID.');return false;"><img src="../images/back/ajouter.gif" alt="Lier les services de cette catégorie" border="0"></a>';
					break;
				} // FIN switch $option

			$html .= '<div class="rubriqueGuideFinale">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="popup/popup_rechercher_service.php" target="idPopIframe" onClick="envoyerFormulaire('.$this->ID.',this.href);return false;" class="rubriqueGuideFinale">'.$this->libelle.' ('.$this->ID.') '.'</a>';
			$html .= $htmlOption;
			$html .= '</div>'.chr(10);
			}
		else
			{
			$html = '<div class="rubriqueGuideOuverte"><b>';
			$html .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$this->libelle.' ('.$this->ID.') '.chr(10);
			$html .= '</b></div><div class="divVisible" id="div'.$this->ID.'">';

			for($i = 0; $i < sizeof($liste); $i++)
				{
				$categorie = new Tannuaire_categorie($liste[$i]['ID_categorieFille']);
				$html .= $categorie->genererHtmlSupportEntier($option);
				}
			$html .= '</div>';
			}
		return ($html);
		}

	/** 
	* Renvoie le code html permetant d'afficher l'arbre des catégories
	* @return array retour 
	* @access  public 
	*/
	function genererSupportEntier()
		{
		$liste = $this->listerCategoriesFille();

		if(sizeof($liste) == 0)
			{
			$retour = array_merge($retour, array(array("ID"=>$this->ID, "libelle"=>$this->libelle, "nbFille"=>'0')));
			}
		else
			{
			$retour = array_merge($retour, array(array("ID"=>$this->ID, "libelle"=>$this->libelle, "nbFille"=>sizeof($liste))));
			for($i = 0; $i < sizeof($liste); $i++)
				{
				$categorie = new Tannuaire_categorie($liste[$i]['ID_categorieFille']);
				$retour = array_merge($retour, $categorie->genererSupportEntier());
				}
			}
		return $retour;
		}

	/** 
	* Lister l'ensemble des services liés à cette catégorie
	* @return array Tableau contenant les ID des services
	* @access  public 
	*/
	function listerServices()
		{
		$sql = "SELECT * FROM annuaire_rel_categorie_service WHERE ID_categorie = ".$this->ID." ORDER BY ordre";
		$result = $this->query($sql);
		while($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
			{
			$retour[] = $row['ID_service'];
			}
		return $retour;
		}

	/** 
	* Lister l'ensemble des services liés à cette catégorie, ainsi que des informations sur la 
	* structure auquel il appartient
	* @param visible Si =1 alors on recherche uniquement les structures visibles sur la catégorie
	* @return array Tableau contenant les ID des services, ID de la structure, son nom et descriptif
	* @access  public 
	*/
	function listerServicesID($visible = 0)
		{
		$sql = "SELECT DISTINCT annuaire_obj_structure.ID AS ID_structure, annuaire_obj_structure.nom, 
						annuaire_obj_service.ID AS ID_service, annuaire_rel_categorie_service.descriptif AS descriptif 
						FROM annuaire_obj_service, annuaire_rel_categorie_service, annuaire_obj_structure, annuaire_rel_structure_service 
						WHERE annuaire_obj_service.ID = annuaire_rel_categorie_service.ID_service 
						AND annuaire_obj_structure.ID = annuaire_rel_structure_service.ID_structure 
						AND annuaire_obj_service.ID = annuaire_rel_structure_service.ID_service 
						AND ID_categorie = '".$this->ID."' ";

		if ($visible)
			{
			$sql .= "AND annuaire_rel_categorie_service.visible = '1' ";
			}
		
		$sql .= "GROUP BY annuaire_obj_structure.ID ORDER BY annuaire_obj_structure.nom";

		$result = $this->query($sql);
		while($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
			{
			$retour[] = $row;
			}
		return $retour;
		}

	/** 
	* Renvoie la catégorie mère
	* @return int ID de la catégorie mère
	* @access  public 
	*/
	function getCategorieMere()
		{
		$sql = "SELECT ID_categorieMere, libelle 
						FROM annuaire_rel_categorie_categorie, annuaire_obj_categorie 
						WHERE ID_categorieFille = ".$this->ID." 
						AND annuaire_obj_categorie.ID = annuaire_rel_categorie_categorie.ID_categorieFille
						ORDER BY ordre";
		$result = $this->query($sql);
		$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
		return $row;
		}

	/** 
	* Renvoie le descriptif présente entre une catégorie et un service
	* @param int $ID_service ID du service à rechercher
	* @return int ID de la catégorie mère
	* @access  public 
	*/
	function getCategorieService($ID_service)
		{
		$sql = "SELECT *
						FROM annuaire_rel_categorie_service
						WHERE ID_categorie = '".$this->ID."' 
						AND ID_service = '".$ID_service."'";
		$result = $this->query($sql);
		//echo $sql.'<br>';
		return ($result->fetchRow(DB_FETCHMODE_ASSOC));
		}

	/** 
	* Renvoie l'ordre entre la catégorie instanciée (mère) et sa fille
	* @param int $ID_categorieFille ID de la catégorie fille
	* @return int ID de la catégorie mère
	* @access  public 
	*/
	function getOrdre($ID_categorieFille)
		{
		$sql = "SELECT ordre
						FROM annuaire_rel_categorie_categorie
						WHERE ID_categorieMere = '".$this->ID."'				
						AND ID_categorieFille = '".$ID_categorieFille."'";
		$result = $this->query($sql);
		$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
		return $row['ordre'];
		}

	/** 
	* Lie les services à la catégorie en cours
	* @param array $valeur tableau contenant les inputs (value=on)
	* @access  public 
	*/
	function lierServiceCategories($valeurs)
		{
		if ($valeurs['services'])
			{
			//pour tous les checkboxes existantes
			while(list ($ID_service, $checked) = each ($valeurs['services'])) 
				{
				//on regarde si en base, c'est lié
				$sql = "SELECT * FROM annuaire_rel_categorie_service WHERE ID_categorie = ".$this->ID." AND ID_service = '".$ID_service."'";
				$result = $this->query($sql);
	
				//si ce n'est pas lié en base, et que la case est cochée, on lie
				if($result->numRows() == 0 && $checked == 'on')
					{
					$sql = "INSERT INTO annuaire_rel_categorie_service (ID_categorie,ID_service,visible,descriptif) 
									VALUES(".$this->ID.", ".$ID_service.", '1', '')";
					$result = $this->query($sql);
					}
				} // FIN while(list ($ID_service, $checked) = each ($valeurs['services']) 
			} // FIN if ($valeurs['services'])
		} // FIN function lierServiceCategories($valeurs)

	/** 
	* Retourne booléen selon si le service est lié à la catégorie
	* @param int $ID_service ID du service
	* @access  public 
	*/
	function getServiceLie($ID_service)
		{
		$sql = "SELECT * FROM annuaire_rel_categorie_service 
						WHERE ID_categorie = ".$this->ID." AND ID_service = '".$ID_service."'";
		$result = $this->query($sql);
		if ($result->numRows() == 0)
			{ return false; }
		else 
			{ return true; }
		}

	function modifierVisibilite($ID_service)
		{
		$catService = $this->getCategorieService($ID_service);
		if ($catService['visible']=='1')
			{
			$this->setVisibilite($ID_service, '0');
			}
		else
			{
			$this->setVisibilite($ID_service, '1');
			}
		} // FIN function modifierVisibilite($ID_service);
		

	}
?>