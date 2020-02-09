<p><strong>Choississez la taille de votre menu :</strong>
<select name="radioTaille" id="radioTaille">
	<option></option>
    <?php
	if($formule->getPrixGrand()>0)
		{
		//La valeur value 'Grand','Moyen' et 'Petit' des options détermine le prix à payer. A modifier avec prudence !?>
        <option value="Grand" <?php if($favori->taille=='Grand' || $_GET['taille']=='Grand'){echo'selected="selected"';}?>>Grand - <?php echo  $formule->getPrixGrand();?>&nbsp;&euro;</option><?php
		}
	if($formule->getPrixMoyen()>0)
		{?>
        <option value="Moyen" <?php if($favori->taille=='Moyen' || $_GET['taille']=='Moyen'){echo'selected="selected"';}?>>Moyen - <?php echo $formule->getPrixMoyen();?>&nbsp;&euro;</option><?php
		}
	if($formule->getPrixPetit()>0)
		{?>
        <option value="Petit" <?php if($favori->taille=='Petit' || $_GET['taille']=='Petit'){echo'selected="selected"';}?>>Petit - <?php echo $formule->getPrixPetit(); ?>&nbsp;&euro;</option><?php
		}?>
</select></p>