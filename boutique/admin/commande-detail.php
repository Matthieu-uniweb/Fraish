<?
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/classes.inc.php';
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/includes/classes/paquetage.inc.php';
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>La boutique Fraish</title>
<style type="text/css">
<!--
#page {
	position:relative;
	border:#BE0C30 solid 6px;
	width:546px;
	font-family: Arial, Helvetica, sans-serif;
}
#contenu {
	width:546px;
}
a {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #000000;
	text-decoration:underline;
}
strong, b {
	font-weight:bold;
}
#contenu h1 {
	color:#ffffff;
	font-size:20px;
	text-transform:uppercase;
	border-top:#ad9961 solid 1px;
	border-bottom:#ad9961 solid 1px;
	padding:5px 25px 5px 25px;
	background-color:#BE0C30;
	margin:0;
}
#contenu h3 {
	padding:5px;
	margin:0;
}
#contenu p {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #320103;
	margin: 0 0 0 20px;
}
#contenu form { 
	padding:5px;
	margin:0;
	text-align:right;
}
#contenu ul li {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #320103;
	padding:10px;
	margin:0;
}
#basPage {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #AD9961;
	padding:5px;
	background-color:#c5d14a;
}
#basPage a {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #AD9961;
	text-decoration:underline;
}
#basPage a:hover {
	text-decoration:none;
}
-->
</style>
</head>
<?
$ID_commande = $_GET['ID_commande'];

$com = new Tbq_commande();
$commande = $com->detailCommande($ID_commande);
$client = new Tbq_client($commande[0]['ID_client']);
$user = new Tbq_user($commande[0]['ID_pointDeVente']);
?>
<div id="page">
 <div id="contenu">
   <img src="/images/fraish_sans_flash-1.gif" alt="kiosque Fraish" width="546" height="200">
<h1>R&eacute;capitulatif de votre commande</h1>
<?php include_once rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/Library/bq_recapitulatif.php';?>
<form><img style="border: 0px solid ; width: 17px; height: 12px;" 
alt="imprimer" src="/images/print.gif" 
onclick="window.print();return false;" type="button"></form>
 <div id="basPage"></div>
 </div>
</div>
</body>
</html>
