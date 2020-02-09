<?
session_start();

if (! $_SESSION['ID_client'])
	{ header("Location: ../login.php"); }
	
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/classes.inc.php';
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/includes/classes/paquetage.inc.php';

$favori = new Tbq_client_favori($_GET['ID_menuFavori']);
$plat = explode(', ', $favori->plat);
$pointDeVente = new Tbq_user();
$pointsDeVente = $pointDeVente->lister();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Fraish r&eacute;servation</title>
<link rel="stylesheet" type="text/css" href="/includes/styles/admin.css" />
<link rel="stylesheet" type="text/css" href="/includes/styles/formulaire.css" />
<link rel="stylesheet" type="text/css" href="/includes/styles/global.css" />
<link rel="stylesheet" type="text/css" href="/includes/styles/calendrier.css" />
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />
<link rel="icon" type="image/x-icon" href="/favicon.ico" />
<script type="text/javascript" src="/includes/javascript/masques.js"></script>
<script src="../../includes/plugins/tinymce/jscripts/tiny_mce/tiny_mce.js" type="text/javascript"></script>
<script src="/boutique/includes/javascript/bq_admin-boutique.js" type="text/javascript"></script>
<script src="../../includes/javascript/reserver.js" type="text/javascript"></script>
<style type="text/css">
<!--
.Style1 {
	color: #990000
}
-->
</style>
</head>
<body>
<div id="page">
<a href="espace-client.php">&lt; Retour</a>
<div id="enTete">&nbsp;
</div>
<div id="contenu">
<h1>Votre menu favori</h1>  
  <form method="post" id="formulaireMenu" action="../scripts/sauver-menu-favori.php" onsubmit="return verifierMenu(this);">
    <h3>Enregistrer votre menu favori:</h3>
	<div id="choixPointDeVente">
      <p>
        <label for="pointDeVente">Menu à retirer à : </label>
        <select name="ID_pointDeVente"><option value="">Sélectionnez le point de vente</option><?php foreach ($pointsDeVente as $point) { ?><option value="<?php echo $point->ID;?>" <?php if ($favori->ID_pointDeVente==$point->ID) { echo 'selected="selected"'; } ?>><?php echo $point->pointDeVente;?></option><?php } ?></select>
      </p>
    </div>
    <div id="choixMenu">
      <p>
        <label for="salades">Salades</label>
        <input type="radio" <?php if ($favori->typePlat=='salades') { echo 'checked="checked"'; } ?> name="radioMenu" id="salades" value="salades" onClick="affichageMenuSalades();" />
      </p>
    </div>
    <div id="choixMenuS">
      <p>
        <label for="soupes">Soupes</label>
        <input type="radio" <?php if ($favori->typePlat=='soupes') { echo 'checked="checked"'; } ?> name="radioMenu" id="soupes" value="soupes" onClick="affichageMenuSoupes();" />
      </p>
    </div>
    <div class="ajusteur">&nbsp;</div>
    <div id="tableauSalades" style="visibility:hidden">
      <p class="ssTitre">Les ingrédients toujours disponibles<br />
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
				?><p><input type="checkbox" <?php if (in_array($ingredients[$i], $plat)) { echo 'checked="checked"'; } ?> name="<?php echo $cpt; ?>saladeIngredients" id="<?php echo $ingredients[$i];?>" value="<?php echo $ingredients[$i];?>" /></p><?php 
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
          <input type="checkbox" <?php if (in_array($ingredients[$i], $plat)) { echo 'checked="checked"'; } ?> name="<?php echo $cpt; ?>saladeIngredients" id="<?php echo $ingredients[$i];?>" value="<?php echo $ingredients[$i];?>" />
        </p><?php 
				$cpt++;
				} ?>
      </div>
    </div>
    <div id="tableauSalades2" style="visibility:hidden">
    <p class="ssTitre">Les ingrédients pas toujours disponibles</p>
    <p class="legende">Cochez les ingr&eacute;dients que vous souhaiteriez dans votre salade.
    Veuillez nous excuser par avance si l&rsquo;ingr&eacute;dient de votre choix n&rsquo;est pas   pr&eacute;sent le jour de votre r&eacute;servation.</p>
    <br />
      <p class="ssTitre">Légumes</p>
      <div id="cinq"><p>
      <?php 
			for($i=16; $i < 21; $i++)
				{	?><span><?php echo $ingredients[$i];?> 
        <input type="checkbox" <?php if (in_array($ingredients[$i], $plat)) { echo 'checked="checked"'; } ?> name="<?php echo $cpt; ?>saladeIngredients" id="<?php echo $ingredients[$i];?>" value="<?php echo $ingredients[$i];?>" /></span><?php 
				$cpt++;
				} ?></p>       
      </div>
      <div class="ajusteur">&nbsp;</div>
      <p class="ssTitre">Féculents</p>
      <div id="six">
        <p><?php 
			for($i=21; $i < 26; $i++)
				{	?><span><?php echo $ingredients[$i];?> 
        <input type="checkbox" <?php if (in_array($ingredients[$i], $plat)) { echo 'checked="checked"'; } ?> name="<?php echo $cpt; ?>saladeIngredients" id="<?php echo $ingredients[$i];?>" value="<?php echo $ingredients[$i];?>" /></span><?php 
				$cpt++;
				} ?></p>
      </div>
      <div class="ajusteur">&nbsp;</div>
      <p class="ssTitre">Graines</p>
      <div id="sept">
        <p><?php 
			for($i=26; $i < 31; $i++)
				{	?><span><?php echo $ingredients[$i];?> 
        <input type="checkbox" <?php if (in_array($ingredients[$i], $plat)) { echo 'checked="checked"'; } ?> name="<?php echo $cpt; ?>saladeIngredients" id="<?php echo $ingredients[$i];?>" value="<?php echo $ingredients[$i];?>" /></span><?php 
				$cpt++;
				} ?></p>
      </div>
    </div>
    <div id="tableauSalades3" style="visibility:hidden">
      <p class="ssTitre">Vinaigrette</p>
      <div id="huit">
        <p>
          <label class="smooth" for="Méditerranéenne : Huile d'olive - Vinaigre Balsamique - Moutarde - Sel - Poivre -"><b>Méditerranéenne</b> <em>- Huile d'olive - Vinaigre Balsamique - Moutarde - Sel - Poivre -</em></label>
          <input type="radio" <?php if ( ($favori->vinaigrette=='Méditerranéenne') || (! $favori->vinaigrette) ) { echo 'checked="checked"'; } ?> name="radioVinaigrette" id="Méditerranéenne" value="Méditerranéenne" />
        </p>
        <p>
          <label class="smooth" for="Bulgare : Citron - Yaourt - Sel – Poivre (sans huile) -"><b>Bulgare</b> <em>- Citron - Yaourt - Sel – Poivre (sans huile) -</em></label>
          <input type="radio" <?php if ($favori->vinaigrette=='Bulgare') { echo 'checked="checked"'; } ?> name="radioVinaigrette" id="Bulgare" value="Bulgare" />
        </p>
        <p>
          <label class="smooth" for="Indienne : Curry – Citron – Yaourt – Sel – Poivre (sans huile) -"><b>Indienne</b> <em>- Curry – Citron – Yaourt – Sel – Poivre (sans huile) -</em></label>
          <input type="radio" <?php if ($favori->vinaigrette=='Indienne') { echo 'checked="checked"'; } ?> name="radioVinaigrette" id="Indienne" value="Indienne" />
        </p>
        <p>
          <label class="smooth" for="Provençale : Huile d'Olive - Vinaigre de Vin - Herbe de Provence – Sel - Poivre -"><b>Provençale</b> <em>- Huile d'Olive - Vinaigre de Vin - Herbe de Provence – Sel - Poivre -</em></label>
          <input type="radio" <?php if ($favori->vinaigrette=='Provençale') { echo 'checked="checked"'; } ?> name="radioVinaigrette" id="Provençale" value="Provençale" />
        </p>
        <p>
          <label class="smooth" for="Sans vinaigrette"><b>Sans vinaigrette</b></label>
          <input type="radio" <?php if ($favori->vinaigrette=='Sans vinaigrette') { echo 'checked="checked"'; } ?> name="radioVinaigrette" id="Sans vinaigrette" value="Sans vinaigrette" />
        </p>
      </div>
    </div>
    <?php $cpt2 = 0; ?>
    <div id="tableauSoupes" style="visibility:hidden">
      <center>
        <h3>*Faites Maison</h3>
      </center>
      <p>Faites le plein de fibres et de vitamines !</p>
      <p><label class="soupe" for="Soupe Daily : Recette du jour"><input type="radio" name="radioSoupe" id="Soupe Daily" value="Soupe Daily" <?php if ( (in_array('Soupe Daily', $plat)) || (! $favori->plat) ) { echo 'checked="checked"'; } ?> /> <b>Soupe Daily</b> <em> - Recette du jour -</em></label></p>
      <p><label class="soupe" for="Soupe Diet : Tout légumes sans crème (diététique) -"><input type="radio" name="radioSoupe" id="Soupe Diet" value="Soupe Diet" <?php if (in_array('Soupe Diet', $plat)) { echo 'checked="checked"'; } ?> /> <b>Soupe Diet</b> <em>- Tout légumes sans crème (diététique) -</em></label>        
      </p>
      <div class="ajusteur">&nbsp;</div>
      <p><span>
        <input type="checkbox" <?php if (in_array('Avec croutons', $plat)) { echo 'checked="checked"'; } ?> name="<?php echo $cpt2; $cpt2++; ?>soupeIngredients" id="Avec croutons" value="Avec croutons" />
        Avec croutons</span></p>
      <p><span>
        <input type="checkbox" <?php if (in_array('Avec Emmental', $plat)) { echo 'checked="checked"'; } ?> name="<?php echo $cpt2; $cpt2++; ?>soupeIngredients" id="Avec Emmental" value="Avec Emmental" />
        Avec Emmental</span></p>
      <p><span>
        <input type="checkbox" <?php if (in_array('Avec Fourme d’Ambert', $plat)) { echo 'checked="checked"'; } ?> name="<?php echo $cpt2; $cpt2++; ?>soupeIngredients" id="Avec Fourme d’Ambert" value="Avec Fourme d’Ambert" />
        Avec Fourme d’Ambert</span></p>
    </div>
    <div class="ajusteur">&nbsp;</div>
    <div id="choixMenuG" style="visibility:hidden">
      <p>
        <label for="Smoothies">Smoothies</label>
        <input type="radio" <?php if ($favori->typeBoisson=='Smoothies') { echo 'checked="checked"'; } ?> name="radioBoisson" id="Smoothies" value="Smoothies" onClick="affichageSmoothies();"/>
      </p>
    </div>
    <div id="choixMenuD" style="visibility:hidden">
      <p>
        <label for="Jus de fruits">Jus de fruits</label>
        <input type="radio" <?php if ($favori->typeBoisson=='JusDeFruits') { echo 'checked="checked"'; } ?> name="radioBoisson" id="JusDeFruits" value="JusDeFruits" onClick="affichageJusDeFruits();"/>
      </p>
    </div>
    <div id="tableauSmoothies" style="visibility:hidden">
      <p>
        <label class="smooth" for="WOMEN - lait de soja, banane, fraise -"><b>WOMEN</b> <em>- lait de soja, banane, fraise -</em></label>
        <input type="radio" <?php if ( ($favori->boisson=='WOMEN - lait de soja, banane, fraise -') || (! $favori->boisson) ) { echo 'checked="checked"'; } ?> name="radioSmoothies" id="WOMEN" value="WOMEN - lait de soja, banane, fraise -" />
      </p>
      <p>
        <label class="smooth" for="RED - fruits rouges, sorbet fraise, lait -"><b>RED</b> <em> - fruits rouges, sorbet fraise, lait -</em></label>
        <input type="radio" <?php if ($favori->boisson=='RED - fruits rouges, sorbet fraise, lait -') { echo 'checked="checked"'; } ?> name="radioSmoothies" id="RED" value="RED - fruits rouges, sorbet fraise, lait -" />
      </p>
      <p>
        <label class="smooth" for="COCO - coco, banane, glace vanille, lait de soja -"><b>COCO</b> <em>- coco, banane, glace vanille, lait de soja -</em></label>
        <input type="radio" <?php if ($favori->boisson=='COCO - coco, banane, glace vanille, lait de soja -') { echo 'checked="checked"'; } ?> name="radioSmoothies" id="COCO" value="COCO - coco, banane, glace vanille, lait de soja -" />
      </p>
      <p>
        <label class="smooth" for="STARTER - yaourt 0%, banane, miel, c&eacute;r&eacute;ales, lait de soja -"><b>STARTER</b> <em>- yaourt 0%, banane, miel, c&eacute;r&eacute;ales, lait de soja -</em></label>
        <input type="radio" <?php if ($favori->boisson=='STARTER - yaourt 0%, banane, miel, c&eacute;r&eacute;ales, lait de soja -') { echo 'checked="checked"'; } ?> name="radioSmoothies" id="STARTER" value="STARTER - yaourt 0%, banane, miel, c&eacute;r&eacute;ales, lait de soja -" />
      </p>
      <p>
        <label class="smooth" for="ORIENT - figue, abricot, yaourt 0%, lait -"><b>ORIENT</b> <em>- figue, abricot, yaourt 0%, lait -</em></label>
        <input type="radio" <?php if ($favori->boisson=='ORIENT - figue, abricot, yaourt 0%, lait -') { echo 'checked="checked"'; } ?> name="radioSmoothies" id="ORIENT" value="ORIENT - figue, abricot, yaourt 0%, lait -" />
      </p>
      <p>
        <label class="smooth" for="LATINO - mangue, orange, ananas, lait de soja -"><b>LATINO</b> <em>- mangue, orange, ananas, lait de soja -</em></label>
        <input type="radio" <?php if ($favori->boisson=='LATINO - mangue, orange, ananas, lait de soja -') { echo 'checked="checked"'; } ?> name="radioSmoothies" id="LATINO" value="LATINO - mangue, orange, ananas, lait de soja -" />
      </p>
      <p>
        <label class="smooth" for="ASIAN - lychee, cannelle, pomme, lait de soja -"><b>ASIAN</b> <em>- lychee, cannelle, pomme, lait de soja -</em></label>
        <input type="radio" <?php if ($favori->boisson=='ASIAN - lychee, cannelle, pomme, lait de soja -') { echo 'checked="checked"'; } ?> name="radioSmoothies" id="ASIAN" value="ASIAN - lychee, cannelle, pomme, lait de soja -" />
      </p>
      <p>
        <label class="smooth" for="MILK CHOKY - banane, choco, glace vanille, lait -"><b>MILK CHOKY</b> <em>- banane, choco, glace vanille, lait -</em></label>
        <input type="radio" <?php if ($favori->boisson=='MILK CHOKY - banane, choco, glace vanille, lait -') { echo 'checked="checked"'; } ?> name="radioSmoothies" id="MILK CHOKY" value="MILK CHOKY - banane, choco, glace vanille, lait -" />
      </p>
      <p>
        <label class="smooth" for="MILK FRAISY - banane, fraise, glace vanille, lait -"><b>MILK FRAISY</b> <em>- banane, fraise, glace vanille, lait -</em></label>
        <input type="radio" <?php if ($favori->boisson=='MILK FRAISY - banane, fraise, glace vanille, lait -') { echo 'checked="checked"'; } ?> name="radioSmoothies" id="MILK FRAISY" value="MILK FRAISY - banane, fraise, glace vanille, lait -" />
      </p>
    </div>
    <div id="tableauJusDeFruits" style="visibility:hidden">
      <p>
        <label class="smooth" for="ENERGY - orange, banane, fraise -"><b>ENERGY </b><em> - orange, banane, fraise -</em></label>
        <input type="radio" <?php if ($favori->boisson=='ENERGY - orange, banane, fraise -') { echo 'checked="checked"'; } ?> name="radioJusDeFruits" id="ENERGY" value="ENERGY - orange, banane, fraise -" checked="checked"/>
      </p>
      <p>
        <label class="smooth" for="TROPIK - ananas, orange, banane -"><b>TROPIK </b><em> - ananas, orange, banane -</em></label>
        <input type="radio" <?php if ($favori->boisson=='TROPIK - ananas, orange, banane -') { echo 'checked="checked"'; } ?> name="radioJusDeFruits" id="TROPIK" value="TROPIK - ananas, orange, banane -"/>
      </p>
      <p>
        <label class="smooth" for="SLIM - pomme, pamplemousse, ananas, fruits rouges -"><b>SLIM </b><em> - pomme, pamplemousse, ananas, fruits rouges -</em></label>
        <input type="radio" <?php if ($favori->boisson=='SLIM - pomme, pamplemousse, ananas, fruits rouges -') { echo 'checked="checked"'; } ?> name="radioJusDeFruits" id="SLIM" value="SLIM - pomme, pamplemousse, ananas, fruits rouges -" />
      </p>
      <p>
        <label class="smooth" for="ANTIOXY - th&eacute; vert, fruits rouges, pomme, framboise -"><b>ANTIOXY </b><em> - th&eacute; vert, fruits rouges, pomme, framboise -</em></label>
        <input type="radio" <?php if ($favori->boisson=='ANTIOXY - th&eacute; vert, fruits rouges, pomme, framboise -') { echo 'checked="checked"'; } ?> name="radioJusDeFruits" id="ANTIOXY" value="ANTIOXY - th&eacute; vert, fruits rouges, pomme, framboise -" />
      </p>
      <p>
        <label class="smooth" for="KIPIK - pamplemousse, orange, citron -"><b>KIPIK </b><em> - pamplemousse, orange, citron -</em></label>
        <input type="radio" <?php if ($favori->boisson=='KIPIK - pamplemousse, orange, citron -') { echo 'checked="checked"'; } ?> name="radioJusDeFruits" id="KIPIK" value="KIPIK - pamplemousse, orange, citron -" />
      </p>
      <p>
        <label class="smooth" for="SUNNY - mangue, ananas, orange -"><b>SUNNY </b><em> - mangue, ananas, orange -</em></label>
        <input type="radio" <?php if ($favori->boisson=='SUNNY - mangue, ananas, orange -') { echo 'checked="checked"'; } ?> name="radioJusDeFruits" id="SUNNY" value="SUNNY - mangue, ananas, orange -" />
      </p>
      <p>
        <label class="smooth" for="KAROTEN - carotte, orange, citron -"><b>KAROTEN </b><em> - carotte, orange, citron -</em></label>
        <input type="radio" <?php if ($favori->boisson=='KAROTEN - carotte, orange, citron -') { echo 'checked="checked"'; } ?> name="radioJusDeFruits" id="KAROTEN" value="KAROTEN - carotte, orange, citron -" />
      </p>
      <p>
        <label class="smooth" for="PROTECT - carotte, orange, pomme, gingembre -"><b>PROTECT </b><em> - carotte, orange, pomme, gingembre -</em></label>
        <input type="radio" <?php if ($favori->boisson=='PROTECT - carotte, orange, pomme, gingembre -') { echo 'checked="checked"'; } ?> name="radioJusDeFruits" id="PROTECT" value="PROTECT - carotte, orange, pomme, gingembre -" />
      </p>
    </div>
    <div class="ajusteur">&nbsp;</div>
    <div id="pain" style="visibility:hidden">
      <h2>+ 1 pain <span style="font-size:12px;">(selon disponibilit&eacute;s)</span></h2>
      <table width="250" border="0">
        <tr>
          <td><p>
              <input type="radio" <?php if ( ($favori->pain=='Céréales') || (!$favori->pain) ) { echo 'checked="checked"'; } ?> name="radioPain" id="Céréales" value="Céréales" />
              Céréales</p></td>
          <td>&nbsp;</td>
          <td><p>
              <input type="radio" <?php if ($favori->pain=='Noix') { echo 'checked="checked"'; } ?> name="radioPain" id="Noix" value="Noix" />
              Noix</p></td>
        </tr>
        <tr>
          <td><p>
              <input type="radio" <?php if ($favori->pain=='Cranberries') { echo 'checked="checked"'; } ?> name="radioPain" id="Cranberries" value="Cranberries" />
              Cranberries</p></td>
          <td>&nbsp;</td>
          <td><p>
              <input type="radio" <?php if ($favori->pain=='Lardons') { echo 'checked="checked"'; } ?> name="radioPain" id="Lardons" value="Lardons" />
              Lardons</p></td>
        </tr>
        <tr>
          <td><p>
              <input type="radio" <?php if ($favori->pain=='Raisins/Noisettes') { echo 'checked="checked"'; } ?> name="radioPain" id="Raisins/Noisettes" value="Raisins/Noisettes" />
              Raisins/Noisettes</p></td>
          <td>&nbsp;</td>
          <td><p>
              <input type="radio" <?php if ($favori->pain=='Chorizo') { echo 'checked="checked"'; } ?> name="radioPain" id="Chorizo" value="Chorizo" />
              Chorizo</p></td>
        </tr>
      </table>
      <p>&nbsp;</p>
    </div>
    <div id="pied" style="visibility:hidden">
      <h2>Taille de votre menu :</h2>
      <p>
        <select name="taille" id="taille" style="width:75px">
          <option id="Moyen" value="Moyen" <?php if ($favori->taille=='Moyen') { echo 'selected="selected"'; } ?> />
          Moyen
          </option>
          <option id="Grand" value="Grand" <?php if ( ($favori->taille=='Grand') || (!$favori->taille) ) { echo 'selected="selected"'; } ?> />
          Grand
          </option>
        </select>
        <input type="submit" class="bouton" value="Enregistrez votre menu favori" style="width:200px" />
      </p>
      <p>&nbsp;</p>
    </div>
    <input type="hidden" name="ID_menuFavori" value="<?php echo $_GET['ID_menuFavori']; ?>" />
  </form>
</div>
<script type="text/javascript">
<?php 
if ($favori->typePlat=='salades')
	{?>affichageMenuSalades();<?php } 
else if ($favori->typePlat=='soupes')
	{?>affichageMenuSoupes();<?php } 

if ($favori->typeBoisson=='JusDeFruits')
	{?>affichageJusDeFruits();<?php } 
else if ($favori->typeBoisson=='Smoothies')
	{?>affichageSmoothies();<?php } 
?>
</script>
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-1956792-20";
urchinTracker();
</script>
</body>
</html>
