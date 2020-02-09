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
		<?php /*?><tr>
        	<td><p><strong>Du</strong></p></td>
            <td><p>&nbsp;</p></td>
            <td><input type="submit" value="mois avant" onClick="lsjs_moisDAvant()" /></td>
        </tr><?php */?>
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
        <?php /*?><tr>
        	<td><p><strong>Au</strong></p></td>
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
        	<td>
            <input type="text" name="fin" id="fin" size=9 maxlength=10 value=<?
			if(isset($_POST['fin']))
			{
				$fin = $_POST['fin'];
			}
			else
			{ 	
				//$fin = date("d-m-Y");
				$fin = date("m-Y");
			}
			$anneeFin = substr($fin,3,4);
			echo $fin;
			?> />
            </td>
            <td>
            <p><i>mm-aaaa</i></p>
            </td>
            <td>&nbsp;</td>
        </tr> 
        <tr>
        	<td colspan="3">&nbsp;</td>
        </tr><?php */?>
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
                <th>Nb inscriptions</th>
                <th>Nb commandes</th>
                <th>Ventes HT</th>
                <th>TVA 5.5</th>
                <th>Ventes TTC</th>
            </tr>
		</tbody>
		<?php
	//pour chauqe jour du mois sélectionné
	//récupère la composante mois
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
        	<td><?php echo T_LAETIS_site::convertirDate($date);?></td>
            <td>&nbsp;</td>
            <td><?php echo Tbq_client::getNbInscriptionsSelonJour($date);
			$totalInscriptions+=Tbq_client::getNbInscriptionsSelonJour($date);?></td>
            <td align="right"><?php 
			$totalNbCommandes += Tbq_commande::getNbCommandesSelonTypePaiementEtDate(1,$date)+Tbq_commande::getNbCommandesSelonTypePaiementEtDate(5,$date);
			echo Tbq_commande::getNbCommandesSelonTypePaiementEtDate(1,$date)+Tbq_commande::getNbCommandesSelonTypePaiementEtDate(5,$date);?></td>
            <td align="right"><?php 
			$totalMontantHT+=Tbq_commande::getMontantHTSelonDate($date);
			echo Tbq_commande::getMontantHTSelonDate($date);?>&nbsp;&euro;</td>
            <td align="right"><?php 
			$totalMontantTVA+=Tbq_commande::getMontantTVASelonDate($date);
			echo Tbq_commande::getMontantTVASelonDate($date);?>&nbsp;&euro;</td>
            <td align="right"><?php 
			$totalMontantTTC+=Tbq_commande::getMontantTTCSelonDate($date);
			echo Tbq_commande::getMontantTTCSelonDate($date);?>&nbsp;&euro;</td>
        </tr>
        <?php
		}?>
     <tr>
        	<td><strong>TOTAL</strong></td>
            <td><strong>|</strong></td>
            <td align=""><strong><?php echo $totalInscriptions;?></strong></td>
            <td align="right"><strong><?php echo $totalNbCommandes;?></strong></td>
            <td align="right"><strong><?php echo $totalMontantHT;?> &euro;</strong></td>
            <td align="right"><strong><?php echo $totalMontantTVA;?> &euro;</strong></td>
            <td align="right"><strong><?php echo $totalMontantTTC;?> &euro;</strong></td>
        </tr><?php
		
	 //pour chaque année, faire une boucle
	 /*for($a = $anneeDebut; $a<=$anneeFin; $a++)
	 	{
		if($a == $anneeDebut)
			{
			$moisDebut = substr($debut,0,2);
			}
		else
			{
			$moisDebut=1;
			}
		if($a==$anneeFin)
			{
			$moisFin = substr($fin,0,2);
			}
		else
			{
			$moisFin = 12;
			}
		for($m = $moisDebut; $m<=$moisFin; $m++)
			{
			$statsVentesLabege = Tbq_commande::commandesAnneeMois('livree',$a,$m,1);
			$totalNbLabege+=$statsVentesLabege['nb'];
			$totalCALabege+=$statsVentesLabege['somme'];
			
			$statsVentesFilatiers = Tbq_commande::commandesAnneeMois('livree',$a,$m,2);	
			$totalNbFilatiers+=$statsVentesFilatiers['nb'];
			$totalCAFilatiers+=$statsVentesFilatiers['somme'];
			?>
			<tr>
            	<td><?php echo T_LAETIS_site::mois($m).' '.$a;?></td>
                <td>|</td>
                <td><?php echo $statsVentesLabege['nb'];?></td>
                <td><?php echo $statsVentesFilatiers['nb'];?></td>
                <td><?php echo $statsVentesLabege['somme'];?> &euro;</td>
                <td><?php echo $statsVentesFilatiers['somme'];?> &euro;</td>
			</tr><?php
			}
		}?>
        <tr>
        	<td><strong>TOTAL</strong></td>
            <td><strong>|</strong></td>
            <td><strong><?php echo $totalNbLabege;?></strong></td>
            <td><strong><?php echo $totalNbFilatiers;?></strong></td>
            <td><strong><?php echo $totalCALabege;?> &euro;</strong></td>
            <td><strong><?php echo $totalCAFilatiers;?> &euro;</strong></td>
        </tr>

        <tr>
        	<td>&nbsp;</td>
            <td></td>
            <td colspan="2" align="center"><strong><?php echo $totalNbLabege + $totalNbFilatiers;?></strong></td>
            <td colspan="2" align="center"><strong><?php echo $totalCALabege + $totalCAFilatiers;?> &euro;</strong></td>
        </tr><?php */?>
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
		//$moisExercice = array(9,10,11,12,1,2,3,4,5,6,7,8);
        //foreach( $moisExercice as $y)
		for($y=1;$y<=12;$y++)
        {?>
          <th><?php echo T_LAETIS_site::mois($y);?></th><?php
        }?>
        <th class="total">Total</th>
    </tr>
    <?php
  $tab = array();
  $anneeCourante = date('Y');
  $anneeDebut = $commande->anneePremiereCommande() -1;
  
  for( $y = $anneeDebut; $y <= $anneeCourante; $y++)
  {
	  $nbCommandesAnnee = 0;
	  $montantCommandesAnnee = 0;
	  $anSuiv=0;
	  ?><tr>
	 <td class="enTete"><?php echo $y;?></td><?php
	 
	 //foreach( $moisExercice as $m)
	 for($m=1;$m<=12;$m++)
	 {
		$commandesMois = $commande->commandesAnneeMois('livree', $y, $m, $_SESSION['sessionID_user']);
		$nbCommandesAnnee += $commandesMois['nb'];
		$montantCommandesAnnee += $commandesMois['somme'];
		
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
            
		 <span class="montantCommande"><?php echo number_format($commandesMois['somme'], 2,',',' ');?> &euro;
         (<?php
$diffPourcent = T_LAETIS_site::getDifferencePourcent($tab[$y-1][$m],$tab[$y][$m]);
		if($diffPourcent>0)
			{
			echo '+';
			}
		echo $diffPourcent;?>%)
         </span><br/>
         <span class="nbCommande"><?php echo $commandesMois['nb'];?></span><br/><span class="panierMoyen"><?php if($commandesMois['nb'] == 0){ echo '0';}else{ echo number_format($commandesMois['somme'] / $commandesMois['nb'], 2,',',' ');}?> &euro;</span></td><?php
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
<span class="montantCommande"><?php echo number_format($montantCommandesAnnee, 2,',',' ');?> &euro;
<?php
$diffPourcent = T_LAETIS_site::getDifferencePourcent($tab[$y-1][13],$tab[$y][13]);?> (<?php 
		if($diffPourcent>0)
			{
			echo '+';
			}
		echo $diffPourcent;?>%)</span><br/>
<span class="nbCommande"><?php echo $nbCommandesAnnee;?></span><br/>
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
		for($y=1;$y<=12;$y++)
        //foreach( $moisExercice as $y)
        {?>
          <th><?php echo T_LAETIS_site::mois($y);?></th><?php
        }?>
        <th class="total">Total</th>
    </tr>
    <?php
  $tab = array();
  $client = new Tbq_client();
  $anneeCourante = date('Y');
  $anneeDebut = $commande->anneePremiereCommande();
  
  for( $y = $anneeDebut; $y <= $anneeCourante; $y++)
  {
	  $nbCommandesAnnee = 0;
	  $montantCommandesAnnee = 0;
	  ?><tr>
	 <td class="enTete"><?php echo $y;?></td><?php
	 for( $m = 1; $m <= 12; $m++)
	 //foreach($moisExercice as $m)
	 {
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
