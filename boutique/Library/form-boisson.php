<?php
$boissonFavorite = explode(' ',$favori->boisson); 
$tabStockageProvisoir = array();
for($i=0; $i<count($boissonFavorite); $i++){
	//check if id is correct. if not, then try to find the ID with sql request
	$tabStockageProvisoir[$i] = Tbq_ingredient::checkIdForFavoris($boissonFavorite[$i]);
}
$boissonFavorite = $tabStockageProvisoir;
?>



<div id="choixMenuG">
<p><?php 
if(substr($ID_pointDeVente,0,3)=='LIV')
		{
		$jusJour = $platJour->getMenuJour($dateReservation,$ptLivraison->ID_pointDeVente,'jus');
		}
	else
		{
$jusJour = $platJour->getMenuJour($dateReservation,$ID_pointDeVente,'jus');
		}
		
		
	$sousFamilles = Tbq_ingredient::getSsFamilles(5);	
	foreach ($sousFamilles as $ssFamille){
		?>
        <label for="Daily Juice"><?php $ssFamille['libelleSousFamille']; ?></label>
        <?php
	}
		

?>
      <label for="Daily Juice">Daily Juice</label>
        <input type="radio" name="radioBoisson" id="DailyJuice" value="DailyJuice" onclick="javascript:affichageDailyJuice();" <?php
        if($boissonFavorite[0]=='DailyJuice')
			{
			echo 'checked="checked"';
			}?>/>&nbsp; <?php
        if($jusJour)
			{?>
            <em>
			<?php 
			$tbq_ingredient = new Tbq_ingredient();
			$tbq_ingredient->initialiser($jusJour);
			if($tbq_ingredient->details){
				echo ' - '.$tbq_ingredient->details;
			}
			?> </em><?php
			}?>
        </p>
</div>        
<div class="ajusteur"></div>
<div id="choixMenuG">
<p>
        <label for="Smoothies">Smoothies</label>
        <input type="radio" name="radioBoisson" id="Smoothies" value="Smoothies" onClick="affichageSmoothies();" <?php 
		if ($boissonFavorite[0]=='Smoothies') 
			{ 
			echo 'checked="checked"';
			} ?> />
        
      </p>
      
    </div>
    <div id="choixMenuD">
      <p>
        <label for="Jus de fruits">Jus de fruits</label>
        <input type="radio" name="radioBoisson" id="JusDeFruits" value="JusDeFruits" onClick="affichageJusDeFruits();" <?php if ($boissonFavorite[0]=='Jus') { echo 'checked="checked"'; } ?> />
      </p>
    </div>
    <div id="tableauSmoothies" style="display:none;">
    	<?php
		$smoothies = Tbq_famille::listerIngredients(5, 'ordreWeb', 'Smoothies',1);
		foreach ($smoothies as $boisson){
			?>
            <p>
                <label class="smooth" for="<?php echo $boisson['libelle']; ?>"><b><?php echo $boisson['libelle']; ?></b> - <em><?php echo $boisson['details']; ?></em></label>
                 <?php 
				if($boisson['libelle'] == 'MY'){
				?>
                <input type="radio" name="radioSmoothies" id="<?php echo $boisson['libelle']; ?>" value="<?php echo $boisson['ID'].' - '.$boisson['details']; ?>" onclick="afficherMySmoothies();" />
       			 <br /><input type="text" size="30" name="myingredientsSmoothies" id="myingredientsSmoothies" value="" style="margin:5px;display:none;border:solid 1px #000000;float:right;" />
                 <?php
				} else {
				?>
                <input type="radio" name="radioSmoothies" id="<?php echo $boisson['libelle']; ?>" value="<?php echo $boisson['ID']; ?>" <?php 
                if ( (in_array($boisson['ID'],$boissonFavorite)) || (! $favori->boisson) ) { echo 'checked="checked"'; } ?> />
                <?php
                }
                ?>
            </p>
            <?php
		}
		?>
      
    </div>
    <div id="tableauJusDeFruits" style="visibility:hidden;">
    
    <?php
		$jusdefruit = Tbq_famille::listerIngredients(5, 'ordreWeb', 'Jus de fruits', 1);
		foreach ($jusdefruit as $boisson){
			?>
            <p>
                <label class="smooth" for="<?php echo $boisson['libelle']; ?>"><b><?php echo $boisson['libelle']; ?></b> - <em><?php echo $boisson['details']; ?></em></label>
                <?php 
				if($boisson['libelle'] == 'MY'){
				?>
                <input type="radio" name="radioJusDeFruits" id="<?php echo $boisson['libelle']; ?>" value="<?php echo $boisson['ID'].' - '.$boisson['details']; ?>" onclick="afficherMyJusDeFruit();" />
       			 <br /><input type="text" size="30" name="myingredientsJusDeFruits" id="myingredientsJusDeFruits" value="" style="margin:5px;display:none;border:solid 1px #000000;float:right;" />
                 <?php
				} else {
				?>
                <input type="radio" name="radioJusDeFruits" id="<?php echo $boisson['libelle']; ?>" value="<?php echo $boisson['ID']; ?>" <?php 
                if ( (in_array($boisson['ID'],$boissonFavorite)) || (! $favori->boisson) ) { echo 'checked="checked"'; } ?> />
                <?php
                }
                ?>
            </p>
            <?php
		}
	?>
      <p>
</div>
<?php
if ($boissonFavorite[0]=='Smoothies') 
	{?>
	<script>affichageSmoothies();</script><?php
	}

if($boissonFavorite[0]=='Jus')
	{?>
    <script>affichageJusDeFruits();</script><?php
    }
if($boissonFavorite[0]=='DailyJuice')
	{?>
    <script>affichageDailyJuice();</script><?php
	}