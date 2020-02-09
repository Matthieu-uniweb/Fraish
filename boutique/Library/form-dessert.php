<?php
$dessertFavori = explode('|',$favori->dessert);

//check if id is correct. if not, then try to find the ID with sql request
$dessertFavori = Tbq_ingredient::checkIdForFavoris($dessertFavori[0]);

?>
    <p><?php 
	
	
	
    //Lister les desserts du jour
	if($menuEstEnregistre){
		$ingredientsDessert = $platJour->getMenuJour($dateReservation,'1','desserts');
		$ingredientsDessert = substr($ingredientsDessert, 0, -1);
		$ingredientsDessert = explode('|', $ingredientsDessert);
	} else { //par défaut
		$ingredientsDessert = Tbq_famille::listerIngredients(4, 'ordreWeb', '',1);
		$tabProvisoire = array();
		for($i = 0; $i<count($ingredientsDessert); $i++){
			$tabProvisoire[$i] = $ingredientsDessert[$i]['ID'];
		}
		$ingredientsDessert = $tabProvisoire;
	}
	
	if(!$modeSupplement) {
	
	for ($x=0; $x<count($ingredientsDessert); $x++){
		
		$tbq_ingredient = new Tbq_ingredient();
		$tbq_ingredient->initialiser($ingredientsDessert[$x]);
				
		
			?>
			<p><input name="radioDessert" type="radio" value="<?php echo $tbq_ingredient->ID; ?>" <?php if ($dessertFavori==$tbq_ingredient->ID || !$dessertFavori) 			{ echo 'checked="checked"'; } ?> /><?php echo $tbq_ingredient->libelle; ?></p>
			<?php
			}//fin for
	}else{?>
		<table><?php
		$tabDesserts = array('Cake carotte et noix','Fruits a croquer','Yaourt');
		foreach($tabDesserts as $itemDessert)
			{
			$i++;?>
			<tr>
				<td><input type="hidden" name="sup[<?php echo $i;?>][nom]" value="<?php echo $itemDessert;?>" />
				<input type="hidden" name="sup[<?php echo $i;?>][prix]" value="2.6" /</td>				
				<td style="width:170px;"><?php echo $itemDessert;?></td>
				<td>quantit&eacute;&nbsp;<input type="text" name="sup[<?php echo $i;?>][qte]" value="0" class="inputQte"/></td><?php
			//$i++;?>
			</tr><?php
			}
			$i++;?>
		</table><?php
	}?></p>