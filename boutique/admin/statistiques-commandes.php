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
$commande = new Tbq_commande();
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
    <h1>Les statistiques des commandes</h1>
    <h2>Les commandes</h2>
    
    <form name="formulaire" action="" method="post" onsubmit="return lsjs_controleDates2();">
  		<table border=0>
       <tr>
        	<td>
            <input type="text" name="debut" id="debut" size=9 maxlength=10 value=<?php 
			if(isset($_POST['debut']))
			{
				$debut = $_POST['debut'];
			}
			else
			{
				//$debut = "01-".date("m-Y");
				$debut = date("m-Y");
			}
			$anneeDebut = substr($debut,3,4);
			echo $debut;
			?> />
            </td>
            <td>
            <p><i>mm-aaaa</i></p>
            </td>
            <td>&nbsp;</td>
        </tr>
       
 		<tr align="center">
        	<td colspan="3">
        	<input type="submit" value="Afficher les statistiques" />
            </td>
        </tr>
     </table>
      </form>
      
     <table class="bordure" cellpadding="0" cellspacing="0">
	 	<tbody>
        	<tr>
            	<th></th>
                <th>|</th>
                <th>Nb insc.</th>
                <th>Nb cmdes</th>
                <th>Appros CB</th>
                <th>Appros TR</th>
                <th>Appros CHQ</th>
                <th>Appros ESP</th>
                <th>Appros Offert</th>
                <th>Appros Rep AV</th>
                <th>Appros Offert rech.</th>
                <th>Ventes HT</th>
                <th>TVA 5.5</th>
                <th>TVA 7</th>
                <th>Ventes TTC</th>
            </tr>
		</tbody>
		<?php
	//pour chauqe jour du mois sÃ©lectionnÃ©
	//rÃ©cupÃ¨re la composante mois
	$mois = substr($debut,0,2);
	$tabNbJours = array('01'=>31,'02'=>29,'03'=>31,'04'=>30,'05'=>31,'06'=>30,'07'=>31,'08'=>31,'09'=>30,'10'=>31,'11'=>30,'12'=>31);

	for($i=1;$i<=$tabNbJours[$mois];$i++)
		{
		$iRech = $i;
		if($i<10)
			{
			$iRech='0'.$i;
			}
		$date=T_LAETIS_site::convertirDate($iRech.'-'.$debut);?>
        <tr>
        	<td><?php echo T_LAETIS_site::convertirDatelight($date);?></td>
            <td>&nbsp;</td>
            <td align="right"><?php echo Tbq_client::getNbInscriptionsSelonJour($date);
			$totalInscriptions+=Tbq_client::getNbInscriptionsSelonJour($date);?></td>
            <td align="right"><?php 
			$totalNbCommandes += Tbq_commande::getNbCommandesSelonTypePaiementEtDate(1,$date)+Tbq_commande::getNbCommandesSelonTypePaiementEtDate(5,$date);
			echo Tbq_commande::getNbCommandesSelonTypePaiementEtDate(1,$date)+Tbq_commande::getNbCommandesSelonTypePaiementEtDate(5,$date);?></td>
            <td align="right"><?php /* Appros cb*/
			$totalApproCb += Tbq_approvisionnement::getSommeApproSelonTypeEtDate(1,$date);
			echo Tbq_approvisionnement::getSommeApproSelonTypeEtDate(1,$date);?>&nbsp;&euro;</td>
            <td align="right"><?php /* Appros TR*/
			$totalApproTr +=Tbq_approvisionnement::getSommeApproSelonTypeEtDate(3,$date);
			echo Tbq_approvisionnement::getSommeApproSelonTypeEtDate(3,$date);?>&nbsp;&euro;</td>
            <td align="right"><?php /* Appros ch*/
			$totalApproChq+=Tbq_approvisionnement::getSommeApproSelonTypeEtDate(2,$date);
			echo Tbq_approvisionnement::getSommeApproSelonTypeEtDate(2,$date);?>&nbsp;&euro;</td>
            <td align="right"><?php /* Appros esp*/
			$totalApproEsp+=Tbq_approvisionnement::getSommeApproSelonTypeEtDate(4,$date);
			echo Tbq_approvisionnement::getSommeApproSelonTypeEtDate(4,$date);?>&nbsp;&euro;</td>
            <td align="right"><?php /* Appros offert*/
			$totalApproOffert+=Tbq_approvisionnement::getSommeApproSelonTypeEtDate(6,$date);
			echo Tbq_approvisionnement::getSommeApproSelonTypeEtDate(6,$date);?>&nbsp;&euro;</td>
            <td align="right"><?php /* Appros reprise avoir*/
			$totalApproReprise+=Tbq_approvisionnement::getSommeApproSelonTypeEtDate(7,$date);
			echo Tbq_approvisionnement::getSommeApproSelonTypeEtDate(7,$date);?>&nbsp;&euro;</td>
            <td align="right"><?php /* Appros offert sur recharge*/
			$totalApproOffertRecharge+=Tbq_approvisionnement::getSommeApproSelonTypeEtDate(8,$date);
			echo Tbq_approvisionnement::getSommeApproSelonTypeEtDate(8,$date);?>&nbsp;&euro;</td>
            <td align="right"><?php 
			if($date<'2012-01-01') {
				$tauxTva = 5.5;
			}
			else {
				$tauxTva = 7;
			}
			$totalMontantHT+=Tbq_commande::getMontantHTSelonDate($date,$tauxTva);
			echo Tbq_commande::getMontantHTSelonDate($date,$tauxTva);?>&nbsp;&euro;</td>
			<td align="right"><?php 
			//TVA 5.5
			if($tauxTva==5.5) {
				$totalMontantTVA+=Tbq_commande::getMontantTVASelonDate($date,5.5);
				echo Tbq_commande::getMontantTVASelonDate($date,5.5);?>&nbsp;&euro;<?php
			} else {echo'0&euro;';}?></td>
             <td align="right"><?php 
			//TVA 7
			if($tauxTva==7) {
				$totalMontantTVA7+=Tbq_commande::getMontantTVASelonDate($date);
				echo Tbq_commande::getMontantTVASelonDate($date);?>&nbsp;&euro;<?php 
			}
			else {echo '0 &euro;';}?></td>
            <td align="right"><?php 
			$totalMontantTTC+=Tbq_commande::getMontantTTCSelonDate($date);
			echo Tbq_commande::getMontantTTCSelonDate($date);?>&nbsp;&euro;</td>
        </tr>
        <?php
		}?>
     <tr>
        	<td><strong>TOTAL</strong></td>
            <td><strong>|</strong></td>
            <td align="right"><strong><?php echo $totalInscriptions;?></strong></td>
            <td align="right"><strong><?php echo $totalNbCommandes;?></strong></td>
            <td align="right"><strong><?php echo $totalApproCb;?> &euro;</strong></td>
            <td align="right"><strong><?php echo $totalApproTr;?> &euro;</strong></td>
            <td align="right"><strong><?php echo $totalApproChq;?> &euro;</strong></td>
            <td align="right"><strong><?php echo $totalApproEsp;?> &euro;</strong></td>
            <td align="right"><strong><?php echo $totalApproOffert;?> &euro;</strong></td>
            <td align="right"><strong><?php echo $totalApproReprise;?> &euro;</strong></td>
            <td align="right"><strong><?php echo $totalApproOffertRecharge;?> &euro;</strong></td>
            <td align="right"><strong><?php echo $totalMontantHT;?> &euro;</strong></td>
            <td align="right"><strong><?php echo $totalMontantTVA;?> &euro;</strong></td>
            <td align="right"><strong><?php echo $totalMontantTVA7;?> &euro;</strong></td>            
            <td align="right"><strong><?php echo $totalMontantTTC;?> &euro;</strong></td>
        </tr>
     </table>
     
     <div id="statistiques">
     <h3>Comparatif ventes</h3>
  <ul>
  	<li>Chiffre d'affaire du mois pour l'ann&eacute;e correspondante <span class="montantCommande">(exemple)</span></li>
    <li>Nombre de commandes pour le mois et l'ann&eacute;e correspondant <span class="nbCommande">(exemple)</span></li>
    <li>Panier moyen pour le mois et l'ann&eacute;e correspondant <span class="panierMoyen">(exemple)</span></li>
  </ul>
  <table class="bordure">
    <tr>
        <th class="enTete"></th>
        <?php
		$moisExercice = array(9,10,11,12,1,2,3,4,5,6,7,8);
        foreach( $moisExercice as $y)
        {?>
          <th><?php echo T_LAETIS_site::mois($y);?></th><?php
        }?>
        <th class="total">Total</th>
    </tr>
    <?php
  $tab = array();
  $anneeCourante = date('Y');
  $anneeDebut = $commande->anneePremiereCommande();
  $anneeDebut=2009;
  
  for( $y = $anneeDebut; $y <= $anneeCourante; $y++)
  {
	  $nbCommandesAnnee = 0;
	  $montantCommandesAnnee = 0;
	  $anSuiv=0;
	  ?><tr>
	 <td class="enTete"><?php echo ($y-1).'/'.$y;?></td><?php
	 
	 foreach( $moisExercice as $m)
	 //for($m=1;$m<=12;$m++)
	 {
		 if($m==1)
		 	{
			$y++;
			}
		if($m==9)
			{
			$y--;
			}
		$commandesMois = $commande->commandesAnneeMois('livree', $y, $m, $_SESSION['sessionID_user']);
		$nbCommandesAnnee += $commandesMois['nb'];
		$montantCommandesAnnee += $commandesMois['somme'];
		
		$tabNbCommandes[$y][$m] = $commandesMois['nb'];
		$tab[$y][$m] = $commandesMois['somme'];
		 ?>
		 <td <?php 
		 	if(isset($tab[$y-1][$m]) && $commandesMois['nb'] != 0){
		 		if($tab[$y-1][$m] > $tab[$y][$m]){ 
					echo 'class="bas"';
				}elseif($tab[$y-1][$m] < $tab[$y][$m]){
					echo 'class="haut"';
				}else{
					echo 'class="droit"';}
			}?>>
            
		 <span class="montantCommande"><?php echo number_format($commandesMois['somme'], 2,',',' ');?> &euro;<br />
         (<?php
$diffPourcent = T_LAETIS_site::getDifferencePourcent($tab[$y-1][$m],$tab[$y][$m]);
		if($diffPourcent>0)
			{
			echo '+';
			}
		echo $diffPourcent;?>%)
         </span><br/>
         <span class="nbCommande"><?php echo $commandesMois['nb'];?><br />(<?php
$diffPourcent = T_LAETIS_site::getDifferencePourcent($tabNbCommandes[$y-1][$m],$tabNbCommandes[$y][$m]);
		if($diffPourcent>0)
			{
			echo '+';
			}
		echo $diffPourcent;?>%)</span><br/>
         <span class="panierMoyen"><?php if($commandesMois['nb'] == 0){ echo '0';}else{ echo number_format($commandesMois['somme'] / $commandesMois['nb'], 2,',',' ');}?> &euro;</span></td><?php
	 }
	 $tab[$y][13] = $montantCommandesAnnee;
	 $tabNbCommandes[$y][13] = $nbCommandesAnnee;
	 ?>
     <td class="total <?php 
		if(isset($tab[$y-1][13])){
			if($tab[$y-1][13] > $montantCommandesAnnee){ 
				echo 'bas';
			}elseif($tab[$y-1][13] < $montantCommandesAnnee){
				echo 'haut';
			}else{
				echo 'droit';}
		}?>">
<span class="montantCommande"><?php echo number_format($montantCommandesAnnee, 2,',',' ');?> &euro;
<?php
$diffPourcent = T_LAETIS_site::getDifferencePourcent($tab[$y-1][13],$tab[$y][13]);?> (<?php 
		if($diffPourcent>0)
			{
			echo '+';
			}
		echo $diffPourcent;?>%)</span><br/>
<span class="nbCommande"><?php echo $nbCommandesAnnee;?><br />
<?php
$diffPourcent = T_LAETIS_site::getDifferencePourcent($tabNbCommandes[$y-1][13],$tabNbCommandes[$y][13]);?> (<?php 
		if($diffPourcent>0)
			{
			echo '+';
			}
		echo $diffPourcent;?>%)</span><br/>
<span class="panierMoyen"><?php if($nbCommandesAnnee == 0){ echo '0';}else{ echo number_format($montantCommandesAnnee / $nbCommandesAnnee, 2,',',' ');}?> &euro;</span></td>
	 </tr><?php
  }?>
  
  </table>
  </div>
  
  
  <?php /** INSCRIPTIONS **/ 
  $moisExercice = array(9,10,11,12,1,2,3,4,5,6,7,8);?>
  <div id="statistiques">
  <h3>Comparatif inscriptions</h3>
  <table class="bordure">
    <tr>
        <th class="enTete"></th>
        <?php
        foreach( $moisExercice as $y)
        {?>
          <th><?php echo T_LAETIS_site::mois($y);?></th><?php
        }?>
        <th class="total">Total</th>
    </tr>
    <?php
  $tab = array();
  $client = new Tbq_client();
  $anneeCourante = date('Y');
  //$anneeDebut = $commande->anneePremiereCommande();
  $anneeDebut=2009;
  
  for( $y = $anneeDebut; $y <= $anneeCourante; $y++)
  {
	  $nbCommandesAnnee = 0;
	  $montantCommandesAnnee = 0;
	  ?><tr>
	 <td class="enTete"><?php echo ($y-1).'/'.$y;?></td><?php
	 foreach($moisExercice as $m)
	 {
		 if($m==1)
		 	{
			$y++;
			}
		if($m==9)
			{
			$y--;
			}
		$commandesMois = $client->getNbInscriptions($y, $m, $_SESSION['sessionID_user']);
		
		$nbCommandesAnnee += $commandesMois;
		$montantCommandesAnnee += $commandesMois;
		
		$tab[$y][$m] = $commandesMois;
		 ?>
		 <td <?php 
		 	if(isset($tab[$y-1][$m]) && $commandesMois != 0){
		 		if($tab[$y-1][$m] > $tab[$y][$m]){ 
					echo 'class="bas"';
				}elseif($tab[$y-1][$m] < $tab[$y][$m]){
					echo 'class="haut"';
				}else{
					echo 'class="droit"';}
			}?>>
		 <span class="montantCommande"></span><br/>
         <span class="nbCommande">
		 <?php echo $commandesMois;?><br /><?php
		 $diffPourcent = T_LAETIS_site::getDifferencePourcent($tab[$y-1][$m],$tab[$y][$m]);?> (<?php 
		if($diffPourcent>0)
			{
			echo '+';
			}
		echo $diffPourcent;?>%)</span><br/>
         <span class="panierMoyen"></span></td><?php

	 }
	 $tab[$y][13] = $montantCommandesAnnee;
	 ?>
     <td class="total <?php 
		if(isset($tab[$y-1][13])){
			if($tab[$y-1][13] > $montantCommandesAnnee){ 
				echo 'bas';
			}elseif($tab[$y-1][13] < $montantCommandesAnnee){
				echo 'haut';
			}else{
				echo 'droit';}
		}?>">
<span class="montantCommande"></span><br/>
<span class="nbCommande"><?php echo $nbCommandesAnnee;?><br /><?php
$diffPourcent = T_LAETIS_site::getDifferencePourcent($tab[$y-1][13],$tab[$y][13]);?> (<?php 
		if($diffPourcent>0)
			{
			echo '+';
			}
		echo $diffPourcent;?>%)</span><br/>
<span class="panierMoyen"></span></td>
	 </tr><?php
  }?>
  
  </table>
  </div>
    <!-- InstanceEndEditable --> </div>
  <div class="ajusteur"></div>
</div>
</body>
<!-- InstanceEnd --></html>
