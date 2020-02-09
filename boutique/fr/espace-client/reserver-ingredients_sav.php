<?
session_start();

if (! $_SESSION['ID_client'])
	{ header("Location: ../login.php"); }
	
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/classes.inc.php';
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/includes/classes/paquetage.inc.php';

//Empeche la réservation si le client a des dettes
$client = new Tbq_client($_SESSION['ID_client']);
if(!$client->peutCommander())
	{
	header("Location: /boutique/fr/espace-client/espace-client.php");
	}
	
$commande = new Tbq_commande();
$commandeEnCours = new Tbq_commande($_GET['ID_commandeEnCours']);
/*if (isset($_SESSION['dateReservation']))
{	$dateReservation = $_SESSION['dateReservation'];}
elseif($_POST['dateReservation'])
{	
	$dateReservation = $_POST['dateReservation'];
	$_SESSION['dateReservation'] = $_POST['dateReservation'];
	//$commande->determineDateJour(date('Y-m-d'));
}
else
	{
	$dateReservation = $commande->determineDateJour(date('Y-m-d'));
	$_SESSION['dateReservation'] = $dateReservation;
	}

if(!$_SESSION['ID_pointDeVente'])
	{
	$_SESSION['ID_pointDeVente'] = $_POST['ID_pointDeVente'];
	}*/
$dateReservation = date('d-m-Y');
if($_GET['dateReservation'])
	{
	$dateReservation = T_LAETIS_site::convertirDate($_GET['dateReservation']);
	}

$favori = new Tbq_client_favori($_REQUEST['ID_menuFavori']);
if(!$favori->ID_menu)//positionne GET pour le cas où on clique sur le bouton retour de récapitulatif
	{
	$favori->ID_menu = $_GET['ID_menu'];
	$favori->taille = $client->getTailleFavori();
	}
$menu = new Tbq_menu($favori->ID_menu);
if($favori->ID_menu)//Positionne le menu si l'on vient de l'action "commander mon menu favori"
	{
	//$_GET['ID_menu'] = $favori->ID_menu;
	$_GET['ID_formule'] = $menu->ID_typ_formule;
	}

$plat = explode(', ', $favori->plat);

//$ID_pointDeVente = $favori->ID_pointDeVente;
/*if($client->getPointLivraisonFavori())//IF un pt de livraison favori
	{
	$ptLivraison = $client->getPointLivraisonFavori();
	}
else//ELSE pas de point de livraison, on récupère le pt de vente favori
	{
	$ID_pointDeVente = $client->getPointVenteFavori();
	}*/
$ID_pointDeVente = $favori->ID_pointDeVente;
if($_GET['ID_pointDeVente'])
	{
	$ID_pointDeVente = $_GET['ID_pointDeVente'];
	unset($favori->ID_pointDeVente);//25/08/2011
	$favori->ID_pointLivraison='';//Si l'internaute a modifié son point de vente, on ne force plus le point de livraison favori
	}

if(!$ID_pointDeVente)//IF on ne commande pas le menu favori et le point de vente n'est pas indiqué
	{
	if($client->getPointLivraisonFavori())//IF livraison
		{
		$favori->ID_pointLivraison = $client->getPointLivraisonFavori();
		}
	else//ELSE
		{
		$ID_pointDeVente = $client->getPointVenteFavori();
		}
	}

$entreprise = new Tbq_entreprise();
$entreprise->initialiserParCodeEntreprise($client->codeEntreprise);
$ptLivraison = new Tbq_pointLivraison($entreprise->ID_pointLivraison);

$dateSelect = explode('-',$dateReservation);
$jourSelect = $dateSelect[0];
$moisSelect = $dateSelect[1];
$anSelect = $dateSelect[2];
	
$mois2 = date('m');
$jour2 = date('d');
$annee2 = date('Y');

$formule=new Tbq_formule($_GET['ID_formule']);

$platJour = new Tbq_menuJour();
$pointDeVente = new Tbq_user();
$pointsDeVente = $pointDeVente->lister();
$platsEnOption = $formule->getPlatsEnOption();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Fraish r&eacute;servation</title>
<link rel="stylesheet" type="text/css" href="/includes/styles/admin.css" />
<link rel="stylesheet" type="text/css" href="/includes/styles/formulaire.css" />
<link rel="stylesheet" type="text/css" href="/includes/styles/global.css" />
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />
<link rel="icon" type="image/x-icon" href="/favicon.ico" />

<link rel="stylesheet" type="text/css" href="/boutique/includes/styles/calendrier.css">
<!-- On inclut la librairie openrico / prototype -->
<script src="/boutique/includes/plugins/rico/src/prototype.js" type="text/javascript"></script>
<script type="text/javascript" src="/includes/javascript/masques.js"></script>
<script type="text/javascript" src="/includes/javascript/formulaire.js"></script>
<script src="/boutique/includes/plugins/tinymce/jscripts/tiny_mce/tiny_mce.js" type="text/javascript"></script>
<script src="/boutique/includes/javascript/bq_admin-boutique.js" type="text/javascript"></script>
<script src="/boutique/includes/javascript/reserver.js" type="text/javascript"></script>
<script type="text/javascript" language="javascript">
/** Fonctions calendrier **/
var sortie=0;
var FRENCH_DAYS = new Array("Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi");
	dateA=new Date()
	an=dateA.getFullYear();
	moisActuel='<?php $moisAC=date("m"); echo $moisAC;?>'+"-"+an;
	compt=0;
	
function invisible() 
	{
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
function envoiMoisSelect(MoisSelectionner)
	{
	tableau(MoisSelectionner,<?php echo $annee2; //date("Y");?>);
	actualiseJour(<?php echo $annee2; ?>, MoisSelectionner, 1);	
	}
function actualiseJour(year,numericMonth,selectedDay)
	{
	document.getElementById('jour').value=selectedDay;
	//alert(year+"-"+numericMonth+"-"+selectedDay);
	
	var myDate = new Date(Date.UTC(year,numericMonth-1,selectedDay,0,0,0));
	//alert(myDate.getMonth());
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
	   var num_jour_actuel=Number (jourActuel) + Number (num_jour1) -1;
	   var num_jour_ap_midi=Number (jourApresMidi) + Number (num_jour2) -1;

      while(compteur<43){
	  	if(num_jour_actuel>compteur && date_en_cours==moisActuel){
			document.getElementById(compteur).style.backgroundColor="#CCCCCC";
		 } else if(num_jour_actuel==compteur && date_en_cours==moisActuel){
			  document.getElementById(compteur).style.backgroundColor="#FF0000";
		 } else {
		  	document.getElementById(compteur).style.backgroundColor="#FFFFFF";
		 }
          compteur++;
       }
	}
function remplirCalendrier(reponsejson) 
	{
   //on utilise la fonction evalJSON de prototype pour parser la réponse JSON
	var data=reponsejson.responseText.evalJSON();
   //On place les liens suivants,précédents et le mois en cours
   $('link_suivant').onclick=function(){eval(data.lien_suivant); document.getElementById('mois').value = data.moisSuiv; envoiMoisSelect(document.getElementById('mois').value);};
   $('link_precedent').onclick=function(){eval(data.lien_precedent); document.getElementById('mois').value = data.moisPrec; envoiMoisSelect(document.getElementById('mois').value);};
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

/** (FIN) Fonctions calendrier **/

/**
* 
*/
function alternerAffichage(div1)
	{
	if(div1 == '<?php echo $platsEnOption[0];?>')
		{
		div2 = '<?php echo $platsEnOption[1];?>';
		}
	else
		{
		div2 = '<?php echo $platsEnOption[0]?>';
		}

	//activer salade
	document.getElementById('masque-'+div1).style.display = 'block';
	document.getElementById('masque-'+div1).style.visibility = '';
	//desactiver soupe
	document.getElementById('masque-'+div2).style.display = 'none';
	document.getElementById('masque-'+div2).style.visibility = 'hidden';	
	}
function validerIngredients()
	{
	var form = lsjs_verifierFormulaire2(document.forms[0]);
	
	//controler les ingrédients salade
	
	//controler les ingrédients soupe
	
	if(form == true)//etape 1 verif formulaire
		{//si form ok, verif dates
		sortie=1;
		return lsjs_controleDates('<?php echo date("r"); ?>',document.getElementById('ID_pointDeVente').value);
		}
	else
		{
		return false;
		}
	}
function actualiserAffichageSelonDateEtLieu()
	{
	sortie=1;
	date = an+'-'+document.getElementById('mois').value+'-'+document.getElementById('jour').value;
	lieu = document.getElementById('ID_pointDeVente').value;
	taille = document.getElementById('radioTaille').value;
	if(lieu.substr(0,3)=='LIV')
		{
		lieu='LIV';
		}
		
	//enregistrer les choix pour les réafficher
	
	document.location.href="reserver-ingredients.php?dateReservation="+date+"&ID_pointDeVente="+lieu+"&ID_formule=<?php echo $formule->ID;?>&taille="+taille+"&ID_menuFavori=<?php echo $favori->ID;?>";
	}
window.onload=function()
	{
	invisible();
	//actualiseJour(<?php echo $annee2; ?>,<?php echo $mois2 ?>,<?php echo $jour2;?>);
	actualiseJour(<?php echo $anSelect; ?>,<?php echo $moisSelect; ?>,<?php echo $jourSelect;?>);
	}
window.onunload = function ()
	{
	if(sortie==0)
		{
		var ok = confirm("Voulez-vous abandonner votre commande Fraish ? \nSi vous cliquez sur 'Ok', votre commande ne sera pas préparée.\nSi vous cliquez sur 'Annuler', vous pourrez accéder à la validation et au paiement de votre commande.");

		if(ok==false)
			{
			//document.location.href = this.document.location.href;
			actualiserAffichageSelonDateEtLieu();
			}
		}
	}
</script>

</head>
<body>
<div id="page">
<a href="espace-client.php">&lt; Retour</a>
<div id="enTete">&nbsp;
</div>
<div id="contenu">
<form method="post" action="/boutique/fr/scripts/valider-reservation.php" onsubmit="javascript:return validerIngredients();">
<h1>Votre espace client</h1>
<?php
$etape=3;
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/Library/bq_etapes.php';
?>
<h3>Votre formule</h3>
<p>Vous avez choisi la formule <strong>"<?php echo $formule->nom;/*?><strong>"<?php echo $formule->getNomFormule();?>"</strong>.<?php */?>"</strong>
<a href="javascript:sortie=1; document.location.href='reserver-formule.php';" class="bouton" style="position:absolute; left:450px; ">Modifier ma formule</a>
</p>

<?php include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/Library/form-taille.php';?> 
<?php //date de réservation?>

<div id="dateReserv" name="dateReserv">
      <p><strong>Commande pour le : </strong>
        <input name="dateReservation" type="hidden" id="dateReservation" size="10" maxlength="10" value="<?php echo  $dateReservation;?>" />
       
		<input type="hidden" readonly="readonly" value="" <? /*if (isset($_POST['dateReservation'])) { echo 'disabled="disabled" style="display:none"'; }*/?>/>
        <input type="hidden" name="ID_menuFavori" value="<?php echo $_GET['ID_menuFavori'];?>" />
		<input id="jourLettre" type="text" readonly="readonly" value="" <? /*if (isset($_POST['dateReservation'])) { echo 'disabled="disabled" style="display:none"'; }*/?>/>
		<select onchange="javascript:actualiserAffichageSelonDateEtLieu();" id="jour" name="jour" <? /*if (isset($_POST['dateReservation'])) { echo 'disabled="disabled" style="display:none"'; }*/?>>
        <?php
		for($i=1; $i<=31; $i++)
			{?>
            <option value="<?php echo $i;?>" <?php if($i == $jourSelect){?>selected="selected"<?php }?>><?php echo $i;?></option>
            <?php
			}
		?>
        </select>
		<select onchange="javascript:actualiserAffichageSelonDateEtLieu();" id="mois" name="mois" <? /*if (isset($_POST['dateReservation'])) { echo 'disabled="disabled" style="display:none"'; }*/?>>
          <option value="01" <?php if($moisSelect==1){?>selected="selected"<?php }?>>Janvier</option>
          <option value="02" <?php if($moisSelect==2){?>selected="selected"<?php }?>>Février</option>
          <option value="03" <?php if($moisSelect==3){?>selected="selected"<?php }?>>Mars</option>
          <option value="04" <?php if($moisSelect==4){?>selected="selected"<?php }?>>Avril</option>
          <option value="05" <?php if($moisSelect==5){?>selected="selected"<?php }?>>Mai</option>
          <option value="06" <?php if($moisSelect==6){?>selected="selected"<?php }?>>Juin</option>
          <option value="07" <?php if($moisSelect==7){?>selected="selected"<?php }?>>Juillet</option>
          <option value="08" <?php if($moisSelect==8){?>selected="selected"<?php }?>>Août</option>
          <option value="09" <?php if($moisSelect==9){?>selected="selected"<?php }?>>Septembre</option>
          <option value="10" <?php if($moisSelect==10){?>selected="selected"<?php }?>>Octobre</option>
          <option value="11" <?php if($moisSelect==11){?>selected="selected"<?php }?>>Novembre</option>
          <option value="12" <?php if($moisSelect==12){?>selected="selected"<?php }?>>Décembre</option>
        </select>
        <a href="javascript:afficheCalendrier()" <? /*if (isset($_POST['dateReservation'])) { echo 'disabled="disabled" style="display:none"'; }*/?>><img src="../../images/calendrier.gif" alt="calendrier" title="calendrier" /></a></p>
	  <script>tableau(<?php echo $mois2; ?>,<?php echo $annee2; ?>);</script>
      <div id="calendrier" class="conteneur calendrier" style="width:260px;background-color:#FFFFFF;">
      <table class="tab_calendrier" align="center">
             <tr><td class="titre_calendrier" colspan="7" width="100%"><a id="link_precedent" href="#calendrier"><img src="../../images/previous.png"></a> <a id="link_suivant" href="#calendrier"><img src="../../images/next.png"></a> <span id="titre"></span> </td></tr>
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
    </div>

<?php //point de vente ?>
<p><strong>Menu &agrave; retirer &agrave; :</strong>
<select name="ID_pointDeVente" id="ID_pointDeVente" onchange="javascript:actualiserAffichageSelonDateEtLieu();">
	<option value="">S&eacute;lectionnez un point de vente</option><?php
	//IF client peut bénéficier d'une livraison
	if($client->codeEntreprise && Tbq_entreprise::codeEntrepriseExiste($client->codeEntreprise))
	  	{?>
		<option value="LIV#<?php echo $ptLivraison->ID;?>" <?php
		if($favori->ID_pointLivraison > 0 || substr($ID_pointDeVente,0,3)=='LIV')
			{
			echo 'selected="selected"';
			}
        ?>><?php echo $ptLivraison->nom;?> (+ 0,90 &euro;)</option><?php
		}//FIN IF client peut bénéficier d'une livraison?>
        
	  <?php 
	  foreach ($pointsDeVente as $point) 
	  	{ ?>
      	<option value="<?php echo $point->ID;?>" <?php 
		if (($favori->ID_pointDeVente==$point->ID && !$favori->ID_pointLivraison)||($point->ID==$ID_pointDeVente&&!$favori->ID_pointLivraison)) 
			{ 
			echo 'selected="selected"'; 
			} 
		if($point->ID==2)//Filatiers
			{
			echo ' disabled="disabled"';
			}?>><?php echo $point->pointDeVente;?></option><?php 
		}?>
      </select></p>

<?php
if($formule->aLePlatEnOption('salade'))
	{
	$lib_option = 'ou salade';
	}
if($formule->aLePlatEnOption('soupe'))
	{
	$lib_option .= ' ou soupe';
	}
if($formule->aLePlatEnOption('boisson'))
	{
	$lib_option .= ' ou boisson';
	}
if($formule->aLePlatEnOption('dessert'))
	{
	$lib_option .= ' ou dessert';
	}
?>
<input type="hidden" name="obligatoire" value="radioTaille-La taille de votre menu|menuOU-Choisissez l'option <?php echo $lib_option;?> de votre formule" />
<input type="hidden" name="ID_formule" value="<?php echo $formule->ID;?>" />
<?php
// Salade
if($formule->aLePlat('salade'))
	{?>
	<div class="ajusteur">&nbsp;</div>
	<h3 style="display:inline;">Salade</h3><?php
	include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/Library/form-salade.php';?>	
    <div id="tableauSalades3">
      <p class="ssTitre">Vinaigrette</p>
      <div id="huit"><?php
        include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/Library/form-vinaigrette.php';?>
      </div>
    </div><?php
	}
	

if($formule->aLePlatEnOption('salade'))
	{?>
    <div class="ajusteur"></div>
    <input type="radio" name="menuOU" value="salade" onclick="javascript:alternerAffichage('salade');" <?php
	if($favori->salade)
		{
		echo 'checked="checked"';
		}?>/>
    <div id="menuOptionsalade" style="display:inline; font-weight:bold;">Formule avec option Salade</div>
	<div id="masque-salade" <?php
	if(!$favori->salade)
		{?>
		style="display:none; visibility:hidden;"<?php
		}?>><?php
	include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/Library/form-salade.php';?> 
        <div id="tableauSalades3">
          <p class="ssTitre">Vinaigrette</p>
          <div id="huit"><?php
            include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/Library/form-vinaigrette.php';?>
          </div>
        </div>
    </div>
	<?php 
	}
	
// Soupe
if($formule->aLePlat('soupe'))
	{?>
    <div class="ajusteur"></div>
    <h3 style="display:inline;">Soupe</h3><?php
    include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/Library/form-soupe.php';?>	
    <div class="ajusteur">&nbsp;</div><?php
	}
if($formule->aLePlatEnOption('soupe'))
	{?>
    <div class="ajusteur"></div>
    <input type="radio" name="menuOU" value="soupe" onclick="javascript:alternerAffichage('soupe');" <?php
	if($favori->soupe)
		{
		echo 'checked="checked"';
		}?>/>
    <div id="menuOptionsoupe" style="display:inline; font-weight:bold;">Formule avec option Soupe</div>
	<div id="masque-soupe" <?php
	if(!$favori->soupe)
		{?>
        style="display:none; visibility:hidden;"<?php
		}?>><?php
	include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/Library/form-soupe.php';?>
    </div><?php
	}
	
// Boisson
if($formule->aLePlat('boisson'))
	{?>
    <div class="ajusteur"></div>
	<h3>Boisson</h3>
    <?php
    include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/Library/form-boisson.php';?>      
	  <?php
	}
if($formule->aLePlatEnOption('boisson'))
	{?>
    <div class="ajusteur"></div>
    <input type="radio" name="menuOU" value="boisson" onclick="javascript:alternerAffichage('boisson');" <?php
	if($favori->boisson)
		{
		echo 'checked="checked"';
		}?>/>
    <div id="menuOptionboisson" style="display:inline; font-weight:bold;">Formule avec option Boisson</div>
	<?php /*?><h3 style="display:inline; text-align:left;">Boisson</h3><?php */?>
    <div id="masque-boisson" <?php
	if(!$favori->boisson)
		{?>
        style="display:none; visibility:hidden;"<?php
		}?>>
	<div class="ajusteur"></div><?php
	include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/Library/form-boisson.php';?>
    </div><?php
	}
	
// Dessert
if($formule->aLePlat('dessert'))
	{?>
    <div class="ajusteur"></div>
    <div id="dessert">
	<h3>Dessert</h3>
    <?php
	$modeSupplement = false;
	include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/Library/form-dessert.php';?>
    </div><?php
	}
	
// Pain
if($formule->aLePlat('pain'))
	{?>
    <div class="ajusteur"></div>
	<h3>Pain</h3>
	<?php
	include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/Library/form-pain.php';
	}
	
// Eau
if($formule->aLePlat('eau'))
	{?>
    <div class="ajusteur"></div>
	<h3>Eau</h3>
    <?php
	include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/Library/form-eau.php';
	}
?>
<div class="ajusteur"></div>
<?php 
/***************/
/* SUPPLEMENTS */
/***************/

?>
<h3>Suppl&eacute;ment(s)</h3>
<a href="javascript:lsjs_afficherCalque('supplements');">Pain, eau, dessert ou jus de fruit suppl&eacute;mentaire ? Cliquez-ici !</a>
<div id="supplements" style="float:left; display:none;">

<strong>Pain</strong> (+0,60 &euro;) : 
<table><?php
$tabPains = array(0=>'Pain cereales',1=>'Pain figues',2=>'Pain raisins/noisettes',3=>'Pain noix',4=>'Pain lardons',5=>'Pain fromage');
$i=0;
foreach($tabPains as $pain)
	{?>
    <tr>
		<td style="width:170px;"><?php echo $pain;?></td>
        <td><input type="hidden" name="sup[<?php echo $i;?>][nom]" value="<?php echo $pain;?>" />
        <input type="hidden" name="sup[<?php echo $i;?>][prix]" value="0.6" /></td>
    	<td>quantit&eacute; <input type="text" name="sup[<?php echo $i;?>][qte]" value="0" class="inputQte"/></td>
    </tr>
	<?php 
	$i++;
	}?>
</table>
<p>&nbsp;</p>
<table>
<tr>
<td style="width:170px;">
<strong>Bouteille d'eau 50cl</strong> (+ 1,60 &euro;)</td>
<td><input type="hidden" name="sup[<?php echo $i;?>][nom]" value="bouteille eau" />
<input type="hidden" name="sup[<?php echo $i;?>][prix]" value="1.6" /></td>
<td>quantit&eacute; <input type="text" name="sup[<?php echo $i;?>][qte]" value="0" class="inputQte" /></td>
</tr>
</table>
<p>&nbsp;<strong>Dessert</strong> (+2,60 &euro;)</p><?php
$modeSupplement = true;
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/Library/form-dessert.php';?>
<p>&nbsp;</p>
<?php /*?><strong>Les boisson = jus de fruit, smoothies, dairy smoothies</strong><br />(le prix varie selon la taille) :<br /><?php */?>
<strong>Jus de fruit</strong>
<table>
<?php
$i++;

$tabJus = array('ENERGY','TROPIK','SLIM','ANTIOXY','KIPIK','SUNNY','KAROTEN','PROTECT');
foreach($tabJus as $itemJus)
	{?>
      <tr>
          <td><input type="hidden" name="sup[<?php echo $i;?>][nom]" value="<?php echo $itemJus;?>" /><?php
              echo $itemJus;?>
          </td>
          <td>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;quantit&eacute; <input type="text" name="sup[<?php echo $i;?>][qte]" value="0" class="inputQte" />
          </td>
          <td>
          &nbsp;&nbsp;&nbsp;Taille 
          <select name="sup[<?php echo $i;?>][prix]">
              <option value="4.5|Grand">Grand - 4,50 &euro;</option>
              <option value="4.1|Moyen">Moyen - 4,10 &euro;</option>
              <option value="3.9|Petit">Petit - 3,90 &euro;</option>
          </select>
          </td>
      </tr><?php
	$i++;
	}?>
</table>
</div>
<p>&nbsp;</p>
<p>&nbsp;</p>
<div class="ajusteur"></div>
<div style="margin-left:200px;"><a href="javascript:;" onclick="afficherCommentaire();">Un commentaire sur votre commande ? Cliquez-ici</a><br><textarea name="commentaire" id="commentaire" cols="40" rows="5" style="display:none;border:solid 1px #000000;margin:5px; font-size:11px"></textarea></div>
<div class="ajusteur">&nbsp;</div>
<p>&nbsp;</p>

<?php include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/Library/form-sondage.php';?>

<input type="submit" value="Etape suivante &gt;" class="bouton" style="background-color:#76BD48;" />
</form>
<p>&nbsp;</p>
<script type="text/javascript">
lsjs_actualiseSelectDate('<? echo $dateReservation; ?>');
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
</div>
</div>
</body>
</html>