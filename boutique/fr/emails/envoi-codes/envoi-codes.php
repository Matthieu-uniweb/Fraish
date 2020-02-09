<?
session_start();
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/classes.inc.php';
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/includes/classes/paquetage.inc.php';
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FRAISH jus & smoothies - Compte client</title>
<style type="text/css">
<!--
#page {
	position:relative;
	border:#BE0C30 solid 6px;
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
	border-top:#ad9961 solid 1px;
	border-bottom:#ad9961 solid 1px;
	padding:5px 25px 5px 25px;
	background-color:#BE0C30;
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
	background-color:#c5d14a;
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
 <img src="../../../../images/fraish_sans_flash-1.gif" alt="kiosque Fraish" width="546" height="200">
  <h1>Vos codes d'accEs A la boutique FRAISH</h1>
  <p>Suite &agrave; votre demande, vous trouverez ci-dessous les codes d'acc&egrave;s demand&eacute;s :</p>
  <p><strong>Identifiant: <? echo $_POST['login'];?></strong><br>
  <strong>Mot de passe: <? echo $_POST['motDePasse'];?></strong></p>
  <p><a href="http://www.fraish.fr">&gt; Retourner sur le site Fraish</a></p>
  <div id="basPage"></div>
 </div>
</div>
</body>
</html>
