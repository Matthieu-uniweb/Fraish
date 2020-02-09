<?
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/classes.inc.php';
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/includes/classes/paquetage.inc.php';

T_LAETIS_site::initialiserSession();

// Enregistrement des modifs
$commande = new Tbq_commande();
$commande->sauverListe($_POST);

// Redirection
header("Location: ../commande-lister.php");
?>