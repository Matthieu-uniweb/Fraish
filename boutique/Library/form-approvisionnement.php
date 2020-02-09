<?php
$commandeAppro = new Tbq_commande($appro->ID_commande);

?>
<?php /*?><div id="formulaire-credit">
	<div id="fond-formulaire"><img src="/images/site/formulaire-credit.jpg" alt="Formulaire de recharge compte client Fraish"/></div>
    <div id="nom"><?php echo $client->nomFacturation;?></div>
    <div id="prenom"><?php echo $client->prenomFacturation;?></div>
    <div id="mail"><?php echo $client->emailFacturation;?></div><?php
	if($appro->ID_commande)
		{
		$ptVenteAppro = new Tbq_user($commandeAppro->ID_pointDeVente);?>
		<div id="rapprochementCommande">Rapprochement commande n&deg; <?php echo $commandeAppro->ID_commande_fraish;?> du <?php echo T_LAETIS_site::convertirDate($commandeAppro->dateReservation);?> - point de vente <?php echo $ptVenteAppro->pointDeVente;?></div><?php
		}
		
    if($appro->ID_typ_paiement==4)//'paiementEspeces'
        {?>
        <div id="mode-especes"><?php echo $appro->montant;?>&nbsp;&euro;</div><?php
        }
    if($appro->ID_typ_paiement==2)//'paiementCheque'
        {?>
        <div id="mode-cheque">
            <div id="numCheque"><?php echo $appro->numCheque;?>&nbsp;</div>
            <div id="somme"><?php echo $appro->montant;?>&nbsp;&euro;</div>
        </div><?php
        }
    if($appro->ID_typ_paiement==3)//'paiementTitresResto'
        {?>
        <div id="mode-titresResto">
            <div id="nbTitres"><?php echo $appro->nbTitres;?>&nbsp;</div>
            <div id="valeurTitre"><?php echo $appro->valeurTitre;?>&nbsp;&euro;</div>
            <div id="somme"><?php echo $appro->montant;?>&nbsp;&euro;</div>
        </div><?php
        }?>
    <div id="date"><?php echo T_LAETIS_site::convertirDate($appro->date);?></div>
    <div id="numClient"><?php echo $client->ID;?></div>
</div><?php */?>
<div id="formAppro" style="border:dashed 1px #000; padding-left:5px; width:500px; font-size:12px;">
<h3 style="border-bottom:solid 1px #000;">Le compte FRAISH - Formulaire d'approvisionnement n&deg;<?php echo $appro->ID;?></h3>
<table>
	<tr>
    	<td align="right"><strong>Nom : </strong></td>
        <td><strong><?php echo $client->nomFacturation;?></strong></td>
    </tr>
    <tr>
    	<td align="right">Pr&eacute;nom : </td>
		<td><?php echo $client->prenomFacturation;?></td>
    </tr>
    <tr>
    	<td align="right">Num&eacute;ro client : </td>
		<td><?php echo $client->ID;?></td>
    </tr>
    <tr>
		<td align="right">Mail : </td>
		<td><?php echo $client->emailFacturation;?></td>
    </tr>
    <tr>
    	<td align="right"><strong>Mode de paiement : </strong></td>
        <td><strong><?php echo ucfirst($appro->getLabelTypePaiement()); ?></strong></td>
    </tr>
	
		<?php
switch($appro->ID_typ_paiement)
	{
	case 4:?>
    <tr>
    	<td align="right"><strong>Montant : </strong></td>
		<td><strong><?php echo $appro->montant;?>&nbsp;&euro;</strong></td>
        </tr>
    <?php
		break;
	case 2:?>
    	<tr><td align="right">Num&eacute;ro de ch&egrave;que : </td>
		<td><?php echo $appro->numCheque;?></td>
        </tr>
        <tr>
        <td align="right"><strong>Montant : </strong></td>
		<td><strong><?php echo $appro->montant;?>&nbsp;&euro;</strong></td>
        </tr>
    <?php
		break;
	case 3:?>
    	<tr><td align="right">Nombre de titres : </td>
		<td><?php echo $appro->nbTitres;?></td>
        </tr>
        	<td align="right">Valeur d'un titre : </td>
			<td><?php echo $appro->valeurTitre;?>&nbsp;&euro;</td>
        </tr>
        <tr>
        	<td align="right"><strong>Montant total : </strong></td>
			<td><strong><?php echo $appro->montant;?>&nbsp;&euro;</strong></td>
        </tr>
    <?php
		break;
	}
?>
	</tr>
    <tr>
    	<td align="right">Date : </td>
		<td><?php echo T_LAETIS_site::convertirDate($appro->date);?></td>
    </tr><?php
	if($appro->ID_commande)
		{?>
        <tr>
        	<td align="right" style="vertical-align:top;"><strong>Commande : </strong></td>
            <td><?php
            $ptVenteAppro = new Tbq_user($commandeAppro->ID_pointDeVente);?>
		<strong>N&deg; <?php echo $commandeAppro->ID_commande_fraish;?> du <?php echo T_LAETIS_site::convertirDate($commandeAppro->dateReservation);?></strong>
        	</td>
        </tr>
        	<td align="right"><strong>Point de vente : </strong></td>
            <td><strong>
        <?php echo $ptVenteAppro->pointDeVente;?></strong>
            </td>
        </tr><?php
		}?>
    <tr>
    	<td align="right">Signature du client :</td>
        <td>&nbsp;</td>
    </tr>
</table>

</div>
<?php
if($appro->approOffert)
	{
	$approOffert = new Tbq_approvisionnement($appro->approOffert);
	?>
    <p style="font-weight:bold;">Fraish vous offre <?php echo $approOffert->montant;?> &euro; de cr&eacute;dit suppl&eacute;mentaire !<br />Votre approvisionnement sera donc de <?php echo $appro->montant+$approOffert->montant;?> &euro;.<br />Merci de votre fid&eacute;lit&eacute;.</p><?php
	}
?>