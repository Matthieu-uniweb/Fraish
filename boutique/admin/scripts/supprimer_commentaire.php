<?
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/classes.inc.php';
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/includes/classes/paquetage.inc.php';

// Suppression de la fiche
$questionnaire=new Tbq_questionnaire($_GET['ID_questionnaire']);
$questionnaire->supprimer();

// Redirection
header("Location: ../questionnaire-lister.php");
?>