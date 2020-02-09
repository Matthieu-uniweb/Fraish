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
<!-- InstanceEndEditable -->
<meta name="description" content="Espace d'administration de votre boutique" />
<meta name="keywords" content="espace, administration, boutique" />
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />
<link rel="icon" type="image/x-icon" href="/favicon.ico" />
<link href="/boutique/includes/styles/bq_admin-boutique.css" rel="stylesheet" type="text/css" />
<script src="/boutique/includes/javascript/bq_admin-boutique.js" type="text/javascript"></script>
<script src="/includes/javascript/formulaire.js" type="text/javascript"></script>
<!-- InstanceBeginEditable name="head" -->
<?
$commande = new Tbq_commande();
$menuJour=new Tbq_menujour();
$soupes=$menuJour->listerParDate(date("Y-m-d", mktime(0,0,0,date("m"),date("d")-date("w")+1,date("Y"))), date("Y-m-d", mktime(0,0,0,date("m"),date("d")-date("w")+6,date("Y"))),'soupe');
$juss=$menuJour->listerParDate(date("Y-m-d", mktime(0,0,0,date("m"),date("d")-date("w")+1,date("Y"))), date("Y-m-d", mktime(0,0,0,date("m"),date("d")-date("w")+6,date("Y"))),'jus');
$soupesDiet=$menuJour->listerParDate(date("Y-m-d", mktime(0,0,0,date("m"),date("d")-date("w")+1,date("Y"))), date("Y-m-d", mktime(0,0,0,date("m"),date("d")-date("w")+6,date("Y"))),'soupeDiet');
/*$legumes=$menuJour->listerParDate(date("Y-m-d", mktime(0,0,0,date("m"),date("d")-date("w")+1,date("Y"))), date("Y-m-d", mktime(0,0,0,date("m"),date("d")-date("w")+6,date("Y"))),'legumes');
$feculents=$menuJour->listerParDate(date("Y-m-d", mktime(0,0,0,date("m"),date("d")-date("w")+1,date("Y"))), date("Y-m-d", mktime(0,0,0,date("m"),date("d")-date("w")+6,date("Y"))),'feculents');
$graines=$menuJour->listerParDate(date("Y-m-d", mktime(0,0,0,date("m"),date("d")-date("w")+1,date("Y"))), date("Y-m-d", mktime(0,0,0,date("m"),date("d")-date("w")+6,date("Y"))),'graines');*/
$salade=$menuJour->listerParDate(date("Y-m-d", mktime(0,0,0,date("m"),date("d")-date("w")+1,date("Y"))), date("Y-m-d", mktime(0,0,0,date("m"),date("d")-date("w")+6,date("Y"))),'salade');
$desserts=$menuJour->listerParDate(date("Y-m-d", mktime(0,0,0,date("m"),date("d")-date("w")+1,date("Y"))), date("Y-m-d", mktime(0,0,0,date("m"),date("d")-date("w")+6,date("Y"))),'desserts');
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
  <script type="text/javascript" src="/boutique/includes/javascript/menu-jour.js"></script>
  <?php
  //par leo le 07-02-2012
  
  
  /**
    * definition des IDs de familles
	**/
	$ID_familles = array (
						'salade' => 1,
						'soupe' => 2,
						'dessert' => 4,
						'boisson' => 5
						);
  
  
  /**
    * définition des 7 prochains jours de la semaine pour eviter les doublons
	**/
	$jours = array ('lundi','mardi','mercredi','jeudi','vendredi','samedi');
	$dates = array	(
					'lundi'=>date("d-m-Y", mktime(0,0,0,date("m"),date("d")-date("w")+1,date("Y"))),
					'mardi'=>date("d-m-Y", mktime(0,0,0,date("m"),date("d")-date("w")+2,date("Y"))),
					'mercredi'=>date("d-m-Y", mktime(0,0,0,date("m"),date("d")-date("w")+3,date("Y"))),
					'jeudi'=>date("d-m-Y", mktime(0,0,0,date("m"),date("d")-date("w")+4,date("Y"))),
					'vendredi'=>date("d-m-Y", mktime(0,0,0,date("m"),date("d")-date("w")+5,date("Y"))),
					'samedi'=>date("d-m-Y", mktime(0,0,0,date("m"),date("d")-date("w")+6,date("Y")))
					);
					
					
  ?>
  <form name="formulaire" method="post" action="scripts/sauver_menus.php">
      <h1>Le menu du jour</h1>
      <p>Veuillez entrer les ingrédients pour les soupes et les jus du jour :</p>
      <p>&nbsp;</p>
      <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:none;">
        <tr>
          <td valign="top" style="border:solid 1px #000;"><table width="100%"  style="border:none" cellspacing="0" cellpadding="0">
              <tr>
                <td colspan="2"><h2>La soupe du jour (Daily)</h2></td>
              </tr>
			  <?php 
			  $listeSoupes = Tbq_famille::listerIngredients($ID_familles['soupe'], 'ordreWeb', 'Daily');
              $index = 0;
              foreach ($jours as $jour){
				  $soupeEnBase = explode('|',$soupes[$dates[$jour]]['ingredients']);
               ?>
                  <tr id="soupe-<?php echo $index; ?>" onclick="javascript:menuJour.afficher(<?php echo $index; ?>);">
                    <td width="30"><strong><?php echo $jour; ?></strong></td>
                    <td width="99%"><input type="text" name="soupe[<?php echo $dates[$jour]; ?>][dateJour]" value="<?php echo $dates[$jour]; ?>" style="width:80px;" /></td>
                    
                  </tr>
                  <tr style="display:none" class="contenu jour<?php echo $index; ?>">
                    <td width="99%" style="padding:0px;" colspan="2">
                    	<ul style="width:100%;">
                        <?php 
							foreach ($listeSoupes as $soupe){
								(in_array($soupe['ID'],$soupeEnBase))? $checked='checked=checked' : $checked='';
						?>
                    	<li style="list-style:none; font-size:10px; padding:0px;"><input <?php echo $checked; ?> type="radio" name="soupe[<?php echo $dates[$jour]; ?>][ingredients]" value="<?php echo $soupe['ID'] ?>"/>&nbsp;<?php echo $soupe['libelle'] ?></li>
						<?php
                            }
                        ?>
                        </ul>
                     </td>
                  </tr>
               <?php
			   $index++;
              }
              ?>
  			</table></td>
            
            
            <td valign="top" style="border:solid 1px #000;"><table width="100%"  style="border:none" cellspacing="0" cellpadding="0">
              <tr>
                <td colspan="2"><h2>Le jus du jour</h2></td>
              </tr>
			  <?php
			  $jus = Tbq_famille::listerIngredients($ID_familles['boisson'], 'ordreWeb', 'Daily Juice');
              $index = 0;
              foreach ($jours as $jour){
				  //jus enregistrés dans la base de données mis dans un tableau
				  $jusEnBase = explode('|',$juss[$dates[$jour]]['ingredients']);
               ?>
                  <tr id="jus-<?php echo $index; ?>" onclick="javascript:menuJour.afficher(<?php echo $index; ?>);">
                    <td width="30"><strong><?php echo $jour; ?></strong></td>
                    <td width="99%"><input type="text" name="jus[<?php echo $dates[$jour]; ?>][dateJour]" value="<?php echo $dates[$jour]; ?>" style="width:80px;" /></td>
                    
                  </tr>
                  <tr style="display:none" class="contenu jour<?php echo $index; ?>">
                    <td width="99%" style="padding:0px;" colspan="2">
                    	<ul style="width:100%;">
                        <?php
							foreach ($jus as $ju){
								(in_array($ju['ID'],$jusEnBase))? $checked='checked=checked' : $checked='';
						?>
                    	<li style="list-style:none; font-size:10px; padding:0px;"><input <?php echo $checked; ?> type="radio" name="jus[<?php echo $dates[$jour]; ?>][ingredients]" value="<?php echo $ju['ID'] ?>"/>&nbsp;<?php echo $ju['libelle'] ?></li>
						<?php
                            }
                        ?>
                        </ul>
                     </td>
                  </tr>
               <?php
			   $index++;
              }
              ?>
  			</table></td>
            
            
            <td valign="top" style="border:solid 1px #000;"><table width="100%"  style="border:none" cellspacing="0" cellpadding="0">
              <tr>
                <td colspan="2"><h2>La soupe du jour (Diet)</h2></td>
              </tr>
			  <?php
			  $listeSoupesDiet = Tbq_famille::listerIngredients($ID_familles['soupe'], 'ordreWeb', 'Diet');
              $index = 0;
              foreach ($jours as $jour){
				  //soupes diet enregistrés dans la base de données mis dans un tableau
				  $soupesDietEnBase = explode('|',$soupesDiet[$dates[$jour]]['ingredients']);
               ?>
                  <tr id="soupeDiet-<?php echo $index; ?>" onclick="javascript:menuJour.afficher(<?php echo $index; ?>);">
                    <td width="30"><strong><?php echo $jour; ?></strong></td>
                    <td width="99%"><input type="text" name="soupeDiet[<?php echo $dates[$jour]; ?>][dateJour]" value="<?php echo $dates[$jour]; ?>" style="width:80px;" /></td>
                    
                  </tr>
                  <tr style="display:none" class="contenu jour<?php echo $index; ?>">
                    <td width="99%" style="padding:0px;" colspan="2">
                    	<ul style="width:100%;">
                        <?php
							foreach ($listeSoupesDiet as $soupe){
								(in_array($soupe['ID'],$soupesDietEnBase))? $checked='checked=checked' : $checked='';
						?>
                    	<li style="list-style:none; font-size:10px; padding:0px;"><input <?php echo $checked; ?> type="radio" name="soupeDiet[<?php echo $dates[$jour]; ?>][ingredients]" value="<?php echo $soupe['ID'] ?>"/>&nbsp;<?php echo $soupe['libelle'] ?></li>
						<?php
                            }
                        ?>
                        </ul>
                     </td>
                  </tr>
               <?php
			   $index++;
              }
              ?>
  			</table></td>
         </tr>   
         
         <tr><td><h2>La salade</h2></td></tr>
         
         <tr>
            <td valign="top" style="border:solid 1px #000;"><table width="100%"  style="border:none" cellspacing="0" cellpadding="0">
              <tr>
                <td colspan="2"><h2>Les légumes du jour</h2></td>
              </tr>
			  <?php
			  $defaultChecked = Tbq_ingredient::getDefaultStuff($ID_familles['salade'],'Légumes');
			  $legumesSalade = Tbq_famille::listerIngredients($ID_familles['salade'], 'libelleSousFamille DESC', 'Légumes');
              $index = 0;
              foreach ($jours as $jour){
				  //legumes enregistrés dans la base de données mis dans un tableau
				  $legumesEnBase = explode('|',$salade[$dates[$jour]]['ingredients']);
               ?>
                  <tr id="legumes-<?php echo $index; ?>" onclick="javascript:menuJour.afficher(<?php echo $index; ?>);">
                    <td width="30"><strong><?php echo $jour; ?></strong></td>
                    <td width="99%"><input type="text" name="salade[<?php echo $dates[$jour]; ?>][dateJour]" value="<?php echo $dates[$jour]; ?>" style="width:80px;" /></td>
                    
                  </tr>
                  <tr style="display:none" class="contenu jour<?php echo $index; ?>">
                    <td width="99%" style="padding:0px;" colspan="2">
                    	<ul style="width:100%;">
                        <?php
							foreach ($legumesSalade as $ingredient){
								(in_array($ingredient['ID'],$legumesEnBase))? $checked='checked=checked' : $checked='';
						?>
                    	<li style="list-style:none; font-size:10px; padding:0px;"><input id="ingredient<?php echo $index.'-'.$ingredient['ID']; ?>" <?php echo $checked; ?> type="checkbox" name="salade[<?php echo $dates[$jour]; ?>][ingredients][]" value="<?php echo $ingredient['ID'] ?>"/>&nbsp;<?php echo $ingredient['libelle'] ?></li>
						<?php
                            }
                        ?>
                        </ul>
                        <input type="button" style="font-size:9px; margin-bottom:10px;" onclick="javascript:menuJour.selectDefaultStuff('<?php echo $defaultChecked; ?>',<?php echo $index; ?>);" value="Sélectionner les ingrédients par défaut" />
                     </td>
                  </tr>
               <?php
			   $index++;
              }
              ?>
  			</table></td>
            
            
            <td valign="top" style="border:solid 1px #000;"><table width="100%"  style="border:none" cellspacing="0" cellpadding="0">
              <tr>
                <td colspan="2"><h2>Les féculents du jour</h2></td>
              </tr>
			  <?php
			  $defaultChecked = Tbq_ingredient::getDefaultStuff($ID_familles['salade'],'Féculents');
			  $feculentSalade = Tbq_famille::listerIngredients($ID_familles['salade'], 'libelleSousFamille DESC', 'Féculents');
              $index = 0;
              foreach ($jours as $jour){
				  //feculents enregistrés dans la base de données mis dans un tableau
				  $feculentsEnBase = explode('|',$salade[$dates[$jour]]['ingredients']);
               ?>
                  <tr id="feculent-<?php echo $index; ?>" onclick="javascript:menuJour.afficher(<?php echo $index; ?>);">
                    <td width="30"><strong><?php echo $jour; ?></strong></td>
                    <td width="99%"><input type="text" name="salade[<?php echo $dates[$jour]; ?>][dateJour]" value="<?php echo $dates[$jour]; ?>" style="width:80px;" /></td>
                    
                  </tr>
                  <tr style="display:none" class="contenu jour<?php echo $index; ?>">
                    <td width="99%" style="padding:0px;" colspan="2">
                    	<ul style="width:100%;">
                        <?php
							foreach ($feculentSalade as $ingredient){
								(in_array($ingredient['ID'],$feculentsEnBase))? $checked='checked=checked' : $checked='';
						?>
                    	<li style="list-style:none; font-size:10px; padding:0px;"><input id="ingredient<?php echo $index.'-'.$ingredient['ID']; ?>" <?php echo $checked; ?> type="checkbox" name="salade[<?php echo $dates[$jour]; ?>][ingredients][]" value="<?php echo $ingredient['ID'] ?>"/>&nbsp;<?php echo $ingredient['libelle'] ?></li>
						<?php
                            }
                        ?>
                        </ul>
                        <input type="button" style="font-size:9px; margin-bottom:10px;" onclick="javascript:menuJour.selectDefaultStuff('<?php echo $defaultChecked; ?>',<?php echo $index; ?>);" value="Sélectionner les ingrédients par défaut" />
                     </td>
                  </tr>
               <?php
			   $index++;
              }
              ?>
  			</table></td>
            
            
            <td valign="top" style="border:solid 1px #000;"><table width="100%"  style="border:none" cellspacing="0" cellpadding="0">
              <tr>
                <td colspan="2"><h2>Les Graines du jour</h2></td>
              </tr>
			  <?php
			  $defaultChecked = Tbq_ingredient::getDefaultStuff($ID_familles['salade'],'Graines');
			  $grainesSalade = Tbq_famille::listerIngredients($ID_familles['salade'], 'libelleSousFamille DESC', 'Graines');
              $index = 0;
              foreach ($jours as $jour){
				  //graines enregistrés dans la base de données mis dans un tableau
				  $grainesEnBase = explode('|',$salade[$dates[$jour]]['ingredients']);
               ?>
                  <tr id="graines-<?php echo $index; ?>" onclick="javascript:menuJour.afficher(<?php echo $index; ?>);">
                    <td width="30"><strong><?php echo $jour; ?></strong></td>
                    <td width="99%"><input type="text" name="salade[<?php echo $dates[$jour]; ?>][dateJour]" value="<?php echo $dates[$jour]; ?>" style="width:80px;" /></td>
                    
                  </tr>
                  <tr style="display:none" class="contenu jour<?php echo $index; ?>">
                    <td width="99%" style="padding:0px;" colspan="2">
                    	<ul style="width:100%;">
                        <?php
							foreach ($grainesSalade as $ingredient){
								(in_array($ingredient['ID'],$grainesEnBase))? $checked='checked=checked' : $checked='';
						?>
                    	<li style="list-style:none; font-size:10px; padding:0px;"><input id="ingredient<?php echo $index.'-'.$ingredient['ID']; ?>" <?php echo $checked; ?> type="checkbox" name="salade[<?php echo $dates[$jour]; ?>][ingredients][]" value="<?php echo $ingredient['ID'] ?>"/>&nbsp;<?php echo $ingredient['libelle'] ?></li>
						<?php
                            }
                        ?>
                        </ul>
                        <input type="button" style="font-size:9px; margin-bottom:10px;" onclick="javascript:menuJour.selectDefaultStuff('<?php echo $defaultChecked; ?>',<?php echo $index; ?>);" value="Sélectionner les ingrédients par défaut" />
                     </td>
                  </tr>
               <?php
			   $index++;
              }
              ?>
  			</table></td>
        <tr>
        	<td valign="top" style="border:solid 1px #000;"><table width="100%"  style="border:none" cellspacing="0" cellpadding="0">
              <tr>
                <td colspan="2"><h2>Les Autres ingrédients du jour</h2></td>
              </tr>
			  <?php
			  $defaultChecked = Tbq_ingredient::getDefaultStuff($ID_familles['salade'],'Autre');
			  $grainesSalade = Tbq_famille::listerIngredients($ID_familles['salade'], 'libelleSousFamille DESC', 'Autre');
              $index = 0;
              foreach ($jours as $jour){
				  //graines enregistrés dans la base de données mis dans un tableau
				  $grainesEnBase = explode('|',$salade[$dates[$jour]]['ingredients']);
               ?>
                  <tr id="graines-<?php echo $index; ?>" onclick="javascript:menuJour.afficher(<?php echo $index; ?>);">
                    <td width="30"><strong><?php echo $jour; ?></strong></td>
                    <td width="99%"><input type="text" name="salade[<?php echo $dates[$jour]; ?>][dateJour]" value="<?php echo $dates[$jour]; ?>" style="width:80px;" /></td>
                    
                  </tr>
                  <tr style="display:none" class="contenu jour<?php echo $index; ?>">
                    <td width="99%" style="padding:0px;" colspan="2">
                    	<ul style="width:100%;">
                        <?php
							foreach ($grainesSalade as $ingredient){
								(in_array($ingredient['ID'],$grainesEnBase))? $checked='checked=checked' : $checked='';
						?>
                    	<li style="list-style:none; font-size:10px; padding:0px;"><input id="ingredient<?php echo $index.'-'.$ingredient['ID']; ?>" <?php echo $checked; ?> type="checkbox" name="salade[<?php echo $dates[$jour]; ?>][ingredients][]" value="<?php echo $ingredient['ID'] ?>"/>&nbsp;<?php echo $ingredient['libelle'] ?></li>
						<?php
                            }
                        ?>
                        </ul>
                        <input type="button" style="font-size:9px; margin-bottom:10px;" onclick="javascript:menuJour.selectDefaultStuff('<?php echo $defaultChecked; ?>',<?php echo $index; ?>);" value="Sélectionner les ingrédients par défaut" />
                     </td>
                  </tr>
               <?php
			   $index++;
              }
              ?>
  			</table></td>
        </tr>
        </tr>
        <tr><td><h2>Les desserts du jour</h2></td></tr>
         
         <tr>
            <td valign="top" style="border:solid 1px #000;"><table width="100%"  style="border:none" cellspacing="0" cellpadding="0">
			  <?php
			  $defaultChecked = Tbq_ingredient::getDefaultStuff($ID_familles['dessert'],'');
			  $listeDesserts = Tbq_famille::listerIngredients($ID_familles['dessert'], 'ordreWeb');
              $index = 0;
              foreach ($jours as $jour){
				  //desserts enregistrés dans la base de données mis dans un tableau
				  $dessertsEnBase = explode('|',$desserts[$dates[$jour]]['ingredients']);
               ?>
                  <tr id="legumes-<?php echo $index; ?>" onclick="javascript:menuJour.afficher(<?php echo $index; ?>);">
                    <td width="30"><strong><?php echo $jour; ?></strong></td>
                    <td width="99%"><input type="text" name="desserts[<?php echo $dates[$jour]; ?>][dateJour]" value="<?php echo $dates[$jour]; ?>" style="width:80px;" /></td>
                    
                  </tr>
                  <tr style="display:none" class="contenu jour<?php echo $index; ?>">
                    <td width="99%" style="padding:0px;" colspan="2">
                    	<ul style="width:100%;">
                        <?php
							foreach ($listeDesserts as $ingredient){
								(in_array($ingredient['ID'],$dessertsEnBase))? $checked='checked=checked' : $checked='';
						?>
                    	<li style="list-style:none; font-size:10px; padding:0px;"><input id="ingredient<?php echo $index.'-'.$ingredient['ID']; ?>" <?php echo $checked; ?> type="checkbox" name="desserts[<?php echo $dates[$jour]; ?>][ingredients][]" value="<?php echo $ingredient['ID'] ?>"/>&nbsp;<?php echo $ingredient['libelle'] ?></li>
						<?php
                            }
                        ?>
                        </ul>
                        <input type="button" style="font-size:9px; margin-bottom:10px;" onclick="javascript:menuJour.selectDefaultStuff('<?php echo $defaultChecked; ?>',<?php echo $index; ?>);" value="Sélectionner les ingrédients par défaut" />
                     </td>
                  </tr>
               <?php
			   $index++;
              }
              ?>
  			</table></td>
            
        </tr>
        <tr><td><input type="submit" name="ok" value="Enregistrer" /></td></tr>
      </table>
   </form>
  
  
  
    <!-- InstanceEndEditable --> </div>
  <div class="ajusteur"></div>
</div>
</body>
<!-- InstanceEnd --></html>
