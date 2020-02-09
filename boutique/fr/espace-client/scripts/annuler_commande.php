<?
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/classes.inc.php';
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/includes/classes/paquetage.inc.php';

// Enregistrement des modifs
$commande = new Tbq_commande($_POST['ID_commande']);

$commande->sauverListe($_POST);
$commande->genererEmailAbandon($_POST);

// Redirection
header("Location: ../espace-client.php");
?>