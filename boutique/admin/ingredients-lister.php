<?
header("Expires: 0"); 
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache");
header("Cache-Control: post-check=0,pre-check=0");
header("Cache-Control: max-age=0");
header("Pragma: no-cache");

include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/classes.inc.php';
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/includes/classes/paquetage.inc.php';

T_LAETIS_site::initialiserSession();
Tbq_user::estConnecte();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/bq_admin_boutique.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Mon espace d'administration e-boutique</title>
<script type="text/javascript" src="/boutique/includes/javascript/ingredient.js"></script>
<script type="text/javascript" src="/boutique/includes/javascript/option.js"></script>
<!-- InstanceEndEditable -->
<meta name="description" content="Espace d'administration de votre boutique" />
<meta name="keywords" content="espace, administration, boutique" />
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />
<link rel="icon" type="image/x-icon" href="/favicon.ico" />
<link href="/boutique/includes/styles/bq_admin-boutique.css" rel="stylesheet" type="text/css" />
<script src="/boutique/includes/javascript/bq_admin-boutique.js" type="text/javascript"></script>
<script src="/includes/javascript/formulaire.js" type="text/javascript"></script>
<!-- InstanceBeginEditable name="head" -->
<?php

$tbq_famille = new Tbq_famille();
$tbq_ingredient = new Tbq_ingredient();
$tbq_option = new Tbq_option();

$options=$tbq_option->listerOptions();
$familles = $tbq_famille->listerFamilles();
?>
<!-- InstanceEndEditable -->
</head>
<body id="hautPage">
<div id="page">
  <div id="enTete"><a href="/boutique/admin/accueil.php" title="Retourner à l'accueil de l'espace d'administration">Accueil</a><img src="/boutique/images/bandeau-boutique.jpg" alt="" width="750" height="135" /></div>
  <!-- Colonne Boutique -->
  <div id="divAdmin">
    <!-- Menu Boutique -->
    <div id="menuAdmin">
      <ul>
        <li><a href="/boutique/admin/commande-jour.php" title="Les reservations du jour">&gt; R&eacute;servations jour</a></li>
        <li><a href="/boutique/admin/commande-lister.php" title="Les commandes">&gt; Les r&eacute;servations</a></li>
        <li><a href="/boutique/admin/cb-lister.php" title="Les paiements CB">&gt; Les paiements CB</a></li>
        <li><a href="/boutique/admin/ingredients-lister.php" title="Les ingrédients">&gt; Les ingr&eacute;dients</a></li>
        <li><a href="/boutique/admin/menu-jour.php" title="Le menu du jour">&gt; Le menu du jour</a></li>
        <li><a href="/boutique/admin/client-lister.php" title="Les clients">&gt; Les clients</a></li>
        <li><a href="/boutique/admin/entreprises-lister.php" title="Les entreprises">&gt; Les entreprises</a></li>
        <li><a href="/boutique/admin/points-livraison-lister.php" title="Les points de livraison">&gt; Les points livraison</a></li>
        <li><a href="/boutique/admin/sondage-lister.php" title="Les sondages">&gt; Les sondages</a></li>
        <?php /*?><li><a href="/boutique/admin/questionnaire-lister.php" title="Le questionnaire">&gt; Le questionnaire</a></li><?php */?>
        <li><a href="/boutique/admin/statistiques.php" title="Les statistiques">&gt; Les statistiques</a></li>
        <li><a href="/boutique/admin/astuces.php" title="Astuces de Sophie">&gt; Astuces de Sophie</a></li>
      </ul>
    </div>
    <!-- Fin Menu Boutique -->
  </div>
  <!-- Fin Colonne Boutique -->
  <div id="contenu"> <!-- InstanceBeginEditable name="contenu" -->
   <h1>Les ingrédients</h1>
   
<?php    
for($i = 0; $i<count($familles); $i++){
	echo '.<h2>'.$familles[$i]['libelle'].'</h2>';
	$ingredients = $tbq_famille->listerIngredients($familles[$i]['ID'], 'ID');
	
?>
          <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tbody>
              <tr>
                <th style="width:100px">ID</th>
                <th style="width:100%">Libelle</th>
                <th style="width:50px">Sous-famille</th>
                <th style="width:50px">ord. mag.</th>
                <th style="width:50px">ord. web</th>
                <th style="width:50px">Dispo.</th>
                <th style="width:50px">Supp.</th>
                <th style="width:50px"></th>
                <th style="width:50px"></th>
              </tr>
            </tbody>
            <?
    if (! $ingredients)
        {
        ?>
            <tr>
              <td colspan="9" align="center" class="infos"> -- Pas d'ingrédients pour cette famille -- </td>
            </tr>
            <? 
        }
    else
        {
			
			for($j = 0; $j<count($ingredients); $j++){
				//regarde si options existent
				$idSelectedOptions = tbq_ingredient::getCheckedOptionsIds($ingredients[$j]['ID']);
				
				//on precoche la case supplement si ok
				$supplement = $ingredients[$j]['supplement'];
				$defaut = $ingredients[$j]['parDefaut'];
				if ($supplement){ $supplement='oui'; }else{ $supplement='non'; }
				if ($defaut){ $defaut='oui'; }else{ $defaut='non'; }
    	?> 
        	<tr <?php if(($j+1)%2==0){ echo 'style="background-color:#CCC;"'; } ?> >
              <td style="padding:0px 10px 0px 10px;"><?php echo $ingredients[$j]['ID'].''; ?></td>
              <td><?php echo $ingredients[$j]['libelle']; 
			  			if($idSelectedOptions){ echo '<span style="color:#F00; font-size:16px;"> *</span>';} 
						if($ingredients[$j]['details']){ echo ' : '.$ingredients[$j]['details']; } ?></td>
              <td align="center"><?php echo $ingredients[$j]['libelleSousFamille']; ?></td>
              <td align="center"><?php echo $ingredients[$j]['ordreAdmin']; ?></td>
              <td align="center"><?php echo $ingredients[$j]['ordreWeb']; ?></td>
              <td align="center"><?php echo $defaut; ?></td>
              <td align="center"><?php echo $supplement; ?></td>
              <td>
                  <input type="button" onclick="javascript:ingredient.modifier(<?php echo $ingredients[$j]['ID']; ?>)" value="modifier" />
              </td>
              <td>
                  <form id="supression-<?php echo $ingredients[$j]['ID'].''; ?>" action="scripts/supprimer-ingredient.req.php" method="post">
                    <input type="hidden" name="ID_ingredient" value="<?php echo $ingredients[$j]['ID']; ?>" />
                    <input onclick="javascript:ingredient.confirmerSupression(); return false;" type="submit" value="supprimer" />
                  </form>
              </td>
            </tr>
            
            <tr class="blocModif" style="display:none;" id="blocModif-<?php echo $ingredients[$j]['ID']; ?>" >
            	<form action="scripts/modifier-ingredient.req.php" method="post">
               		<td colspan="9" style=" border:solid 1px #C90; width:100%; background-color:#FFF;">
                		<table style="border:none; padding:0px; margin:0px;">
                            <tr>
                                <td style="padding:0px 5px;">Libelle : </td>
                                <td style="padding:0px 5px;"><input style="width:100px;" type="text" name="libelle" value="<?php echo $ingredients[$j]['libelle']; ?>"/></td>
                                <td style="padding:0px 5px;">Sous-famille : </td>
                                <td style="padding:0px 5px;"> 
                                	<?php
										if ($familles[$i]['ID']==1){
											$valeursSsFamilles = array('Féculents','Salades','Crudités','Fromages','Viandes','Poissons','Topping','Autre','Daily');
											echo '<select name="libelleSousFamille">';
											foreach ($valeursSsFamilles as $libelle){
												if($ingredients[$j]['libelleSousFamille'] == $libelle){	$selected = 'selected="selected"'; } else { $selected = ''; }
                                            	echo '<option '.$selected.' style="padding:0px 10px 0px 10px;" value="'.$libelle.'">'.$libelle.'</option>';
											}
                                     		echo '</select>';
                                    
										}elseif ($familles[$i]['ID']==2){
											$valeursSsFamilles = array('Daily','Diet');
											echo '<select name="libelleSousFamille">';
											foreach ($valeursSsFamilles as $libelle){
												if($ingredients[$j]['libelleSousFamille'] == $libelle){	$selected = 'selected="selected"'; } else { $selected = ''; }
                                            	echo '<option '.$selected.' style="padding:0px 10px 0px 10px;" value="'.$libelle.'">'.$libelle.'</option>';
											}
                                     		echo '</select>';
                                    
										}elseif ($familles[$i]['ID']==5){
											$valeursSsFamilles = array('Jus de fruits','Smoothies', 'Milk Shakes', 'Daily Juice');
											echo '<select name="libelleSousFamille">';
											foreach ($valeursSsFamilles as $libelle){
												if($ingredients[$j]['libelleSousFamille'] == $libelle){	$selected = 'selected="selected"'; } else { $selected = ''; }
                                            	echo '<option '.$selected.' style="padding:0px 10px 0px 10px;" value="'.$libelle.'">'.$libelle.'</option>';
											}
                                     		echo '</select>';
                                    
										} else {
                                			echo '<input style="width:100px;" type="text" name="libelleSousFamille" value="'.$ingredients[$j]['libelleSousFamille'].'" /></td>';
										}
									?>
                                <td style="padding:0px 5px;">Par défaut : </td>
                                <td style="padding:0px 5px;"><input type="checkbox" name="parDefaut" <?php if($defaut=='oui'){ echo 'checked=checked'; } ?> value='1' /></td>
                                <td style="padding:0px 5px;">
                                    <input type="hidden" name="ID_ingredient" value="<?php echo $ingredients[$j]['ID']; ?>" />
                                    <input type="hidden" name="ID_famille" value="<?php echo $ingredients[$j]['ID_famille']; ?>" />
                                    <input type="hidden" name="ordreAdmin" value="<?php echo $ingredients[$j]['ordreAdmin']; ?>" />
                                    <input type="hidden" name="ordreWeb" value="<?php echo $ingredients[$j]['ordreWeb']; ?>" />
                                    <input type="submit" value="enregistrer" />
                                    <input type="button" value="annuler" onclick="javascript:ingredient.annuler(<?php echo $ingredients[$j]['ID']; ?>)" /></td>
                            </tr>
                            <tr>
                            	<td colspan="9"><label style="font-size:11px" for="details">Détails</label><input type="text" name="details" value="<?php echo $ingredients[$j]['details']; ?>" style="width:400px" /></td>
                            </tr>
                            <tr>
                           		<td colspan="4" valign="top" style="padding:20px 0px 20px 0px;">
                                <h3 style="padding:10px 0px 0px 0px;">Les options : </h3><br />
                                <ul>
                                <?php
                               for($h = 0; $h<count($options); $h++){
                                ?>
                                    <li style="list-style:none; padding:0px;"><input <?php if(in_array($options[$h]['ID'],$idSelectedOptions)){ echo 'checked=checked'; } ?> type="checkbox" name="options-<?php echo $ingredients[$j]['ID']; ?>[]" value="<?php echo $options[$h]['ID']; ?>" style="margin-right:10px;" /><label for="options-<?php echo $options[$j]['ID']; ?>[]"><?php echo $options[$h]['libelle']; ?></label></li>
                                <?php
                                }
                                ?>
                               </ul>
                               </td>
                            	<td colspan="4" valign="top" style="padding:20px 0px 20px 0px;">
								<?php 
									$prixOption = explode('][',substr($ingredients[$j]['prixSupplement'],1,-1)); 
									for($y=0; $y<count($prixOption); $y++){
										$tabPrixOption = explode('|',$prixOption[$y]);
										$prixOption[$y] = array ();
										$prixOption[$y]['libelle'] = $tabPrixOption[0];
										$prixOption[$y]['prix'] = $tabPrixOption[1];
									}
								?>
                                		<h3 style="padding:10px 0px 0px 0px;">Les suppléments</h3><br />
                                        <label for="supplement">Supplément</label><input type="checkbox" name="supplement" <?php if($supplement=='oui'){ echo 'checked=checked'; } ?> value='1' /><br /><br />
                                		<label for="libelleSupplement-1">libelle</label><input style="width:50px; margin-right:5px;" type="text" name="libelleSupplement-1" value="<?php echo $prixOption[0]['libelle']; ?>" /><label for="libelleSupplement-1">prix</label><input value="<?php echo $prixOption[0]['prix']; ?>" style="width:50px;" type="text" name="prixSupplement-1" /><br />
                                		<label for="libelleSupplement-2">libelle</label><input style="width:50px; margin-right:5px;" type="text" name="libelleSupplement-2" value="<?php echo $prixOption[1]['libelle']; ?>" /><label for="libelleSupplement-2">prix</label><input value="<?php echo $prixOption[1]['prix']; ?>" style="width:50px;" type="text" name="prixSupplement-2" /><br />
                                		<label for="libelleSupplement-3">libelle</label><input style="width:50px; margin-right:5px;" type="text" name="libelleSupplement-3" value="<?php echo $prixOption[2]['libelle']; ?>" /><label for="libelleSupplement-3">prix</label><input value="<?php echo $prixOption[2]['prix']; ?>" style="width:50px;" type="text" name="prixSupplement-3" />
                                </td></tr>
                               <tr><td colspan="9">
                               <label for="deplacerOrdreAdmin">Ordre magasin</label>
                               <select name="deplacerOrdreAdmin">
                                    <option style="padding:0px 10px 0px 10px;" value="">déplacer avant</option>
                               		<?php
                               		for($x = 0; $x<count($ingredients); $x++){
									?>
                                    	<option style="padding:0px 10px 0px 10px; <?php if ($ingredients[$x]['ID'] == $ingredients[$j]['ID']){ echo 'background-color:#ccc;'; } ?>" value="<?php echo $ingredients[$x]['ordreAdmin']; ?>"><?php echo $ingredients[$x]['libelle']; ?></option>
                                    <?Php 
									}
									?>
                               </select>
                               
                               <label style="margin-left:20px;" for="deplacerOrdreWeb">Ordre web</label>
                               <select name="deplacerOrdreWeb">
                                    <option style="padding:0px 10px 0px 10px;" value="">déplacer avant</option>
                               		<?php
                               		for($x = 0; $x<count($ingredients); $x++){
									?>
                                    	<option style="padding:0px 10px 0px 10px; <?php if ($ingredients[$x]['ID'] == $ingredients[$j]['ID']){ echo 'background-color:#ccc;'; } ?>" value="<?php echo $ingredients[$x]['ordreWeb']; ?>"><?php echo $ingredients[$x]['libelle']; ?></option>
                                    <?Php 
									}
									?>
                               </select>
                            </td></tr>
                        </table>
                	</td>
                </form>
            </tr>
        <?php	
			}//FIN for ingredients
        } // FIN else
    ?>
          </table>
          
          <form action="scripts/ajouter-ingredient.req.php" method="post">
          	<table>
            	<tr>
                	<td>nom : </td><td><input type="text" value="" name="ingredient" /></td>
                   	<td>sous-famille : </td>
                    <td>
                    	<?php
						if($familles[$i]['ID'] == 1){
							?>
							
                            <select name="sousfamille">
                            	
                            	<option style="padding:0px 10px 0px 10px;" value="Féculents">Féculents</option>
                            	<option style="padding:0px 10px 0px 10px;" value="Salades">Salades</option>
                            	<option style="padding:0px 10px 0px 10px;" value="Crudités">Crudités</option>
                            	<option style="padding:0px 10px 0px 10px;" value="Fromages">Fromages</option>
                            	<option style="padding:0px 10px 0px 10px;" value="Viandes">Viandes</option>
                            	<option style="padding:0px 10px 0px 10px;" value="Poissons">Poissons</option>   	
                            	<option style="padding:0px 10px 0px 10px;" value="Topping">Topping</option>
                            	<option style="padding:0px 10px 0px 10px;" value="Daily">Daily</option>
                            	<option selected="selected" style="padding:0px 10px 0px 10px;" value="Autre">Autre</option>
                            </select>
                            <?php
						}elseif($familles[$i]['ID'] == 2){
							?>
                            <select name="sousfamille">
                            	<option style="padding:0px 10px 0px 10px;" value="Daily">Daily</option>
                            	<option style="padding:0px 10px 0px 10px;" value="Diet">Diet</option>
                            </select>
                            <?php
						}elseif($familles[$i]['ID'] == 5){
							?>
                            <select name="sousfamille">
                            	<option style="padding:0px 10px 0px 10px;" value="Jus de fruits">Jus de fruits</option>
                            	<option style="padding:0px 10px 0px 10px;" value="Smoothies">Smoothies</option>
                            	<option style="padding:0px 10px 0px 10px;" value="Milk Shakes">Milk Shakes</option>
                            	<option style="padding:0px 10px 0px 10px;" value="Daily Juice">Daily Juice</option>
                            </select>
                            <?php
						} else {
                    		echo '<input type="text" value="" name="sousfamille" />';
						}
						?>
                    </td>
                    <td>Dispo : </td><td><input type="checkbox" value="1" name="parDefaut" /></td>
                    <td>supplément : </td><td><input type="checkbox" value="1" name="supplement" /></td>
                    <td>
                    	<input type="hidden" name="ID_famille" value="<?php echo $familles[$i]['ID']; ?>" />
                    	<input type="submit" value="ajouter un ingrédient" />
                    </td>
                </tr>
           	</table>
          </form>
<?php
} //Fin for Famille
?>




<h1>Les options</h1>
<table style="background-color:#FC6">
	<?php
	for($i = 0; $i<count($options); $i++){
	?>
    	<tr>
        	<td><?php echo $options[$i]['ID']; ?></td>
        	<td><?php echo $options[$i]['libelle']; ?></td>
            <td>
                <input type="button" onclick="javascript:option.modifier(<?php echo $ingredients[$i]['ID']; ?>)" value="modifier" />
            </td>
            <td>
                <form action="scripts/supprimer-option.req.php" method="post">
                <input type="hidden" name="ID_option" value="<?php echo $options[$i]['ID']; ?>" />
                <input type="submit" value="supprimer" />
                </form>
            </td>
        </tr>
        
    	<tr  class="blocModifOption" style="display:none; background-color:#FFFFFF;" id="blocModifOption-<?php echo $ingredients[$i]['ID']; ?>">
        	<td colspan="4"><form action="scripts/modifier-option.req.php" method="post">
            	<table style="border:none; padding:0px; margin:0px; width:100%;">
            		<tr>
                        <td><input type="text" name="libelle" value="<?php echo $options[$i]['libelle']; ?>" /></td>
                        <td>
                			<input type="hidden" name="ID_option" value="<?php echo $options[$i]['ID']; ?>" />
                        	<input type="submit" value="modifier" />
                        </td>
                    </tr>
                </table>
            </form></td>
        </tr>
	<?php
	}
	?>
    <tr><td colspan="2">
     <form action="scripts/ajouter-option.req.php" method="post">
        <table style="border:none; padding:0px; margin:0px;">
            <tr>
                <td>nom : </td><td><input type="text" value="" name="libelle" /></td>
                <td><input type="submit" value="ajouter" /></td>
            </tr>
        </table>
      </form>
      </td></tr>
</table>

    <!-- InstanceEndEditable --> </div>
  <div class="ajusteur"></div>
</div>
</body>
<!-- InstanceEnd --></html>
