
<h3>R&eacute;servation n&deg;<? echo $commande[0]['ID_commande_fraish']; ?> 
<?php
if($ptLivraison->ID)
	{?>
    (&agrave; retirer sur votre point de livraison)<?php
	}
else
	{?>
    (&agrave; retirer sur votre point de vente)<?php
	}?></h3>
<p><strong>Date de la r&eacute;servation :</strong> <? echo T_LAETIS_site::dateEnFrancais($commande[0]['dateReservation']); ?></p>
<p><strong>Point de vente : </strong>
<?php 
if($ptLivraison->ID)
	{
	echo $ptLivraison->nom.' ('.$ptLivraison->adresse1.' '.$ptLivraison->adresse2.' '.$ptLivraison->ville.')';
	}
else
	{
	echo $user->pointDeVente;
	}?></p>
<p>Nom: <?php echo '<b>'.$client->prenomFacturation.' '.$client->nomFacturation.'</b>'; ?></p><br/><?php

//SOUPE
if($commande[0]['soupe']!=', , ,' && $commande[0]['soupe']!='')
	{?>
    <p><strong>Soupe : </strong>
    <? echo $commande[0]['soupe']; ?></p><?php
	}
	
//SALADE	
if($commande[0]['plat'])
	{?>
    <p><strong>Salade : </strong>
    <? echo $commande[0]['plat']; ?></p>
    
    <?php
    if ($commande[0]['vinaigrette'])
        { ?><p><strong>Vinaigrette: </strong><? echo $commande[0]['vinaigrette']; ?></p><?php } 
	}
	
//BOISSON
if($commande[0]['boisson'])
	{?>    
    <p><strong>Boisson : </strong>
    <? echo $commande[0]['boisson']; ?></p><?php
	}

//DESSERT
if($commande[0]['dessert'])
	{?>    
    <p><strong>Dessert : </strong>
    <? echo $commande[0]['dessert']; ?></p><?php
	}

//PAIN
if($commande[0]['pain'])
	{?>    
    <p><strong>Pain : </strong>
    <? echo $commande[0]['pain']; ?></p><?php
	}
    
//EAU
if($commande[0]['eau'])
	{?>    
    <p><strong>Eau : </strong>
    Bouteille 50cl</p><?php
	}    

//SUPPLEMENTS
if($commande[0]['supplement'])
	{?>    
    <p><strong>Suppl&eacute;ment(s) : </strong>
    <? echo $commande[0]['supplement']; ?></p><?php
	}
?>
    
<p><strong>Taille : </strong>
<? echo $commande[0]['taille']."."; ?></p>
<p style="font-size:13px;"><strong>Total : <? echo $commande[0]['prix']."&euro; TTC."; ?></strong></p>
<?php

if($commande[0]['ID_typ_paiement']>0)
	{?>
    <br />
	<p>Pay&eacute; par : <?php echo Tbq_commande::getLabelTypePaiement($commande[0]['ID']);?></p><?php
	}?>
<p>&nbsp;</p>
<p><strong>Informations compte Fraish : </strong>
Votre crédit compte Fraish est de <?php echo $client->soldeCompte;?> &euro;<?php
if($client->soldeCompte < 0)
	{?>
    <br /><strong>Attention : vous devez recharger votre compte !</strong><?php
	}?></p>
<?php
if ($commande[0]['commentaire'])
	{ ?>
<p><strong>Commentaire : </strong>
<? echo nl2br($commande[0]['commentaire']); ?></p>
<?php } ?>