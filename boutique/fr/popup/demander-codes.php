<?
session_start();
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/classes.inc.php';
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/includes/classes/paquetage.inc.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>La boutique Fraish - Vos codes d'acc&egrave;s</title>
<meta name="Description" content="La boutique Klaus - Vos codes d'acc&egrave;s" />
<meta name="Keywords" content="boutique, Klaus, codes, acc&egrave;s" />

<link href="/includes/styles/globals.css" rel="stylesheet" type="text/css">
<link href="/includes/styles/popups.css" rel="stylesheet" type="text/css">

<link href="/includes/styles/form.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="/includes/javascript/fonctions_formulaires.js"></script>
</head>
<body onLoad="window.self.focus();">
<a name="haut"></a>
<div id="pagePopup">
 <h1>Vos codes d'acc&egrave;s</h1>
 <div id="contenu">
   <div class="article">
     <h2>Communication  de vos codes clients</h2>
     <p> Pour obtenir vos codes d'acc&egrave;s, inscrivez votre adresse &eacute;lectronique
      ci-dessous. </p>
     <p>Vos codes d'acc&egrave;s y seront envoy&eacute;s instantan&eacute;ment:</p>
     <p>&nbsp;</p>
     <form method="post" name="formulaire" action="../scripts/demander-codes.php" onsubmit="return verifierFormulaire(this);">
       <p>Votre e-mail :
         <input name="email" type="text" id="email" size="25">
         <input name="obligatoire" type="hidden" id="obligatoire" value="email-votre adresse email" />
         <input name="envoyer" id="envoyer" type="submit" value="Envoyer">
        </p>
     </form>
     <p>&nbsp;</p>
     <p>&nbsp;</p>
   </div>
 </div>
</div>
</body>
</html>