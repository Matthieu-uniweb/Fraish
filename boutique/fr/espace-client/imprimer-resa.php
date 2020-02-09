<?php
session_start();

if (! $_SESSION['ID_client'])
	{ header("Location: ../login.php"); }

include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/classes.inc.php';
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/includes/classes/paquetage.inc.php';

$client = new Tbq_client($_SESSION['ID_client']);
$commande = new Tbq_commande();


if($_GET['ID_commande'])
	{
	$listeCommandesLivrees = $commande->detailCommande($_GET['ID_commande']);
	$detailCommande = $commande->detailCommande($_GET['ID_commande']);
	$listeApprosValides = Tbq_approvisionnement::lister($_SESSION['ID_client'],'1');	
	$libCommandes = "Commande du ".T_LAETIS_site::convertirDate($detailCommande[0]['dateReservation']);
	}
else
	{
	if($_GET['dateDebut'])
		{
		$dateDebut = $_GET['dateDebut'];
		}
	if($_GET['dateFin'])
		{
		$dateFin = $_GET['dateFin'];
		}
	$listeCommandesLivrees = $commande->listerCommande($_SESSION['ID_client'], 'livree',$dateDebut,$dateFin);	
	$listeCommandesLivrees=array_reverse($listeCommandesLivrees);
	$listeApprosValides =  Tbq_approvisionnement::lister($_SESSION['ID_client'],'1',$dateDebut,$dateFin);
	$libCommandes="Commandes du ".$dateDebut." au ".$dateFin;
	}?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<style type="text/css">
p#fraish {
	color:#BE0C30;
}
.tdBordure{
	border-bottom:solid 1px #000;
	line-height:2px;
}
#infos {
	font-size:11px;
}
</style>
</head>
<body>
<p id="fraish"><strong>FRAISH - 40 Rue des Filatiers</strong> - 31000 TOULOUSE - 05 62 17 52 76<br />
<strong>FRAISH - Centre Commercial LABEGE2</strong> - 31670 LABEGE - 05 61 73 17 88</p>
<h2><?php echo $libCommandes;?></h2>
<table>
	<tr>
    	<th align="left">Date</th>
        <th align="left">Formule</th>
        <th align="left">Mode de paiement</th>
        <?php /*?><th>Prix HT</th><?php */?>
        <th>Prix TTC</th>
        <th>Dont TVA <?php /*?>5,5<?php */?>7%</th>
    </tr>
	<tr><td colspan="5" class="tdBordure"></td></tr><?php
	foreach($listeCommandesLivrees as $itemCommande)
		{?>
        <tr>
        	<td><?php echo T_LAETIS_site::convertirDate($itemCommande['dateReservation']);?></td>
            <td><?php
			$formule = new Tbq_formule(Tbq_commande::getIDFormule($itemCommande['ID']));
			echo $formule->nom;
            ?></td>
            <td>R&eacute;gl&eacute; par <?php echo Tbq_commande::getLabelTypePaiement($itemCommande['ID']);?></td>
            <?php /*?><td><?php echo $itemCommande['prix']*(1-0.055); //TVA 5,5?>&nbsp;&euro;</td><?php */?>
            <td align="right"><?php echo $itemCommande['prix'];?>&nbsp;&euro;</td>
			<td align="right"><?php echo round($itemCommande['prix']-($itemCommande['prix']/1.07),2);?>&nbsp;&euro;</td><?php /*?>0.055<?php */?>     
        </tr>
        <?php
		//$totalHT += $itemCommande['prix']*(1-0.055);
		$totalTVA += round($itemCommande['prix']-($itemCommande['prix']/1.07),2);/*0.055*/
		$totalTTC += $itemCommande['prix'];
		}
	
	/*if($listeApprosValides)
		{
		foreach($listeApprosValides as $itemAppro)
			{?>
            <tr>
        	<td><?php echo T_LAETIS_site::convertirDate($itemAppro['date']);?></td>
            <td><?php
			echo $itemAppro->getDescriptif();
            ?></td>
            <td>R&eacute;gl&eacute; par <?php echo $itemAppro->getLabelTypePaiement($itemAppro['ID_typ_paiement']);?></td>
            <td align="right"><?php echo $itemAppro['montant'];?>&nbsp;&euro;</td>
			<td align="right"><?php echo round($itemAppro['prix']*0.055,2);?>&nbsp;&euro;</td>            
        </tr>
            <?php
			$totalTVA += round($itemAppro['montant']*0.055,2);
			$totalTTC += $itemAppro['montant'];
			}
		}*/
	?>
    <tr><td colspan="5" class="tdBordure">&nbsp;</td></tr>
    <tr>
    	<td colspan="3" align="right"><strong>TOTAL</strong></td>
        <?php /*?><td><?php echo $totalHT;?>&nbsp;&euro;</td><?php */?>
        <td align="right"><strong><?php echo $totalTTC;?>&nbsp;&euro;</strong></td>        
		<td align="right"><?php echo $totalTVA;?>&nbsp;&euro;</td>        
    </tr>
</table>
<p id="infos">
GROUP' FRAISH - Route de la belauti&eacute; 81140 Cahuzac-sur-V&egrave;re - info@fraish.fr - SIRET 509 201 141 00017
</p>
<script type="text/javascript" language="javascript">
<!--//
window.self.print();
//-->
</script>
</body>
</html>