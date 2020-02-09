<?php
/*echo 'trace';*/
/*$f=fopen('test.txt','w');
fwrite($f,'trace auto_response / '.date('Y-m-d'));
fclose($f);*/

session_start();
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/classes.inc.php';
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/includes/classes/paquetage.inc.php';


$commande = new Tbq_commande($_POST['vads_order_id']/*$_POST['vads_order_info2']*/);
$client = new Tbq_client($commande->ID_client);
$paiement_ok = false;
$type='commande';

if(/*substr($_POST['vads_trans_id'],0,1)=='r'*/$_POST['vads_order_info']>0)
	{
	$type = 'recharge';
	}
/*
//VERIFIE LE RETOUR DU SERVEUR DE PAIEMENT, contrôle de la signature
$contenu_signature = '';
$params = $_POST;
ksort($params);
foreach ($params as $nom => $valeur)
	{
	if(substr($nom,0,5) == 'vads_')
		{
		// C'est un champ utilisé pour calculer la signature
		$contenu_signature .= $valeur."+";
		}
	}
$contenu_signature .= $key; // On ajoute le certificat (dernier paramètre)
$signature_calculee = sha1($contenu_signature);
//FIN VERIFIE LE RETOUR DU SERVEUR DE PAIEMENT*/

/*if(isset($_POST['signature']) && $signature_calculee == $_POST['signature'])
	{*/
if($commande->ID)
	{
	if($_POST['vads_result']=='00')//IF paiement réussi
		{
		//echo 'paiement reussi';
		
		$paiement_ok = true;
		//modifier le statut de la commande
		$commande->setIDCommandeFraish();
		$commande->modifierStatut($commande->ID,'en_cours');
		$commande->reglementCB('retourAutoPaiementAccepte');
		$commande -> genererEmailReservation("/boutique/fr/emails/envoi-commande/envoi-commande.php", $client->ID);
		///unset($_SESSION['ID_commande']);


		if($_POST['vads_order_info']>0)//IF APPRO
			{			
			//valider l'approvisionnement
			$appro = new Tbq_approvisionnement($_POST['vads_order_info']);
			$client = new Tbq_client($appro->ID_client);
			$appro->valider();
			
			$montantAppro = $appro->montant;
			$approValide = 1;
			include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/Library/bq_remise-approvisionnement.php';
            
			//mettre à jour le solde client ?
			if($commande->ID)//IF appro cb avec commande
				{
				$client = new Tbq_client($commande->ID_client);
				$client->debiterSoldeCompte($commande->prix);
				}
			$appro->genererMailDemandeAppro('/boutique/fr/emails/envoi-commande/envoi-appro-ok.php');
			}
		}//FIN IF paiement réussi
	else
		{
		if($_POST['vads_order_info']>0)
			{
			$appro = new Tbq_approvisionnement($_POST['vads_order_info']);
			$appro->supprimer();
			}
		
			$commande->reglementCB('retourAutoPaiementRefuse');		
			$commande->modifierStatut($commande->ID,'abandonnee');
		
		//echo 'echec du paiement';
		}
	}
else
	{
	exit('erreur');
	}
?>