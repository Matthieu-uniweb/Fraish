<?
session_start();
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/classes.inc.php';
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/includes/classes/paquetage.inc.php';

$commande = new Tbq_commande($_POST['ID_commande']);
$commande->setIDCommandeFraish();
header('Location:/boutique/fr/espace-client/paiement.php');
?>