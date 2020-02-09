
<?php /*?><h3>R&eacute;servation n&deg;<? echo $commande[0]['ID_commande_fraish']; ?> 
<?php
if($ptLivraison->ID)
	{?>
    (&agrave; retirer sur votre point de livraison)<?php
	}
else
	{?>
    (&agrave; retirer sur votre point de vente)<?php
	}?></h3><?php */?>
<p><strong>Date de la r&eacute;servation :</strong> <? echo T_LAETIS_site::dateEnFrancais($commande[0]['dateReservation']); ?></p>
<p><strong>Point de vente :Centre commercial LABEGE 2 </strong></p>

<p>Nom: <?php echo '<b>'.$client->prenomFacturation.' '.$client->nomFacturation.'</b>'; ?></p><br/>

<p><strong>Quantit&eacute; command&eacute;e :</strong> <? echo $commande[0]['nb_dans_panier']; ?></p>
<p><strong>Code promo :</strong> <? echo $commande[0]['code_promo']; ?></p><?php

//SOUPE
if($commande[0]['soupe']!=', , ,' && $commande[0]['soupe']!='')
	{?>
    <p><strong>Soupe : </strong>
    <? echo utf8_decode($commande[0]['soupe']); ?></p><?php
	}
	
//SALADE	
if($commande[0]['plat'])
	{?>
    <p><strong>Salade : </strong>
    <? echo utf8_decode($commande[0]['plat']); ?></p>
    
    <?php
    if ($commande[0]['vinaigrette'])
        { ?><p><strong>Vinaigrette: </strong><? echo utf8_decode($commande[0]['vinaigrette']); ?></p><?php } 
	}
	
//BOISSON

if(trim($commande[0]['boisson'])!='')
	{?>    
    <p><strong>Boisson : </strong>
    <? echo utf8_decode($commande[0]['boisson']); ?></p><?php
	}

//DESSERT
if($commande[0]['dessert'])
	{?>    
    <p><strong>Dessert : </strong>
    <? echo utf8_decode($commande[0]['dessert']); ?></p><?php
	}

//PAIN
if($commande[0]['pain'])
	{?>    
    <p><strong>Pain : </strong>
    <? echo utf8_decode($commande[0]['pain']); ?></p><?php
	}
    
//EAU
if($commande[0]['eau'])
	{?>    
    <p><strong>Eau : </strong>
    	<? echo utf8_decode($commande[0]['eau']); ?></p><?php
    
	}    

//SUPPLEMENTS
if($commande[0]['supplement'])
	{?>    
    <p><strong>Suppl&eacute;ment(s) : </strong>
    <? echo utf8_decode($commande[0]['supplement']); ?></p><?php
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
Votre cr&eacute;dit compte Fraish est de <?php echo $client->soldeCompte;?> &euro;<?php
if($client->soldeCompte < 0)
	{?>
    <br /><strong>Attention : vous devez recharger votre compte !</strong><?php
	}?></p>
<?php
if ($commande[0]['commentaire'])
	{ ?>
<p><strong>Commentaire : </strong>
<? echo nl2br(utf8_decode($commande[0]['commentaire'])); ?></p>
<?php } ?>