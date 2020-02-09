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
 <h3>Demande de r&eacute;approvisionnement compte Fraish</h3>
 <p>Vous avez effectu&eacute; une demande de r&eacute;approvisionnement de votre compte Fraish.<br/>
 <?php echo $appro->getDescriptif();?>.</p><?php
 /*if()
 	{?>
    <p></p><?php
	}*/?>
 
 <p>&nbsp;</p>
 <p>Pour qu'elle soit prise en compte, veuillez vous pr&eacute;senter au kiosque Fraish muni de votre paiement<br/>
<p><a style="color: #ea2673; font-weight: bold; font-size: 14px;" href="/"> FRAISH.fr</a></p>
<div id="basPage"></div>
 </div>
</div>
</body>
</html>