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

$entreprise = new Tbq_entreprise($_GET['ID_entreprise']);
$listePointsLivraison = Tbq_pointLivraison::lister();

switch($_POST['fonction'])
	{
	case 'valider':
		$entreprise->enregistrer($_POST);
		break;
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
<!-- InstanceBeginEditable name="head" --><!-- InstanceEndEditable -->
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
    <h1>Les entreprises</h1>
    <h2>D&eacute;tail</h2>
    <p>&nbsp;</p>
    <a href="entreprises-lister.php">&lt; Retour &agrave; la liste des entreprises</a>
    <p>&nbsp;</p>
    <form method="post" action="" onsubmit="javascript:return lsjs_verifierFormulaire2(this);">
    	<input type="hidden" name="fonction" value="valider" />
        <input type="hidden" name="obligatoire" value="code-Le code de l'entreprise" />
        <table>
        	<tr>
            	<td>Code entreprise* : </td>
                <td><input type="text" name="code" value="<?php echo $entreprise->code;?>" />
            </tr>
            <tr>
            	<td>Nom de l'entreprise : </td>
                <td><input type="text" name="nom" value="<?php echo $entreprise->nom;?>" /></td>
            </tr>
           	<tr>
            	<td>Adresse (ligne1) : </td>
                <td><input type="text" name="adresse1" value="<?php echo $entreprise->adresse1;?>" />
            </tr>
            <tr>
            	<td>Adresse (ligne 2) : </td>
                <td><input type="text" name="adresse2" value="<?php echo $entreprise->adresse2;?>" />
            </tr>
            <tr>
            	<td>Code postal : </td>
                <td><input type="text" name="codePostal" value="<?php echo $entreprise->codePostal;?>" /></td>
            </tr>
            <tr>
            	<td>Ville : </td>
                <td><input type="text" name="ville" value="<?php echo $entreprise->ville;?>" /></td>
            </tr>
            <tr>
            	<td>Point de livraison : </td>
                <td><?php
				if($listePointsLivraison)
					{?>
                    <select name="ID_pointLivraison">
						<option>&nbsp;</option><?php
					foreach($listePointsLivraison as $ptLivraison)
						{?>
						<option value="<?php echo $ptLivraison->ID;?>" <?php
                        if($ptLivraison->ID == $entreprise->ID_pointLivraison)
							{
							echo 'selected="selected"';
							}?>><?php echo $ptLivraison->nom;?></option><?php
						}?>
                    </select><?php
					}
                ?></td>
            </tr>
            <tr>
            	<td>&nbsp;</td>
                <td><input type="submit" class="bouton" value="Sauver" />
            </tr>
        </table>
    </form>
    <!-- InstanceEndEditable --> </div>
  <div class="ajusteur"></div>
</div>
</body>
<!-- InstanceEnd --></html>
