<?
session_start();

if (! $_SESSION['ID_client'])
	{ header("Location: ../login.php"); }
	
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/classes.inc.php';
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/includes/classes/paquetage.inc.php';

$commande = new Tbq_commande();

if (isset($_POST['dateReservation']))
{	$dateReservation = $_POST['dateReservation'];
	$_SESSION['dateReservation'] = $_POST['dateReservation'];}
else
{	
	$dateReservation = $commande->determineDateJour(date('Y-m-d'));
}

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

<link rel="stylesheet" type="text/css" href="/includes/styles/calendrier.css">
<!-- On inclut la librairie openrico / prototype -->
<script src="/boutique/includes/plugins/rico/src/prototype.js" type="text/javascript"></script>
<script type="text/javascript" src="/includes/javascript/masques.js"></script>
<script src="/boutique/includes/plugins/tinymce/jscripts/tiny_mce/tiny_mce.js" type="text/javascript"></script>
<script src="/boutique/includes/javascript/bq_admin-boutique.js" type="text/javascript"></script>
<script src="/boutique/includes/javascript/reserver.js" type="text/javascript"></script>
<script type="text/javascript"><!--//
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

window.onload=function(){invisible(); actualiseJour(<?php echo $annee2; ?>,<?php echo $mois2 ?>,<?php echo $jour2;?>);}
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
  <form method="post" id="formulaireHeure" name="formulaireHeure" action="<?php
  if(!$_GET['ID_menuFavori'])
  	{?>
	reserver-formule.php<?php
	}
  else
  	{?>
    reserver-ingredients.php<?php
	}?>" onsubmit="return lsjs_controleDates('<?php echo date("r"); ?>',document.getElementById('ID_pointDeVente').value)">
  <h3 <? if (isset($_POST['dateReservation'])) { echo 'disabled="disabled" style="display:none"'; }?>>S&eacute;lectionnez ci-dessous<br />
  la date pour lequel vous<br />
  souhaitez commander votre menu.</h3>
    <div id="dateReserv">
      <p <? if (isset($_POST['dateReservation'])) { echo 'disabled="disabled" style="display:none"'; }?>><strong>S&eacute;lectionnez ci-dessous <br />
        la date de livraison de votre menu :</strong></p>
      <p>
        <input name="dateReservation" type="hidden" id="dateReservation" size="10" maxlength="10" value="<?php echo  $dateReservation;?>" />
        <br />
		<input type="hidden" readonly="readonly" value="" <? if (isset($_POST['dateReservation'])) { echo 'disabled="disabled" style="display:none"'; }?>/>
        <input type="hidden" name="ID_menuFavori" value="<?php echo $_GET['ID_menuFavori'];?>" />
		<input id="jourLettre" type="text" readonly="readonly" value="" <? if (isset($_POST['dateReservation'])) { echo 'disabled="disabled" style="display:none"'; }?>/>
		<select onchange="javascript:actualiseJour(<?php echo $annee2; ?>, document.getElementById('mois').value, value);" id="jour" name="jour" <? if (isset($_POST['dateReservation'])) { echo 'disabled="disabled" style="display:none"'; }?>>
          <option value="1">01</option>
          <option value="2">02</option>
          <option value="3">03</option>
          <option value="4">04</option>
          <option value="5">05</option>
          <option value="6">06</option>
          <option value="7">07</option>
          <option value="8">08</option>
          <option value="9">09</option>
          <option value="10">10</option>
          <option value="11">11</option>
          <option value="12">12</option>
          <option value="13">13</option>
          <option value="14">14</option>
          <option value="15">15</option>
          <option value="16">16</option>
          <option value="17">17</option>
          <option value="18">18</option>
          <option value="19">19</option>
          <option value="20">20</option>
          <option value="21">21</option>
          <option value="22">22</option>
          <option value="23">23</option>
          <option value="24">24</option>
          <option value="25">25</option>
          <option value="26">26</option>
          <option value="27">27</option>
          <option value="28">28</option>
          <option value="29">29</option>
          <option value="30">30</option>
          <option value="31">31</option>
        </select>
		<select onchange="javascript:envoiMoisSelect(value);" id="mois" name="mois" <? /*if (isset($_POST['dateReservation'])) { echo 'disabled="disabled" style="display:none"'; }*/?>>
          <option value="01">Janvier</option>
          <option value="02">Février</option>
          <option value="03">Mars</option>
          <option value="04">Avril</option>
          <option value="05">Mai</option>
          <option value="06">Juin</option>
          <option value="07">Juillet</option>
          <option value="08">Août</option>
          <option value="09">Septembre</option>
          <option value="10">Octobre</option>
          <option value="11">Novembre</option>
          <option value="12">Décembre</option>
        </select>
        <a href="javascript:afficheCalendrier()" <? if (isset($_POST['dateReservation'])) { echo 'disabled="disabled" style="display:none"'; }?>><img src="../../images/calendrier.gif" alt="calendrier" title="calendrier" /></a></p>
	  <script>tableau(<?php echo $mois2; ?>,<?php echo $annee2; ?>);</script>
      <div id="calendrier" class="conteneur calendrier" style="width:260px;background-color:#FFFFFF;">
      <table class="tab_calendrier" align="center">
             <tr><td class="titre_calendrier" colspan="7" width="100%"><a id="link_precedent" href="#"><img src="../../images/previous.png"></a> <a id="link_suivant" href="#"><img src="../../images/next.png"></a> <span id="titre"></span> </td></tr>
             <tr>
                 <td bgcolor="#C8E9A3" class="cell_calendrier" >
                 Lun.                 </td>
                 <td bgcolor="#C8E9A3" class="cell_calendrier" >
                 Mar.                 </td>
                 <td bgcolor="#C8E9A3" class="cell_calendrier">
                 Mer.                 </td>
                 <td bgcolor="#C8E9A3" class="cell_calendrier">
                 Jeu.                 </td>
                 <td bgcolor="#C8E9A3" class="cell_calendrier" >
                 Ven.                 </td>
                 <td bgcolor="#75B378" class="cell_calendrier">
                 Sam.                 </td>
                 <td bgcolor="#75B378"  class="cell_calendrier">
                 Dim.                 </td>
             </tr>
             <?php
             $compteur_lignes=0;
             $total=1;
             while($compteur_lignes<6){
                echo '<tr>';
                $compteur_colonnes=0;
                while($compteur_colonnes<7){
                   echo '<td id="'.$total.'" class="cell_calendrier" >';
                   echo '</td>';
                   $compteur_colonnes++;
                   $total++;
                }
                echo '</tr>';
                $compteur_lignes++;
             }
             ?>
      </table>
      </div>	
    </div><br>
<div id="choixPointDeVente" <? if (isset($_POST['dateReservation'])) { echo 'disabled="disabled" style="display:none"'; }?>>
      <p><strong>Menu &agrave; retirer &agrave; : </strong></p>
      <p>
     
      <select name="ID_pointDeVente" id="ID_pointDeVente">
	  <option value="">S&eacute;lectionnez un point de vente</option><?php 
	  foreach ($pointsDeVente as $point) 
	  	{ ?>
      	<option value="<?php echo $point->ID;?>" <?php if ($favori->ID_pointDeVente==$point->ID) { echo 'selected="selected"'; } ?>><?php echo $point->pointDeVente;?></option><?php 
		} ?>
      </select>
      </p>      
    </div>
<p>
    	<input type="hidden" name="ID_menuFavori" value="<?php echo $_GET['ID_menuFavori']; ?>" />
      <input name="submit" type="submit" class="bouton" id="choisirSonMenu" value="Choisir son Menu" <? if (isset($_POST['dateReservation'])) { echo 'disabled="disabled" style="display:none"'; }?> />
    </p>
  </form>
  <p>&nbsp;</p>
<?
if (isset($_POST['dateReservation']))
{ 
$pointDeVente = new Tbq_user($_POST['ID_pointDeVente']);
?>
  <form method="post" id="formulaireMenu" action="reserver-formule.php" onsubmit="return verifierMenu(this);">
    <h3>Votre date de livraison : <span class="Style1"> <?php echo $_POST['dateReservation']; ?> </span></h3>
    <p>
      <input name="dateRes" type="hidden" value="<? echo $_POST['dateReservation']; ?>" />
    </p>	
<h3>Votre point de vente : <span class="Style1"> <?php echo $pointDeVente->pointDeVente; ?> </span></h3>
    <p>
      <input name="ID_pointDeVente" type="hidden" value="<? echo $_POST['ID_pointDeVente']; ?>" />
    </p>
  </form>
</div>
<?
}?>
<script type="text/javascript">
lsjs_actualiseSelectDate('<? echo $dateReservation; ?>')
</script>
  <?
/*if (isset($_POST['dateReservation']) && $favori->ID)
{ 
?>
<script type="text/javascript">
<?php 
if ($favori->typePlat=='salades')
	{?>affichageMenuSalades();<?php } 
else if ($favori->typePlat=='soupes')
	{?>affichageMenuSoupes();<?php } 

if ($favori->typeBoisson=='JusDeFruits')
	{?>affichageJusDeFruits();<?php } 
else if ($favori->typeBoisson=='Smoothies')
	{?>affichageSmoothies();<?php } 
?>
</script>
<?php } // FIN if (isset($_POST['dateReservation'])) */?>
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-1956792-20";
urchinTracker();
</script>
</body>
</html>
