<?
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/classes.inc.php';
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/includes/classes/paquetage.inc.php';

// Suppression de la fiche
$commande=new Tbq_commande($_GET['ID_commande']);
$commande->supprimer();

// Redirection
header("Location: ../commande-lister.php");
?>