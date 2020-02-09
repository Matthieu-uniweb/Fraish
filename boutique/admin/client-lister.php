<?php
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
<style type="text/css">
ul.listeClient li {
	font-size:12px !important;
	padding:2px 0px !important;
}
</style>
<?php

$client=new Tbq_client();
$listeClient=$client->listerAdmin($_GET);

$commande=new Tbq_commande();
$user = new Tbq_user($_SESSION['sessionID_user']);

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
<h1>Les clients</h1>
    <h2>Liste de vos clients</h2>
    
    <br/><br/>
    <a href="/boutique/admin/client-export.php" title="export">&gt; Exporter la liste de vos clients au format Excel (CSV)</a>
    <br/><br/>
    
    <form name="tri" method="get" action="client-lister.php">
    	<select name="champTri" onchange="document.tri.submit()" style="width:200px;">
        <option value="" selected="selected">Trier par date d'inscription</option>
      	<option value="parNom" <?php if ($_GET['champTri']=='parNom') { echo 'selected="selected"'; } ?>>Trier par nom</option>        
      	<option value="totale" <?php if ($_GET['champTri']=='totale') { echo 'selected="selected"'; } ?>>Commandes totales</option>
        <option value="en_cours" <?php if ($_GET['champTri']=='en_cours') { echo 'selected="selected"'; } ?>>Commandes en cours</option>
        <option value="livree" <?php if ($_GET['champTri']=='livree') { echo 'selected="selected"'; } ?>>Commandes livréees</option>
        <option value="non livree" <?php if ($_GET['champTri']=='non livree') { echo 'selected="selected"'; } ?>>Commandes non livréees</option>
        <option value="abandonnee" <?php if ($_GET['champTri']=='abandonnee') { echo 'selected="selected"'; } ?>>Commandes abandonnées</option>        
      </select>
      <p>&nbsp;</p>
      <h2>Rechercher</h2>
      <input type="text" name="rechNom" value="<?php echo $_GET['rechNom'];?>" />
      <input type="submit" value="OK" />
    </form>
    <br />
	<?php //FE echo  "debug" ; 
	 //print_r($listeClient);
	//exit;?>
	<?php
	
   foreach($listeClient as $clients)
		{
		  
		//$compteFraishCreditsRestants += $clients->soldeCompte;
		//Retiré FE
		$compteFraishCreditsUtilises += Tbq_approvisionnement::getSommeApproSelonClient($clients->ID)-$clients->soldeCompte;
		}
  $compteFraishCreditsRestants = Tbq_approvisionnement::getEncours();?>
  
   <p>
   <strong><?php /*?>Cr&eacute;dits Fraish utilis&eacute;s : <?php echo $compteFraishCreditsUtilises;?>&euro; &nbsp;&nbsp; <?php */?>
   Cr&eacute;dits Fraish restants : <?php echo $compteFraishCreditsRestants;?>&euro;</strong><?php /*?> : point de vente <?php echo $user->pointDeVente;?><?php */?></p>
  <table width="100%" border="0">
  <tr>
    <td><h3>Clients</h3></td>
    <td align="center"><h3>Totales</h3></td>
    <td align="center"><h3>En cours</h3></td>
    <td align="center"><h3>Livrées</h3></td>
    <td align="center"><h3>Non Livr&eacute;es</h3></td>
    <td align="center"><h3>Abandonnées</h3></td>
    <td align="center"><h3>Fiabilit&eacute;</h3></td>    
  </tr>
  <?
  foreach($listeClient as $clients)
		{
		$nomCli = $clients->nomFacturation;
		if($nomCli != '' && strlen($nomCli) > 1)
			{
			$listeCommandes = $commande->listerToutesCommandes($clients->ID, $_SESSION["sessionID_user"]);
			$listeCommandesEnCours = $commande->listerCommandeAdmin($clients->ID, 'en_cours', $_SESSION["sessionID_user"]);
			$listeCommandesLivrees = $commande->listerCommandeAdmin($clients->ID, 'livree', $_SESSION["sessionID_user"]);
			$listeCommandesNonLivrees = $commande->listerCommandeAdmin($clients->ID, 'non livree', $_SESSION["sessionID_user"]);
			$listeCommandesAbandonnees = $commande->listerCommandeAdmin($clients->ID, 'abandonnee', $_SESSION["sessionID_user"]); 
			$tauxFiabilite = $commande->tauxFiabilite($clients->ID, $_SESSION["sessionID_user"]); 
?>			
  <tr>
    <td><a href="client-detail.php?ID_client=<?php echo $clients->ID;?>"><?php echo $clients->nomFacturation.' '.$clients->prenomFacturation; ?></a><br />Date d'inscription : <? echo T_LAETIS_site::dateFormatFrancais($clients->dateInscription); ?><br />Login: <strong><? echo $clients->emailFacturation; ?></strong> - Passe: <strong><? echo $clients->motDePasse; ?></strong></td>
    <td align="center"><?php echo number_format(sizeof($listeCommandes), 0, ',', ' '); ?></td>
    <td align="center"><?php echo number_format(sizeof($listeCommandesEnCours), 0, ',', ' '); ?></td>
    <td align="center"><?php echo number_format(sizeof($listeCommandesLivrees), 0, ',', ' '); ?></td>
    <td align="center"><?php echo number_format(sizeof($listeCommandesNonLivrees), 0, ',', ' '); ?></td>
    <td align="center"><?php echo number_format(sizeof($listeCommandesAbandonnees), 0, ',', ' '); ?></td>
    <td align="center"><?php echo $tauxFiabilite; ?></td>
    <td align="center">&nbsp;</td>
  </tr><?php
   } // FIN if($nomCli != '' && strlen($nomCli) > 1)
	}// FIN foreach($listeClient as $clients)
	?>
</table>  
    <!-- InstanceEndEditable --> </div>
  <div class="ajusteur"></div>
</div>
</body>
<!-- InstanceEnd --></html>
