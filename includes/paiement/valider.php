<?php
session_start();
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/classes.inc.php';
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/includes/classes/paquetage.inc.php';

/*$_POST['vads_order_id']=12849;
$commande = new Tbq_commande($_POST['vads_order_id']);
$client = new Tbq_client($commande->ID_client);

$commande->modifierStatut($commande->ID,'en_cours');
$commande->reglementCB('retourAutoPaiementAccepte');
$commande -> genererEmailReservation("/boutique/fr/emails/envoi-commande/envoi-commande.php", $client->ID);*/
?>