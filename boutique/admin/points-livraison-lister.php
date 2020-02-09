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
    <h1>Les points de livraison</h1>
    <h2>Liste des points de livraison</h2>
    <?php /*?><form name="tri" method="get" action="points-livraison-lister.php">
      <p>&nbsp;</p>
      <h2>Rechercher</h2>
      <input type="text" name="rechNom" value="<?php echo $_GET['rechNom'];?>" />
      <input type="submit" value="OK" />
    </form><?php */?>
<p>&nbsp;</p>    
<p><a href="point-livraison-detail.php">&gt;&nbsp;Ajouter un point de livraison</a></p>    
<p>&nbsp;</p>
<table width="100%" border="0">
<tr>
  <th align="center"><h3>Nom</h3></th>
  <th align="center"><h3>Adresse</h3></th>
  <th align="center"><h3>Code postal</h3></th>
  <th align="center"><h3>Ville</h3></th>
  <th align="center"><h3>Entreprises</h3></th> 
</tr><?
$listePointsLivraison = Tbq_pointLivraison::lister();
if($listePointsLivraison)
	{
	foreach($listePointsLivraison as $pointLivraison)
		{
		$pointLivraison = new Tbq_pointLivraison($pointLivraison->ID);?>			
		  <tr>
			<td align="center"><a href="point-livraison-detail.php?ID_pointLivraison=<?php echo $pointLivraison->ID;?>"><?php echo $pointLivraison->nom; ?></a></td>
			<td align="center"><?php echo $pointLivraison->adresse1.'<br/>'.$pointLivraison->adresse2; ?></td>
			<td align="center"><?php echo $pointLivraison->codePostal; ?></td>
			<td align="center"><?php echo $pointLivraison->ville; ?></td>
			<td align="center"><?php echo sizeof($pointLivraison->getEntreprisesSelonPointLivraison()); ?> entreprises</td>
		  </tr><?php
		}// FIN foreach($listeClient as $clients)
	}
	?>
</table>  
    <!-- InstanceEndEditable --> </div>
  <div class="ajusteur"></div>
</div>
</body>
<!-- InstanceEnd --></html>
