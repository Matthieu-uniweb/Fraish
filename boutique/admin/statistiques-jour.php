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

//$date = date('Y-m-d');
if($_GET['date'])
	{
	$date = T_LAETIS_site::convertirDate($_GET['date']);
	}
else
	{
	$date = date('Y-m-d');
	}
$dateFR = T_LAETIS_site::convertirDate($date);
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
    <h1>Les statistiques sur le CA</h1>
    <h2>Les r&eacute;sultats journaliers du <?php echo T_LAETIS_site::convertirDate($date);?></h2>
    <p>Les statistiques ci-dessous sont &eacute;tablies &agrave; partir des commandes &agrave; l'&eacute;tat "livr&eacute;e".</p>
    <p>&nbsp;</p>
    <form action="" method="get">
    <p>Veuillez saisir une date : 
    <input type="text" name="date" value="" />
    <input type="submit" value="OK" />
    </p>
    </form>
    <p>&nbsp;</p>
    <h3>Ticket de caisse</h3>
    <table>
    	<tr>
        	<td colspan="2">Cr&eacute;dit FRAISH</td>
        </tr>
        <tr>
        	<td><strong>Total approvisionnement valid&eacute; le <?php echo $dateFR;?></strong></td>
            <td align="right"><?php 
			$totalValide = Tbq_approvisionnement::getSommeApproSelonDate($date);
			echo $totalValide;?> &euro;</td>
        </tr>
        <tr>
        	<td>Dont CB</td>
            <td align="right"><?php echo Tbq_approvisionnement::getSommeApproSelonTypeEtDate(1,$date);?> &euro;</td>
        </tr>
        <tr>
        	<td>Dont TR</td>
            <td align="right"><?php echo Tbq_approvisionnement::getSommeApproSelonTypeEtDate(3,$date);?> &euro;</td>
        </tr>
        <tr>
        	<td>Dont Ch&egrave;ques</td>
            <td align="right"><?php echo Tbq_approvisionnement::getSommeApproSelonTypeEtDate(2,$date);?> &euro;</td>
        </tr>
        <tr>
        	<td>Dont Esp&egrave;ces</td>
            <td align="right"><?php echo Tbq_approvisionnement::getSommeApproSelonTypeEtDate(4,$date);?> &euro;</td>
        </tr>
        <tr>
        	<td>Dont Appro offert par Fraish</td>
            <td align="right"><?php 
			$sommeCreditOffert = Tbq_approvisionnement::getSommeApproSelonTypeEtDate(6,$date);
			$sommeCreditOffert += Tbq_approvisionnement::getSommeApproSelonTypeEtDate(8,$date);
			echo $sommeCreditOffert;?> &euro;</td>
        </tr>
        <tr>
        	<td><strong>Total approvisionnement utilis&eacute; le <?php echo $dateFR;?></strong></td>
            <td align="right"><?php 
			$totalUtilise = Tbq_commande::getCASelonTypePaiementEtDate(5,$date);
			echo $totalUtilise;?> &euro;</td>
        </tr>
        <tr>
        	<td>En cours restant pour la journ&eacute;e du <?php echo $dateFR;?></td>
            <td align="right"><?php echo $totalValide - $totalUtilise;?> &euro;</td>
        </tr>
        <tr>
        	<td>En cours restant total</td>
            <td align="right"><?php echo Tbq_approvisionnement::getEnCours();?> &euro;</td>
        </tr>
        <?php /*?><tr>
        	<td>Op&eacute;ration manuelle</td>
            <td>?</td>
        </tr><?php */?>
    </table>
    <h3>D&eacute;tail r&eacute;partition des commandes</h3>
    <table>
    	<tr>
        	<td>Nombre</td>
            <td>Paiement</td>
            <td>Somme</td>
        </tr>
       	<tr>
        	<td><?php echo Tbq_commande::getNbCommandesSelonTypePaiementEtDate(1,$date);?></td>
            <td>CB</td>
            <td align="right"><?php echo Tbq_commande::getCASelonTypePaiementEtDate(1,$date);?> &euro;</td>
        </tr>
        <tr>
        	<td><?php echo Tbq_commande::getNbCommandesSelonTypePaiementEtDate(5,$date);?></td>
            <td>Compte Fraish</td>
            <td align="right"><?php echo Tbq_commande::getCASelonTypePaiementEtDate(5,$date);?> &euro;</td>
        </tr>
        <?php /*?><tr>
        	<td></td>
            <td>TR</td>
            <td></td>
        </tr>
        <tr>
        	<td></td>
            <td>ESP</td>
            <td></td>
        </tr>
        <tr>
        	<td></td>
            <td>CHQ</td>
            <td></td>
        </tr><?php */?>
    </table>
    <h3>Vente comptable</h3>
    <table>
    	<tr>
        	<td>HT</td>
            <td align="right"><?php echo Tbq_commande::getMontantHTSelonDate($date);?> &euro;</td>
        </tr><?php
		
		if($date<'2012-01-01') {//tva 5.5 pour une date inférieur au 1er janvier 2012
		?>
        <tr>
        	<td>TVA (5,5%)</td>
            <td align="right"><?php echo Tbq_commande::getMontantTVASelonDate($date,5.5);?> &euro;</td>
        </tr><?php
		}
		else {//tva 7 à partir du 1er janvier 2012?>
        <tr>
        	<td>TVA (7%)</td>
            <td align="right"><?php echo Tbq_commande::getMontantTVASelonDate($date);?> &euro;</td>
        </tr><?php
		}?>
        
        <tr>
        	<td>TTC</td>
            <td align="right"><?php echo Tbq_commande::getMontantTTCSelonDate($date);?> &euro;</td>
        </tr>
    </table>
    <h3>D&eacute;tail des ventes</h3>
    <table>
    	<tr>
        	<td>Menu</td>
            <td>Moyen</td>
            <td>Grand</td>
        </tr><?php //liste les menus
		$listeMenus = Tbq_menu::listerSaufDoublon();
		foreach($listeMenus as $itemMenu)
			{?>
            <tr>
            	<td><?php echo $itemMenu->getLibelle();?></td>
                <td><?php echo Tbq_commande::getNbMenuVendusSelonTailleEtDate($itemMenu->ID,'Moyen',$date);?></td>
                <td><?php echo Tbq_commande::getNbMenuVendusSelonTailleEtDate($itemMenu->ID,'Grand',$date);?></td>
            </tr><?php
			}?>
    </table>
    <h3>Suppl&eacute;ments</h3>
    <table>
    	<?php
		$listeSup = Tbq_commande::listerSupplements($date);
		if($listeSup)
			{
			foreach($listeSup as $sup)
				{?>
				<tr>
                	<td><?php echo $sup['supplement'];?></td>
				</tr><?php
				}
			}
		?>
    </table>

    <!-- InstanceEndEditable --> </div>
  <div class="ajusteur"></div>
</div>
</body>
<!-- InstanceEnd --></html>
