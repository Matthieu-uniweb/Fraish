<?php
/**
 * gestion des ingrédients
 **/

class Tbq_famille{
	
	var $ID = NULL;
	var $libelle = NULL;
	var $supplement = NULL;
	var $famille = NULL;
	var $sousfamille = NULL;
	
	/** 
	* Initialisation de l'objet
	* L'initialisation se fait à partir de l'ID
	*
	* @author leo
	*/
	function initialiser($id)
		{
		if ( $this->ID>0 )
			{
			// initialisation de l'objet
			$requete = "SELECT * FROM boutique_obj_ingredient WHERE ID='".$id."'";
			$resultats = T_LAETIS_site::requeter($requete);
			foreach ($resultats[0] as $nomChamp => $valeur)
				{
				echo $nomChamp.'-'.$valeur;
				$this->$nomChamp = stripslashes($valeur);
				}
			}
		} // FIN function initialiser()
	
	function listerFamilles (){
		$requete = "SELECT * FROM boutique_typ_famille ";
		$resultats = T_LAETIS_site::requeter($requete);
		return $resultats;
	}
	
	function listerIngredients ($idFamille,$order=NULL,$sFamille=NULL, $defaut=NULL){
		$requete = "SELECT * 
					FROM boutique_obj_ingredient
					WHERE ID_famille = ".$idFamille;
		if($sFamille){ $requete .= " AND libelleSousFamille = '".$sFamille."'"; }
		if($defaut){ $requete .= " AND parDefaut = '".$defaut."'"; }
		if($order){ $requete .= " ORDER BY ".$order; }
		//echo $requete;
		$resultats = T_LAETIS_site::requeter($requete);
		return $resultats;
	}

}
?>