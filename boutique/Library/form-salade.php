<?php
//check if id is correct. if not, then try to find the ID with sql request
if(strstr($favori->salade,'|')){
	$ingredientsFavoris = explode('|',$favori->salade);
} 
if(strstr($favori->salade,',')) {
	$ingredientsFavoris = explode(',',$favori->salade);
}
$tabStockageProvisoir = array();
for($i=0; $i<count($ingredientsFavoris); $i++){
	
	$tabStockageProvisoir[$i] = Tbq_ingredient::checkIdForFavoris(trim($ingredientsFavoris[$i]));
}
$ingredientsFavoris = $tabStockageProvisoir;
?>



    <div id="tableauSalades">
      <p class="ssTitre">Les ingr&eacute;dients de votre salade<br />
        <br />
      </p>
      <?php 
			/*$commande = new Tbq_commande();
			$ingredients = $commande->ingredients;*/
		
		//$listeCategoriesIngredients = array('legumes','feculents','graines');
		$nbTotalIngredients = 0;
		$cat = 'salade';
		echo '<ul>';
		$indexClear = 0;
		//foreach ($listeCategoriesIngredients as $cat){
			
			 //Lister les ingredients du jour
			if($menuEstEnregistre){
				$ingredients = $platJour->getMenuJour($dateReservation,'1',$cat);
				$ingredients = substr($ingredients, 0, -1);
				$ingredients = explode('|', $ingredients);
			} else { //par défaut
			
				$ingredients = Tbq_famille::listerIngredients(1, 'ordreWeb', '' ,1);
				$tabProvisoire = array();
				for($i = 0; $i<count($ingredients); $i++){
					$tabProvisoire[$i] = $ingredients[$i]['ID'];
				}
				$ingredients = $tabProvisoire;
				
			}
			
			
			$nbIngredientPourCetteSousFamille = count($ingredients);
			$nbTotalIngredients += $nbIngredientPourCetteSousFamille;
			
			for ($x=0; $x < $nbIngredientPourCetteSousFamille; $x++){
				
				$tbq_ingredient = new Tbq_ingredient();
				$tbq_ingredient->initialiser($ingredients[$x]);
				
			?>
            	
                	<li style="width:200px; font-size:13px; list-style:none; text-align:right; float:left;  <?php if($indexClear%2==0){ echo 'clear:both'; } ?>">
						<?php echo $tbq_ingredient->libelle;?>
                    </li>
            		<li style="width:50px; list-style:none; float:left;">
                    		<input 	type="checkbox" <?php if (in_array($tbq_ingredient->ID, $ingredientsFavoris)) { echo 'checked="checked"'; } ?> 
                            		name="<?php echo $indexClear; ?>saladeIngredients" 
                                    id="<?php echo $tbq_ingredient->libelle;?>" 
                                    value="<?php echo $tbq_ingredient->ID;?>" />
                    </li>
                
			<?php 
				$indexClear++;
			}
		//}
		echo '</ul>';
		
?>
    </div>
    <input type="hidden" name="nbIngredientsSalade" value="<?php echo $nbTotalIngredients; ?>" />
  