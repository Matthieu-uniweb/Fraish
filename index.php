<?php
//Si le cookie de commande n'est pas en place, on le cré et on l'initialise à "ok"
//if(!$_COOKIE["commandefraish"]) setcookie ("commandefraish", "ok", time()+60*60*24*30, '/'); // 1 mois

ini_set('display_errors', 1);
error_reporting(E_ERROR | E_WARNING | E_PARSE);	
//error_reporting(E_ALL);	
header('Content-type: text/html; charset=UTF-8'); 
// traitement de la query string, acces page statique (url rewriting)

//on teste si la requete contient .html
if(eregi('.html',$_SERVER['REQUEST_URI'])){ 
	$query_string = explode('/',$_SERVER['REQUEST_URI']);

	//passage des cases a 2 car sous dossier !!!
	$url = $query_string.'/index.php?fonction='.substr($query_string[1], 0, (strlen($query_string[1]) - strlen('.html')));
	$url = str_replace('-','&',$url);
	//$url = str_replace('-','',$url);
	$url = str_replace('_','=',$url);
// traitement de la query string, acces page dynamique (PHP)
}else{
	$url = $_SERVER['REQUEST_URI'];
}

//compression HTML
ob_start("ob_gzhandler");

include ('class/demande.class.php');
$C_demande = new demande($url);
?>
