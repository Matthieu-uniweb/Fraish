<?php
session_start();

if (! $_SESSION['ID_client'])
	{ header("Location: ../login.php"); }

include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/classes.inc.php';
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/includes/classes/paquetage.inc.php';

$client = new Tbq_client($_SESSION['ID_client']);
$appro = new Tbq_approvisionnement($_GET['ID_appro']);


if($_GET['ID_appro'])
	{
	$listeApprosValides = array($appro);/*Tbq_approvisionnement::lister($_SESSION['ID_client'],'1');*/
	$libCommandes = "Approvisionnement n&deg; ".$appro->ID." du ".T_LAETIS_site::convertirDate($appro->date);
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
	$listeApprosValides =  Tbq_approvisionnement::lister($_SESSION['ID_client'],'1',$dateDebut,$dateFin);
	$listeApprosValides=array_reverse($listeApprosValides);
	$libCommandes="Approvisionnements du ".$dateDebut." au ".$dateFin;
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
        <th align="left">Num.</th>
        <th align="left">Formule</th>
        <th align="left">Mode de paiement</th>
        <?php /*?><th>Prix HT</th><?php */?>
        <th>Prix TTC</th>
        <th>Dont TVA 7%</th>
    </tr>
	<tr><td colspan="6" class="tdBordure"></td></tr><?php
	if($listeApprosValides)
		{
		foreach($listeApprosValides as $itemAppro)
			{
			$appro = new Tbq_approvisionnement($itemAppro->ID);?>
            <tr>
        	<td><?php echo T_LAETIS_site::convertirDate($appro->date);?></td>
            <td><?php echo $appro->ID;?></td>
            <td><?php
			echo $appro->getDescriptif().'<br/>'.$appro->getDetailPaiement();
            ?></td>
            <td>R&eacute;gl&eacute; par <?php echo $appro->getLabelTypePaiement($appro->ID_typ_paiement);?></td>
            <td align="right"><?php echo $appro->montant;?>&nbsp;&euro;</td>
			<td align="right"><?php /*echo round($appro->montant*0.07,2);*/
			echo round($appro->montant-($appro->montant/1.07),2);?>&nbsp;&euro;</td>            
        </tr>
            <?php
			$totalTVA += /*round($appro->montant*0.07,2)*/round($appro->montant-($appro->montant/1.07),2);
			$totalTTC += $appro->montant;
			}
		}?>
    <tr><td colspan="6" class="tdBordure">&nbsp;</td></tr>
    <tr>
    	<td colspan="4" align="right"><strong>TOTAL</strong></td>
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
