<?
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/classes.inc.php';
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/includes/classes/paquetage.inc.php';
require_once("mailler/htmlMimeMail.php");

// Identification de l'utilisateur
if ($_POST['email'])
	{
	$client = new Tbq_client();

	$detailClient = $client->demanderLogin($_POST['email']);
	if ($detailClient->emailFacturation != '')
		{
		$detailClient->envoyerLogin();
		$url = "../popup/retour-codes.php?erreur=".$_POST['email'];
		}
	else
		{
		$url = "../popup/retour-codes.php?erreur=inconnu";
		}
	}
else
	{
	$url = "../popup/retour-codes.php?erreur=inconnu";
	}

header("Location: $url");
?>