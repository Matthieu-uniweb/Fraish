<?php
session_start();
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/classes.inc.php';
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/includes/classes/paquetage.inc.php';
$appro = new Tbq_approvisionnement($_GET['ID_appro']);
$client = new Tbq_client($appro->ID_client);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>La boutique Fraish</title>
<style type="text/css">
<!--
#page {
	position:relative;
	border:#7aba4d solid 6px;
	width:546px;
}
#contenu {
	width:546px;
}
a {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #000000;
	text-decoration:underline;
}
#contenu h1 {
	color:#ffffff;
	font-size:20px;
	text-transform:uppercase;	
	padding:5px 25px 5px 35px;
	background-color:#7aba4d;
	margin:0;
}
#contenu p {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #320103;
	padding:10px;
	margin:0;
}
#basPage {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #AD9961;
	padding:5px;
	background-color:#939598;
}
#basPage a {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #AD9961;
	text-decoration:underline;
}
#basPage a:hover {
	text-decoration:none;
}
-->
</style>
</head>

<div id="page">
<div id="contenu">
<img src="https://www.fraish.fr/styles/frontend/img/fraish_04.png" alt="Fraish" width="292" height="174" style="margin-left: 125px;"/>
<h3>Validation de votre approvisionnement compte Fraish</h3>

<p>Votre demande d'approvisionnement n&deg; <?php echo $appro->ID;?> a &eacute;t&eacute; valid&eacute;e.<br/>
<?php echo $appro->getDescriptif();?>.</p>
<p>Votre solde compte Fraish est d&eacute;sormais de <?php echo $client->soldeCompte;?> &euro;.</p>
<p><a style="color: #ea2673; font-weight: bold; font-size: 14px;" href="/"> FRAISH.fr</a></p>
<div id="basPage"></div>
</div>
</div>
</body>
</html>

