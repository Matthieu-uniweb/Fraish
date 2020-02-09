<?
session_start();
header('Location:/boutique/fr/espace-client/espace-client.php');
require_once 'DB.php';
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/includes/classes/paquetage.inc.php';
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/classes.inc.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Fraish</title>
<meta name="description" content="Fraish" />
<meta name="keywords" content="Fraish" />
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
  <div id="enTete">&nbsp;
  </div>
  <div id="contenu">
   <h1>Votre espace client</h1>
    <p><strong>Votre espace client vous permet de :</strong></p>
    <p> - suivre l'&eacute;volution de vos r&eacute;servations,<br />
      - visionner vos anciennes r&eacute;servations.<strong></strong></p>
    <p>&nbsp;</p>
    <h3>&gt;&gt; Votre compte client</h3>
    <p><strong>Vous avez un compte client FRAISH ? Identifiez-vous </strong></p>
    <form name="formClient" id="formClient" action="scripts/verif-codes.php" method="post" onsubmit="return lsjs_verifierFormulaire(this);">
      <fieldset>
      <?
		  session_destroy();
if ($_GET["message"]=="erreur")
	{ ?>
      <p>L'identification &agrave; votre compte client a &eacute;chou&eacute;. <br />
        Veuillez ressaisir votre email et votre mot de passe.</p>
      <? } // FIN if ($message) ?>
      <p>
        <label for="email" title="Votre adresse email">Votre adresse email* :</label>
        <input name="email" type="text" id="email" class="input300" size="30" value="<? echo $_COOKIE['fraish_id'];//$_GET['login']; ?>" />
      </p>
      <p>
        <label for="email" title="Votre adresse email">Votre mot de passe* :</label>
        <input name="motDePasse" type="password" id="motDePasse" class="input300" size="30" value="<? echo $_COOKIE['fraish_mdp']//$_GET['passe']; ?>" />
      </p>
      <p>Si vous avez oubli&eacute; votre mot de passe, <a href="javascript:demanderCodes('fr');">cliquez ici</a>.</p>
      <p>
        <input type="submit" name="acces" id="acces" value="Acc&eacute;der &agrave; l'espace client" class="bouton" />
      </p>
      </fieldset>
      <input name="obligatoire" type="hidden" id="obligatoire" value="email-Votre adresse email|motDePasse-Votre mot de passe" />
    </form>
    <p>&nbsp;</p>
    <h3>&gt;&gt; Pas encore inscrit ?</h3>
    <form action="/boutique/fr/creation-compte-etape1.php">
      <fieldset>
      <p>
        <input type="submit" name="inscription" id="inscription" value="inscription" class="bouton" />
      </p>
      </fieldset>
    </form>
    <p>&nbsp;</p>
  </div>
</div>
</body>
</html>
