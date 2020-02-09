<?
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/classes.inc.php';
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/includes/classes/paquetage.inc.php';

// Suppression de la fiche
$tbq_option=new Tbq_option();
$tbq_option->modifierOption($_POST);

// Redirection
header("Location: ../ingredients-lister.php");
?>