<?
// Récupération du nom de domaine
$domaine= 'http://'.$_SERVER['SERVER_NAME'].'/';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Erreur 404 - Document non trouv&eacute;</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
body,td,th {
	font-family: Helvetica, Arial, sans-serif;
	font-size: 16px;
	color: #CC3300;
}
body {
	background-color: #FFFFFF;
	margin-left: 10px;
	margin-top: 10px;
	margin-right: 10px;
	margin-bottom: 10px;
}
.Style1 {color: #CC0000; font-weight:bold;}
-->
</style>
</head>
<body>
<h1>&nbsp;</h1>
<h1>Ce document est inaccessible </h1>
<p>Le document que vous souhaitez consulter est en cours de modification.<br />
Pour acc&eacute;der &agrave; la page d'accueil du site internet, cliquez ici : <a href="<? echo $domaine; ?>" class="Style1"><? echo $domaine; ?></a></p>
</body>
</html>