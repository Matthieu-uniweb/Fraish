<?php
session_start();
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/classes.inc.php';
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/includes/classes/paquetage.inc.php';

$commande=new Tbq_commande($_SESSION['ID_commande']);
unset($_SESSION['ID_pointDeVente']);
unset($_SESSION['dateReservation']);
$client = new Tbq_client($_SESSION['ID_client']);
$commande->setIDPaiement(1);

$VADS_ORDER_INFO = 0; //Indicateur approvisionnement
$VADS_ORDER_INFO2 = $_SESSION['ID_commande']; //Indicateur menu

if(!$client->ID)
	{
	exit('erreur session');
	}

if($_POST['fonction']=='rechargeCartebancaire')//IF recharge compte client
	{
	$appro = new Tbq_approvisionnement();
	$_POST['ID_client'] = $client->ID;

	if($_SESSION['ID_commande'])//IF commande associée
		{
		//$commande->prix+=$_POST['montant'];
		$commande->prix = $_POST['montant'];
		$appro->enregistrer($_POST);
		}//FIN IF commande associée
	else//ELSE recharge seule
		{
		$commande->prix=$_POST['montant'];
		$appro->enregistrer($_POST);
		$commande->ID = /*'rech'.$appro->ID*/$appro->ID;		
		}//FIN ELSE recharge seule		
	$VADS_ORDER_INFO = $appro->ID; //signale que le paiement inclut 1 approvisionnement
	}//FIN IF recharge compte client

// Montant de la commande en centimes d'euro
$VADS_AMOUNT=$commande->prix*100;

//Modifie l'état de la commande
//$commande->setStatut('appel cb');

$VADS_SITE_ID = "10316247"; // Valeur reel
$VADS_CERTIFICAT = "5948554159575131";
//"6753350399258591";//certificat de test

$VADS_ACTION_MODE="INTERACTIVE";
$VADS_CTX_MODE="PRODUCTION";//valeur "TEST"
$VADS_CURRENCY="978";
$VADS_CUST_EMAIL=$client->emailFacturation;
$VADS_LANGUAGE = "fr";
$VADS_ORDER_ID=$commande->ID;
$VADS_PAGE_ACTION = "PAYMENT";
$VADS_PAYMENT_CONFIG = "SINGLE";
$VADS_RETURN_MODE="POST";


//ID_pointDeVente ID_commandeFraish
//$nbZeros = 5-strlen($commande->ID_commande_fraish) +1;//Le TRANS_ID doit etre sur 6 caractères
//$partie2 = str_pad($commande->ID_commande_fraish,$nbZeros,0,STR_PAD_LEFT);
//$VADS_TRANS_ID = $commande->ID_pointDeVente.$partie2;
$nbZeros = 6-strlen($commande->ID);//Le TRANS_ID doit etre sur 6 caractères
for($i=0;$i<$nbZeros;$i++)
	{
	$zeros.='0';
	}
$VADS_TRANS_ID = $zeros.$commande->ID;

//$VADS_TRANS_DATE = date('YmdHis');
$VADS_TRANS_DATE = gmdate('YmdHis');

$VADS_EFFECTUE = 'http://'.$_SERVER['HTTP_HOST']."/boutique/fr/paiement-cb.php";
$VADS_URL_CANCEL = 'http://'.$_SERVER['HTTP_HOST']."/boutique/fr/paiement-annule.php";
$VADS_REFUSE = 'http://'.$_SERVER['HTTP_HOST']."/boutique/fr/paiement-refuse.php";
$VADS_ERREUR = 'http://'.$_SERVER['HTTP_HOST']."/boutique/fr/paiement-refuse.php"; 
$VADS_VERSION = "V2";
?>
<html>
<head>
<title>Paiement S&eacute;curis&eacute;</title>
<link href="/includes/styles/boutique.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body onLoad="document.forms[0].submit();">
<form name="formulaire" method="post" action="https://systempay.cyberpluspaiement.com/vads-payment/">
  <input type="hidden" name="vads_action_mode" value="<?php echo $VADS_ACTION_MODE;?>">
  <input type="hidden" name="vads_amount" value="<?php echo $VADS_AMOUNT;?>">
  <input type="hidden" name="vads_ctx_mode" value="<?php echo $VADS_CTX_MODE;?>">
  <input type="hidden" name="vads_currency" value="<?php echo $VADS_CURRENCY;?>">
  <input type="hidden" name="vads_cust_email" value="<?php echo $VADS_CUST_EMAIL;?>">
  <input type="hidden" name="vads_language" value="<?php echo $VADS_LANGUAGE;?>"><?php //FACULTATIF ?>
  <input type="hidden" name="vads_order_id" value="<?php echo $VADS_ORDER_ID;?>"><?php //FACULTATIF ?>
  <input type="hidden" name="vads_order_info" value="<?php echo $VADS_ORDER_INFO;?>">
  <input type="hidden" name="vads_order_info2" value="<?php echo $VADS_ORDER_INFO2;?>">  
  <input type="hidden" name="vads_page_action" value="<?php echo $VADS_PAGE_ACTION;?>">
  <input type="hidden" name="vads_payment_config" value="<?php echo $VADS_PAYMENT_CONFIG;?>">
  <input type="hidden" name="vads_return_mode" value="<?php echo $VADS_RETURN_MODE;?>">
  <input type="hidden" name="vads_site_id" value="<?php echo $VADS_SITE_ID;?>">
  <input type="hidden" name="vads_trans_date" value="<?php echo $VADS_TRANS_DATE;?>">
  <input type="hidden" name="vads_trans_id" value="<?php echo $VADS_TRANS_ID;?>">
  <?php /*?><input type="hidden" name="vads_url_cancel" value="<?php echo $VADS_URL_CANCEL;?>"/><?php //FACULTATIF ?>
  <input type="hidden" name="vads_url_error" value="<?php echo $VADS_ERREUR;?>"/><?php //FACULTATIF ?>
  <input type="hidden" name="vads_url_refused" value="<?php echo $VADS_REFUSE;?>"/><?php //FACULTATIF ?>
  <input type="hidden" name="vads_url_success" value="<?php echo $VADS_EFFECTUE;?>"/><?php //FACULTATIF ?><?php */?>
  <input type="hidden" name="vads_version" value="<?php echo $VADS_VERSION;?>">   
  <input type="hidden" name="signature" value="<?php echo sha1($VADS_ACTION_MODE.'+'.$VADS_AMOUNT.'+'.$VADS_CTX_MODE.'+'.$VADS_CURRENCY.'+'.$VADS_CUST_EMAIL.'+'.$VADS_LANGUAGE.'+'.$VADS_ORDER_ID.'+'.$VADS_ORDER_INFO.'+'.$VADS_ORDER_INFO2.'+'.$VADS_PAGE_ACTION.'+'.$VADS_PAYMENT_CONFIG.'+'.$VADS_RETURN_MODE.'+'.$VADS_SITE_ID.'+'.$VADS_TRANS_DATE.'+'.$VADS_TRANS_ID./*'+'.$VADS_URL_CANCEL.'+'.$VADS_ERREUR.'+'.$VADS_REFUSE.'+'.VADS_EFFECTUE.*/'+'.$VADS_VERSION.'+'.$VADS_CERTIFICAT);?>">
</form>
  
  <?php /*?><input name="PBX_TXT" type="hidden" value="<p align='center'><font face=arial color=#4E231E>Bonjour,<br>&nbsp;<br>Vous allez &ecirc;tre redirig&eacute; vers le syst&egrave;me de paiement s&eacute;curis&eacute; .</font></p><p align='center'><img src='http://www.boutique-ethiquable.com/images/patienter.gif' alt='patienter'></p>">
  <input type="hidden" name="PBX_BOUTPI" value="nul"><?php */?>
<?php

//include_once(rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/Library/suivi_analytics.php');
?>
</body>
</html>