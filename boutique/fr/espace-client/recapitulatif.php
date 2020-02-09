<?
session_start();

if (! $_SESSION['ID_client'])
	{ header("Location: ../login.php"); }
	
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/classes.inc.php';
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/includes/classes/paquetage.inc.php';

//$commande = new Tbq_commande($_GET['ID']);

$ID_commande = $_GET['ID_commande'];	
$com = new Tbq_commande();
$commande = $com->detailCommande($ID_commande);
$client = new Tbq_client($_GET['ID_client']);
$user = new Tbq_user($commande[0]['ID_pointDeVente']);
$ptLivraison = new Tbq_pointLivraison($commande[0]['ID_pointLivraison']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Fraish r&eacute;servation</title>
<link rel="stylesheet" type="text/css" href="/includes/styles/admin.css" />
<link rel="stylesheet" type="text/css" href="/includes/styles/formulaire.css" />
<link rel="stylesheet" type="text/css" href="/includes/styles/global.css" />
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />
<link rel="icon" type="image/x-icon" href="/favicon.ico" />

<link rel="stylesheet" type="text/css" href="../../includes/styles/calendrier.css">
<!-- On inclut la librairie openrico / prototype -->
<script src="../../includes/plugins/rico/src/prototype.js" type="text/javascript"></script>
<script type="text/javascript" src="/includes/javascript/masques.js"></script>
<script src="../../includes/plugins/tinymce/jscripts/tiny_mce/tiny_mce.js" type="text/javascript"></script>
<script src="/boutique/includes/javascript/bq_admin-boutique.js" type="text/javascript"></script>
<script language="javascript" type="text/javascript">
<!--
var sortie = 0;
window.onunload = function()
	{
	if(sortie==0)
		{
		var ok = confirm("Voulez-vous abandonner votre commande Fraish ? \nSi vous cliquez sur 'Ok', votre commande ne sera pas préparée.\nSi vous cliquez sur 'Annuler', vous pourrez accéder à la validation et au paiement de votre commande.");

		if(ok==false)
			{
			document.location.href = this.document.location.href;
			}
		}
	}
-->
</script>
<style type="text/css">
<!--
.Style1 {
	color: #990000
}
#infoRecharge {
	top:/*420*/200px;
}
#infoRecharge a {
	display:none;
}
-->
</style>
</head>
<body>
<div id="page">
<a href="espace-client.php">&lt; Retour</a>
<div id="enTete">&nbsp;
</div>
<div id="contenu">
<h1>Votre espace client</h1>
<?php
$etape=4;
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/Library/bq_etapes.php';
?>
<form method="post" action="/boutique/fr/espace-client/paiement.php">
<?php //boutique/fr/scripts/valider-commande.php?>
<input type="hidden" name="ID_commande" value="<?php echo $ID_commande;?>"/>
<?php /*?><h2>R&eacute;capitulatif de votre commande</h2><?php */?>
<h2>R&eacute;capitulatif avant paiement</h2>

<?php include_once rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/Library/bq_recapitulatif.php';
include_once rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/Library/bq_info-recharge.php';?>
<?php /*?><input type="button" class="bouton" value="Retour" style="display:inline;" /><?php */?>

<?php /*?><input type="submit" class="bouton" value="Valider ma commande &gt;" style="display:inline; background-color:#76BD48;" onclick="javascript:sortie=1;" /><?php */?>
<?php
?>
<input type="submit" class="bouton" value="Je valide ma commande pour pouvoir la retirer sur le kiosque" style="display:inline; background-color:#76BD48; width:360px;" onclick="javascript:sortie=1;" />

<p><a <?php /*?>class="boutonRetour"<?php */?> <?php /*?>style="background-color:#C00;"<?php */?> href="javascript:sortie=1; document.location.href='reserver-ingredients.php?ID_commande=<?php echo $commande[0]['ID'];?>&amp;ID_menu=<?php echo $_GET['ID_menu'];?>'">&lt;&nbsp;Retour</a></p>

</form>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
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
