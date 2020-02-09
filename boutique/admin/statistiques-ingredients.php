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
<?
$stats=new Tbq_client_specifique();
$preferences=$stats->statsPreferences($_SESSION["sessionID_user"]);

$commande=new Tbq_commande();

$statsParIngredientsAime = array_count_values($preferences['aime']);
$statsParIngredientsMoyen = array_count_values($preferences['moyen']);
$statsParIngredientsDeteste = array_count_values($preferences['deteste']);
?>
<!-- InstanceEndEditable -->
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
<h1>Les statistiques sur les ingrédients</h1>
    <p>Statistiques basées sur <?php echo $stats->nbClientsInterroges($_SESSION["sessionID_user"]); ?> clients<br />
      <br />
    </p>
    <table width="70%" border="0">
  <tr>
    <td><h3>Ingrédients</h3></td>
    <td align="center"><h3>Aime</h3></td>
    <td align="center"><h3>Moyen</h3></td>
    <td align="center"><h3>Déteste</h3></td>
  </tr>    
    <?php
		foreach($commande->ingredients as $ingred)
			{ 
			$tous = $statsParIngredientsAime[$ingred]+$statsParIngredientsMoyen[$ingred]+$statsParIngredientsDeteste[$ingred];
			?>
  <tr>
    <td><strong><?php echo $ingred; ?></strong></td>
    <td align="center"><strong><?php echo $statsParIngredientsAime[$ingred]; ?></strong><br />
		<?php if ($statsParIngredientsAime[$ingred] && $tous) { echo ' ('.number_format($statsParIngredientsAime[$ingred]/$tous*100,'0',',','').'%)'; } ?></td>
    <td align="center"><strong><?php echo $statsParIngredientsMoyen[$ingred]; ?></strong><br />
		<?php if ($statsParIngredientsMoyen[$ingred] && $tous) { echo ' ('.number_format($statsParIngredientsMoyen[$ingred]/$tous*100,'0',',','').'%)'; } ?></td>
    <td align="center"><strong><?php echo $statsParIngredientsDeteste[$ingred]; ?></strong><br />
		<?php if ($statsParIngredientsDeteste[$ingred] && $tous) { echo ' ('.number_format($statsParIngredientsDeteste[$ingred]/$tous*100,'0',',','').'%)'; } ?></td>
  </tr>
  <?php } ?>
</table>
    <!-- InstanceEndEditable --> </div>
  <div class="ajusteur"></div>
</div>
</body>
<!-- InstanceEnd --></html>
