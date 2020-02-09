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
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />
<link rel="icon" type="image/x-icon" href="/favicon.ico" />
<style type="text/css">
<!--
* {
	margin: 0;
	padding: 0;
	border: 0;
	font-family: Arial, sans-serif;
	font-weight: normal;
	font-style: normal;
	text-decoration: none;
	}
body {
	height: 100%; /* debug selection de texte */
	position:absolute;
	background-color: #BE0C30;
}
#enTete {
	width:600px;
	height: 200px;
	background-position:right;
	background-image: url(/images/fraish_sans_flash-1.gif);
	background-repeat: no-repeat;
	
}
#enTete h1 {
	color: #df204c;
	font-weight:bold;
	padding: 250px 0 0 20px;
	text-align:left;
}
#page {
	height:auto;
	width:600px;
	margin:0 0 10px 0;
	padding:0 0 10px 0;
	background-color:#FFFFFF;
}
#page a{
	padding: 0 0 0 10px;
	color:#000000;
	font-size:12px;
}
#contenu {
	padding: 0 20px 0 20px;
}
#contenu h3{
	font-weight:bold;
}
#contenu p{
	font-size:12px;
}
#contenu p a{
	color:#000000;
}
#contenu img {
	display:inline;
}
strong, b {
	font-weight:bold;
}
-->
</style>
</head>
<body>
<div id="page">
  <div id="enTete">
  <h1>R&eacute;sultats questionnaire</h1>
  </div>
  <div id="contenu">
<p><strong>Nom: </strong><? echo $questionnaire->nom.' '.$questionnaire->prenom; ?></p><br />
<p><strong>Email: </strong><? echo $questionnaire->email; ?></p><br />
<p><strong>Date: </strong><? echo $questionnaire->dateQuestionnaire; ?></p><br />
<p><strong>Point de vente: </strong><? echo $questionnaire->pointVente; ?></p><br />
<p><strong>Notes: </strong><br /><? echo $questionnaire->afficherNotes(); ?></p><br />
<p><strong>Commentaires: </strong><? echo nl2br($questionnaire->commentaire); ?></p>
	</div>
</div>
</body>
</html>
