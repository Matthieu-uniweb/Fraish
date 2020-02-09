<?
session_start();

if (! $_SESSION['ID_client'])
	{ header("Location: ../login.php"); }
	
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/classes.inc.php';
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/includes/classes/paquetage.inc.php';

$commande = new Tbq_commande();

if (isset($_POST['dateReservation']))
	{
	$_SESSION['dateReservation'] = $_POST['dateReservation'];
	$dateReservation = $_POST['dateReservation'];
	}
else
{	
	$dateReservation = $commande->determineDateJour(date('Y-m-d'));
}
$_SESSION['ID_pointDeVente'] = $_POST['ID_pointDeVente'];
$favori = new Tbq_client_favori($_REQUEST['ID_menuFavori']);
$plat = explode(', ', $favori->plat);

			$mois2 = date('m');
			$jour2 = date('d');
			$annee2 = date('Y');


$pointDeVente = new Tbq_user();
$pointsDeVente = $pointDeVente->lister();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!--<META HTTP-EQUIV="Pragma" CONTENT="no-cache" />
<META HTTP-EQUIV="Expires" CONTENT="-1" />-->
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Fraish r&eacute;servation</title>
<link rel="stylesheet" type="text/css" href="/includes/styles/admin.css" />
<link rel="stylesheet" type="text/css" href="/includes/styles/formulaire.css" />
<link rel="stylesheet" type="text/css" href="/includes/styles/global.css" />
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />
<link rel="icon" type="image/x-icon" href="/favicon.ico" />

<link rel="stylesheet" type="text/css" href="../../includes/styles/calendrier.css">
<!-- On inclut la librairie openrico / prototype -->
<script src="../../includes/plugins/rico/src/prototype.js" type="text/javascript"></script>
<script type="text/javascript" src="/includes/javascript/masques.js"></script>
<script src="../../includes/plugins/tinymce/jscripts/tiny_mce/tiny_mce.js" type="text/javascript"></script>
<script src="/boutique/includes/javascript/bq_admin-boutique.js" type="text/javascript"></script>
<script src="../../includes/javascript/reserver.js" type="text/javascript"></script>
<script type="text/javascript"><!--

	var FRENCH_DAYS = new Array("Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi");
	dateA=new Date()
	an=dateA.getFullYear();
	moisActuel='<?php $moisAC=date("m"); echo $moisAC;?>'+"-"+an;
	compt=0;
	
function invisible() {
	document.getElementById("calendrier").style.display= 'none';
	}
	
function afficheCalendrier() {
	if(document.getElementById("calendrier").style.display=='none'){
	document.getElementById("calendrier").style.display= 'block';
	} else {
	document.getElementById("calendrier").style.display= 'none';
	}
	}
	
var num_jour_global;
function  numJourGlobal(num_jour) {
	num_jour_global=num_jour;
	}

function envoiMoisSelect(MoisSelectionner){
	//var moisSelect = MoisSelectionner;
	//eval(data.lien_choisi); 
	tableau(MoisSelectionner,<?php echo $annee2; //date("Y");?>);
	//document.getElementById('mois').value = data.moisChoisi;
	actualiseJour(<?php echo $annee2; ?>, MoisSelectionner, 1);
	
}

function actualiseJour(year,numericMonth,selectedDay) {
	document.getElementById('jour').value=selectedDay;
	//alert(year+"-"+numericMonth+"-"+selectedDay);
	var myDate = new Date(Date.UTC(year,numericMonth-1,selectedDay,0,0,0));
	//alert(myDate.getDay());
	document.getElementById('jourLettre').value = FRENCH_DAYS[myDate.getDay()];
}
	
function actualiseMois(date_en_cours,num_jour) {
	if(date_en_cours==moisActuel){
	document.getElementById('link_precedent').style.display = 'none';
	}else{
	document.getElementById('link_precedent').style.display = 'block';
	}
	var num_jour1=num_jour;
	var num_jour2=num_jour;
	var compteur=1;
	   var jourActuel='<?php $jourA=date("d"); echo $jourA;?>';
	   var jourApresMidi='<?php echo $jour2;?>';
	   //jourActuel=jourActuel.substring(1, 2) + jourActuel.substring(2 + 1, jourActuel.length);

	   var num_jour_actuel=Number (jourActuel) + Number (num_jour1) -1;
	   var num_jour_ap_midi=Number (jourApresMidi) + Number (num_jour2) -1;
	   /*alert (jourApresMidi);
	  alert (num_jour);
	   alert (num_jour_ap_midi);*/
	  /* for(i=1; i<42; i++){
				if(i==6 || i==7 || i==13 || i==14 || i==20 || i==21 || i==27 || i==28 || i==34 || i==35){
		  			document.getElementById(i).style.backgroundColor="#CCCCCC";
		 		}
		 }*/
      while(compteur<43){
	  	if(num_jour_actuel>compteur && date_en_cours==moisActuel){
			document.getElementById(compteur).style.backgroundColor="#CCCCCC";
			//document.getElementById(compteur).style.backgroundImage="url(../../images/raye.jpg)";
		 } else if(num_jour_actuel==compteur && date_en_cours==moisActuel){
			  document.getElementById(compteur).style.backgroundColor="#FF0000";
		 } else {
		  	document.getElementById(compteur).style.backgroundColor="#FFFFFF";
			//document.getElementById(compteur).style.backgroundImage="none";
		 }
          compteur++;
       }
	}
	
	function remplirCalendrier(reponsejson) {
       //on utilise la fonction evalJSON de prototype pour parser la réponse JSON
        var data=reponsejson.responseText.evalJSON();
       //On place les liens suivants,précédents et le mois en cours
       $('link_suivant').onclick=function(){eval(data.lien_suivant); document.getElementById('mois').value = data.moisSuiv; envoiMoisSelect(document.getElementById('mois').value);};
       $('link_precedent').onclick=function(){eval(data.lien_precedent); document.getElementById('mois').value = data.moisPrec; envoiMoisSelect(document.getElementById('mois').value);};
	   actualiseMois(data.moisEnCoursNum,data.num_jour);
	   numJourGlobal(data.num_jour);
	   //alert (data.moisSelection);
       $('titre').innerHTML=data.mois_en_cours;
       //Maintenant, on affiche tous les jours du calendrier
       var compteur=1;
       var id='';
       while(compteur<43){
          id=compteur.toString();
          $(id).innerHTML=data.calendrier[(compteur-1)].fill;
		  
          compteur++;
       }

}
	
function tableau(mois,annee)
{
   var url = '../../includes/ajax/ajax_calendrier.php';
   var parametres = 'mois=' + mois + '&annee=' + annee;

		var myAjax = new Ajax.Request(
			url,
			{
				method: 'post',
				parameters: parametres,
				onComplete: remplirCalendrier
			}
		);
}

/*function addLoadEvent(func) {
  var oldonload = window.onload;
  if (typeof window.onload != 'function') {
    window.onload = func;
  } else {
    window.onload = function() {
      if (oldonload) {
        oldonload();
      }
      func();
    }
  }
}

//addLoadEvent(nameOfSomeFunctionToRunOnPageLoad);
addLoadEvent(function() {
  invisible();
});
addLoadEvent(function() {
  actualiseJour(<?php// echo $jour2;?>);
});*/
//window.onload=function(){invisible(); actualiseJour(<?php echo $annee2; ?>,<?php echo $mois2 ?>,<?php echo $jour2;?>);}
--></script>
<style type="text/css">
<!--
.Style1 {
	color: #990000
}
-->
</style>
</head>
<body>
<div id="page">
<a href="espace-client.php">&lt; Retour</a>
<div id="enTete">&nbsp;
</div>
<div id="contenu">
<h1>Votre espace client</h1>  
<h2>Choisissez votre formule favorite</h2>
<?php 
$_SESSION['favori'] = true;
$favori = Tbq_client_favori::getMenuFavori($_SESSION['ID_client']);
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/Library/detail-menus.php';?>
</div>

<script type="text/javascript">
//lsjs_actualiseSelectDate('<? echo $dateReservation; ?>')
</script>
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-1956792-20";
urchinTracker();
</script>
</div>
</body>
</html>
