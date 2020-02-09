<?php


    //Lister les desserts du jour
	if(!$menuEstEnregistre) { 
		$nEstPasEnregistre = true;
		$soupeDaily = Tbq_famille::listerIngredients(2, 'ordreWeb', 'Daily',1);
		$soupeDiet = Tbq_famille::listerIngredients(2, 'ordreWeb', 'Diet',1);
		$soupeDaily = $soupeDaily[0]['ID'];
		$soupeDiet = $soupeDiet[0]['ID'];
	}
	
//check if id is correct. if not, then try to find the ID with sql request
$soupeFavorie = explode(',',$favori->soupe); 
$tabStockageProvisoir = array();
for($i=0; $i<count($soupeFavorie); $i++){
	
	$tabStockageProvisoir[$i] = Tbq_ingredient::checkIdForFavoris(trim($soupeFavorie[$i]));
}
$soupeFavorie = $tabStockageProvisoir;
?>

<div id="tableauSoupes">
      <center>
        <h3>*Faites Maison</h3>
      </center>
      <p>Faites le plein de fibres et de vitamines !</p>
      <?php
	  if ($menuEstEnregistre){
		  if(substr($ID_pointDeVente,0,3)=='LIV')
			{
			$soupeDaily = $platJour->getMenuJour($dateReservation,$ptLivraison->ID_pointDeVente,'soupe');
			}
			else
			{
		  $soupeDaily = $platJour->getMenuJour($dateReservation,$ID_pointDeVente,'soupe');
			}
	  }
	  if($soupeDaily)
	  	{?>
        <p><label class="soupe" for="<?php echo $soupeDaily; ?>"><input type="radio" name="radioSoupe" id="Soupe Daily" value="<?php echo $soupeDaily; ?>" <?php 
	  if ( in_array($soupeDaily,$soupeFavorie) || (! $favori->soupe) ) { echo 'checked="checked"'; } ?> /> <b>Soupe Daily</b> <em>
      	 <?php 
			$tbq_ingredient = new Tbq_ingredient();
			$tbq_ingredient->initialiser($soupeDaily);
			if( $tbq_ingredient->details )
				echo ' - '.$tbq_ingredient->details;
	  	}?></em></label></p>
     <?php
	 if ($menuEstEnregistre){
		  if(substr($ID_pointDeVente,0,3)=='LIV')
			{
			$soupeDiet = $platJour->getMenuJour($dateReservation,$ptLivraison->ID_pointDeVente,'soupeDiet');
			}
			else
			{
		  $soupeDiet = $platJour->getMenuJour($dateReservation,$ID_pointDeVente,'soupeDiet');
			}
	 }
	  if($soupeDiet)
	  	{?> <p><label class="soupe" for="<?php echo $soupeDiet; ?>"><input type="radio" name="radioSoupe" id="Soupe Diet" value="<?php echo $soupeDiet; ?>" <?php if (in_array($soupeDiet,$soupeFavorie)) { echo 'checked="checked"'; } ?> /> <b>Soupe Diet</b> <em><?php /*?>- Tout l&eacute;gumes sans cr&egrave;me (di&eacute;t&eacute;tique)<?php */?>
      	 <?php 
			$tbq_ingredient = new Tbq_ingredient();
			$tbq_ingredient->initialiser($soupeDiet);
			if( $tbq_ingredient->details )
				echo ' - '.$tbq_ingredient->details;
	  	}?></em></label>        
      </p>
      <div class="ajusteur">&nbsp;</div>
      
      <?php  
	  if ($soupeDiet){
	  	$option = Tbq_option::getOptionsParIngredient($soupeDiet);
		?>
        <input type="hidden" name="nbOptionSoupe" value="<?php echo count($option); ?>" />
        <?php
	  	  $index = 0;
		  foreach ($option as $opt){
			  ?>
				  <p><span>
				<input type="checkbox" name="<?php echo $index; ?>soupeIngredients" id="<?php echo $opt['libelle'] ?>" value="<?php echo $opt['ID'] ?>" <?php if (in_array($opt['ID'],$soupeFavorie)) { echo 'checked="checked"'; } ?> />
				<?php echo $opt['libelle'] ?></span></p>
			  <?php
			  $index++;
		  }
	  }

	  ?>
      
</div>