<p>
          <label class="smooth" for="Méditerranéenne : Huile d'olive - Vinaigre Balsamique - Moutarde - Sel - Poivre -"><b>M&eacute;diterran&eacute;enne</b> <em>- Huile d'olive - Vinaigre Balsamique - Moutarde - Sel - Poivre -</em></label>
          <input type="radio" name="radioVinaigrette" id="Méditerranéenne" value="Mediterraneenne" <?php if ( ($favori->vinaigrette=='Mediterraneenne') || (! $favori->vinaigrette) ) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <label class="smooth" for="Bulgare : Citron - Yaourt - Sel – Poivre (sans huile) -"><b>Bulgare</b> <em>- Citron - Yaourt - Sel - Poivre (sans huile) -</em></label>
          <input type="radio" name="radioVinaigrette" id="Bulgare" value="Bulgare" <?php if ($favori->vinaigrette=='Bulgare') { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <label class="smooth" for="Indienne : Curry – Citron – Yaourt – Sel – Poivre (sans huile) -"><b>Indienne</b> <em>- Curry - Citron - Yaourt - Sel - Poivre (sans huile) -</em></label>
          <input type="radio" name="radioVinaigrette" id="Indienne" value="Indienne" <?php if ($favori->vinaigrette=='Indienne') { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <label class="smooth" for="Provençale : Huile d'Olive - Vinaigre de Vin - Herbe de Provence - Sel - Poivre -"><b>Proven&ccedil;ale</b> <em>- Huile d'Olive - Vinaigre de Vin - Herbe de Provence - Sel - Poivre -</em></label>
          <input type="radio" name="radioVinaigrette" id="Proven&ccedil;ale" value="Provencale" <?php if ($favori->vinaigrette=='Provencale') { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <label class="smooth" for="Miel : Miel - Moutarde - Huile d'olive – Sel - Poivre -"><b>Miel</b> <em>- Miel - Moutarde - Huile d'olive - Sel - Poivre -</em></label>
          <input type="radio" name="radioVinaigrette" id="Miel" value="Miel" <?php if ($favori->vinaigrette=='Miel') { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <label class="smooth" for="Sans vinaigrette"><b>Sans vinaigrette</b></label>
          <input type="radio" name="radioVinaigrette" id="Sans vinaigrette" value="Sans vinaigrette" <?php if ($favori->vinaigrette=='Sans vinaigrette') { echo 'checked="checked"'; } ?> />
        </p>
        
        
<?php
$vinaigrettes = Tbq_famille::listerIngredients(7, 'libelle', '');

for ($i=0; $i<count($vinaigrettes); $i++){
	?>
     <p>
      <label class="smooth" for="<?php echo $vinaigrettes[$i]['libelle']; ?>"><?php echo $vinaigrettes[$i]['libelle']; ?></label>
      <input type="radio" name="radioVinaigrette" id="Miel" value="<?php echo $vinaigrettes[$i]['libelle']; ?>" <?php if ($favori->vinaigrette==$vinaigrettes[$i]['libelle']) { echo 'checked="checked"'; } ?> />
    </p>
    <?php
}

?>



