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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Mon espace d'administration e-boutique</title>
<meta name="description" content="Espace d'administration de votre boutique" />
<meta name="keywords" content="espace, administration, boutique" />
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />
<link rel="icon" type="image/x-icon" href="/favicon.ico" />
<style type="text/css">
body {
	font-family:Arial, Helvetica, sans-serif;
	font-size:10px;
	padding:0px;
	margin:0px;
}
h2 {
	font-size:16px;
}
h3 {
	font-size:12px;
}
.barre {
	text-decoration: line-through;
}
</style>
</head>
<body>
<?php 
$_GET['ordre']="ASC";
$commande = new Tbq_commande();
$commandes = $commande->listerTousesCommandes($_GET);

foreach($commandes as $detailCommande)
	{	
	$client = new Tbq_client($detailCommande['ID_client']);

	$jus[] = $detailCommande['boissonStat'];
	$nom[] = $client->nomFacturation; 
	$prenom[] = $client->prenomFacturation;     
	$numCommande[] = $detailCommande['ID_commande_fraish']; 
	$taille[] = $detailCommande['taille'];           
	$pain[] = $detailCommande['pain']; 
	$ingredient[] = $detailCommande['plat']." <b>".$detailCommande['vinaigrette']."</b>";
	$statut[] = $detailCommande['statut'];
	$boisson[] = $detailCommande['boisson'];
	$boissonStat[] = $detailCommande['boissonStat'];
	$commentaire[] = $detailCommande['commentaire'];
	}
?>
<table width="100%" border="0" cellpadding="10" cellspacing="0">
  <tr>
    <td colspan="7"><h2><?php echo "Commandes FRAISH'Menu du ".T_LAETIS_site::dateEnFrancais($_GET['dateSeuleInsertion']); ?></h2></td>
  </tr>
  <tr>
    <td><h3>Jus</h3></td>
    <td><h3>Nom</h3></td>
    <td><h3>Pr&eacute;nom</h3></td>
    <td align="center" nowrap="nowrap"><h3>N&deg; Com.</h3></td>
    <td><h3>Taille</h3></td>
    <td><h3>Pain</h3></td>
    <td><h3>Ingr&eacute;dients</h3></td>
  </tr>
  <?php
  if (isset($nom)){
	  
 
for ($i=0; $i<count($nom); $i++)
	{ 
	$classe='';
	if ($statut[$i]=='abandonnee')
		{ $classe = 'class="barre"'; }
	?>
  <tr>
    <td><?php echo $jus[$i]; ?></td>
    <td <?php echo $classe; ?>><?php echo $nom[$i]; ?></td>
    <td <?php echo $classe; ?>><?php echo $prenom[$i]; ?></td>
    <td align="center"><?php echo $numCommande[$i]; ?></td>
    <td><?php echo $taille[$i]; ?></td>
    <td><?php echo $pain[$i]; ?></td>
    <td><?php echo $ingredient[$i]; ?><?php 
	if ( ($boissonStat[$i]=='MY JUICE') || ($boissonStat[$i]=='MY SMOOTHIE') || ($boissonStat[$i]=='MY DAIRY') )
	{ echo "<br>".str_replace('- 3 ingrédients au choix -', '', $boisson[$i]); }?>
	<?php if ($commentaire[$i]) { echo "<br>Commentaire: ".nl2br($commentaire[$i]); } ?></td>
  </tr>
	<?php }  }?>
</table>
<br /><br /><br />
<?php
$stats = $commande->listerStatsBoissonsCommandes($_GET);
?>
<table width="15%" border="0" cellpadding="10" cellspacing="0">
  <tr>
    <td><h3>Jus / Smoothie</h3></td>    
    <td><h3>Moyen</h3></td>
    <td><h3>Grand</h3></td>
  </tr>
<?php
if ($stats)
	{
while(list($boisson) = each($stats)) 
	{ 
	?>
  <tr>
    <td><?php echo $boisson; ?></td>
    <td><?php if (isset($stats[$boisson]['Moyen'])) echo $stats[$boisson]['Moyen']; ?></td>
    <td><?php  if (isset($stats[$boisson]['Grand'])) echo $stats[$boisson]['Grand']; ?></td>
  </tr>
<?php } 
	} // FIN if ($stats) ?>  
</table>
</body>
</html>
