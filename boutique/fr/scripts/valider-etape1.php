<?
session_start();
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/classes.inc.php';
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/includes/classes/paquetage.inc.php';
require_once("mailler/htmlMimeMail.php");

//
// CLIENT
//
$client = new Tbq_client($_SESSION['ID_client']);

// On vérifie si un compte client avec cet email existe en BDD
if (! $_SESSION['ID_client'])
	{
	$detailClient = $client->demanderLogin($_POST['emailFacturation']);
	// Si cet email existe alors on demande au client de se connecter au compte client
	if ($detailClient->ID != '')
		{
		header("Location: ../creation-compte-etape1.php?erreur=clientExistant");
		exit();
		} // FIN if ($detail['ID'] != '')
	} // FIN if (! $_SESSION['ID_client'])


/*// Enregistrer les infos du client
if($_POST['codeEntreprise'] && !Tbq_entreprise::codeEntrepriseExiste($_POST['codeEntreprise']))
	{
	header("Location: ../creation-compte-etape1.php?erreur=codeEntrepriseInvalide");
	exit();
	}*/
$client->enregistrer($_POST);
$valeurs['ID_client']=$client->ID;

// Enregistrer les gouts du client
$client_specifique = new Tbq_client_specifique($_POST['ID_client_specifique']);

//$valeurs['aime'] = "Aime les ingr&eacute;dients :<ul>";
//$valeurs['moyen'] = "Moyen ingr&eacute;dients :<ul>";
//$valeurs['deteste'] = "D&eacute;teste les ingr&eacute;dients :<ul>";

if ($_POST['questionnaire'])
	{
	while(list($ingredient) = each($_POST['questionnaire']))
		{
		$tabIngredient = explode('|', $_POST['questionnaire'][$ingredient]);
		$valeurs[$tabIngredient[0]] .= $tabIngredient[1].", ";
		}
	}

$ID = $client_specifique -> enregistrer($valeurs);

// Redirection
$client -> envoyerLoginInscription("/boutique/fr/emails/envoi-codes/envoi-codes-inscription.php", $valeurs['ID_client']);

// Ce client vient d'être crée
if (! $_SESSION['ID_client'])
	{
	session_destroy();
	header("Location: ../login.php?inscription=ok");
	}
else
	{
	header("Location: ../espace-client/espace-client.php");
	}
?>