<?php

//ini_set('display_errors', 1);
//error_reporting(E_ALL);	

include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/classes.inc.php';
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/includes/classes/paquetage.inc.php';

$client = new Tbq_client($_POST['ID_client']);

switch($_POST['fonction'])
	{
	case 'validerApprovisionnement':
		$appro = new Tbq_approvisionnement($_POST['ID_approvisionnement']);
		$appro->valider();
		$appro->genererMailDemandeAppro('/boutique/fr/emails/envoi-commande/envoi-appro-ok.php');
		break;
		
		case 'supprimerApprovisionnement':
		$appro = new Tbq_approvisionnement($_POST['ID_approvisionnement']);
		$appro->supprimer();
		break;
		
		case 'supprimerClient':		
		$client->supprimer();
		header("Location:/boutique/admin/accueil.php");
		break;

	}


header("Location:/boutique/admin/client-detail.php?ID_client=".$client->ID."#approvisionnements");?>