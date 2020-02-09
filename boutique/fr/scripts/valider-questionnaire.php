<?php
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/classes.inc.php';
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/includes/classes/paquetage.inc.php';
require_once("mailler/htmlMimeMail.php");

$notes="";
foreach($_POST['notes'] as $key=>$valeur)
	{
	$notes .= $key.'-'.$valeur.'|';
	}

$_POST['notes']=$notes;
$_POST['dateQuestionnaire']=date("Y-m-d");

$questionnaire = new Tbq_questionnaire();
$questionnaire->enregistrer($_POST);
$questionnaire->genererEmail();

header("Location:../questionnaire.php?message=ok");
?>