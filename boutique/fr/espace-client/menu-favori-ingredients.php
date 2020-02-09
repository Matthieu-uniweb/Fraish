<?
session_start();

if (! $_SESSION['ID_client'])
	{ header("Location: ../login.php"); }
	
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/classes.inc.php';
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/includes/classes/paquetage.inc.php';

$client = new Tbq_client($_SESSION['ID_client']);
$commande = new Tbq_commande();

$favori = new Tbq_client_favori($_REQUEST['ID_menuFavori']);
$plat = explode(', ', $favori->plat);

if($favori->ID_menu)//IF modification du menu favori
	{
	$_GET['ID_menu'] = $favori->ID_menu;
	}//FIN IF modification du menu favori
	
$menu = new Tbq_menu($favori->ID_menu);

$formule=$menu->ID_typ_formule;//positionne la formule, soit on la charge, soit modif par GET
if(!$menu->ID_typ_formule)
	{
	$formule = $_GET['ID_formule'];
	}
$formule = new Tbq_formule($formule);


$platJour = new Tbq_menuJour();
$pointDeVente = new Tbq_user();
$pointsDeVente = $pointDeVente->lister();
$platsEnOption = $formule->getPlatsEnOption();
$modeFavori = true;
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
<script src="/boutique/includes/javascript/reserver.js" type="text/javascript"></script>
<script type="text/javascript" src="/includes/javascript/formulaire.js"></script>
<script type="text/javascript">
<!--//
function alternerAffichage(div1)
	{
	if(div1 == '<?php echo $platsEnOption[0];?>')
		{
		var div2 = '<?php echo $platsEnOption[1];?>';
		}
	else
		{
		var div2 = '<?php echo $platsEnOption[0]?>';
		}

	//activer salade
	document.getElementById('masque-'+div1).style.display = 'block';
	document.getElementById('masque-'+div1).style.visibility = '';
	//desactiver soupe
	document.getElementById('masque-'+div2).style.display = 'none';
	document.getElementById('masque-'+div2).style.visibility = 'hidden';	
	}

//-->
</script>

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
<?php
/*if($formule->aLePlatEnOption('salade'))
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
	}*/?>
<form method="post" action="/boutique/fr/scripts/valider-menu-favori.php" onsubmit="javascript:return lsjs_verifierFormulaire2(this);">
<input type="hidden" name="ID_formule" value="<?php echo $formule->ID;?>" />
<input type="hidden" name="ID_menu" value="<?php echo $menu->ID;?>" />

<input type="hidden" name="obligatoire" value="ID_pointDeVente-Le point de retrait|radioTaille-La taille de votre menu|menuOU-Choisissez l'option <?php echo $lib_option;?> de votre formule" />

<h1>Votre espace client</h1>
<h3>Choissisez votre point de retrait favori</h3>
<p>
      <select name="ID_pointDeVente" id="ID_pointDeVente">
	  <option value=""></option><?php 
	  
	  //IF client peut bénéficier d'une livraison
	  if($client->codeEntreprise && Tbq_entreprise::codeEntrepriseExiste($client->codeEntreprise))
	  	{
		$entreprise = new Tbq_entreprise();
		$entreprise->initialiserParCodeEntreprise($client->codeEntreprise);
		$ptLivraison = new Tbq_pointLivraison($entreprise->ID_pointLivraison);?>
		<option value="LIV#<?php echo $ptLivraison->ID;?>" <?php
        if($favori->ID_pointLivraison > 0 )
			{
			echo 'selected="selected"';
			}?>><?php echo $ptLivraison->nom;?> (+0.90&euro;)</option><?php
		}
	  //FIN IF client peut bénéficier d'une livraison
	  
	  foreach ($pointsDeVente as $point) 
	  	{ ?>
      	<option value="<?php echo $point->ID;?>" <?php if ($favori->ID_pointDeVente==$point->ID && !$favori->ID_pointLivraison) { echo 'selected="selected"'; } ?>><?php echo $point->pointDeVente;?></option><?php 
		} ?>
      </select>
      </p> 
<p>&nbsp;</p>
<h3>Votre formule favorite</h3>
<p>Vous avez choisi la formule <strong>"<?php echo $formule->nom;?>"</strong>.
<a href="menu-favori-formule.php" class="bouton" style="width:200px;">Choisir une formule favorite</a></p>


<?php 
// Salade
if($formule->aLePlat('salade'))
	{?>
	<div class="ajusteur">&nbsp;</div>
    <h3>Salade favorite</h3><?php
	include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/Library/form-salade.php';?> 
    
    <div id="tableauSalades3">
      <p class="ssTitre">Vinaigrette favorite</p>
      <div id="huit">
        <?php
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
		}
	?>/>
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
    <h3>Soupe favorite</h3><?php
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
	<h3>Boisson favorite</h3><?php 
	include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/Library/form-boisson.php';
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
    <div id="masque-boisson" <?php
	if(!$favori->boisson)
		{?> style="display:none; visibility:hidden;"<?php
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
	<h3>Dessert favori</h3>
    <?php
	include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/Library/form-dessert.php';?>
    </div><?php
	}
	
// Pain
if($formule->aLePlat('pain'))
	{?>
    <div class="ajusteur"></div>
	<h3>Pain favori</h3>
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

<?php /*?><h3>Suppl&eacute;ment(s)</h3>
<div id="supplements">
<input type="checkbox" name="supplementPain" value="0.6"/> Pain (+ 0,60&euro;)
, <strong>Type</strong>
<select name="supplement">
	<option></option>
    <option value="Pain cereales,">C&eacute;r&eacute;ales</option>
    <option value="Pain cranberries,">Cranberries</option>
    <option value="Pain raisins/noisettes,">Raisins/Noisettes</option>
    <option value="Pain noix,">Noix</option>
    <option value="Pain lardons,">Lardons</option>
    <option value="Pain chorizo,">Chorizo</option>
</select>
<br />
<input type="checkbox" name="supplementYaourt" value="2.5"/> Yaourt (+ 2,50&euro;)<br />
</div><?php */?>
<div class="ajusteur"></div>
<?php /*?><div style="margin-left:200px;"><a href="javascript:;" onclick="afficherCommentaire();">Un commentaire sur votre commande ? Cliquez-ici</a><br><textarea name="commentaire" id="commentaire" cols="40" rows="5" style="display:none;border:solid 1px #000000;margin:5px; font-size:11px"></textarea></div><?php */?>
<div class="ajusteur">&nbsp;</div>
<p>&nbsp;</p>
<?php include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/Library/form-taille.php';?>
<div class="ajusteur"></div>
<a class="boutonRetour" href="/boutique/fr/espace-client/espace-client.php">&lt;&nbsp;Retour</a>
<input type="submit" value="Enregistrer mes modifications" class="bouton" style="width:250px;"/>
</form>
<p>&nbsp;</p>
<script type="text/javascript">
//lsjs_actualiseSelectDate('<? echo $dateReservation; ?>')
</script>
  <?
if (isset($_POST['dateReservation']) && $favori->ID)
{ 
?>

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
