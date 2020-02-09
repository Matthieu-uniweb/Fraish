<script language="javascript" type="text/javascript"><!--//
function alerteValidation()
	{
	alert("Veuillez choisir les ingrédients à l\'étape 3,\n puis validez en cliquant sur le bouton \"Etape suivante\" en bas de page.");
	}
//-->
</script>
<?php
//param pour la navigation etapes
$et_ID_commande = $commande->ID;
$et_ID_menuFavori = Tbq_client_favori::getMenuFavori($client->ID);
$et_ID_menuFavori = $et_ID_menuFavori->ID;
//FIN param pour la navigation etape?>
<ul class="etapes">Etapes : 
<li <?php if($etape==1){?>class="actif"<?php }?>
	<?php if($etape>1){?>class="ok"<?php }?>>1. <?php
    if(basename($_SERVER['PHP_SELF'])=='creation-compte-etape1.php')
		{?>
		Cr&eacute;ation compte<?php
		}
	else
		{?>
        <?php
        if($etape>1)
			{?>
            <a href="javascript:sortie=1; document.location.href='/boutique/fr/espace-client/espace-client.php';" title="Accueil"><?php
			}?>Accueil<?php if($etape>=1){?></a><?php }?><?php 
		}?></li>
<li <?php if($etape==2){?>class="actif"<?php }?>
	<?php if($etape>2){?>class="ok"<?php }?>>
    <?php
    	if($etape>2)
			{?><a href="javascript:sortie=1; document.location.href='/boutique/fr/espace-client/reserver-formule.php';" title="R&eacute;servez votre formule"><?php
			}?>2. R&eacute;servez votre menu<?php if($etape>=2){?></a><?php }?></li>
<li <?php if($etape==3){?>class="actif"<?php }?>
	<?php if($etape>3){?>class="ok"<?php }?>><?php
    if($etape>3)
		{?>
        <a href="javascript:sortie=1; document.location.href='/boutique/fr/espace-client/reserver-ingredients.php?ID_menuFavori=<?php echo $et_ID_menuFavori;?>'" title="Choix ingr&eacute;dients"><?php
		}?>
        3. Choix ingr&eacute;dients
        <?php
        if($etape>3)
			{?></a><?php }?></li>
<li <?php if($etape==4){?>class="actif"<?php }?>
	<?php if($etape>4){?>class="ok"<?php }?>><?php
    if($etape>4)
		{?>
        <a href="javascript:sortie=1; document.location.href='/boutique/fr/espace-client/recapitulatif.php?ID_commande=<?php echo $et_ID_commande;?>&ID_client=<?php echo $client->ID;?>&ID_menu=';" title="Validation"><?php
		}
	elseif($etape<=3)
		{?>
		<a href="javascript:alerteValidation();" style="text-decoration:none;"><?php
		}?>
		4. Validation</a></li>
<li <?php if($etape==5){?>class="actif"<?php }?>>5. Paiement</li>
</ul>
<p>&nbsp;</p>