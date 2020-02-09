<?
header("Expires: 0"); 
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache");
header("Cache-Control: post-check=0,pre-check=0");
header("Cache-Control: max-age=0");
header("Pragma: no-cache");

include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/classes.inc.php';
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/includes/classes/paquetage.inc.php';

T_LAETIS_site::initialiserSession();
Tbq_user::estConnecte();

$sondage = new Tbq_sondage($_GET['ID_sondage']);
if($_POST['fonction']=='valider')
	{
	$sondage->enregistrer($_POST);
	header('Location:sondage-lister.php');
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/bq_admin_boutique.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->

<title>Mon espace d'administration e-boutique</title>
<!-- InstanceEndEditable -->
<meta name="description" content="Espace d'administration de votre boutique" />
<meta name="keywords" content="espace, administration, boutique" />
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />
<link rel="icon" type="image/x-icon" href="/favicon.ico" />
<link href="/boutique/includes/styles/bq_admin-boutique.css" rel="stylesheet" type="text/css" />
<script src="/boutique/includes/javascript/bq_admin-boutique.js" type="text/javascript"></script>
<script src="/includes/javascript/formulaire.js" type="text/javascript"></script>
<!-- InstanceBeginEditable name="head" -->
<style type="text/css">
input[type="text"]
	{
	width:500px;
	}
</style>
<?php
$sondage = new Tbq_sondage($_GET['ID_sondage']);

if($_POST['valider'])
	{
	$sondage->enregistrer($_POST);
	header('Location:sondage-lister.php');
	}?><!-- InstanceEndEditable -->
</head>
<body id="hautPage">
<div id="page">
  <div id="enTete"><a href="/boutique/admin/accueil.php" title="Retourner à l'accueil de l'espace d'administration">Accueil</a><img src="/boutique/images/bandeau-boutique.jpg" alt="" width="750" height="135" /></div>
  <!-- Colonne Boutique -->
  <div id="divAdmin">
    <!-- Menu Boutique -->
    <div id="menuAdmin">
      <ul>
        <li><a href="/boutique/admin/commande-jour.php" title="Les reservations du jour">&gt; R&eacute;servations jour</a></li>
        <li><a href="/boutique/admin/commande-lister.php" title="Les commandes">&gt; Les r&eacute;servations</a></li>
        <li><a href="/boutique/admin/cb-lister.php" title="Les paiements CB">&gt; Les paiements CB</a></li>
        <li><a href="/boutique/admin/ingredients-lister.php" title="Les ingrédients">&gt; Les ingr&eacute;dients</a></li>
        <li><a href="/boutique/admin/menu-jour.php" title="Le menu du jour">&gt; Le menu du jour</a></li>
        <li><a href="/boutique/admin/client-lister.php" title="Les clients">&gt; Les clients</a></li>
        <li><a href="/boutique/admin/entreprises-lister.php" title="Les entreprises">&gt; Les entreprises</a></li>
        <li><a href="/boutique/admin/points-livraison-lister.php" title="Les points de livraison">&gt; Les points livraison</a></li>
        <li><a href="/boutique/admin/sondage-lister.php" title="Les sondages">&gt; Les sondages</a></li>
        <?php /*?><li><a href="/boutique/admin/questionnaire-lister.php" title="Le questionnaire">&gt; Le questionnaire</a></li><?php */?>
        <li><a href="/boutique/admin/statistiques.php" title="Les statistiques">&gt; Les statistiques</a></li>
        <li><a href="/boutique/admin/astuces.php" title="Astuces de Sophie">&gt; Astuces de Sophie</a></li>
      </ul>
    </div>
    <!-- Fin Menu Boutique -->
  </div>
  <!-- Fin Colonne Boutique -->
  <div id="contenu"> <!-- InstanceBeginEditable name="contenu" -->
    <h1>Les sondages</h1>
    <h2>Question de sondage<br /><?php echo $sondage->question;?></h2>
    <form method="post" action="" onsubmit="return lsjs_verifierFormulaire2(this);">
    <input type="hidden" name="ID" value="<?php echo $sondage->ID;?>" />
    <input type="hidden" name="fonction" value="valider" />
    <input type="hidden" name="obligatoire" value="question-La question|reponse1-La premi&egrave;re r&eacute;ponse|reponse2-La deuxi&egrave;me r&eacute;ponse" />
    <table>
    	<tr>
        	<td><label>Question :</label></td>
            <td><input type="text" name="question" value="<?php echo $sondage->question;?>" /></td>
        </tr>
        <tr>
        	<td><label>R&eacute;ponse 1 :</label></td>
            <td><input type="text" name="reponse1" value="<?php echo $sondage->reponse1;?>" /></td>
        </tr>
        <tr>
        	<td><label>R&eacute;ponse 2 :</label></td>
            <td><input type="text" name="reponse2" value="<?php echo $sondage->reponse2;?>" /></td>
        </tr>
        <tr>
        	<td><label>R&eacute;ponse 3 :</label></td>
            <td><input type="text" name="reponse3" value="<?php echo $sondage->reponse3;?>" /></td>
        </tr>
        <tr>
        	<td><label>Etat :</label></td>
            <td>
            <select name="actif">
            	<option value="1" <?php 
				if($sondage->actif==1)
					{
					echo 'selected="selected"';
					}?>>Activ&eacute;</option>
                <option value="0" <?php 
				if($sondage->actif==0)
					{
					echo 'selected="selected"';
					}?>>D&eacute;sactiv&eacute;</option>
            </select>
            </td>
        </tr>
    </table>
    <p>
        <input type="submit" name="Submit" value="Sauver" class="bouton" />
     </p>
     <p>&nbsp;</p>
     <p><a href="sondage-lister.php" title="Retour &agrave; la liste des questions de sondage">&lt; Retour &agrave; la liste des questions de sondage</a></p>
     <p>&nbsp;</p>
    <p><a href="sondage-resultats.php" title="Voir les r&eacute;sultats des sondages">&gt; Voir les r&eacute;sultats des sondages</a></p>
    </form>
    <!-- InstanceEndEditable --> </div>
  <div class="ajusteur"></div>
</div>
</body>
<!-- InstanceEnd --></html>
