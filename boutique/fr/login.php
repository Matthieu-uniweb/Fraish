<?
session_start();

//session_destroy();
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/classes.inc.php';
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/includes/classes/paquetage.inc.php';
$client = new Tbq_client($_SESSION['ID_client']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Fraish authentification</title>
<meta name="description" content="La boutique Fraish" />
<meta name="keywords" content="boutique Fraish" />

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

<script type="text/javascript">
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
//-->
</script>
</head>
<body>
<div id="page">
<div id="enTete">&nbsp;
</div>
<div id="contenu">
<h1>Authentification</h1>
<p>Connectez vous à votre compte client pour pouvoir r&eacute;server votre menu et g&eacute;rer vos informations.</p>
<?php
if ($_GET['inscription']=='ok')
	{ ?>
<fieldset>
<h3>Votre compte vient d'être crée, vous pouvez maintenant vous connecter à l'aide du formulaire ci-dessous.</h3>
</fieldset>
<br />
<? } // FIN if ($_GET['inscription']=='ok') ?>
<form name="formulaireCompteClient" id="formulaireCompteClient" action="espace-client/scripts/verif-codes.php" method="post" onsubmit="return lsjs_verifierFormulaire(this);">
<fieldset>
<h3>&gt;&gt; Vous avez déjà un compte </h3>
       <p><strong>Identifiez-vous:</strong></p>
       <?
if ($_GET['erreur']=='1')
	{ ?>

          <p>L'identification à votre compte client a échoué. <br />
            Veuillez ressaisir votre email et votre mot de passe.</p>
       <? } // FIN if ($message) ?>
        <p><label for="email" title="Votre adresse email" class="obligatoire">Votre adresse email* :</label><input name="email" type="text" id="email" class="input300" value="<?php 
		if($_COOKIE['fraish_id'])
			{
			echo $_COOKIE['fraish_id'];
			}
		else
			{
			echo $client->emailFacturation;
			}?>" size="30" /></p>
        <p><label for="motDePasse" title="Votre mot de passe" class="obligatoire">Votre mot de passe* :</label><input name="motDePasse" type="password" id="motDePasse" class="input300" value="<?php echo $_COOKIE['fraish_mdp'];?>" size="30" /></p>
        <p><label for="retenirMdp">Retenir le mot de passe : </label>
        <input type="checkbox" name="retenirMdp" value="1" <?php
		if($_COOKIE['fraish_rmbmdp']==1)
			{
			echo 'checked="checked"';
			}?>/>&nbsp;</p>
        <p>Si vous avez oubli&eacute; votre mot de passe, <a href="javascript:demanderCodes('fr');" title="Demander vos codes de la boutique">cliquez ici</a>.</p>
        <p><input type="submit" name="acces" id="acces" value="Acc&eacute;der &agrave; mon compte" class="bouton" /></p>
        </fieldset>
        <input name="obligatoire" type="hidden" id="obligatoire" value="email-votre adresse email|motDePasse-votre mot de passe" />
        </form>
        <form action="/boutique/fr/creation-compte-etape1.php">
        <fieldset>
        <h3>&gt;&gt; Vous &ecirc;tes un nouveau client ?</h3>
        <p>Cr&eacute;ez votre compte sur Fraish.fr pour commander et acc&eacute;der &agrave; nos services. Fraish s'engage &agrave; s&eacute;curiser vos informations et les garder strictement confidentielles. </p>  
        <p><strong>Le compte Fraish vous permet :</strong></p>
        <ul>
        	<li>de r&eacute;server votre menu</li>
        	<li>de payer en ligne et donc de gagner du temps</li>
            <li>de gérer vos informations client</li>
            <li>d'imprimer vos factures</li>
            <li>de passer en VIP</li>
        </ul>    
      <p><input type="submit" name="Cr&eacute;er mon compte" id="CreerMonCompte" value="Cr&eacute;er mon compte" class="bouton" /></p>
      </fieldset>
      <p>&nbsp;</p>
      </form>
      </div>
      </div>
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-1956792-20";
urchinTracker();
</script>
</body>
</html>