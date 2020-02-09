<?
session_start();
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/classes.inc.php';
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/includes/classes/paquetage.inc.php';
if (! $_SESSION['ID_client'])
	{ header("Location: ../login.php"); }
$client = new Tbq_client($_SESSION['ID_client']);

$commande = new Tbq_commande($_REQUEST['ID_commande']);

$prix = $commande->prix;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!--<META HTTP-EQUIV="Pragma" CONTENT="no-cache" />
<META HTTP-EQUIV="Expires" CONTENT="-1" />-->
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Fraish r&eacute;servation</title>
<link rel="stylesheet" type="text/css" href="/includes/styles/admin.css" />
<link rel="stylesheet" type="text/css" href="/includes/styles/formulaire.css" />
<link rel="stylesheet" type="text/css" href="/includes/styles/global.css" />
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />
<link rel="icon" type="image/x-icon" href="/favicon.ico" />

<link rel="stylesheet" type="text/css" href="../../includes/styles/calendrier.css">
<!-- On inclut la librairie openrico / prototype -->
<script type="text/javascript" language="javascript">
var sortie=0;
window.onunload = function()
	{
	if(sortie==0)
		{
		var ok = confirm("Voulez-vous abandonner votre commande Fraish ? \nSi vous cliquez sur 'Ok', votre commande ne sera pas préparée.\nSi vous cliquez sur 'Annuler', vous pourrez accéder au paiement de votre commande.");

		if(ok==false)
			{
			document.location.href = '/boutique/fr/espace-client/paiement.php?ID_commande=<?php echo $commande->ID;?>';
			//document.history.go(-1);
			}
		else
			{
			//abandonnerCommande();
			}
		}
	}
</script>
<script src="../../includes/plugins/rico/src/prototype.js" type="text/javascript"></script>
<script type="text/javascript" src="/includes/javascript/masques.js"></script>
<script src="../../includes/plugins/tinymce/jscripts/tiny_mce/tiny_mce.js" type="text/javascript"></script>
<script src="/boutique/includes/javascript/bq_admin-boutique.js" type="text/javascript"></script>
<script type="text/javascript" language="javascript">

function abandonnerCommande()
	{
	
	}
function accederPaiementCB()
	{
	sortie=1;
	window.document.forms[0].submit();
	}
function accederPaiementCompteCredit(mode)
	{
	sortie=1;
	document.location.href = 'paiement-formulaire-credit.php?ID_commande=<?php echo $commande->ID;?>&amp;mode='+mode;
	}
function accederPaiementCompte()
	{
	sortie=1;
	document.location.href='/boutique/fr/paiement-compte.php?ID_commande=<?php echo $commande->ID;?>';
	}

</script>
<style type="text/css">
<!--
.Style1 {
	color: #990000
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
$etape=5;
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/Library/bq_etapes.php';
?>
<h2>Total de votre commande : <?php echo $prix;?>&nbsp;&euro;</h2>

<h3 style="background:url('/boutique/images/bk-paiement-cb.jpg') no-repeat; width:259px; height:42px; padding-top:20px; padding-left:20px; margin-top:5px;">
<a href="javascript:accederPaiementCB();" title="Paiement carte bancaire" style="font-size:18px; font-weight:bold; padding-left:0px; text-decoration:none;">Je paie par carte bancaire</a></h3>
<div style="border:solid 2px #93C6FF; width:550px; padding-left:35px;">
<p>
<form action="/includes/paiement/call_request_v2.php" method="post">
</form>
<a href="javascript:accederPaiementCB();" style="text-decoration:underline;" title="Acc&eacute;dez au paiement s&eacute;curis&eacute;">Cliquez ici pour acc&eacute;der au paiement s&eacute;curis&eacute;</a><br />
</p>
<div style="width:400px; padding-top:10px; padding-bottom:10px;">
<a href="javascript:accederPaiementCB();" title="Acc&eacute;dez au paiement s&eacute;curis&eacute;"><img src="/includes/paiement/images/logo_cb.gif" height="49" /></a>
<a href="javascript:accederPaiementCB();" title="Acc&eacute;dez au paiement s&eacute;curis&eacute;"><img src="/includes/paiement/images/logo_mastercard.gif" /></a>
<a href="javascript:accederPaiementCB();" title="Acc&eacute;dez au paiement s&eacute;curis&eacute;"><img src="/includes/paiement/images/logo_visa.gif" /></a>
<a href="javascript:accederPaiementCB();" title="Acc&eacute;dez au paiement s&eacute;curis&eacute;"><img src="/includes/paiement/images/maestro.gif" /></a>
</div>

<p>Le paiement de votre commande va &ecirc;tre trait&eacute; sur le serveur s&eacute;curis&eacute; de notre banque.<br />
Nous utilisons le système <strong>CyberPlus</strong> de la <strong>Banque Populaire</strong>.</p>
</div>

<p>&nbsp;</p>

<h3 style="background:url('/boutique/images/bk-paiement-compte.jpg') no-repeat; width:259px; height:42px; padding-top:20px; padding-left:20px;">
<a href="<?php
if($client->soldeCompte>=$prix)
	{?>
    javascript:sortie=1; accederPaiementCompte();<?php
	}
else
	{?>
    javascript:sortie=1; document.location.href='paiement-formulaire-credit.php?ID_commande=<?php echo $commande->ID;?>';<?php
	}
?>" style="font-size:18px; font-weight:bold; padding-left:0px; text-decoration:none; color:#fff;">
Je paie avec mon compte</a></h3>
<div style="border:solid 2px #BE0C30; width:550px; padding-left:35px;">
<p>
<strong>Vous avez <?php echo $client->soldeCompte;?> &euro; sur votre compte client.</strong><?php
if($client->soldeCompte>=$prix)
	{?>
<br /><a href="javascript:accederPaiementCompte();" title="Payer avec mon compte client"><strong>Je paie avec mon compte</strong></a><br />
<img src="/boutique/images/paiement-titres-resto.jpg" />
<img src="/boutique/images/paiement-cheque.jpg" />
<?php /*?><img src="/boutique/images/paiement-especes.jpg" /><?php */?>
</a><?php
	}?></p>
<?php
if($client->soldeCompte<$prix)
	{?>
    <?php /*?><strong>Vous n'avez pas assez de crédits pour régler votre menu</strong><br /><?php */?>
    
    <p><strong>Pour cr&eacute;diter votre compte, cliquez sur le logo de votre choix et laissez vous guider.</strong></p>
    <div style="width:550px; padding-top:10px; padding-bottom:10px;">
<a href="javascript:accederPaiementCompteCredit('paiementTitresResto');" title="Créditer mon compte client"><img src="/boutique/images/paiement-titres-resto.jpg" /></a>
<a href="javascript:accederPaiementCompteCredit('paiementCheque');" title="Créditer mon compte client"><img src="/boutique/images/paiement-cheque.jpg" /></a>
<?php /*?><a href="javascript:accederPaiementCompteCredit('paiementEspeces');" title="Créditer mon compte client"><img src="/boutique/images/paiement-especes.jpg" /></a><?php */?>
</div>
   
    <?php
	}?>
    <div style="" id="le-saviez-vous"><img src="/images/site/le-saviez-vous.jpg" width="150"/>
    <p style="text-align:justify;"><img src="/images/site/titre-paiement-cb.jpg" width="115" /><br />Vous pouvez payer juste la somme de votre menu du jour en ligne avec CB.<?php /*?><img src="/images/site/ex-paiement-cb.jpg" width="220" /><?php */?></p>
 
    <p><img src="/images/site/ou.jpg" /><img src="/images/site/titre-paiement-compte.jpg" width="115" /><br />FRAISH vous a réservé un espace personnel  ou vous pouvez créditer votre compte  et l'utiliser comme votre porte monnaie !!<br />
    A l'&eacute;tape <img src="/images/site/etape5-paiement.jpg" width="80" />, vous cliquez sur le paiement de votre choix.
    <?php /*?><img src="/images/site/ex-paiement-compte.jpg" width="220" /><?php */?>
    </p>
    <p>Un formulaire apparait. Vous le remplissez avec la somme de votre choix et le paiement de votre choix.<br />Imprimez le formulaire.<br /><strong>Rendez-vous dans votre point de vente avec votre formulaire rempli et votre règlement, votre premier menu vous attend.</strong><br />24 heures après, votre compte sera crédité et accessible sur votre profil FRAISH.<br />
Pour les commandes suivantes, cliquez sur <span style="text-align:left;"><strong>&ldquo;je paie avec mon compte&rdquo;</strong></span><img src="/images/site/ex-paiement-compte-credite.jpg" width="220" /></p></div> 
</div>

<p>&nbsp;</p>
<?php /*?><h3>Par ch&egrave;que ou esp&egrave;ces</h3>
<p>A r&eacute;gler lors du retrait de votre menu sur le kiosque Fraish.</p>
<p>&nbsp;</p><?php */

unset($_SESSION['ID_pointDeVente']);?>
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
