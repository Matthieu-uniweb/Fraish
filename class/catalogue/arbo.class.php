<?php
/**
 * Classe de manipulation de l'arbo
 *
 */
require_once ('./class/commun/mysql.class.php');

class arbo
{

function __construct()
	{
	}

function listeCategorie(){
	$rqt = new mysql ;
	$rst = $rqt->query("SELECT * FROM categorie");
	return $rst;	
}

function listeSsCategorie($id_cat){
	$rqt = new mysql ;
	$rst = $rqt->query("SELECT * FROM ss_categorie WHERE id_categorie = $id_cat");
	return $rst;	
}

function createCategorie($data){
	$rqt = new mysql ;	
	$rst1 = $rqt->query("INSERT INTO categorie (titre) VALUES ('".$data[titre]."')");            
    return 1;	
}

function createSscategorie($data){
	$rqt = new mysql ;
	$rst1 = $rqt->query("INSERT INTO ss_categorie (titre, id_categorie) VALUES ('".$data[titre]."','".$data[id_cat]."')");            
    return 1;	
}

function deleteCategorie($data){
	$rqt = new mysql ;	
	$rst = $rqt->query("DELETE FROM categorie where id_categorie='$data[id_cat]'");   
    return 1;
}

function deleteSscategorie($data){
	$rqt = new mysql ;	
	$rst = $rqt->query("DELETE FROM ss_categorie where id_ss_categorie='$data[id_ss_cat]'");  
	return ($rst);
}

function updateCategorie($data){
	$rqt = new mysql ;	
	$rst = $rqt->query("UPDATE categorie set titre='".$data[titre]."' WHERE id_categorie='$data[id_cat]' ");
	return ($rst);
}

function updateSscategorie($data){
	$rqt = new mysql ;	
	$rst = $rqt->query("UPDATE ss_categorie set titre='".$data[titre]."' WHERE id_ss_categorie='$data[id_ss_cat]' ");
	return ($rst);
}

function selectCategorie($id_cat) {
		$rqt = new mysql;
		$rst = $rqt -> query("SELECT * FROM categorie where id_categorie='$id_cat'");
		return $rst;
	}

function selectSsCategorie($id_sscatt) {	
		$rqt = new mysql;
		$rst = $rqt -> query("SELECT * FROM ss_categorie where id_ss_categorie='$id_sscatt'");
		return $rst;
	}

}
?>