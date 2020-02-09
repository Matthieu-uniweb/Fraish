<?php
/**
 * gestion des ingr�dients
 **/

class Tbq_ingredient{
	
	var $ID = NULL;
	var $libelle = NULL;
	var $supplement = NULL;
	var $famille = NULL;
	var $sousfamille = NULL;
	var $details = NULL;
	var $prixSupplement = NULL;
	
	/** 
	* Initialisation de l'objet
	* L'initialisation se fait � partir de l'ID
	*
	* @author leo
	*/
	function initialiser($id){ 
		if ( $id ){
			
			$requete = "SELECT * FROM boutique_obj_ingredient WHERE ID='".$id."'";
			$resultats = T_LAETIS_site::requeter($requete);
			
			$this->ID = $resultats[0]['ID'] ;
			$this->libelle = $resultats[0]['libelle'] ;
			$this->supplement = $resultats[0]['supplement'] ;
			$this->famille = $resultats[0]['ID_famille'] ;
			$this->sousfamille = $resultats[0]['libelleSousFamille'] ;
			$this->details = $resultats[0]['details'] ;
			$this->prixSupplement = $resultats[0]['prixSupplement'] ;
		}
	} // FIN function initialiser()
	
	
	function getLibelleFamille($id){ 
		if ( $id ){			
			$requete = "SELECT * FROM boutique_typ_famille WHERE ID='".$id."'";
			$resultats = T_LAETIS_site::requeter($requete);			
			return $resultats[0]['libelle'] ;
		}
	} 
	
	
	function ajouterIngredient($tab){
		
		$requete = "SELECT MAX(ordreAdmin) as ordreAdmin, MAX(ordreWeb) as ordreWeb FROM boutique_obj_ingredient 
					WHERE ID_famille = ".$tab['ID_famille'];
		$resultats = T_LAETIS_site::requeter($requete);
		
		$requete = "INSERT INTO boutique_obj_ingredient (ID_famille,libelleSousFamille,supplement,libelle,ordreAdmin,ordreWeb,parDefaut )
					VALUES ('".$tab['ID_famille']."','".$tab['sousfamille']."','".$tab['supplement']."','".$tab['ingredient']."','".($resultats[0]['ordreAdmin']+1)."','".($resultats[0]['ordreWeb']+1)."','".$tab['parDefaut']."')";
		$resultats = T_LAETIS_site::requeter($requete);
		if (!$resultats)
			return false;
		return true;
	} // FIN function initialiser()
	
	
	function supprimerIngredient($tab){
		
		//suppression de toutes les options de l'ingr�dient
		
		$requete = "SELECT ID_famille
					FROM boutique_obj_ingredient
					WHERE ID =".$tab['ID_ingredient'];
		$resultats = T_LAETIS_site::requeter($requete);
		$ID_famille = $resultats[0]['ID_famille'];
		
		$requete = "DELETE FROM boutique_rel_ingredient_option
					WHERE ID_ingredient=".$tab['ID_ingredient'];
		$resultats = T_LAETIS_site::requeter($requete);
		if (!$resultats)
			return false;
		
		//suppression de l'ingr�dient
		$requete = "DELETE FROM boutique_obj_ingredient
					WHERE ID=".$tab['ID_ingredient'];
		$resultats = T_LAETIS_site::requeter($requete);
		if (!$resultats)
			return false;
		
		/** reindexation **/
		
		$listesAModifier = array('ordreWeb','ordreAdmin');
		
		
		foreach($listesAModifier as $ordre){
			//echo '<br>-----'.$ordre.'-----<br>';
			$requete = "SELECT ID 
						FROM boutique_obj_ingredient
						WHERE ID_famille=".$ID_famille."
						ORDER BY ".$ordre;
			$resultats = T_LAETIS_site::requeter($requete);
			$IDs = $resultats;	
			//print_r($IDs);
			for ($i=0; $i<count($IDs); $i++){
				$requete = "UPDATE boutique_obj_ingredient
						SET ".$ordre." = ".($i+1)."
						WHERE ID=".$IDs[$i]['ID'];
						//echo $requete.'<br>';
				$resultats = T_LAETIS_site::requeter($requete);
			} //echo '<br><br>';
		}
		
		
		return true;
	} // FIN function initialiser()
	
	
	function modifierIngredient($tab){
		
		$requete = "UPDATE boutique_obj_ingredient
					SET libelle='".addslashes($tab['libelle'])."', libelleSousFamille='".addslashes($tab['libelleSousFamille'])."', supplement='".$tab['supplement']."', parDefaut='".$tab['parDefaut']."', prixSupplement='[".$tab['libelleSupplement-1']."|".$tab['prixSupplement-1']."][".$tab['libelleSupplement-2']."|".$tab['prixSupplement-2']."][".$tab['libelleSupplement-3']."|".$tab['prixSupplement-3']."]', details='".$tab['details']."' 
					WHERE ID=".$tab['ID_ingredient'];
		$resultats = T_LAETIS_site::requeter($requete);
		
		if (!$resultats)
			return false;
		
		
		$requete = "DELETE FROM boutique_rel_ingredient_option
					WHERE ID_ingredient='".$tab['ID_ingredient']."'";
		$resultats = T_LAETIS_site::requeter($requete);
		
		if($tab['options-'.$tab['ID_ingredient']]){
			foreach($tab['options-'.$tab['ID_ingredient']] as $option){
				Tbq_option::lierOption($tab['ID_ingredient'], $option);
			}
		}
		
		if ($tab['deplacerOrdreWeb']){
			Tbq_ingredient::reindexerTab('ordreWeb', $tab['ID_famille'],$tab['ordreWeb'] ,$tab['deplacerOrdreWeb'],$tab['ID_ingredient']);
		}
		if ($tab['deplacerOrdreAdmin']){
			Tbq_ingredient::reindexerTab('ordreAdmin', $tab['ID_famille'],$tab['ordreAdmin'] ,$tab['deplacerOrdreAdmin'],$tab['ID_ingredient']);
		}
		
		return true;
	} // FIN function initialiser()


	function getCheckedOptionsIds($idIngredient){
		$requete = "SELECT ID_option as ID FROM boutique_rel_ingredient_option WHERE ID_ingredient='".$idIngredient."'";
		$resultats = T_LAETIS_site::requeter($requete);
		
		$tabIds = array();
		for($i=0; $i<count($resultats); $i++){
			$tabIds[$i]= $resultats[$i]['ID'];
		}
		return $tabIds;
	}
	
	function reindexerTab ($action, $ID_famille, $ordreActuel , $nouvellePlace, $idIngredient){
		
		//echo $action.' - '.$ID_famille.' - '.$ordreActuel .' - '.$nouvellePlace.' - '.$idIngredient;
		
		if ($nouvellePlace < $ordreActuel){
			for ($index = ($ordreActuel-1); $index>= $nouvellePlace; $index--){
				$requete = "UPDATE boutique_obj_ingredient
						SET ".$action." = '".($index+1)."'
						WHERE ID_famille='".$ID_famille."' AND ".$action." = '".$index."'";
				$resultats = T_LAETIS_site::requeter($requete);
				//echo $requete;
				
				$requete = "UPDATE boutique_obj_ingredient
					SET ".$action." = '".$nouvellePlace."'
					WHERE ID='".$idIngredient."'";
				$resultats = T_LAETIS_site::requeter($requete);
				//echo $requete;
			}
		} else {
			for ($index = ($ordreActuel+1); $index<$nouvellePlace; $index++){
				$requete = "UPDATE boutique_obj_ingredient
						SET ".$action." = '".($index-1)."'
						WHERE ID_famille='".$ID_famille."' AND ".$action." = '".$index."'";
				$resultats = T_LAETIS_site::requeter($requete);
				//echo $requete;
				
				$requete = "UPDATE boutique_obj_ingredient
					SET ".$action." = '".($nouvellePlace-1)."'
					WHERE ID='".$idIngredient."'";
				$resultats = T_LAETIS_site::requeter($requete);
				//echo $requete;
			}	
		}
		
		
	}
	
	function getDefaultStuff ($ID_famille, $ssFamille){
		$requete = "SELECT ID
					FROM boutique_obj_ingredient
					WHERE parDefaut = 1
					AND ID_famille =".$ID_famille."
					AND libelleSousFamille='".$ssFamille."'";
		$resultats = T_LAETIS_site::requeter($requete);
		if(!$resultats)
			return false;
			
		$arrayVal = array();
		$index=0;
		foreach ($resultats as $elem){
			
			$arrayVal[$index] = $elem['ID'];
			$index++;
		}
		
		$arrayVal = implode(',', $arrayVal);
		return $arrayVal; 
	}
	
	function getSsFamilles ($ID_famille){
		$requete = "SELECT libelleSousFamille
					FROM boutique_obj_ingredient
					WHERE ID_famille =".$ID_famille."
					GROUP BY libelleSousFamille ";
		$resultats = T_LAETIS_site::requeter($requete);
		if(!$resultats)
			return false;
		
		return $resultats;
	}
	
	function getSupplements ($ID_famille, $ordre, $libelleSsFamille=NULL){
		$requete = "SELECT *
					FROM boutique_obj_ingredient
					WHERE supplement = 1
					AND ID_famille = ".$ID_famille;
		if ($libelleSsFamille)
			$requete .= " AND libelleSousFamille = '".$libelleSsFamille."'";
		$requete .= " ORDER BY ".$ordre;
		//echo $requete;
		$resultats = T_LAETIS_site::requeter($requete);
		if(!$resultats)
			return false;
		
		return $resultats;
	}
	
	function checkIdForFavoris ($libelle){
		if (intval($libelle)){
			
			return $libelle;
			
		} else {
			
			$requete = "SELECT ID
					FROM boutique_obj_ingredient
					WHERE libelle ='".addslashes($libelle)."'";
			$resultats = T_LAETIS_site::requeter($requete);
			if(!$resultats)
				return $libelle;
			
			return $resultats[0]['ID'];
			
		}
		
	}
	
}
?>