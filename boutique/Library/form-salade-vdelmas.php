<?php
$ingredientsFavoris = explode('|',$favori->salade);?>
    <div id="tableauSalades">
      <p class="ssTitre">Les ingr&eacute;dients toujours disponibles<br />
        <br />
      </p>
      <?php 
			$commande = new Tbq_commande();
			$ingredients = $commande->ingredients;
			$cpt = 0; 
			?><div id="un"><?php 
			for($i=0; $i < 8; $i++)
				{	?><p><?php echo $ingredients[$i];?></p><?php } ?></div>
      <div id="deux">
      <?php 
			for($i=0; $i < 8; $i++)
				{	
				?><p><input type="checkbox" <?php if (in_array($ingredients[$i], $ingredientsFavoris)) { echo 'checked="checked"'; } ?> name="<?php echo $cpt; ?>saladeIngredients" id="<?php echo $ingredients[$i];?>" value="<?php echo $ingredients[$i];?>" /></p><?php 
				$cpt++;
				} ?>
      </div>
      <div id="trois"><?php 
			for($i=8; $i < 16; $i++)
				{	?><p><?php echo $ingredients[$i];?></p><?php } ?></div>
      <div id="quatre">
        <?php 
			for($i=8; $i < 16; $i++)
				{	?><p>
          <input type="checkbox" <?php if (in_array($ingredients[$i], $ingredientsFavoris)) { echo 'checked="checked"'; } ?> name="<?php echo $cpt; ?>saladeIngredients" id="<?php echo $ingredients[$i];?>" value="<?php echo $ingredients[$i];?>" />
        </p><?php 
				$cpt++;
				}
				// Modif CHR 2012-09-04
				//$cpt--;
				?>
      </div>
    </div>
    <div id="tableauSalades2">
    <p class="ssTitre">Les ingr&eacute;dients pas toujours disponibles</p>
    <p class="legende">Cochez les ingr&eacute;dients que vous souhaiteriez dans votre salade.
    Veuillez nous excuser par avance si l&rsquo;ingr&eacute;dient de votre choix n&rsquo;est pas   pr&eacute;sent le jour de votre r&eacute;servation.</p>
    <br />
      <p class="ssTitre">L&eacute;gumes</p>
      <div id="cinq"><p>
      <?php 
	  //Lister les légumes du jour
	  if(substr($ID_pointDeVente,0,3)=='LIV')
		{
		$listeLegumes = $platJour->getMenuJour($dateReservation,$ptLivraison->ID_pointDeVente,'legumes');
		}
	  else
	  	{
	  	$listeLegumes = $platJour->getMenuJour($dateReservation,$ID_pointDeVente,'legumes');
		}
	  //$listeLegumes="Choux rouges|Endives|Lentilles";
	  
	  if($listeLegumes)//IF legumes du jour renseignés
	  	{
		$listeLegumes = explode('|',$listeLegumes);
		  foreach($listeLegumes as $legume)
			{	
			if($legume)
				{?><span><?php echo $legume;?> 
				<input type="checkbox" <?php if (in_array($legume, $ingredientsFavoris)) { echo 'checked="checked"'; } ?> name="<?php echo $cpt++; ?>saladeIngredients" id="<?php echo $legume;?>" value="<?php echo $legume;?>" /></span><?php 
				// Modif CHR 2012-09-04
				//$cpt++;
				}
			}
			// Modif CHR 2012-09-04
			//$cpt--;
		}//FIN IF legumes du jour renseignés 
	else
		{//ELSE Afficher les 5 légumes par défaut?>
		<span>Choux blancs <input name="<?php echo $cpt++; ?>saladeIngredients" type="checkbox" value="Choux blancs" <?php if (in_array('Choux blancs', $ingredientsFavoris)) { echo 'checked="checked"'; } ?> /></span> 
        <span>Choux rouges <input name="<?php echo $cpt++; ?>saladeIngredients" type="checkbox" value="Choux rouges" <?php if (in_array('Choux rouges', $ingredientsFavoris)) { echo 'checked="checked"'; } ?>/></span>
        <span>Endives<input name="<?php echo $cpt++; ?>saladeIngredients" type="checkbox" value="Endives" <?php if (in_array('Endives', $ingredientsFavoris)) { echo 'checked="checked"'; } ?>/></span>
        <span>Fenouil<input name="<?php echo $cpt++; ?>saladeIngredients" type="checkbox" value="Fenouil" <?php if (in_array('Fenouil', $ingredientsFavoris)) { echo 'checked="checked"'; } ?>/></span>
        <span>Lentilles<input name="<?php echo $cpt++; ?>saladeIngredients" type="checkbox" value="Lentilles" <?php if (in_array('Lentilles', $ingredientsFavoris)) { echo 'checked="checked"'; } ?>/></span><?php
		}//FIN ELSE afficher les 5 légumes par défaut?></p>       
      </div>
      <div class="ajusteur">&nbsp;</div>
      <p class="ssTitre">F&eacute;culents</p>
      <div id="six">
        <p><?php 
		//Lister les féculents du jour
		if(substr($ID_pointDeVente,0,3)=='LIV')
		{
		$listeFeculents = $platJour->getMenuJour($dateReservation,$ptLivraison->ID_pointDeVente,'feculents');
		}
		else
		{
		$listeFeculents = $platJour->getMenuJour($dateReservation,$ID_pointDeVente,'feculents');
		}
		//$listeFeculents = "Pates|Quinoa";
		if($listeFeculents)//IF liste féculent du jour renseignés
			{
			$listeFeculents = explode('|',$listeFeculents);	
			foreach($listeFeculents as $feculent)
				{				
				if($feculent)
					{?>
					<span><?php echo $feculent;?> 
			<input type="checkbox" <?php if (in_array($feculent, $ingredientsFavoris)) { echo 'checked="checked"'; } ?> name="<?php echo $cpt++; ?>saladeIngredients" id="<?php echo $feculent;?>" value="<?php echo $feculent;?>" /></span><?php 
					// Modif CHR 2012-09-04
					//$cpt++;
					}
				}
				// Modif CHR 2012-09-04
				//$cpt--;
			}//FIN IF féculents du jour renseignés
		else//ELSE afficher féculents par défaut
			{?>
            <span>Bl&eacute; <input name="<?php echo $cpt++;?>saladeIngredients" type="checkbox" value="Ble" <?php if (in_array('Ble', $ingredientsFavoris)) { echo 'checked="checked"'; } ?> /></span>
            <span>Boulgour <input name="<?php echo $cpt++;?>saladeIngredients" type="checkbox" value="Boulgour" <?php if (in_array('Boulgour', $ingredientsFavoris)) { echo 'checked="checked"'; } ?> /></span>
            <span>P&acirc;tes <input name="<?php echo $cpt++;?>saladeIngredients" type="checkbox" value="Pates" <?php if (in_array('Pates', $ingredientsFavoris)) { echo 'checked="checked"'; } ?> /></span>
            <span>Quinoa <input name="<?php echo $cpt++;?>saladeIngredients" type="checkbox" value="Quinoa" <?php if (in_array('Quinoa', $ingredientsFavoris)) { echo 'checked="checked"'; } ?> /></span>
            <span>Riz <input name="<?php echo $cpt++;?>saladeIngredients" type="checkbox" value="Riz" <?php if (in_array('Riz', $ingredientsFavoris)) { echo 'checked="checked"'; } ?> /></span><?php
			}?></p>
      </div>
      <div class="ajusteur">&nbsp;</div>
      <p class="ssTitre">Graines</p>
      <div id="sept">
        <p><?php 
		//Lister les graines du jour
		if(substr($ID_pointDeVente,0,3)=='LIV')
		{
		$listeGraines = $platJour->getMenuJour($dateReservation,$ptLivraison->ID_pointDeVente,'graines');
		}
		else
		{
		$listeGraines = $platJour->getMenuJour($dateReservation,$ID_pointDeVente,'graines');
		}
		//$listeGraines = "Cranberries|Pralin|Tournesol";
		if($listeGraines)//IF liste graines du jour renseignées
			{
			$listeGraines = explode('|',$listeGraines);	
			foreach($listeGraines as $graine)
				{	
				if($graine)
					{?><span><?php echo $graine;?> 
                    <input type="checkbox" <?php if (in_array($graine, $ingredientsFavoris)) { echo 'checked="checked"'; } ?> name="<?php echo $cpt++; ?>saladeIngredients" id="<?php echo $graine;?>" value="<?php echo $graine;?>" /></span><?php 
                           // $cpt++;
					}
				}
				//$cpt--; 
			}
		else//ELSE afficher graines par défaut
			{?>
            <span>Amandes <input name="<?php echo $cpt++; ?>saladeIngredients" type="checkbox" value="Amandes" <?php if (in_array('Amandes', $ingredientsFavoris)) { echo 'checked="checked"'; } ?> /></span>
            <span>Cranberries <input name="<?php echo $cpt++; ?>saladeIngredients" type="checkbox" value="Cranberries" <?php if (in_array('Cranberries', $ingredientsFavoris)) { echo 'checked="checked"'; } ?> /></span>
            <span>Noix <input name="<?php echo $cpt++; ?>saladeIngredients" type="checkbox" value="Noix" <?php if (in_array('Noix', $ingredientsFavoris)) { echo 'checked="checked"'; } ?> /></span>
            <span>Pralin <input name="<?php echo $cpt++; ?>saladeIngredients" type="checkbox" value="Pralin" <?php if (in_array('Pralin', $ingredientsFavoris)) { echo 'checked="checked"'; } ?> /></span>
            <span>Tournesol <input name="<?php echo $cpt++; ?>saladeIngredients" type="checkbox" value="Tournesol" <?php if (in_array('Tournesol', $ingredientsFavoris)) { echo 'checked="checked"'; } ?> /></span><?php
			}?></p>
      </div>
    </div>