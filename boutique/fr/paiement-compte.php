<?
session_start();
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/classes.inc.php';
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/includes/classes/paquetage.inc.php';
if (! $_SESSION['ID_client'])
	{ header("Location: ../login.php"); }
$client = new Tbq_client($_SESSION['ID_client']);
/*$commande = new Tbq_commande($_POST['ID_commande']);
$prix = $commande->prix;*/
//echo $_SESSION['aDejaCommande'];
if($_SESSION['aDejaCommande']==true)//Evite les trous de num commande et les débits multiples
	{
	$_SESSION['aDejaCommande'] = false;
	header('Location:/boutique/fr/espace-client/espace-client.php');
	}

$commande = new Tbq_commande($_REQUEST['ID_commande']);
if(!$commande->ID_typ_paiement && $commande->ID>0 && !$_SESSION['aDejaCommande'])
	{
	//$commande->setStatut();
	//$commande->validerPaiementCompteFraish();
	$_SESSION['aDejaCommande'] = true;
	$commande->setIDPaiement(5);
	$commande->setIDCommandeFraish();
	$commande->modifierStatut($commande->ID,'en_cours');
	$commande->validerPaiementCompteFraish();
	$commande->genererEmailReservation("/boutique/fr/emails/envoi-commande/envoi-commande.php", $client->ID);
	unset($_REQUEST['ID_commande']);
	}

$client = new Tbq_client($_SESSION['ID_client']);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Fraish r&eacute;servation</title>
<link rel="stylesheet" type="text/css" href="/includes/styles/admin.css" />
<link rel="stylesheet" type="text/css" href="/includes/styles/formulaire.css" />
<link rel="stylesheet" type="text/css" href="/includes/styles/global.css" />
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />
<link rel="icon" type="image/x-icon" href="/favicon.ico" />

<!-- On inclut la librairie openrico / prototype -->
<script type="text/javascript" src="/includes/javascript/masques.js"></script>
<script src="/boutique/includes/javascript/bq_admin-boutique.js" type="text/javascript"></script>

</head>
<body>
<div id="page">
<a href="/boutique/fr/espace-client/espace-client.php">&lt; Retour</a>
<div id="enTete">&nbsp;
</div>
<div id="contenu">
<h1><?php /*?>Votre espace client<?php */?>Votre paiement a &eacute;t&eacute; accept&eacute;,<br />votre commande vous attend.</h1>
<?php /*?><h2>Paiement de votre commande</h2>
<h3>Votre paiement a &eacute;t&eacute; accept&eacute;</h3><?php */?>
<p>&nbsp;</p>
<p>
<a href="/boutique/fr/espace-client/imprimer-resa.php?ID_commande=<?php echo $commande->ID;?>" target="_blank">&gt; Cliquez ici pour imprimer la facture</a>
</p>
<p>
Vous avez &eacute;galement acc&egrave;s &agrave; toutes vos factures depuis votre espace client.
</p>
<p>&nbsp;</p>
<a href="/boutique/fr/espace-client/espace-client.php" class="bouton">Retour &agrave; l'accueil</a>

<p>&nbsp;</p>
</div>
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-1956792-20";
urchinTracker();
</script>
</div>
</body>
</html>
