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
if (empty($_GET))
	{ $_GET['mois']=date("m"); }
$commandes = new Tbq_commande();
// Liste des commandes

//fixation des variables
$_GET['statut']="livree";


$resultats = $commandes->listerTousesCommandes($_GET);
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
   <h1>Les commandes</h1>
     <p>&nbsp;</p>
    <p align="center">Mois de la commande:<br /><?php
	$mois = array("","janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août", "septembre", "octobre", "novembre", "décembre");
	$i=1;
	while( ($i<count($mois)) && ($i<=date("m")) )
		{
		?>| <a href="cb-lister.php?mois=<?php echo $i; ?>"><b><?php echo $mois[$i]; ?></b></a> | - <?php
		$i++;
		} ?></p>
      <p>&nbsp;</p>
    <div class="ajusteur"></div>
    <p>&nbsp;</p>

      <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tbody>
          <tr>
            <th style="width:75px">N&deg; <br />
              commande</th>
            <th style="width:150px">Client</th>
            <th style="width:100px">Date de r&eacute;servation</th>
            <th style="width:100px">Statut</th>
            <th style="width:50px;">Paiement</th>
            <th style="width:100px">Montant</th>
          </tr>
        </tbody>
        <?
if (! $resultats)
	{
	?>
        <tr>
          <td colspan="6" align="center" class="infos"><< Aucune commande >></td>
        </tr>
        <?
	}
else
	{
foreach($resultats as $commande)
	{
	$client = new Tbq_client($commande['ID_client']);
	if ($commande['ID_typ_paiement']==1)
	{
	?>
        <tbody>
          <tr>
            <td><a href="commande-detail.php?ID_commande=<? echo $commande['ID']; ?>" target="_blank">n&deg;<? echo $commande['ID_commande_fraish']; ?></a></td>
            <td><a href="client-detail.php?ID_client=<? echo $client->ID;?>"><? echo $client->nomFacturation.' '.$client->prenomFacturation; ?></a></td>
            <td><? echo T_LAETIS_site::dateFormatFrancais($commande['dateReservation']); ?></td>
            <td><? echo $commande['statut']; ?></td>
            <td><?php echo Tbq_commande::getLabelTypePaiement($commande['ID']);?></td>
            <td><?php echo $commande['prix']?> €</td>

          </tr>
        </tbody>
        <?
	}
	} // FIN foreach($resultats as $commande)
	} // FIN else
?>
      </table>
      <br /> <br />
       <h1>Les approvisionnements</h1>

    <table width="100%" border="0" cellpadding="0" cellspacing="0">

          <tr>
            <th style="width:150px">Client</th>
            <th style="width:100px">Date d'approvisionnement</th>
            <th style="width:100px">Montant</th>
          </tr>



   <?php
   $appro = new Tbq_approvisionnement();
   $appros = $appro->listerAllCB($_GET);
   var_dump($appros);die;
   foreach($appros as $app){

	$client = new Tbq_client($app->ID_client);

	?>

          <tr>
            <td><a href="client-detail.php?ID_client=<? echo $client->ID;?>"><? echo $client->nomFacturation.' '.$client->prenomFacturation; ?></a></td>
            <td><? echo T_LAETIS_site::dateFormatFrancais($app->date); ?></td>
          	<td><? echo $app->montant;?> €</td>
          </tr>

	<?

   }
   ?>
   </table>

    <!-- InstanceEndEditable --> </div>
  <div class="ajusteur"></div>
</div>
</body>
</html>
