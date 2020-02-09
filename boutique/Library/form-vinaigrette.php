<?php
//check if id is correct. if not, then try to find the ID with sql request
$idVinaigreFav = Tbq_ingredient::checkIdForFavoris($favori->vinaigrette);

$vinaigrettes = Tbq_famille::listerIngredients(7, 'ordreWeb', '',1);

for ($i=0; $i<count($vinaigrettes); $i++){
	?>
     <p>
      <label class="smooth" for="<?php echo $vinaigrettes[$i]['libelle'].' : '.$vinaigrettes[$i]['details']; ?>"><?php echo '<b>'.$vinaigrettes[$i]['libelle'].'</b> : <em>'.$vinaigrettes[$i]['details'].'</em>'; ?></label>
      <input type="radio" name="radioVinaigrette" id="<?php echo $vinaigrettes[$i]['libelle']; ?>" value="<?php echo $vinaigrettes[$i]['ID']; ?>" <?php if ($idVinaigreFav==$vinaigrettes[$i]['ID']) { echo 'checked="checked"'; } ?> />
    </p>
    <?php
}

?>



