<?php
session_start();

if (! $_SESSION['ID_client'])
	{ header("Location: ../login.php"); }

include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/classes.inc.php';
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/includes/classes/paquetage.inc.php';

$client = new Tbq_client($_SESSION['ID_client']);
$commande = new Tbq_commande();

$dateDebut = '01-'.date('m-Y');// 1er du mois
$dateFin = date('d-m-Y');//date du jour

if($_POST['dateDebut'])
	{
	$dateDebut = $_POST['dateDebut'];
	}
if($_POST['dateFin'])
	{
	$dateFin = $_POST['dateFin'];
	}
$listeCommandesLivrees = $commande->listerCommande($_SESSION['ID_client'], 'livree',$dateDebut,$dateFin);?>
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
<script type="text/javascript" src="/includes/javascript/masques.js"></script>
<script type="text/javascript" src="/includes/javascript/formulaire.js"></script>
<script type="text/javascript" src="/boutique/includes/javascript/bq_front-boutique.js"></script>
<script type="text/javascript" src="/includes/javascript/preload-fr.js"></script>
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />
<link rel="icon" type="image/x-icon" href="/favicon.ico" />
<style type="text/css">
input[type="text"]
	{
	border:solid 1px #000000;
	width:75px;
	text-align:center;
	}
</style>
</head>
<body>
<div id="page">
<a href="espace-client.php">&lt; Retour</a>
<div id="enTete">&nbsp;
</div>
<div id="contenu">
<form id="formDates" action="" method="post">
<h1>Votre espace client</h1>
<h2>Vos r&eacute;servations effectu&eacute;es</h2>
<p>
Lister les r&eacute;servations effectu&eacute;es entre le 
<input type="text" name="dateDebut" value="<?php echo $dateDebut;?>" onkeypress="javascript:verifierMasqueSaisie(this,'##-##-####');" />
et le 
<input type="text" name="dateFin" value="<?php echo $dateFin;?>" onkeypress="javascript:verifierMasqueSaisie(this,'##-##-####');" />&nbsp;(dates au format jj-mm-aaaa, exemple : 01-<?php echo date('m-Y');?>)
<input type="submit" value="Valider" class="bouton"/></p>
<ul><?php	 
	 if($listeCommandesLivrees)
	 	{?>
        <li style="list-style:none;"><a href="/boutique/fr/espace-client/imprimer-resa.php?dateDebut=<?php echo $dateDebut;?>&dateFin=<?php echo $dateFin;?>" title="Imprimer toutes les factures de cette liste" target="_blank" style="font-weight:bold;">&gt; Imprimer toutes les factures de cette liste</a></li><?php
		foreach($listeCommandesLivrees as $commandesLivrees)
	 		{
	 ?>
      		<li><a href="afficher_commande.php?ID_commande=<? echo $commandesLivrees['ID']; ?>" target="_blank">R&eacute;servations n&deg;<strong><? echo $commandesLivrees['ID_commande_fraish']; ?></strong> pour le <? echo T_LAETIS_site::dateEnFrancais($commandesLivrees['dateReservation']); ?> (effectu&eacute;e le <? echo T_LAETIS_site::dateHeureFormatFrancais($commandesLivrees['dateCommande']); ?>)</a> - <a href="/boutique/fr/espace-client/imprimer-resa.php?ID_commande=<?php echo $commandesLivrees['ID'];?>" title="Imprimer la facture" target="_blank">&gt; Imprimer la facture</a></li>
      <? 	} // FIN for ($i=0; $i<count($commandesEffectuees); $i++) ?>
      	<?php
		}
	else
		{?>
        <li><p>Aucun r&eacute;servation n'a &eacute;t&eacute; effectu&eacute;e entre le <?php echo $dateDebut;?> et le <?php echo $dateFin;?></p></li><?php
		}
?>
        
    </ul>
<p>&nbsp;</p>
<a class="bouton" href="/boutique/fr/espace-client/espace-client.php">&lt;&nbsp;Retour</a>
<p>&nbsp;</p>
</form>
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