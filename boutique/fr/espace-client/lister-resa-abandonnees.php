<?php
session_start();

if (! $_SESSION['ID_client'])
	{ header("Location: ../login.php"); }

include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/classes.inc.php';
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/includes/classes/paquetage.inc.php';

$client = new Tbq_client($_SESSION['ID_client']);
$commande = new Tbq_commande();
$listeCommandesAbandonnees = $commande->listerCommande($_SESSION['ID_client'], 'abandonnee');?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Fraish espace client</title>
<meta name="description" content="La boutique Fraish" />
<meta name="keywords" content="boutiqueFraish" />
<link rel="stylesheet" type="text/css" href="/includes/styles/global.css" />
<link rel="stylesheet" type="text/css" href="/includes/styles/admin.css" />
<link rel="stylesheet" type="text/css" href="/includes/styles/formulaire.css" />
<script type="text/javascript" src="/includes/javascript/globals.js"></script>
<script type="text/javascript" src="/includes/javascript/site.js"></script>
<script type="text/javascript" src="/includes/javascript/flashobject.js"></script>
<script type="text/javascript" src="/includes/javascript/navigation.js"></script>
<script type="text/javascript" src="/includes/javascript/mm.js"></script>
<script type="text/javascript" src="/includes/javascript/formulaire.js"></script>
<script type="text/javascript" src="/boutique/includes/javascript/bq_front-boutique.js"></script>
<script type="text/javascript" src="/includes/javascript/preload-fr.js"></script>
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />
<link rel="icon" type="image/x-icon" href="/favicon.ico" />
</head>
<body>
<div id="page">
<a href="espace-client.php">&lt; Retour</a>
<div id="enTete">&nbsp;
</div>
<div id="contenu">
<h1>Votre espace client</h1>
<h2>Vos r&eacute;servations abandonn&eacute;es</h2>
<ul>
      <?
	 foreach($listeCommandesAbandonnees as $commandesAbandonnees)
	 	{
	 ?>
      <li><a href="afficher_commande.php?ID_commande=<? echo $commandesAbandonnees['ID']; ?>" target="_blank">R&eacute;servations n&deg;<strong><? echo $commandesAbandonnees['ID_commande_fraish']; ?></strong> pour le <? echo T_LAETIS_site::dateEnFrancais($commandesAbandonnees['dateReservation']); ?> (effectu&eacute;e le <? echo T_LAETIS_site::dateHeureFormatFrancais($commandesAbandonnees['dateCommande']); ?>)</a> </li>
      <? } // FIN for ($i=0; $i<count($commandesAbandonnees); $i++) ?>
    </ul>
<p>&nbsp;</p>
<a class="bouton" href="/boutique/fr/espace-client/espace-client.php">Retour</a>
<p>&nbsp;</p>
</div>
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-1956792-20";
urchinTracker();
</script>
</body>
</html>
