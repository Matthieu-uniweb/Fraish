<?
session_start();

if (! $_SESSION['ID_client'])
	{ header("Location: ../login.php"); }
	
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/classes.inc.php';
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/includes/classes/paquetage.inc.php';

function determineDateJour($dateReservation)
{
    if ($dateReservation == date('Y-m-d'))
	{
		$heure = date('H');
		$minute = date('i');
		
		if($heure >= 12 || ($heure == 11 && $minute > 30))
		{
			$mois = date('m');
			$jour = date('d');
			$annee = date('Y');
			if ($jour == 30 && ($mois == 4 || $mois == 6 || $mois == 9 || $mois == 11))
			{	$jour = 1;
				if ($mois != 12)
				{	$mois ++;	}
				else
				{	$mois = 1;
					$annee ++;	}
			}
			else if ($jour == 28 && $mois == 2)
				{	$jour = 1;
					if ($mois != '12')
					{	$mois ++;	}
					else
					{	$mois = 1;
						$annee ++;	}
				}
				else if ($jour == 31)
					{	$jour = 1;
						if ($mois != 12)
						{	$mois ++;	}
						else
						{	$mois = 1;
							$annee ++;	}
					}
					else
					{	$jour ++;	}
			//ajoute '0' si c'est un chiffre compris entre 0 et 9
			if( 0 < $mois && $mois < 10 && strlen($mois) == 1)
			{	$mois = '0'.$mois;	}
			if( 0 < $jour && $jour < 10 && strlen($jour) == 1)
			{	$jour = '0'.$jour;  }
			
			$dateReservation = $annee."-".$mois."-".$jour;
		}
	}

	 return T_LAETIS_site::convertirDate( $dateReservation );
	 
}

if (isset($_POST['dateReservation']))
{	$dateReservation = $_POST['dateReservation'];}
else
{	
	$dateReservation = determineDateJour(date('Y-m-d'));
}

$favori = new Tbq_client_favori($_REQUEST['ID_menuFavori']);
$plat = explode(', ', $favori->plat);

		$heure2 = date('H');
		$minute2 = date('i');
		
		if($heure2 >= 12 || ($heure2 == 11 && $minute2 > 30))
		{
			$mois2 = date('m');
			$jour2 = date('d');
			$annee2 = date('Y');
			if ($jour2 == 30 && ($mois2 == 4 || $mois2 == 6 || $mois2 == 9 || $mois2 == 11))
			{	$jour2 = 1;
				if ($mois2 != 12)
				{	$mois2 ++;	}
				else
				{	$mois2 = 1;
					$annee2 ++;	}
			}
			else if ($jour2 == 28 && $mois2 == 2)
				{	$jour2 = 1;
					if ($mois2 != '12')
					{	$mois2 ++;	}
					else
					{	$mois2 = 1;
						$annee2 ++;	}
				}
				else if ($jour2 == 31)
					{	$jour2 = 1;
						if ($mois2 != 12)
						{	$mois ++;	}
						else
						{	$mois2 = 1;
							$annee ++;	}
					}
					else
					{	$jour2 ++;	}
		}
		else
		{	$mois2 = date('m');
			$jour2 = date('d');
			$annee2 = date('Y');
		}
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
      <!-- script pour gérer les bords arrondis et le panel déroulant -->
      <script src="../../includes/plugins/rico/src/rico.js" type="text/javascript"></script>
      <script src="../../includes/plugins/rico/src/ricoStyles.js" type="text/javascript"></script>
      <script src="../../includes/plugins/rico/src/ricoEffects.js" type="text/javascript"></script>
      <!--<script src="../../includes/javascript/function.js" type="text/javascript"></script>-->
      <script src="../../includes/plugins/rico/src/ricoComponents.js" type="text/javascript"></script>
      <script type="text/javascript">
              function roundMe() {
                       $$('div.conteneur').each(function(e){Rico.Corner.round(e)});
              }
      </script>

<script type="text/javascript" src="/includes/javascript/masques.js"></script>
<script src="../../includes/plugins/tinymce/jscripts/tiny_mce/tiny_mce.js" type="text/javascript"></script>
<script src="/boutique/includes/javascript/bq_admin-boutique.js" type="text/javascript"></script>
<script src="../../includes/javascript/reserver.js" type="text/javascript"></script>
<script src="../../includes/javascript/calandrier.js" type="text/javascript"></script>
<SCRIPT language=JavaScript><!--
	dateA=new Date()
	an=dateA.getFullYear();
	moisActuel='<?php $moisAC=date("m"); echo $moisAC;?>'+"-"+an;
	compt=0;
	
function invisible() {
	document.getElementById("calendrier").style.display= 'none';
	}
	
function afficheCalendrier() {
	if(compt==0){
	document.getElementById("calendrier").style.display= 'block';
	compt=1;
	} else {
	document.getElementById("calendrier").style.display= 'none';
	compt=0;
	}
	}
	
var num_jour_global;
function  numJourGlobal(num_jour) {
	num_jour_global=num_jour;
	}

function actualiseJour(jourSelect) {
	/*if(jourSelect<10) {
	jourSelect = '0'+jourSelect;
	}*/
	document.getElementById('jour').value = jourSelect;
	
	var num_jour_lettre=Number (jourSelect) + Number (num_jour_global) -1;
	if(num_jour_lettre==1 || num_jour_lettre == 8 || num_jour_lettre == 15 || num_jour_lettre == 22 || num_jour_lettre == 29 || num_jour_lettre == 36) {
		document.getElementById("jourLettre").value="Lundi";
	} else if(num_jour_lettre==2 || num_jour_lettre == 9 || num_jour_lettre == 16 || num_jour_lettre == 23 || num_jour_lettre == 30 || num_jour_lettre == 37) {
		document.getElementById("jourLettre").value="Mardi";
	} else if(num_jour_lettre==3 || num_jour_lettre == 10 || num_jour_lettre == 17 || num_jour_lettre == 24 || num_jour_lettre == 31 || num_jour_lettre == 38) {
		document.getElementById("jourLettre").value="Mercredi";
	} else if(num_jour_lettre==4 || num_jour_lettre == 11 || num_jour_lettre == 18 || num_jour_lettre == 25 || num_jour_lettre == 32 || num_jour_lettre == 39) {
		document.getElementById("jourLettre").value="Jeudi";
	} else if(num_jour_lettre==5 || num_jour_lettre == 12 || num_jour_lettre == 19 || num_jour_lettre == 26 || num_jour_lettre == 33 || num_jour_lettre == 40) {
		document.getElementById("jourLettre").value="Vendredi";
	} else if(num_jour_lettre==6 || num_jour_lettre == 13 || num_jour_lettre == 20 || num_jour_lettre == 27 || num_jour_lettre == 34 || num_jour_lettre == 41) {
		document.getElementById("jourLettre").value="Samedi";
	} else if(num_jour_lettre==7 || num_jour_lettre == 14 || num_jour_lettre == 21 || num_jour_lettre == 28 || num_jour_lettre == 35 || num_jour_lettre == 42) {
		document.getElementById("jourLettre").value="Dimanche";
	}
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
		 } else if(num_jour_ap_midi==compteur && date_en_cours==moisActuel){
		 	document.getElementById(compteur).style.backgroundColor="#FFA4A6";
			}else {
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
       $('link_suivant').onclick=function(){eval(data.lien_suivant); document.getElementById('mois').value = data.moisSuiv;};
       $('link_precedent').onclick=function(){eval(data.lien_precedent); document.getElementById('mois').value = data.moisPrec;};
	   actualiseMois(data.moisEnCoursNum,data.num_jour);
	   numJourGlobal(data.num_jour);
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
	
window.onload=function(){invisible(); actualiseJour(<?php echo $jour2;?>);}
--></SCRIPT>
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
<div id="enTete">
  <h1>Votre espace client</h1>
</div>
<div id="contenu">
  <form method="post" id="formulaireHeure" name="formulaireHeure" action="reserver.php" onsubmit="return lsjs_controleDates('<?php echo date("r"); ?>')">
    <h3 <? if (isset($_POST['dateReservation'])) { echo 'disabled="disabled" style="display:none"'; }?>>R&eacute;servez votre date de livraison :</h3>
    <div id="dateReserv">
      <p <? if (isset($_POST['dateReservation'])) { echo 'disabled="disabled" style="display:none"'; }?>><strong>S&eacute;lectionnez ci-dessous <br />
        la date de livraison de votre menu :</strong></p>
      <p>
        <input name="dateReservation" type="hidden" id="dateReservation" size="10" maxlength="10" value="<?php echo  $dateReservation;?>" />
        <br />
		<input type="hidden" readonly="readonly" value="" <? if (isset($_POST['dateReservation'])) { echo 'disabled="disabled" style="display:none"'; }?>/>
		<input id="jourLettre" type="text" readonly="readonly" value="" <? if (isset($_POST['dateReservation'])) { echo 'disabled="disabled" style="display:none"'; }?>/>
		<select onchange="javascript:invisible(); actualiseJour(value);" id="jour" name="jour" <? if (isset($_POST['dateReservation'])) { echo 'disabled="disabled" style="display:none"'; }?>>
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
		<select onchange="javascript:invisible()" id="mois" name="mois" <? if (isset($_POST['dateReservation'])) { echo 'disabled="disabled" style="display:none"'; }?>>
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
		
		<!-- on crée l'élément "calendrier" dans lequel va s'afficher dynamiquement le calendrier-->

     <!-- <script>tableau(<?php// echo date('m');?>,<?php// echo date('Y');?>);</script>-->
	  <script>tableau(<?php echo $mois2; //date("m");?>,<?php echo $annee2; //date("Y");?>);</script>
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
                 <td bgcolor="#C8E9A3" class="cell_calendrier">
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
      <!-- Appel de la fonction qui va arrondir le conteneur du calendrier et des évènements pour le panel déroulant -->
      <script>
              javascript:roundMe()
              Event.observe(window, 'load', function(){
                   PullDown.panel = Rico.SlidingPanel.top( $('outer_panel'), $('inner_panel'));
              })
              var PullDown = {};
      </script>
		
    </div>
    <p>
    	<input type="hidden" name="ID_menuFavori" value="<?php echo $_GET['ID_menuFavori']; ?>" />
      <input name="submit" type="submit" class="bouton" id="choisirSonMenu" value="Choisir son Menu" <? if (isset($_POST['dateReservation'])) { echo 'disabled="disabled" style="display:none"'; }?> />
    </p>
  </form>
<?
if (isset($_POST['dateReservation']))
{ 
?>
  <form method="post" id="formulaireMenu" action="../scripts/valider-reservation.php" onsubmit="return verifierMenu(this);">
    <h3>Votre date de livraison : <span class="Style1"> <?php echo $_POST['dateReservation']; ?> </span></h3>
    <p>
      <input name="dateRes" type="hidden" value="<? echo $_POST['dateReservation']; ?>" />
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
      <p><label class="soupe" for="Soupe Daily : Recette du jour"><input type="radio" name="radioSoupe" id="Soupe Daily" value="Soupe Daily" <?php if ( (in_array('Soupe Daily', $plat)) || (! $favori->plat) ) { echo 'checked="checked"'; } ?> /> <b>Soupe Daily</b> <em> - Recette du jour -</em></label></p>
      <p><label class="soupe" for="Soupe Diet : Tout légumes sans crème (diététique) -"><input type="radio" name="radioSoupe" id="Soupe Diet" value="Soupe Diet" <?php if (in_array('Soupe Diet', $plat)) { echo 'checked="checked"'; } ?> /> <b>Soupe Diet</b> <em>- Tout légumes sans crème (diététique) -</em></label>        
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
    <div id="choixMenuG" style="visibility:hidden">
      <p>
        <label for="Smoothies">Smoothies</label>
        <input type="radio" name="radioBoisson" id="Smoothies" value="Smoothies" onClick="affichageSmoothies();" <?php if ($favori->typeBoisson=='Smoothies') { echo 'checked="checked"'; } ?> />
      </p>
    </div>
    <div id="choixMenuD" style="visibility:hidden">
      <p>
        <label for="Jus de fruits">Jus de fruits</label>
        <input type="radio" name="radioBoisson" id="JusDeFruits" value="JusDeFruits" onClick="affichageJusDeFruits();" <?php if ($favori->typeBoisson=='JusDeFruits') { echo 'checked="checked"'; } ?> />
      </p>
    </div>
    <div id="tableauSmoothies" style="visibility:hidden">
      <p>
        <label class="smooth" for="WOMEN - lait de soja, banane, fraise -"><b>WOMEN</b> <em>- lait de soja, banane, fraise -</em></label>
        <input type="radio" name="radioSmoothies" id="WOMEN" value="WOMEN - lait de soja, banane, fraise -" <?php if ( ($favori->boisson=='WOMEN - lait de soja, banane, fraise -') || (! $favori->boisson) ) { echo 'checked="checked"'; } ?> />
      </p>
      <p>
        <label class="smooth" for="RED - fruits rouges, sorbet fraise, lait -"><b>RED</b> <em> - fruits rouges, sorbet fraise, lait -</em></label>
        <input type="radio" name="radioSmoothies" id="RED" value="RED - fruits rouges, sorbet fraise, lait -" <?php if ($favori->boisson=='RED - fruits rouges, sorbet fraise, lait -') { echo 'checked="checked"'; } ?> />
      </p>
      <p>
        <label class="smooth" for="COCO - coco, banane, glace vanille, lait de soja -"><b>COCO</b> <em>- coco, banane, glace vanille, lait de soja -</em></label>
        <input type="radio" name="radioSmoothies" id="COCO" value="COCO - coco, banane, glace vanille, lait de soja -" <?php if ($favori->boisson=='COCO - coco, banane, glace vanille, lait de soja -') { echo 'checked="checked"'; } ?> />
      </p>
      <p>
        <label class="smooth" for="STARTER - yaourt 0%, banane, miel, c&eacute;r&eacute;ales, lait de soja -"><b>STARTER</b> <em>- yaourt 0%, banane, miel, c&eacute;r&eacute;ales, lait de soja -</em></label>
        <input type="radio" name="radioSmoothies" id="STARTER" value="STARTER - yaourt 0%, banane, miel, c&eacute;r&eacute;ales, lait de soja -" <?php if ($favori->boisson=='STARTER - yaourt 0%, banane, miel, c&eacute;r&eacute;ales, lait de soja -') { echo 'checked="checked"'; } ?> />
      </p>
      <p>
        <label class="smooth" for="ORIENT - figue, abricot, yaourt 0%, lait -"><b>ORIENT</b> <em>- figue, abricot, yaourt 0%, lait -</em></label>
        <input type="radio" name="radioSmoothies" id="ORIENT" value="ORIENT - figue, abricot, yaourt 0%, lait -" <?php if ($favori->boisson=='ORIENT - figue, abricot, yaourt 0%, lait -') { echo 'checked="checked"'; } ?> />
      </p>
      <p>
        <label class="smooth" for="LATINO - mangue, orange, ananas, lait de soja -"><b>LATINO</b> <em>- mangue, orange, ananas, lait de soja -</em></label>
        <input type="radio" name="radioSmoothies" id="LATINO" value="LATINO - mangue, orange, ananas, lait de soja -" <?php if ($favori->boisson=='LATINO - mangue, orange, ananas, lait de soja -') { echo 'checked="checked"'; } ?> />
      </p>
      <p>
        <label class="smooth" for="ASIAN - lychee, cannelle, pomme, lait de soja -"><b>ASIAN</b> <em>- lychee, cannelle, pomme, lait de soja -</em></label>
        <input type="radio" name="radioSmoothies" id="ASIAN" value="ASIAN - lychee, cannelle, pomme, lait de soja -" <?php if ($favori->boisson=='ASIAN - lychee, cannelle, pomme, lait de soja -') { echo 'checked="checked"'; } ?> />
      </p>
      <p>
        <label class="smooth" for="MILK CHOKY - banane, choco, glace vanille, lait -"><b>MILK CHOKY</b> <em>- banane, choco, glace vanille, lait -</em></label>
        <input type="radio" name="radioSmoothies" id="MILK CHOKY" value="MILK CHOKY - banane, choco, glace vanille, lait -" <?php if ($favori->boisson=='MILK CHOKY - banane, choco, glace vanille, lait -') { echo 'checked="checked"'; } ?> />
      </p>
      <p>
        <label class="smooth" for="MILK FRAISY - banane, fraise, glace vanille, lait -"><b>MILK FRAISY</b> <em>- banane, fraise, glace vanille, lait -</em></label>
        <input type="radio" name="radioSmoothies" id="MILK FRAISY" value="MILK FRAISY - banane, fraise, glace vanille, lait -" <?php if ($favori->boisson=='MILK FRAISY - banane, fraise, glace vanille, lait -') { echo 'checked="checked"'; } ?> />
      </p>
    </div>
    <div id="tableauJusDeFruits" style="visibility:hidden">
      <p>
        <label class="smooth" for="ENERGY - orange, banane, fraise -"><b>ENERGY </b><em> - orange, banane, fraise -</em></label>
        <input type="radio" name="radioJusDeFruits" id="ENERGY" value="ENERGY - orange, banane, fraise -" checked="checked" <?php if ($favori->boisson=='ENERGY - orange, banane, fraise -') { echo 'checked="checked"'; } ?> />
      </p>
      <p>
        <label class="smooth" for="TROPIK - ananas, orange, banane -"><b>TROPIK </b><em> - ananas, orange, banane -</em></label>
        <input type="radio" name="radioJusDeFruits" id="TROPIK" value="TROPIK - ananas, orange, banane -" <?php if ($favori->boisson=='TROPIK - ananas, orange, banane -') { echo 'checked="checked"'; } ?> />
      </p>
      <p>
        <label class="smooth" for="SLIM - pomme, pamplemousse, ananas, fruits rouges -"><b>SLIM </b><em> - pomme, pamplemousse, ananas, fruits rouges -</em></label>
        <input type="radio" name="radioJusDeFruits" id="SLIM" value="SLIM - pomme, pamplemousse, ananas, fruits rouges -" <?php if ($favori->boisson=='SLIM - pomme, pamplemousse, ananas, fruits rouges -') { echo 'checked="checked"'; } ?> />
      </p>
      <p>
        <label class="smooth" for="ANTIOXY - th&eacute; vert, fruits rouges, pomme, framboise -"><b>ANTIOXY </b><em> - th&eacute; vert, fruits rouges, pomme, framboise -</em></label>
        <input type="radio" name="radioJusDeFruits" id="ANTIOXY" value="ANTIOXY - th&eacute; vert, fruits rouges, pomme, framboise -" <?php if ($favori->boisson=='ANTIOXY - th&eacute; vert, fruits rouges, pomme, framboise -') { echo 'checked="checked"'; } ?> />
      </p>
      <p>
        <label class="smooth" for="KIPIK - pamplemousse, orange, citron -"><b>KIPIK </b><em> - pamplemousse, orange, citron -</em></label>
        <input type="radio" name="radioJusDeFruits" id="KIPIK" value="KIPIK - pamplemousse, orange, citron -" <?php if ($favori->boisson=='KIPIK - pamplemousse, orange, citron -') { echo 'checked="checked"'; } ?> />
      </p>
      <p>
        <label class="smooth" for="SUNNY - mangue, ananas, orange -"><b>SUNNY </b><em> - mangue, ananas, orange -</em></label>
        <input type="radio" name="radioJusDeFruits" id="SUNNY" value="SUNNY - mangue, ananas, orange -" <?php if ($favori->boisson=='SUNNY - mangue, ananas, orange -') { echo 'checked="checked"'; } ?> />
      </p>
      <p>
        <label class="smooth" for="KAROTEN - carotte, orange, citron -"><b>KAROTEN </b><em> - carotte, orange, citron -</em></label>
        <input type="radio" name="radioJusDeFruits" id="KAROTEN" value="KAROTEN - carotte, orange, citron -" <?php if ($favori->boisson=='KAROTEN - carotte, orange, citron -') { echo 'checked="checked"'; } ?> />
      </p>
      <p>
        <label class="smooth" for="PROTECT - carotte, orange, pomme, gingembre -"><b>PROTECT </b><em> - carotte, orange, pomme, gingembre -</em></label>
        <input type="radio" name="radioJusDeFruits" id="PROTECT" value="PROTECT - carotte, orange, pomme, gingembre -" <?php if ($favori->boisson=='PROTECT - carotte, orange, pomme, gingembre -') { echo 'checked="checked"'; } ?> />
      </p>
      <!--<p>
        <label class="smooth" for="MY - 3 ingr&eacute;dients au choix -"><b>MY </b><em> - 3 ingr&eacute;dients au choix -</em></label>
        <input type="radio" name="radioJusDeFruits" id="MY - 3 ingr&eacute;dients au choix -" value="MY - 3 ingr&eacute;dients au choix -" />
      </p>-->
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
              <input type="radio" name="radioPain" id="Cranberries" value="Cranberries" <?php if ($favori->pain=='Cranberries') { echo 'checked="checked"'; } ?> />
              Cranberries</p></td>
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
              <input type="radio" name="radioPain" id="Chorizo" value="Chorizo" <?php if ($favori->pain=='Chorizo') { echo 'checked="checked"'; } ?> />
              Chorizo</p></td>
        </tr>
      </table>
      <p>&nbsp;</p>
    </div>
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
