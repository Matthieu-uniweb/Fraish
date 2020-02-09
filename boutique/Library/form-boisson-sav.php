<?php
$boissonFavorite = explode(' ',$favori->boisson);?>
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
?>
      <label for="Daily Juice">Daily Juice</label>
        <input type="radio" name="radioBoisson" id="DailyJuice" value="DailyJuice" onclick="javascript:affichageDailyJuice();" <?php
        if($boissonFavorite[0]=='DailyJuice')
			{
			echo 'checked="checked"';
			}?>/>&nbsp; <?php
        if($jusJour)
			{?>
            <em>- <?php echo $jusJour;?> -</em><?php
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
      <p>
        <label class="smooth" for="WOMEN - lait de soja, banane, fraise -"><b>WOMEN</b> <em>- lait de soja, banane, fraise -</em></label>
        <input type="radio" name="radioSmoothies" id="WOMEN" value="WOMEN - lait de soja, banane, fraise -" <?php 
		if ( (in_array('WOMEN',$boissonFavorite)) || (! $favori->boisson) ) { echo 'checked="checked"'; } ?> />
      </p>
      <p>
        <label class="smooth" for="RED - fruits rouges, sorbet fraise, lait -"><b>RED</b> <em> - fruits rouges, sorbet fraise, lait -</em></label>
        <input type="radio" name="radioSmoothies" id="RED" value="RED - fruits rouges, sorbet fraise, lait -" <?php if (in_array('RED',$boissonFavorite)) { echo 'checked="checked"'; } ?> />
      </p>
      <p>
        <label class="smooth" for="COCO - coco, banane, glace vanille, lait de soja -"><b>COCO</b> <em>- coco, banane, glace vanille, lait de soja -</em></label>
        <input type="radio" name="radioSmoothies" id="COCO" value="COCO - coco, banane, glace vanille, lait de soja -" <?php if (in_array('COCO',$boissonFavorite)) { echo 'checked="checked"'; } ?> />
      </p>
      <p>
        <label class="smooth" for="STARTER - yaourt 0%, banane, miel, c&eacute;r&eacute;ales, lait de soja -"><b>STARTER</b> <em>- yaourt 0%, banane, miel, c&eacute;r&eacute;ales, lait de soja -</em></label>
        <input type="radio" name="radioSmoothies" id="STARTER" value="STARTER - yaourt 0%, banane, miel, c&eacute;r&eacute;ales, lait de soja -" <?php if (in_array('STARTER',$boissonFavorite)) { echo 'checked="checked"'; } ?> />
      </p>
      <?php /*?><p>
        <label class="smooth" for="ORIENT - figue, abricot, yaourt 0%, lait -"><b>ORIENT</b> <em>- figue, abricot, yaourt 0%, lait -</em></label>
        <input type="radio" name="radioSmoothies" id="ORIENT" value="ORIENT - figue, abricot, yaourt 0%, lait -" <?php if (in_array('ORIENT',$boissonFavorite)) { echo 'checked="checked"'; } ?> />
      </p><?php */?>
      <p>
        <label class="smooth" for="LATINO - mangue, orange, ananas, lait de soja -"><b>LATINO</b> <em>- mangue, orange, ananas, lait de soja -</em></label>
        <input type="radio" name="radioSmoothies" id="LATINO" value="LATINO - mangue, orange, ananas, lait de soja -" <?php if (in_array('LATINO',$boissonFavorite)) { echo 'checked="checked"'; } ?> />
      </p>
      <p>
        <label class="smooth" for="ASIAN - mangue, cannelle, pomme, lait de soja -"><b>ASIAN</b> <em>- mangue, cannelle, pomme, lait de soja -</em></label>
        <input type="radio" name="radioSmoothies" id="ASIAN" value="ASIAN - mangue, cannelle, pomme, lait de soja -" <?php if (in_array('ASIAN',$boissonFavorite)) { echo 'checked="checked"'; } ?> />
      </p>
      <p>
        <label class="smooth" for="MILK CHOKY - banane, choco, glace vanille, lait -"><b>MILK CHOKY</b> <em>- banane, choco, glace vanille, lait -</em></label>
        <input type="radio" name="radioSmoothies" id="MILK CHOKY" value="MILK CHOKY - banane, choco, glace vanille, lait -" <?php if (in_array('CHOKY',$boissonFavorite)) { echo 'checked="checked"'; } ?> />
      </p>
      <p>
        <label class="smooth" for="MILK FRAISY - banane, fraise, glace vanille, lait -"><b>MILK FRAISY</b> <em>- banane, fraise, glace vanille, lait -</em></label>
        <input type="radio" name="radioSmoothies" id="MILK FRAISY" value="MILK FRAISY - banane, fraise, glace vanille, lait -" <?php if (in_array('FRAISY',$boissonFavorite)) { echo 'checked="checked"'; } ?> />
      </p>
      
      <?php //RAJOUT 2011-03-04 ?>
      <p>
        <label class="smooth" for="JOLY - Carotte, Orange, Fraise -"><b>JOLY</b> <em>- Carotte, Orange, Fraise -</em></label>
        <input type="radio" name="radioSmoothies" id="JOLY" value="JOLY - Carotte, Orange, Fraise -" <?php if (in_array('JOLY',$boissonFavorite)) { echo 'checked="checked"'; } ?> />
      </p>
      <?php /*?><p>
        <label class="smooth" for="POM POIRE - Pomme, Poire, Fraise, Orange -"><b>POM POIRE</b> <em>- Pomme, Poire, Fraise, Orange -</em></label>
        <input type="radio" name="radioSmoothies" id="POM POIRE" value="POM POIRE - Pomme, Poire, Fraise, Orange -" <?php if (in_array('POIRE',$boissonFavorite)) { echo 'checked="checked"'; } ?> />
      </p><?php */?>
      <?php /*?><p>
        <label class="smooth" for="PUNCHY - Pêche, Mangue, Ananas -"><b>PUNCHY</b> <em>- Pêche, Mangue, Ananas -</em></label>
        <input type="radio" name="radioSmoothies" id="PUNCHY" value="PUNCHY - Pêche, Mangue, Ananas -" <?php if (in_array('PUNCHY',$boissonFavorite)) { echo 'checked="checked"'; } ?> />
      </p><?php */?>
      <?php //FIN RAJOUT 2011-03-04 ?>
      
      <p>
        <label class="smooth" for="MY - 3 ingr&eacute;dients au choix -"><b>MY </b><em> - 3 ingr&eacute;dients au choix -</em></label>
        <input type="radio" name="radioSmoothies" id="MY" value="MY - 3 ingr&eacute;dients au choix -" onclick="afficherMySmoothies();" />
        <br /><input type="text" size="30" name="myingredientsSmoothies" id="myingredientsSmoothies" value="" style="margin:5px;display:none;border:solid 1px #000000;float:right;" />
      </p> 
    </div>
    <div id="tableauJusDeFruits" style="visibility:hidden;">
      <p>
        <label class="smooth" for="ENERGY - orange, banane, fraise -"><b>ENERGY </b><em> - orange, banane, fraise -</em></label>
        <input type="radio" name="radioJusDeFruits" id="ENERGY" value="ENERGY - orange, banane, fraise -" checked="checked" <?php if (in_array('ENERGY',$boissonFavorite)) { echo 'checked="checked"'; } ?> />
      </p>
      <p>
        <label class="smooth" for="TROPIK - ananas, orange, banane -"><b>TROPIK </b><em> - ananas, orange, banane -</em></label>
        <input type="radio" name="radioJusDeFruits" id="TROPIK" value="TROPIK - ananas, orange, banane -" <?php if (in_array('TROPIK',$boissonFavorite)) { echo 'checked="checked"'; } ?> />
      </p>
      
      <p>
        <label class="smooth" for="SLIM - pomme, pamplemousse, ananas, fruits rouges -"><b>SLIM </b><em> - pomme, pamplemousse, ananas, fruits rouges -</em></label>
        <input type="radio" name="radioJusDeFruits" id="SLIM" value="SLIM - pomme, pamplemousse, ananas, fruits rouges -" <?php if (in_array('SLIM',$boissonFavorite)) { echo 'checked="checked"'; } ?> />
      </p>
      <p>
        <label class="smooth" for="ANTIOXY - th&eacute; vert, fruits rouges, pomme, framboise -"><b>ANTIOXY </b><em> - th&eacute; vert, fruits rouges, pomme, framboise -</em></label>
        <input type="radio" name="radioJusDeFruits" id="ANTIOXY" value="ANTIOXY - th&eacute; vert, fruits rouges, pomme, framboise -" <?php if (in_array('ANTIOXY',$boissonFavorite)) { echo 'checked="checked"'; } ?> />
      </p>
      <p>
        <label class="smooth" for="KIPIK - pamplemousse, orange, citron -"><b>KIPIK </b><em> - pamplemousse, orange, citron -</em></label>
        <input type="radio" name="radioJusDeFruits" id="KIPIK" value="KIPIK - pamplemousse, orange, citron -" <?php if (in_array('KIPIK',$boissonFavorite)) { echo 'checked="checked"'; } ?> />
      </p>
      <p>
        <label class="smooth" for="SUNNY - mangue, ananas, orange -"><b>SUNNY </b><em> - mangue, ananas, orange -</em></label>
        <input type="radio" name="radioJusDeFruits" id="SUNNY" value="SUNNY - mangue, ananas, orange -" <?php if (in_array('SUNNY',$boissonFavorite)) { echo 'checked="checked"'; } ?> />
      </p>
      <p>
        <label class="smooth" for="KAROTEN - carotte, orange, citron -"><b>KAROTEN </b><em> - carotte, orange, citron -</em></label>
        <input type="radio" name="radioJusDeFruits" id="KAROTEN" value="KAROTEN - carotte, orange, citron -" <?php if (in_array('KAROTEN',$boissonFavorite)) { echo 'checked="checked"'; } ?> />
      </p>
      <p>
        <label class="smooth" for="PROTECT - carotte, orange, pomme, gingembre -"><b>PROTECT </b><em> - carotte, orange, pomme, gingembre -</em></label>
        <input type="radio" name="radioJusDeFruits" id="PROTECT" value="PROTECT - carotte, orange, pomme, gingembre -" <?php if (in_array('PROTECT',$boissonFavorite)) { echo 'checked="checked"'; } ?> />
      </p>
      <p>
        <label class="smooth" for="MY - 3 ingr&eacute;dients au choix -"><b>MY </b><em> - 3 ingr&eacute;dients au choix -</em></label>
        <input type="radio" name="radioJusDeFruits" id="MY" value="MY - 3 ingr&eacute;dients au choix -" onclick="afficherMyJusDeFruit();" />
        <br /><input type="text" size="30" name="myingredientsJusDeFruits" id="myingredientsJusDeFruits" value="" style="margin:5px;display:none;border:solid 1px #000000;float:right;" />
      </p>
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