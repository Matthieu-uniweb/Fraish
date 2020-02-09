<?php
/**
   *  Classe de gestion des menus du jour
   *
   * Permet de créer, modifier, supprimer des menus du jour, en intéraction 
   * avec la base de données
   *
   * @author Christophe Raffy
   * @version 1.0
   * @access public
   * @copyright Laëtis Créations Multimédias
	 * @date 2007-11-12
   */

class Tbq_formule
	{	

	/** 
	* @var int $ID ID de l'element en base de donnée
	* @access  private 
	*/
	var $ID;
	var $nom;
	var $visuel;
	var $prix;

	/** 
	* Constructeur de l'objet
	* @param int $ID (facultatif) ID de l'element à initialiser (si non renseigné, aucune initialisation)
	* @return Tbq_menujour l'objet créé
	* @access  public 
	*/
	function __construct($ID = 0)
		{
		$this->ID = $ID;
		if($ID>0)
			{
			$requete = "SELECT * FROM typ_formule WHERE ID='".$this->ID."'";
			$resultats = T_LAETIS_site::requeter($requete);
			$this->initialiser($resultats[0]);
			}
		}


	function initialiser($enregistrement)
		{
		if($enregistrement) {
		foreach ($enregistrement as $nomChamp => $valeur)
			{
			$this->$nomChamp = stripslashes($valeur);
			}
		return $this;
		}
		}


	/** 
	* Alias du constructeur (compatibilité PHP4)
	* @param int $ID (facultatif) ID de l'element à initialiser (si non renseigné, aucune initialisation)
	* @return Tbq_menujour l'objet créé
	* @see Tbq_menujour::__construct()
	* @access  public 
	*/
	function Tbq_formule($ID = 0)
		{
		$this->__construct($ID);
		}


	/** 
	* Enregistre l'objet en base de donnée
	* Si l'ID est renseigné ==> modification
	* Sinon ==> insertion
	* @access  public 
	*/
	/*function enregistrer($valeurs)
		{
		T_LAETIS_site::modifierAttributs($valeurs);
		
		//si l'ID est renseigné, on modifie, sinon, on insere
		$attributs = get_object_vars($this);
		// on donne les champs à mettre à jour (meme syntaxe pour le UPDATE et le INSERT)
		$contenuRequete = "";
		$champsNonEnregistres = array( );
		
		foreach ($attributs as $nom=>$valeur)
			{
			if ( !in_array( $nom, $champsNonEnregistres ) )
				{
				$valeur = "\"".addslashes($valeur)."\"";
				$contenuRequete .= " ,".$nom."=".$valeur;
				}
			}
		
		// on enlève l'espace et la virgule du début
		
		$contenuRequete = substr($contenuRequete,2);
		if ($this->ID>0)
			{
			// c'est un objet qui existe déjà en BD
			$requete = "UPDATE boutique_obj_menu SET ";
			$requete .= $contenuRequete." WHERE ID=".$this->ID;
			$resSql = T_LAETIS_site::requeter($requete);
			}
		else
			{
			// c'est un objet qui n'existe pas en BD
			$requete = "INSERT INTO boutique_obj_menu SET ";
			$requete .= $contenuRequete;
			T_LAETIS_site::requeter($requete);
			$this->ID = T_LAETIS_site::last_insert_id();
			}
		} // FIN function enregistrer()*/


	/** 
	* Supprime l'objet en base de donnée
	* @access  public 
	*/
	/*function supprimer()
		{		
		$requete = "DELETE FROM boutique_obj_menujour WHERE ID='".$this->ID."'";
		T_LAETIS_site::requeter($requete);
		$this->ID = 0;
		}*/


	/** 
	* Liste les rubriques
	* @access  public 
	*/   
	function lister()
		{		
		$requete = "SELECT *
					FROM typ_formule";
		$resSql = T_LAETIS_site::requeter($requete);
		
		foreach($resSql as $ligne)
			{
			//$resultats[] = Tbq_formule::initialiser($ligne);
			$resultats[] = new Tbq_formule($ligne['ID']);
			}
		return($resultats);
		}
		
	function aLePlat($plat)
		{
		$resultat = true;
		$requete = "SELECT boutique_obj_menu.*
					FROM boutique_obj_menu, typ_formule
					WHERE boutique_obj_menu.ID_typ_formule = typ_formule.ID
					AND typ_formule.ID = '".$this->ID."'";
					//echo $requete;
		$resSql = T_LAETIS_site::requeter($requete);
		if($resSql)
			{
			foreach($resSql as $ligne)
				{
				if($ligne[$plat]!=1)//IF 1 des plats de la formule n'a pas le plat, ce plat est en option
					{
					return(false);
					}//FIN IF
				}
			}
		return $resultat;
		}
		
	function aLePlatV2($plat)
		{		
		$requete = "SELECT *
					FROM boutique_obj_menu
					WHERE boutique_obj_menu.ID = '".$this->ID."'
					";					
		$resSql = T_LAETIS_site::requeter($requete);
		if($resSql[0][$plat]!=1)return(false);			
		else return true;
		}
			
	function aLePlatEnOption($plat)
		{
		//Un ou plusieurs des menus de la formule a le plat $plat, 
		//Tous les menus de la formule ne doivent pas avoir le plat $plat
		$resultat = false;
		if(!$this->aLePlat($plat))//IF tous les menus de la formule n'ont pas le plat $plat
			{
			$requete = "SELECT boutique_obj_menu.*
						FROM boutique_obj_menu, typ_formule
						WHERE boutique_obj_menu.ID_typ_formule = typ_formule.ID
						AND boutique_obj_menu.".$plat."=1
						AND typ_formule.ID = '".$this->ID."'";
			$resSql = T_LAETIS_site::requeter($requete);
			if(sizeof($resSql)>0)//IF au moins 1 des menus de la formule propose le plat $plat
				{
				$resultat = true;
				}
			}
		return($resultat);
		}
	function getPlatsEnOption()
		{
		if($this->aLePlatEnOption('salade'))
			{
			$resultats[]='salade';
			}
		if($this->aLePlatEnOption('soupe'))
			{
			$resultats[]='soupe';
			}
		if($this->aLePlatEnOption('boisson'))
			{
			$resultats[]='boisson';
			}
		return($resultats);
		}
		
	function getPrixGrand()
		{
		$tabPrix = explode('|',$this->prix);
		return str_replace(',','.',$tabPrix[0]);
		}
		
	function getPrixMoyen()
		{
		$tabPrix = explode('|',$this->prix);
		return str_replace(',','.',$tabPrix[1]);
		}
		
	function getPrixPetit()
		{
		$tabPrix = explode('|',$this->prix);
		return str_replace(',','.',$tabPrix[2]);
		}
	function getIDMenu($valeurs)
		{
		if($valeurs['radioSoupe'])
			{
			$and .= " AND soupe=1";
			}
		if($valeurs['radioDessert'])
			{
			$and.=" AND dessert=1";
			}
		if($valeurs['radioVinaigrette'])
			{
			$and.=" AND salade=1";
			}
		$requete = "SELECT ID FROM boutique_obj_menu
					WHERE ID_typ_formule='".$this->ID."'
					$and";
					//echo $requete;
		$resSql = T_LAETIS_site::requeter($requete);
		return($resSql[0]['ID']);
		}
	}
?>