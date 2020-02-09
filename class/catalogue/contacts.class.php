<?php
/**
  Version : 2.3
  Pour Gestion Actus avec titre et photo, gestion des photos par numéro unique aléatoire
 * Gestion Si pas de photo, gestion vignettes pour accélérer affichage
 * Photo : uniquement jpeg
 * Gestion du dossier en séparé, pour changement rapide...
 */
 
 
require_once ('./class/commun/mysql.class.php');

class contacts
{

var $folderImg  = 'media/contacts/';

function __construct()
	{
	}

function liste()
	{
			$rqt = new mysql ;
			$rst = $rqt->query("SELECT * FROM annuaire");
			return $rst;
	}
	
function detail($data)
	{
			//if ($data[id_actu]=="") {$data[id_actu]=$data[id];}
			$rqt = new mysql ;
			$rst = $rqt->query("SELECT * FROM annuaire where id='$data[id_contact]'");			
			return $rst;
	}


function update($data)
	{		
		$rqt = new mysql ;
		$rst = $rqt->query("UPDATE annuaire set ville='".$data[ville]."', prenom='".$data[prenom]."', nom='".$data[nom]."', tel='".$data[tel]."', email='".$data[email]."', resp='".$data[resp]."' where id='$data[id_contact]'");	
		return ($rst);
	}
	

	
}
?>