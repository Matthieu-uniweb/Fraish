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
    <div id="choixMenuSmoothie3" class="choixMenuSmoothie" style="visibility:hidden">
      <p>
        <label for="Jus de fruits">Jus de fruits</label>
        <input type="radio" name="radioBoisson" id="JusDeFruits" value="JusDeFruits" onClick="affichageJusDeFruits();" <?php if ($favori->typeBoisson=='JusDeFruits') { echo 'checked="checked"'; } ?> />
      </p>
    </div>    
    <div id="choixMenuSmoothie1" class="choixMenuSmoothie" style="visibility:hidden">
      <p>
        <label for="Smoothies">Smoothies</label>
        <input type="radio" name="radioBoisson" id="Smoothies" value="Smoothies" onClick="affichageSmoothies();" <?php if ($favori->typeBoisson=='Smoothies') { echo 'checked="checked"'; } ?> />
      </p>
    </div>
    <div id="choixMenuSmoothie2" class="choixMenuSmoothie" style="visibility:hidden">
      <p>
        <label for="Dairy Smoothies">Dairy Smoothies <br />(avec produits laitiers)</label>
        <input type="radio" name="radioBoisson" id="DairySmoothies" value="DairySmoothies" onClick="affichageDairySmoothies();" <?php if ($favori->typeBoisson=='DairySmoothies') { echo 'checked="checked"'; } ?> />
      </p>
    </div>
    <div id="tableauSmoothies" style="visibility:hidden">
      <p>
        <label class="smooth" for="ENERGY - Orange, Fraise, Banane -"><b>ENERGY</b> <em>- Orange, Fraise, Banane -</em></label>
        <input type="radio" name="radioSmoothies" id="ENERGY" value="ENERGY - Orange, Fraise, Banane -" <?php if ( ($favori->boisson=='ENERGY - Orange, Fraise, Banane -') || (! $favori->boisson) ) { echo 'checked="checked"'; } ?> />
      </p>
      <p>
        <label class="smooth" for="SUNNY - Mangue, Orange, Ananas -"><b>SUNNY</b> <em>- Mangue, Orange, Ananas -</em></label>
        <input type="radio" name="radioSmoothies" id="SUNNY" value="SUNNY - Mangue, Orange, Ananas -" <?php if ($favori->boisson=='SUNNY - Mangue, Orange, Ananas -') { echo 'checked="checked"'; } ?> />
      </p>
      <p>
        <label class="smooth" for="TROPIK - Ananas, Orange, Banane -"><b>TROPIK</b> <em>- Ananas, Orange, Banane -</em></label>
        <input type="radio" name="radioSmoothies" id="TROPIK" value="TROPIK - Ananas, Orange, Banane -" <?php if ($favori->boisson=='TROPIK - Ananas, Orange, Banane -') { echo 'checked="checked"'; } ?> />
      </p>
      <p>
        <label class="smooth" for="JOLY - Carotte, Orange, Fraise -"><b>JOLY</b> <em>- Carotte, Orange, Fraise -</em></label>
        <input type="radio" name="radioSmoothies" id="JOLY" value="JOLY - Carotte, Orange, Fraise -" <?php if ($favori->boisson=='JOLY - Carotte, Orange, Fraise -') { echo 'checked="checked"'; } ?> />
      </p>
      <p>
        <label class="smooth" for="POM POIRE - Pomme, Poire, Fraise, Orange -"><b>POM POIRE</b> <em>- Pomme, Poire, Fraise, Orange -</em></label>
        <input type="radio" name="radioSmoothies" id="POM POIRE" value="POM POIRE - Pomme, Poire, Fraise, Orange -" <?php if ($favori->boisson=='POM POIRE - Pomme, Poire, Fraise, Orange -') { echo 'checked="checked"'; } ?> />
      </p>
      <p>
        <label class="smooth" for="PUNCHY - Pêche, Mangue, Ananas -"><b>PUNCHY</b> <em>- Pêche, Mangue, Ananas -</em></label>
        <input type="radio" name="radioSmoothies" id="PUNCHY" value="PUNCHY - Pêche, Mangue, Ananas -" <?php if ($favori->boisson=='PUNCHY - Pêche, Mangue, Ananas -') { echo 'checked="checked"'; } ?> />
      </p>
    </div>
    <div id="tableauDairySmoothies" style="visibility:hidden">
    <p>
        <label class="smooth" for="COCO - Lait de coco, Banane, Lait de soja, Glace vanille -"><b>COCO</b> <em>- Lait de coco, Banane, Lait de soja, Glace vanille -</em></label>
        <input type="radio" name="radioDairySmoothies" id="COCO" value="COCO - Lait de coco, Banane, Lait de soja, Glace vanille -" <?php if ( ($favori->boisson=='COCO - Lait de coco, Banane, Lait de soja, Glace vanille -') || (! $favori->boisson) ) { echo 'checked="checked"'; } ?> />
      </p>
      <p>
        <label class="smooth" for="ASIAN - Pomme, Litchee, Lait de soja, Cannelle -"><b>ASIAN</b> <em>- Pomme, Litchee, Lait de soja, Cannelle -</em></label>
        <input type="radio" name="radioDairySmoothies" id="ASIAN" value="ASIAN - Pomme, Litchee, Lait de soja, Cannelle -" <?php if ($favori->boisson=='ASIAN - Pomme, Litchee, Lait de soja, Cannelle -') { echo 'checked="checked"'; } ?> />
      </p>
      <p>
        <label class="smooth" for="ORIENT - Figues, Abricot, Yaourt 0%, Lait -"><b>ORIENT</b> <em>- Figues, Abricot, Yaourt 0%, Lait -</em></label>
        <input type="radio" name="radioDairySmoothies" id="ORIENT" value="ORIENT - Figues, Abricot, Yaourt 0%, Lait -" <?php if ($favori->boisson=='ORIENT - Figues, Abricot, Yaourt 0%, Lait -') { echo 'checked="checked"'; } ?> />
      </p>
      <p>
        <label class="smooth" for="STARTER - Banane, Flocons d’avoine, Lait de soja, Miel, Yaourt 0% -"><b>STARTER</b> <em>- Banane, Flocons d’avoine, Lait de soja, Miel, Yaourt 0% -</em></label>
        <input type="radio" name="radioDairySmoothies" id="STARTER" value="STARTER - Banane, Flocons d’avoine, Lait de soja, Miel, Yaourt 0% -" <?php if ($favori->boisson=='STARTER - Banane, Flocons d’avoine, Lait de soja, Miel, Yaourt 0% -') { echo 'checked="checked"'; } ?> />
      </p>
      <p>
        <label class="smooth" for="LATINO - Mangue, Ananas, Orange, Lait de soja -"><b>LATINO</b> <em>- Mangue, Ananas, Orange, Lait de soja -</em></label>
        <input type="radio" name="radioDairySmoothies" id="LATINO" value="LATINO - Mangue, Ananas, Orange, Lait de soja -" <?php if ($favori->boisson=='LATINO - Mangue, Ananas, Orange, Lait de soja -') { echo 'checked="checked"'; } ?> />
      </p>
      <p>
        <label class="smooth" for="RED - Fruits rouges, Sorbet fraise, Lait -"><b>RED</b> <em> - Fruits rouges, Sorbet fraise, Lait -</em></label>
        <input type="radio" name="radioDairySmoothies" id="RED" value="RED - Fruits rouges, Sorbet fraise, Lait -" <?php if ($favori->boisson=='RED - Fruits rouges, Sorbet fraise, Lait -') { echo 'checked="checked"'; } ?> />
      </p>
      <p>
        <label class="smooth" for="WOMEN - Fraise, Banane, Lait de soja -"><b>WOMEN</b> <em>- Fraise, Banane, Lait de soja -</em></label>
        <input type="radio" name="radioDairySmoothies" id="WOMEN" value="WOMEN - Fraise, Banane, Lait de soja -" <?php if ($favori->boisson=='WOMEN - Fraise, Banane, Lait de soja -') { echo 'checked="checked"'; } ?> />
      </p>
      <p>
        <label class="smooth" for="FRAISY - Fraise, Lait, Glace vanille -"><b>FRAISY</b> <em>- Fraise, Lait, Glace vanille -</em></label>
        <input type="radio" name="radioDairySmoothies" id="FRAISY" value="FRAISY - Fraise, Lait, Glace vanille -" <?php if ($favori->boisson=='FRAISY - Fraise, Lait, Glace vanille -') { echo 'checked="checked"'; } ?> />
      </p> 
      <p>
        <label class="smooth" for="CHOKY - Chocolat, Banane, Lait, Glace vanille -"><b>CHOKY</b> <em>- Chocolat, Banane, Lait, Glace vanille -</em></label>
        <input type="radio" name="radioDairySmoothies" id="CHOKY" value="CHOKY - Chocolat, Banane, Lait, Glace vanille -" <?php if ($favori->boisson=='CHOKY - Chocolat, Banane, Lait, Glace vanille -') { echo 'checked="checked"'; } ?> />
      </p>
    </div>
    <div id="tableauJusDeFruits" style="visibility:hidden">
      <p>
        <label class="smooth" for="SLIM - Pomme, Fruits rouges, Ananas, Pamplemousse -"><b>SLIM </b><em> - Pomme, Fruits rouges, Ananas, Pamplemousse -</em></label>
        <input type="radio" name="radioJusDeFruits" id="SLIM" value="SLIM - Pomme, Fruits rouges, Ananas, Pamplemousse -" <?php if ( ($favori->boisson=='SLIM - Pomme, Fruits rouges, Ananas, Pamplemousse -') || (! $favori->boisson) ) { echo 'checked="checked"'; } ?> />
      </p>
      <p>
        <label class="smooth" for="ANTIOXY - Thé vert, Pomme, Fruits rouges, Framboise -"><b>ANTIOXY </b><em> - Thé vert, Pomme, Fruits rouges, Framboise -</em></label>
        <input type="radio" name="radioJusDeFruits" id="ANTIOXY" value="ANTIOXY - Thé vert, Pomme, Fruits rouges, Framboise -" <?php if ($favori->boisson=='ANTIOXY - Thé vert, Pomme, Fruits rouges, Framboise -') { echo 'checked="checked"'; } ?> />
      </p>
      <p>
        <label class="smooth" for="KIPIK - Citron, Orange, Pamplemousse -"><b>KIPIK </b><em> - Citron, Orange, Pamplemousse -</em></label>
        <input type="radio" name="radioJusDeFruits" id="KIPIK" value="KIPIK - Citron, Orange, Pamplemousse -" <?php if ($favori->boisson=='KIPIK - Citron, Orange, Pamplemousse -') { echo 'checked="checked"'; } ?> />
      </p>
      <p>
        <label class="smooth" for="KAROTEN - Carotte, Orange, Citron -"><b>KAROTEN </b><em> - Carotte, Orange, Citron -</em></label>
        <input type="radio" name="radioJusDeFruits" id="KAROTEN" value="KAROTEN - Carotte, Orange, Citron -" <?php if ($favori->boisson=='KAROTEN - Carotte, Orange, Citron -') { echo 'checked="checked"'; } ?> />
      </p>
      <p>
        <label class="smooth" for="PROTECT - Carotte, Orange, Pomme, Gingembre -"><b>PROTECT </b><em> - Carotte, Orange, Pomme, Gingembre -</em></label>
        <input type="radio" name="radioJusDeFruits" id="PROTECT" value="PROTECT - Carotte, Orange, Pomme, Gingembre -" <?php if ($favori->boisson=='PROTECT - Carotte, Orange, Pomme, Gingembre -') { echo 'checked="checked"'; } ?> />
      </p>
      <p>
        <label class="smooth" for="RIAD - Thé menthe, Citron, Pomme, Miel -"><b>RIAD </b><em> - Thé menthe, Citron, Pomme, Miel -</em></label>
        <input type="radio" name="radioJusDeFruits" id="RIAD" value="RIAD - Thé menthe, Citron, Pomme, Miel -" <?php if ($favori->boisson=='RIAD - Thé menthe, Citron, Pomme, Miel -') { echo 'checked="checked"'; } ?> />
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
else if ($favori->typeBoisson=='DairySmoothies')
	{?>affichageDairySmoothies();<?php } 
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
