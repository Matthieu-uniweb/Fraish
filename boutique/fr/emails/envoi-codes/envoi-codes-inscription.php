<?php
session_start();
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/classes.inc.php';
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/includes/classes/paquetage.inc.php';
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FRAISH jus &amp; smoothies - Compte client</title>
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
	padding:5px 25px 5px 145px;
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
  <h1>Bienvenue sur FRAISH</h1>
  <p>Veullez trouver ci-dessous les codes d'acc&egrave;s de votre compte :</p>
  <p><strong>Identifiant: <?php echo $_POST['login'];?></strong><br>
  <strong>Mot de passe: <?php echo $_POST['motDePasse'];?></strong></p>
  <p><strong>Votre nom : <?php echo $_POST['nom'];?><br>
  Votre pr&eacute;nom : <?php echo $_POST['prenom'];?><br>
    Votre date de naissance :  <?php echo $_POST['dateNaissance'];?><br>
    Votre t&eacute;l&eacute;phone : <?php echo $_POST['telephone'];?><br>   
    Adresse : <?php echo $_POST['adresse'];?><br>    
    Code Postal : <?php echo $_POST['codePostal'];?><br>
    Ville : <?php echo $_POST['ville'];?><br>
    </strong></p>
    
    <?php 
	/*
	<p><strong style="color: #ea2673">Offre de bienvenue : sur votre premi&egrave;re commande, entrez le code promotion "DESSERTCADO" pour profiter d'un dessert offert ! (offre valable uniquement avec les formules duo et trio)</strong></p>
	*/
    ?>
    
 <p><a style="color: #ea2673; font-weight: bold; font-size: 14px;" href="/"> FRAISH.fr</a></p>
  <div id="basPage"></div>
 </div>
</div>
</body>
</html>
