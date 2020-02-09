<?php
session_start();
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/classes.inc.php';
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/includes/classes/paquetage.inc.php';
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FRAISH - Compte client</title>
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
<body>
<div id="page">
 <div id="contenu">
 <img src="https://www.fraish.fr/styles/frontend/img/fraish_04.png" alt="Fraish" width="292" height="174" style="margin-left: 125px;"/>
  <h1>Vos codes d'acces A la boutique FRAISH</h1>
  <p>Suite &agrave; votre demande, vous trouverez ci-dessous vos codes d'acc&egrave;s :</p>
  <p><strong>Identifiant: <? echo $_POST['login'];?></strong><br>
  <strong>Mot de passe: <? echo $_POST['motDePasse'];?></strong></p>
  <p><a style="color: #ea2673; font-weight: bold; font-size: 14px;" href="/"> FRAISH.fr</a></p>
  <div id="basPage"></div>
 </div>
</div>
</body>
</html>
