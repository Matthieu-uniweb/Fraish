<?
session_start();
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/classes.inc.php';
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/includes/classes/paquetage.inc.php';
$ID_commande = $_GET['ID_commande'];
$commande = new Tbq_commande();
$contenu = $commande->detailCommande($ID_commande);
echo $contenu[0]['recapitulatif'];
?>