<?
session_start();
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/classes.inc.php';
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/includes/classes/paquetage.inc.php';
if (! $_SESSION['ID_client'])
	{ header("Location: /boutique/fr/login.php"); }
/*$client = new Tbq_client($_SESSION['ID_client']);
$commande = new Tbq_commande($_POST['ID_commande']);
$prix = $commande->prix;*/

$client = new Tbq_client($_SESSION['ID_client']);
$commande = new Tbq_commande($_POST['vads_order_id']);
$paiement_ok = false;
//printr_($_POST);
if($_POST['vads_result']=='00')
	{
	$paiement_ok = true;
	}
else
	{//commande abandonnée
	Tbq_commande::modifierStatut($_SESSION['ID_commande'],'abandonnee');
	}

$type='commande';
if(/*substr($_POST['vads_trans_id'],0,4)=='rech'*/$_POST['vads_order_info']>0)
			{
			//echo $_POST['vads_order_info'];
			$type = 'recharge';
			}
unset($_SESSION['ID_commande']);
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
<h1>Votre espace client</h1>
<h2>Paiement de votre commande</h2><?php
if($paiement_ok)
	{?>
    <h3>Votre paiement a &eacute;t&eacute; accept&eacute;</h3>
    <?php
	/*if($commande->ID>0)
		{?>
        <p>&nbsp;</p>
        <p>Commande n&deg; <?php echo $commande->ID_commande_fraish;?> du <?php echo T_LAETIS_site::convertirDate($commande->dateReservation);?>.</p><?php
		}*/?>
    <p>Merci pour votre <?php echo $type;?>.</p><?php
	if($commande->ID)
		{
		if(/*$type=='commande'*/$_POST['vads_order_info2']>0)
			{?>
            <p>Votre commande vous attend chez FRAISH.</p>
            <p>&nbsp;</p>
            <p>
            <a href="/boutique/fr/espace-client/imprimer-resa.php?ID_commande=<?php echo $_POST['vads_order_info2'];?>" target="_blank">&gt; Cliquez ici pour imprimer la facture de votre menu</a>
            </p><?php
			}
		if(/*$type=='recharge'*/$_POST['vads_order_info']>0)
			{?>
            <a href="/boutique/fr/espace-client/imprimer-appro-facture.php?ID_appro=<?php echo $_POST['vads_order_info'];?>" target="_blank">&gt; Cliquez ici pour imprimer la facture d'approvisionnement</a>
            <?php
			}
		?>
        <p>&nbsp;</p>
        <p>
        Vous avez &eacute;galement acc&egrave;s &agrave; toutes vos factures depuis votre <a href="/boutique/fr/espace-client/espace-client.php">espace client</a>.
        </p>
        <p>&nbsp;</p>
	<?php
		}
	}
else
	{?>
    <h3>Votre paiement a &eacute;chou&eacute;</h3>
    <p>
    Votre commande n'a pas aboutie.<br />
    Le paiement n'a pas &eacute;t&eacute; accept&eacute; par la banque. Vous pouvez r&eacute;essayer en passant une autre commande.</p>
    <?php
	}?>
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
