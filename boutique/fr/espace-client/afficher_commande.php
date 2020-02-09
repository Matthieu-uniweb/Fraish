<?
session_start();
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/classes.inc.php';
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/includes/classes/paquetage.inc.php';

$commande = new Tbq_commande($_GET['ID_commande']);
/*$commande=$commande->detailCommande($_GET['ID_commande']);
$client = new Tbq_client($commande[0]['ID_client']);
$user = new Tbq_user($commande[0]['ID_pointDeVente']);*/

//echo $contenu[0]['recapitulatif'];
echo $commande->recapitulatif;
?>

