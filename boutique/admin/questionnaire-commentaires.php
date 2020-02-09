<?
header("Expires: 0"); 
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache");
header("Cache-Control: post-check=0,pre-check=0");
header("Cache-Control: max-age=0");
header("Pragma: no-cache");

include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/classes.inc.php';
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/includes/classes/paquetage.inc.php';

$questionnaire = new Tbq_questionnaire($_GET['ID_questionnaire']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Commentaires</title>
<meta name="description" content="La boutique Fraish" />
<meta name="keywords" content="boutique Fraish" />
<link rel="stylesheet" type="text/css" href="/includes/styles/global.css" />
<link rel="stylesheet" type="text/css" href="/includes/styles/admin.css" />
<link rel="stylesheet" type="text/css" href="/includes/styles/resultat.css" />
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
  <h1>Résultats questionnaire</h1>
<p><strong>Nom: </strong><? echo $questionnaire->nom.' '.$questionnaire->prenom; ?></p><br />
<p><strong>Email: </strong><? echo $questionnaire->email; ?></p><br />
<p><strong>Date: </strong><? echo T_LAETIS_site::dateFormatFrancais($questionnaire->dateQuestionnaire); ?></p><br />
<p><strong>Point de vente: </strong><? echo $questionnaire->pointVente; ?></p><br />
<p><strong>Notes: </strong><br /><? echo $questionnaire->afficherNotes(); ?></p><br />
<p><strong>Commentaires: </strong><? echo nl2br($questionnaire->commentaire); ?></p>
	</div>
</div>
</body>
</html>
