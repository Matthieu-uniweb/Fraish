<?
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/classes.inc.php';
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/includes/classes/paquetage.inc.php';

// Enregistrement des modifs
$commande = new Tbq_commande();

$commande->sauverListe($_POST);
$commande->genererEmailAbandon($_POST);
if($_POST['ID_typ_paiement']==1)//IF paiement CB
	{
	$commande->genererEmailAbandonCB($_POST);//envoie un mail à l'administrateur
	}//FIN IF paiement CB

// Redirection
header("Location: ../espace-client.php");
?>