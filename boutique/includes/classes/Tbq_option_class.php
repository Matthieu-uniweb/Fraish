<?php
/**
 * gestion des ingrédients
 **/

class Tbq_option{
	
	function getOptionName ($id){
		// initialisation de l'objet
		$requete = "SELECT libelle FROM boutique_obj_options WHERE ID =".$id;
		$resultats = T_LAETIS_site::requeter($requete);
		return $resultats[0]['libelle'];
	}
	
	function listerOptions(){
		// initialisation de l'objet
		$requete = "SELECT * FROM boutique_obj_options";
		$resultats = T_LAETIS_site::requeter($requete);
		return $resultats;
	} // FIN function initialiser()
	
	function ajouterOption($tab){
		// initialisation de l'objet
		$requete = "INSERT INTO boutique_obj_options (libelle)
					VALUES ('".$tab['libelle']."')";
		$resultats = T_LAETIS_site::requeter($requete);
		if (!$resultats)
			return false;
		return true;
	} // FIN function initialiser()
	
	
	function supprimerOption($tab){
		// initialisation de l'objet
		$requete = "DELETE FROM boutique_obj_options
					WHERE ID=".$tab['ID_option'];
		$resultats = T_LAETIS_site::requeter($requete);
		if (!$resultats)
			return false;
			
		$requete = "DELETE FROM boutique_rel_ingredient_option
				WHERE ID_option=".$tab['ID_option'];
		$resultats = T_LAETIS_site::requeter($requete);
		if (!$resultats)
			return false;
			
		return true;
	} // FIN function initialiser()
	
	
	function modifierOption($tab){
		// initialisation de l'objet
		$requete = "UPDATE boutique_obj_options
					SET libelle='".$tab['libelle']."'
					WHERE ID=".$tab['ID_option'];
		$resultats = T_LAETIS_site::requeter($requete);
		if (!$resultats)
			return false;
		return true;
	} // FIN function initialiser()
	
	
	function lierOption ($ID_ingredient, $ID_option){
		
		$requete = "INSERT INTO boutique_rel_ingredient_option (ID_ingredient,ID_option)
					VALUES ('".$ID_ingredient."', '".$ID_option."')";
		$resultats = T_LAETIS_site::requeter($requete);
		
		return $resultats;
		
	}
	
	function getOptionsParIngredient ($id_ingredient){
		$requete = 'SELECT boutique_obj_options.*
					FROM boutique_rel_ingredient_option, boutique_obj_options
					WHERE boutique_rel_ingredient_option.ID_ingredient = '.$id_ingredient.'
					AND boutique_rel_ingredient_option.ID_option = boutique_obj_options.ID
					ORDER BY boutique_obj_options.libelle';
		$resultats = T_LAETIS_site::requeter($requete);
		
		return $resultats;
	}

}
?>