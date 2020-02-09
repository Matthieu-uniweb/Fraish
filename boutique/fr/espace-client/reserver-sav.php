<?
session_start();

if (! $_SESSION['ID_client'])
	{ header("Location: ../login.php"); }
	
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/classes.inc.php';
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/includes/classes/paquetage.inc.php';

$commande = new Tbq_commande();

if (isset($_POST['dateReservation']))
{	$dateReservation = $_POST['dateReservation'];}
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
  <form method="post" id="formulaireHeure" name="formulaireHeure" action="reserver.php" onsubmit="return lsjs_controleDates('<?php echo date("r"); ?>',document.getElementById('ID_pointDeVente').value)">
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
		<select onchange="javascript:envoiMoisSelect(value);" id="mois" name="mois" <? if (isset($_POST['dateReservation'])) { echo 'disabled="disabled" style="display:none"'; }?>>
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
      <p><strong>Menu à retirer à : </strong></p>
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
<?
if (isset($_POST['dateReservation']))
{ 
$pointDeVente = new Tbq_user($_POST['ID_pointDeVente']);
?>
  <form method="post" id="formulaireMenu" action="../scripts/valider-reservation.php" onsubmit="return verifierMenu(this);">
    <h3>Votre date de livraison : <span class="Style1"> <?php echo $_POST['dateReservation']; ?> </span></h3>
    <p>
      <input name="dateRes" type="hidden" value="<? echo $_POST['dateReservation']; ?>" />
    </p>	
<h3>Votre point de vente : <span class="Style1"> <?php echo $pointDeVente->pointDeVente; ?> </span></h3>
    <p>
      <input name="ID_pointDeVente" type="hidden" value="<? echo $_POST['ID_pointDeVente']; ?>" />
    </p>	
    <h3>Choisissez votre Menu :</h3>
    <div id="choixMenu">
      <p>
        <label for="salades">Salades</label>
        <input type="radio" name="radioMenu" id="salades" value="salades" onClick="affichageMenuSalades();" <?php if ($favori->typePlat=='salades') { echo 'checked="checked"'; } ?> />
      </p>
    </div>
    <div id="choixMenuS">
      <p>
        <label for="soupes">Soupes</label>
        <input type="radio" name="radioMenu" id="soupes" value="soupes" onClick="affichageMenuSoupes();" <?php if ($favori->typePlat=='soupes') { echo 'checked="checked"'; } ?> />
      </p>
    </div>
    <div class="ajusteur">&nbsp;</div>
    <div id="tableauSalades" style="visibility:hidden">
      <p class="ssTitre">Les ingrédients toujours disponibles<br />
        <br />
      </p>
      <?php 
			$commande = new Tbq_commande();
			$ingredients = $commande->ingredients;
			$cpt = 0; 
			?><div id="un"><?php 
			for($i=0; $i < 8; $i++)
				{	?><p><?php echo $ingredients[$i];?></p><?php } ?></div>
      <div id="deux">
      <?php 
			for($i=0; $i < 8; $i++)
				{	
				?><p><input type="checkbox" <?php if (in_array($ingredients[$i], $plat)) { echo 'checked="checked"'; } ?> name="<?php echo $cpt; ?>saladeIngredients" id="<?php echo $ingredients[$i];?>" value="<?php echo $ingredients[$i];?>" /></p><?php 
				$cpt++;
				} ?>
      </div>
      <div id="trois"><?php 
			for($i=8; $i < 16; $i++)
				{	?><p><?php echo $ingredients[$i];?></p><?php } ?></div>
      <div id="quatre">
        <?php 
			for($i=8; $i < 16; $i++)
				{	?><p>
          <input type="checkbox" <?php if (in_array($ingredients[$i], $plat)) { echo 'checked="checked"'; } ?> name="<?php echo $cpt; ?>saladeIngredients" id="<?php echo $ingredients[$i];?>" value="<?php echo $ingredients[$i];?>" />
        </p><?php 
				$cpt++;
				} ?>
      </div>
    </div>
    <div id="tableauSalades2" style="visibility:hidden">
    <p class="ssTitre">Les ingrédients pas toujours disponibles</p>
    <p class="legende">Cochez les ingr&eacute;dients que vous souhaiteriez dans votre salade.
    Veuillez nous excuser par avance si l&rsquo;ingr&eacute;dient de votre choix n&rsquo;est pas   pr&eacute;sent le jour de votre r&eacute;servation.</p>
    <br />
      <p class="ssTitre">Légumes</p>
      <div id="cinq"><p>
      <?php 
			for($i=16; $i < 21; $i++)
				{	?><span><?php echo $ingredients[$i];?> 
        <input type="checkbox" <?php if (in_array($ingredients[$i], $plat)) { echo 'checked="checked"'; } ?> name="<?php echo $cpt; ?>saladeIngredients" id="<?php echo $ingredients[$i];?>" value="<?php echo $ingredients[$i];?>" /></span><?php 
				$cpt++;
				} ?></p>       
      </div>
      <div class="ajusteur">&nbsp;</div>
      <p class="ssTitre">Féculents</p>
      <div id="six">
        <p><?php 
			for($i=21; $i < 26; $i++)
				{	?><span><?php echo $ingredients[$i];?> 
        <input type="checkbox" <?php if (in_array($ingredients[$i], $plat)) { echo 'checked="checked"'; } ?> name="<?php echo $cpt; ?>saladeIngredients" id="<?php echo $ingredients[$i];?>" value="<?php echo $ingredients[$i];?>" /></span><?php 
				$cpt++;
				} ?></p>
      </div>
      <div class="ajusteur">&nbsp;</div>
      <p class="ssTitre">Graines</p>
      <div id="sept">
        <p><?php 
			for($i=26; $i < 31; $i++)
				{	?><span><?php echo $ingredients[$i];?> 
        <input type="checkbox" <?php if (in_array($ingredients[$i], $plat)) { echo 'checked="checked"'; } ?> name="<?php echo $cpt; ?>saladeIngredients" id="<?php echo $ingredients[$i];?>" value="<?php echo $ingredients[$i];?>" /></span><?php 
				$cpt++;
				} ?></p>
      </div>
    </div>
    <div id="tableauSalades3" style="visibility:hidden">
      <p class="ssTitre">Vinaigrette</p>
      <div id="huit">
        <p>
          <label class="smooth" for="Méditerranéenne : Huile d'olive - Vinaigre Balsamique - Moutarde - Sel - Poivre -"><b>Méditerranéenne</b> <em>- Huile d'olive - Vinaigre Balsamique - Moutarde - Sel - Poivre -</em></label>
          <input type="radio" name="radioVinaigrette" id="Méditerranéenne" value="Méditerranéenne" <?php if ( ($favori->vinaigrette=='Méditerranéenne') || (! $favori->vinaigrette) ) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <label class="smooth" for="Bulgare : Citron - Yaourt - Sel – Poivre (sans huile) -"><b>Bulgare</b> <em>- Citron - Yaourt - Sel – Poivre (sans huile) -</em></label>
          <input type="radio" name="radioVinaigrette" id="Bulgare" value="Bulgare" <?php if ($favori->vinaigrette=='Bulgare') { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <label class="smooth" for="Indienne : Curry – Citron – Yaourt – Sel – Poivre (sans huile) -"><b>Indienne</b> <em>- Curry – Citron – Yaourt – Sel – Poivre (sans huile) -</em></label>
          <input type="radio" name="radioVinaigrette" id="Indienne" value="Indienne" <?php if ($favori->vinaigrette=='Indienne') { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <label class="smooth" for="Provençale : Huile d'Olive - Vinaigre de Vin - Herbe de Provence – Sel - Poivre -"><b>Provençale</b> <em>- Huile d'Olive - Vinaigre de Vin - Herbe de Provence – Sel - Poivre -</em></label>
          <input type="radio" name="radioVinaigrette" id="Provençale" value="Provençale" <?php if ($favori->vinaigrette=='Provençale') { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <label class="smooth" for="Sans vinaigrette"><b>Sans vinaigrette</b></label>
          <input type="radio" name="radioVinaigrette" id="Sans vinaigrette" value="Sans vinaigrette" <?php if ($favori->vinaigrette=='Sans vinaigrette') { echo 'checked="checked"'; } ?> />
        </p>
      </div>
    </div>
    <? $cpt2 = 0; ?>
    <div id="tableauSoupes" style="visibility:hidden">
      <center>
        <h3>*Faites Maison</h3>
      </center>
      <p>Faites le plein de fibres et de vitamines !</p>
<?php
$menuJour=new Tbq_menujour();
$soupeJour=$menuJour->getMenuJour($_POST['dateReservation'],$_POST['ID_pointDeVente'],'soupe');
$soupeDiet=$menuJour->getMenuJour($_POST['dateReservation'],$_POST['ID_pointDeVente'],'soupeDiet');
$jusJour=$menuJour->getMenuJour($_POST['dateReservation'],$_POST['ID_pointDeVente'],'jus');
?>
      <p><label class="soupe" for="Soupe Daily : Recette du jour"><input type="radio" name="radioSoupe" id="Soupe Daily" value="Soupe Daily" <?php if ( (in_array('Soupe Daily', $plat)) || (! $favori->plat) ) { echo 'checked="checked"'; } ?> /> <b>Soupe Daily</b> <em> - Recette du jour -</em></label><?php if ($soupeJour) { echo "<br>".$soupeJour; } ?></p>
      <p><label class="soupe" for="Soupe Diet : Tout légumes sans crème (diététique) -"><input type="radio" name="radioSoupe" id="Soupe Diet" value="Soupe Diet" <?php if (in_array('Soupe Diet', $plat)) { echo 'checked="checked"'; } ?> /> <b>Soupe Diet</b> <em>- Tout légumes sans crème (diététique) -</em></label><?php if ($soupeDiet) { echo "<br>".$soupeDiet; } ?>        
      </p>
      <div class="ajusteur">&nbsp;</div>
      <p><span>
        <input type="checkbox" name="<? echo $cpt2; $cpt2++; ?>soupeIngredients" id="Avec croutons" value="Avec croutons" <?php if (in_array('Avec croutons', $plat)) { echo 'checked="checked"'; } ?> />
        Avec croutons</span></p>
      <p><span>
        <input type="checkbox" name="<? echo $cpt2; $cpt2++; ?>soupeIngredients" id="Avec Emmental" value="Avec Emmental" <?php if (in_array('Avec Emmental', $plat)) { echo 'checked="checked"'; } ?> />
        Avec Emmental</span></p>
      <p><span>
        <input type="checkbox" name="<? echo $cpt2; $cpt2++; ?>soupeIngredients" id="Avec Fourme d’Ambert" value="Avec Fourme d’Ambert" <?php if (in_array('Avec Fourme d’Ambert', $plat)) { echo 'checked="checked"'; } ?> />
        Avec Fourme d’Ambert</span></p>
    </div>
    <div class="ajusteur">&nbsp;</div>
    <div id="choixMenuSmoothie3" class="choixMenuSmoothie" style="visibility:hidden">
      <p>
        <label for="Jus de fruits">Jus de fruits</label>
        <input type="radio" name="radioBoisson" id="JusDeFruits" value="JusDeFruits" onClick="affichageJusDeFruits();" <?php if ($favori->typeBoisson=='JusDeFruits') { echo 'checked="checked"'; } ?> />
      </p>
    </div>    
    <div id="choixMenuSmoothie1" class="choixMenuSmoothie" style="visibility:hidden">
      <p>
        <label for="Smoothies">Smoothies</label>
        <input type="radio" name="radioBoisson" id="Smoothies" value="Smoothies" onClick="affichageSmoothies();" <?php if ($favori->typeBoisson=='Smoothies') { echo 'checked="checked"'; } ?> />
      </p>
    </div>
    <div id="choixMenuSmoothie2" class="choixMenuSmoothie" style="visibility:hidden">
      <p>
        <label for="Dairy Smoothies">Dairy Smoothies <br />(avec produits laitiers)</label>
        <input type="radio" name="radioBoisson" id="DairySmoothies" value="DairySmoothies" onClick="affichageDairySmoothies();" <?php if ($favori->typeBoisson=='DairySmoothies') { echo 'checked="checked"'; } ?> />
      </p>
    </div>
    <div id="tableauSmoothies" style="visibility:hidden">
      <p>
        <label class="smooth" for="ENERGY - Orange, Fraise, Banane -"><b>ENERGY</b> <em>- Orange, Fraise, Banane -</em></label>
        <input type="radio" name="radioSmoothies" id="ENERGY" value="ENERGY - Orange, Fraise, Banane -" <?php if ( ($favori->boisson=='ENERGY - Orange, Fraise, Banane -') || (! $favori->boisson) ) { echo 'checked="checked"'; } ?> />
      </p>
      <p>
        <label class="smooth" for="SUNNY - Mangue, Orange, Ananas -"><b>SUNNY</b> <em>- Mangue, Orange, Ananas -</em></label>
        <input type="radio" name="radioSmoothies" id="SUNNY" value="SUNNY - Mangue, Orange, Ananas -" <?php if ($favori->boisson=='SUNNY - Mangue, Orange, Ananas -') { echo 'checked="checked"'; } ?> />
      </p>
      <p>
        <label class="smooth" for="TROPIK - Ananas, Orange, Banane -"><b>TROPIK</b> <em>- Ananas, Orange, Banane -</em></label>
        <input type="radio" name="radioSmoothies" id="TROPIK" value="TROPIK - Ananas, Orange, Banane -" <?php if ($favori->boisson=='TROPIK - Ananas, Orange, Banane -') { echo 'checked="checked"'; } ?> />
      </p>
      <p>
        <label class="smooth" for="JOLY - Carotte, Orange, Fraise -"><b>JOLY</b> <em>- Carotte, Orange, Fraise -</em></label>
        <input type="radio" name="radioSmoothies" id="JOLY" value="JOLY - Carotte, Orange, Fraise -" <?php if ($favori->boisson=='JOLY - Carotte, Orange, Fraise -') { echo 'checked="checked"'; } ?> />
      </p>
      <p>
        <label class="smooth" for="POM POIRE - Pomme, Poire, Fraise, Orange -"><b>POM POIRE</b> <em>- Pomme, Poire, Fraise, Orange -</em></label>
        <input type="radio" name="radioSmoothies" id="POM POIRE" value="POM POIRE - Pomme, Poire, Fraise, Orange -" <?php if ($favori->boisson=='POM POIRE - Pomme, Poire, Fraise, Orange -') { echo 'checked="checked"'; } ?> />
      </p>
      <p>
        <label class="smooth" for="PUNCHY - Pêche, Mangue, Ananas -"><b>PUNCHY</b> <em>- Pêche, Mangue, Ananas -</em></label>
        <input type="radio" name="radioSmoothies" id="PUNCHY" value="PUNCHY - Pêche, Mangue, Ananas -" <?php if ($favori->boisson=='PUNCHY - Pêche, Mangue, Ananas -') { echo 'checked="checked"'; } ?> />
      </p>    
<p>
        <label class="smooth" for="MY SMOOTHIE- 3 ingr&eacute;dients au choix -"><b>MY SMOOTHIE</b><em> - 3 ingr&eacute;dients au choix -</em></label>
        <input type="radio" name="radioSmoothies" id="MY SMOOTHIE" value="MY SMOOTHIE - 3 ingr&eacute;dients au choix -" onclick="afficherMySmoothies();" />
        <br /><input type="text" size="30" name="myingredientsSmoothies" id="myingredientsSmoothies" value="" style="margin:5px;display:none;border:solid 1px #000000;float:right;" />
      </p>
<?php 
if ($jusJour)
	{ ?>
<p>
        <label class="smooth" for="DAILY - Jus du jour -"><b>DAILY</b> <em>- Jus du jour: <br><?php echo $jusJour; ?> -</em></label>

        <input type="radio" name="radioSmoothies" id="DAILY" value="DAILY - Jus du jour -" />
      </p> 
<? } ?>
    </div>
    <div id="tableauDairySmoothies" style="visibility:hidden">
    <p>
        <label class="smooth" for="COCO - Lait de coco, Banane, Lait de soja, Glace vanille -"><b>COCO</b> <em>- Lait de coco, Banane, Lait de soja, Glace vanille -</em></label>
        <input type="radio" name="radioDairySmoothies" id="COCO" value="COCO - Lait de coco, Banane, Lait de soja, Glace vanille -" <?php if ( ($favori->boisson=='COCO - Lait de coco, Banane, Lait de soja, Glace vanille -') || (! $favori->boisson) ) { echo 'checked="checked"'; } ?> />
      </p>
      <p>
        <label class="smooth" for="ASIAN - Pomme, Litchee, Lait de soja, Cannelle -"><b>ASIAN</b> <em>- Pomme, Litchee, Lait de soja, Cannelle -</em></label>
        <input type="radio" name="radioDairySmoothies" id="ASIAN" value="ASIAN - Pomme, Litchee, Lait de soja, Cannelle -" <?php if ($favori->boisson=='ASIAN - Pomme, Litchee, Lait de soja, Cannelle -') { echo 'checked="checked"'; } ?> />
      </p>
      <p>
        <label class="smooth" for="ORIENT - Figues, Abricot, Yaourt 0%, Lait -"><b>ORIENT</b> <em>- Figues, Abricot, Yaourt 0%, Lait -</em></label>
        <input type="radio" name="radioDairySmoothies" id="ORIENT" value="ORIENT - Figues, Abricot, Yaourt 0%, Lait -" <?php if ($favori->boisson=='ORIENT - Figues, Abricot, Yaourt 0%, Lait -') { echo 'checked="checked"'; } ?> />
      </p>
      <p>
        <label class="smooth" for="STARTER - Banane, Flocons d’avoine, Lait de soja, Miel, Yaourt 0% -"><b>STARTER</b> <em>- Banane, Flocons d’avoine, Lait de soja, Miel, Yaourt 0% -</em></label>
        <input type="radio" name="radioDairySmoothies" id="STARTER" value="STARTER - Banane, Flocons d’avoine, Lait de soja, Miel, Yaourt 0% -" <?php if ($favori->boisson=='STARTER - Banane, Flocons d’avoine, Lait de soja, Miel, Yaourt 0% -') { echo 'checked="checked"'; } ?> />
      </p>
      <p>
        <label class="smooth" for="LATINO - Mangue, Ananas, Orange, Lait de soja -"><b>LATINO</b> <em>- Mangue, Ananas, Orange, Lait de soja -</em></label>
        <input type="radio" name="radioDairySmoothies" id="LATINO" value="LATINO - Mangue, Ananas, Orange, Lait de soja -" <?php if ($favori->boisson=='LATINO - Mangue, Ananas, Orange, Lait de soja -') { echo 'checked="checked"'; } ?> />
      </p>
      <p>
        <label class="smooth" for="RED - Fruits rouges, Sorbet fraise, Lait -"><b>RED</b> <em> - Fruits rouges, Sorbet fraise, Lait -</em></label>
        <input type="radio" name="radioDairySmoothies" id="RED" value="RED - Fruits rouges, Sorbet fraise, Lait -" <?php if ($favori->boisson=='RED - Fruits rouges, Sorbet fraise, Lait -') { echo 'checked="checked"'; } ?> />
      </p>
      <p>
        <label class="smooth" for="WOMEN - Fraise, Banane, Lait de soja -"><b>WOMEN</b> <em>- Fraise, Banane, Lait de soja -</em></label>
        <input type="radio" name="radioDairySmoothies" id="WOMEN" value="WOMEN - Fraise, Banane, Lait de soja -" <?php if ($favori->boisson=='WOMEN - Fraise, Banane, Lait de soja -') { echo 'checked="checked"'; } ?> />
      </p>
      <p>
        <label class="smooth" for="FRAISY - Fraise, Lait, Glace vanille -"><b>FRAISY</b> <em>- Fraise, Lait, Glace vanille -</em></label>
        <input type="radio" name="radioDairySmoothies" id="FRAISY" value="FRAISY - Fraise, Lait, Glace vanille -" <?php if ($favori->boisson=='FRAISY - Fraise, Lait, Glace vanille -') { echo 'checked="checked"'; } ?> />
      </p> 
      <p>
        <label class="smooth" for="CHOKY - Chocolat, Banane, Lait, Glace vanille -"><b>CHOKY</b> <em>- Chocolat, Banane, Lait, Glace vanille -</em></label>
        <input type="radio" name="radioDairySmoothies" id="CHOKY" value="CHOKY - Chocolat, Banane, Lait, Glace vanille -" <?php if ($favori->boisson=='CHOKY - Chocolat, Banane, Lait, Glace vanille -') { echo 'checked="checked"'; } ?> />
      </p>
<p>
        <label class="smooth" for="MY DAIRY- 3 ingr&eacute;dients au choix -"><b>MY DAIRY </b><em> - 3 ingr&eacute;dients au choix -</em></label>
        <input type="radio" name="radioDairySmoothies" id="MY DAIRY" value="MY DAIRY - 3 ingr&eacute;dients au choix -" onclick="afficherMyDairySmoothies();" />
        <br /><input type="text" size="30" name="myingredientsDairySmoothies" id="myingredientsDairySmoothies" value="" style="margin:5px;display:none;border:solid 1px #000000;float:right;" />
      </p> 
<?php 
if ($jusJour)
	{ ?>
<p>
        <label class="smooth" for="DAILY - Jus du jour -"><b>DAILY</b> <em>- Jus du jour: <br><?php echo $jusJour; ?> -</em></label>

        <input type="radio" name="radioDairySmoothies" id="DAILY" value="DAILY - Jus du jour -" />
      </p> 
<? } ?>
    </div>
    <div id="tableauJusDeFruits" style="visibility:hidden">
      <p>
        <label class="smooth" for="SLIM - Pomme, Fruits rouges, Ananas, Pamplemousse -"><b>SLIM </b><em> - Pomme, Fruits rouges, Ananas, Pamplemousse -</em></label>
        <input type="radio" name="radioJusDeFruits" id="SLIM" value="SLIM - Pomme, Fruits rouges, Ananas, Pamplemousse -" <?php if ( ($favori->boisson=='SLIM - Pomme, Fruits rouges, Ananas, Pamplemousse -') || (! $favori->boisson) ) { echo 'checked="checked"'; } ?> />
      </p>
      <p>
        <label class="smooth" for="ANTIOXY - Thé vert, Pomme, Fruits rouges, Framboise -"><b>ANTIOXY </b><em> - Thé vert, Pomme, Fruits rouges, Framboise -</em></label>
        <input type="radio" name="radioJusDeFruits" id="ANTIOXY" value="ANTIOXY - Thé vert, Pomme, Fruits rouges, Framboise -" <?php if ($favori->boisson=='ANTIOXY - Thé vert, Pomme, Fruits rouges, Framboise -') { echo 'checked="checked"'; } ?> />
      </p>
      <p>
        <label class="smooth" for="KIPIK - Citron, Orange, Pamplemousse -"><b>KIPIK </b><em> - Citron, Orange, Pamplemousse -</em></label>
        <input type="radio" name="radioJusDeFruits" id="KIPIK" value="KIPIK - Citron, Orange, Pamplemousse -" <?php if ($favori->boisson=='KIPIK - Citron, Orange, Pamplemousse -') { echo 'checked="checked"'; } ?> />
      </p>
      <p>
        <label class="smooth" for="KAROTEN - Carotte, Orange, Citron -"><b>KAROTEN </b><em> - Carotte, Orange, Citron -</em></label>
        <input type="radio" name="radioJusDeFruits" id="KAROTEN" value="KAROTEN - Carotte, Orange, Citron -" <?php if ($favori->boisson=='KAROTEN - Carotte, Orange, Citron -') { echo 'checked="checked"'; } ?> />
      </p>
      <p>
        <label class="smooth" for="PROTECT - Carotte, Orange, Pomme, Gingembre -"><b>PROTECT </b><em> - Carotte, Orange, Pomme, Gingembre -</em></label>
        <input type="radio" name="radioJusDeFruits" id="PROTECT" value="PROTECT - Carotte, Orange, Pomme, Gingembre -" <?php if ($favori->boisson=='PROTECT - Carotte, Orange, Pomme, Gingembre -') { echo 'checked="checked"'; } ?> />
      </p>
      <p>
        <label class="smooth" for="RIAD - Thé menthe, Citron, Pomme, Miel -"><b>RIAD </b><em> - Thé menthe, Citron, Pomme, Miel -</em></label>
        <input type="radio" name="radioJusDeFruits" id="RIAD" value="RIAD - Thé menthe, Citron, Pomme, Miel -" <?php if ($favori->boisson=='RIAD - Thé menthe, Citron, Pomme, Miel -') { echo 'checked="checked"'; } ?> />
      </p>
      <p>
        <label class="smooth" for="MY JUICE - 3 ingr&eacute;dients au choix -"><b>MY JUICE </b><em> - 3 ingr&eacute;dients au choix -</em></label>
        <input type="radio" name="radioJusDeFruits" id="MY JUICE" value="MY JUICE - 3 ingr&eacute;dients au choix -" onclick="afficherMyJusDeFruit();" />
        <br /><input type="text" size="30" name="myingredientsJusDeFruits" id="myingredientsJusDeFruits" value="" style="margin:5px;display:none;border:solid 1px #000000;float:right;" />
      </p>
<?php 
if ($jusJour)
	{ ?>
<p>
        <label class="smooth" for="DAILY - Jus du jour -"><b>DAILY</b> <em>- Jus du jour: <br><?php echo $jusJour; ?> -</em></label>

        <input type="radio" name="radioJusDeFruits" id="DAILY" value="DAILY - Jus du jour -" />
      </p> 
<? } ?>
    </div>
    <div class="ajusteur">&nbsp;</div>
    <div id="pain" style="visibility:hidden">
      <h2>+ 1 pain <span style="font-size:12px;">(selon disponibilit&eacute;s)</span></h2>
      <table width="250" border="0">
        <tr>
          <td><p>
              <input type="radio" name="radioPain" id="Céréales" value="Céréales" checked="checked" <?php if ( ($favori->pain=='Céréales') || (!$favori->pain) ) { echo 'checked="checked"'; } ?> />
              Céréales</p></td>
          <td>&nbsp;</td>
          <td><p>
              <input type="radio" name="radioPain" id="Noix" value="Noix" <?php if ($favori->pain=='Noix') { echo 'checked="checked"'; } ?> />
              Noix</p></td>
        </tr>
        <tr>
          <td><p>
              <input type="radio" name="radioPain" id="Figues" value="Figues" <?php if ($favori->pain=='Figues') { echo 'checked="checked"'; } ?> />
              Figues</p></td>
          <td>&nbsp;</td>
          <td><p>
              <input type="radio" name="radioPain" id="Lardons" value="Lardons" <?php if ($favori->pain=='Lardons') { echo 'checked="checked"'; } ?> />
              Lardons</p></td>
        </tr>
        <tr>
          <td><p>
              <input type="radio" name="radioPain" id="Raisins/Noisettes" value="Raisins/Noisettes" <?php if ($favori->pain=='Raisins/Noisettes') { echo 'checked="checked"'; } ?> />
              Raisins/Noisettes</p></td>
          <td>&nbsp;</td>
          <td><p>
              <input type="radio" name="radioPain" id="Fromage" value="Fromage" <?php if ($favori->pain=='Fromage') { echo 'checked="checked"'; } ?> />
              Fromage</p></td>
        </tr>
      </table>
      <p>&nbsp;</p>
    </div>    
<div style="margin-left:200px;"><a href="javascript:;" onclick="afficherCommentaire();">Un commentaire sur votre commande ? Cliquez-ici</a><br><textarea name="commentaire" id="commentaire" cols="40" rows="5" style="display:none;border:solid 1px #000000;margin:5px; font-size:11px"></textarea></div>
    <div id="pied" style="visibility:hidden">
      <h2>Taille de votre menu :</h2>
      <p>
        <select name="taille" id="taille" style="width:75px">
          <option id="Moyen" value="Moyen" <?php if ($favori->taille=='Moyen') { echo 'selected="selected"'; } ?> />
          Moyen
          </option>
          <option id="Grand" value="Grand" selected="selected" <?php if ( ($favori->taille=='Grand') || (!$favori->taille) ) { echo 'selected="selected"'; } ?> />
          Grand
          </option>
        </select>
        <input type="submit" class="bouton" value="R&eacute;server" />
      </p>
      <p>&nbsp;</p>
    </div>
  </form>
</div>
<?
}?>
<script type="text/javascript">
lsjs_actualiseSelectDate('<? echo $dateReservation; ?>')
</script>
  <?
if (isset($_POST['dateReservation']) && $favori->ID)
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
<?php } // FIN if (isset($_POST['dateReservation'])) ?>
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-1956792-20";
urchinTracker();
</script>
</body>
</html>
