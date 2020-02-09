<?
header("Expires: 0"); 
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache");
header("Cache-Control: post-check=0,pre-check=0");
header("Cache-Control: max-age=0");
header("Pragma: no-cache");

ini_set('display_errors', 1);
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/classes.inc.php';
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/includes/classes/paquetage.inc.php';

T_LAETIS_site::initialiserSession();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Mon espace d'administration e-boutique</title>
<meta name="description" content="Espace d'administration de votre boutique" />
<meta name="keywords" content="espace, administration, boutique" />
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />
<link rel="icon" type="image/x-icon" href="/favicon.ico" />
<link href="/boutique/includes/styles/bq_admin-boutique.css" rel="stylesheet" type="text/css" />
<script src="/boutique/includes/javascript/bq_admin-boutique.js" type="text/javascript"></script>
<script src="/includes/javascript/formulaire.js" type="text/javascript"></script>
</head>
<body id="hautPage">
<div id="page">
  <div id="enTete"><a href="/boutique/admin/index.php" title="Retourner � l'accueil de l'espace d'administration">Accueil</a><img src="/boutique/images/bandeau-boutique.jpg" alt="" width="750" height="135" /></div>
  <!-- Colonne Boutique -->
  <div id="divAdmin">
    <!-- Menu Boutique -->
    <div id="menuAdmin">
      <ul>
        <li><a href="#">&gt; Connexion</a></li>
      </ul>
    </div>
    <!-- Fin Menu Boutique -->
  </div>
  <!-- Fin Colonne Boutique -->
  <div id="contenu">
    <form name="formulaire" method="post" action="scripts/verifier-login.php" onsubmit="return lsjs_verifierFormulaire2(this);">
      <h1>Identifiez-vous</h1>
      <p>Veuillez entrer vos identifiants ci-dessous.</p>
      <?php
			if (isset($_GET['message'])	&&	$_GET['message']=='erreur')
				{ ?>
      <div class="alerte">
        <p>L'identification &agrave; votre compte client a &eacute;chou&eacute;. <br />
          Veuillez ressaisir votre login et votre mot de passe. </p>
      </div>
      <?php } ?>
      <br />
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="200">Login: </td>
          <td width="99%"><input type="text" name="login" value="" style="width:120px;" title="Veuillez saisir votre login" /></td>
        </tr>
        <tr>
          <td nowrap="nowrap">Mot de passe:</td>
          <td width="99%"><input type="password" name="motDePasse" value="" style="width:120px;" title="Veuillez saisir votre mot de passe" /></td>
        </tr>
      </table>
      <input name="obligatoire" type="hidden" id="obligatoire" value="login-Votre login|motDePasse-Votre mot de passe" />
      <input type="submit" name="ok" value="Entrer" />
    </form>
  </div>
  <div class="ajusteur"></div>
</div>
</body>
</html>
