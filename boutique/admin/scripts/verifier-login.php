<?php
ini_set('display_errors', 1);
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/classes.inc.php';
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/includes/classes/paquetage.inc.php';
T_LAETIS_site::initialiserSession();

// Vérification LOGIN
if (($_POST['login']) && ($_POST['motDePasse']))
	{
	$user = new Tbq_user();
	$ID_user = $user->verifierLogin($_POST);
	if ($ID_user)
		{
		//Initialisation des variables de session
		$_SESSION["sessionID_user"] = $ID_user;
		header("Location: ../accueil.php");
		}
	else
		{
		header("Location: ../index.php?message=erreur");
		}
	}
else
	{
	header("Location: ../index.php?message=erreur");
	}
?>