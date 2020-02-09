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
$feculents=$menuJour->listerParDate(date("Y-m-d", mktime(0,0,0,date("m"),date("d")-date("w")+1,date("Y"))), date("Y-m-d", mktime(0,0,0,date("m"),date("d")-date("w")+6,date("Y"))),'feculent');
$yaourt=$menuJour->listerParDate(date("Y-m-d", mktime(0,0,0,date("m"),date("d")-date("w")+1,date("Y"))), date("Y-m-d", mktime(0,0,0,date("m"),date("d")-date("w")+6,date("Y"))),'desserts');
$yaourt2=$menuJour->listerParDate(date("Y-m-d", mktime(0,0,0,date("m"),date("d")-date("w")+1,date("Y"))), date("Y-m-d", mktime(0,0,0,date("m"),date("d")-date("w")+6,date("Y"))),'desserts2');
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
  <form name="formulaire" method="post" action="scripts/sauver_menus.php">
      <h1>Le menu du jour</h1>
      <p>Veuillez entrer les ingrédients pour les soupes et les jus du jour :</p>
      <p>&nbsp;</p>
      <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:none;">
        <tr>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td colspan="2"><h2>La soupe du jour (Daily)</h2></td>
              </tr>
              <tr>
                <td width="30">Lundi</td>
                <?php $date1 = date("d-m-Y", mktime(0,0,0,date("m"),date("d")-date("w")+1,date("Y"))); ?>
                <td width="99%"><input type="text" name="soupe[<?php echo $date1; ?>][dateJour]" value="<?php echo $date1; ?>" style="width:80px;" /></td>
              </tr>
              <tr>
                <td colspan="2"><textarea name="soupe[<?php echo $date1; ?>][ingredients]" cols="50" rows="2"><?php echo $soupes[$date1]['ingredients']; ?></textarea></td>
              </tr>
              <tr>
                <td>Mardi</td>
                <?php $date2 = date("d-m-Y", mktime(0,0,0,date("m"),date("d")-date("w")+2,date("Y"))); ?>
                <td><input type="text" name="soupe[<?php echo $date2; ?>][dateJour]" value="<?php echo $date2; ?>" style="width:80px;" /></td>
              </tr>
              <tr>
                <td colspan="2"><textarea name="soupe[<?php echo $date2; ?>][ingredients]" cols="50" rows="2"><?php echo $soupes[$date2]['ingredients']; ?></textarea></td>
              </tr>
              <tr>
                <td>Mercredi</td>
                <?php $date3 = date("d-m-Y", mktime(0,0,0,date("m"),date("d")-date("w")+3,date("Y"))); ?>
                <td><input type="text" name="soupe[<?php echo $date3; ?>][dateJour]" value="<?php echo $date3; ?>" style="width:80px;" /></td>
              </tr>
              <tr>
                <td colspan="2"><textarea name="soupe[<?php echo $date3; ?>][ingredients]" cols="50" rows="2"><?php echo $soupes[$date3]['ingredients']; ?></textarea></td>
              </tr>
              <tr>
                <td>Jeudi </td>
                <?php $date4 = date("d-m-Y", mktime(0,0,0,date("m"),date("d")-date("w")+4,date("Y"))); ?>
                <td><input type="text" name="soupe[<?php echo $date4; ?>][dateJour]" value="<?php echo $date4; ?>" style="width:80px;" /></td>
              </tr>
              <tr>
                <td colspan="2"><textarea name="soupe[<?php echo $date4; ?>][ingredients]" cols="50" rows="2"><?php echo $soupes[$date4]['ingredients']; ?></textarea></td>
              </tr>
              <tr>
                <td>Vendredi </td>
                <?php $date5 = date("d-m-Y", mktime(0,0,0,date("m"),date("d")-date("w")+5,date("Y"))); ?>
                <td><input type="text" name="soupe[<?php echo $date5; ?>][dateJour]" value="<?php echo $date5; ?>" style="width:80px;" /></td>
              </tr>
              <tr>
                <td colspan="2"><textarea name="soupe[<?php echo $date5; ?>][ingredients]" cols="50" rows="2"><?php echo $soupes[$date5]['ingredients']; ?></textarea></td>
              </tr>
              <tr>
                <td>Samedi </td>
                <?php $date6 = date("d-m-Y", mktime(0,0,0,date("m"),date("d")-date("w")+6,date("Y"))); ?>
                <td><input type="text" name="soupe[<?php echo $date6; ?>][dateJour]" value="<?php echo $date6; ?>" style="width:80px;" /></td>
              </tr>
              <tr>
                <td colspan="2"><textarea name="soupe[<?php echo $date6; ?>][ingredients]" cols="50" rows="2"><?php echo $soupes[$date6]['ingredients']; ?></textarea></td>
              </tr>
            </table></td>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td colspan="2"><h2>Le jus du jour</h2></td>
              </tr>
              <tr>
                <td width="30">Lundi</td>
                <td width="99%"><input type="text" name="jus[<?php echo $date1; ?>][dateJour]" value="<?php echo $date1; ?>" style="width:80px;" /></td>
              </tr>
              <tr>
                <td colspan="2"><textarea name="jus[<?php echo $date1; ?>][ingredients]" cols="50" rows="2"><?php echo $juss[$date1]['ingredients']; ?></textarea></td>
              </tr>
              <tr>
                <td>Mardi</td>
                <td><input type="text" name="jus[<?php echo $date2; ?>][dateJour]" value="<?php echo $date2; ?>" style="width:80px;" /></td>
              </tr>
              <tr>
                <td colspan="2"><textarea name="jus[<?php echo $date2; ?>][ingredients]" cols="50" rows="2"><?php echo $juss[$date2]['ingredients']; ?></textarea></td>
              </tr>
              <tr>
                <td>Mercredi</td>
                <td><input type="text" name="jus[<?php echo $date3; ?>][dateJour]" value="<?php echo $date3; ?>" style="width:80px;" /></td>
              </tr>
              <tr>
                <td colspan="2"><textarea name="jus[<?php echo $date3; ?>][ingredients]" cols="50" rows="2"><?php echo $juss[$date3]['ingredients']; ?></textarea></td>
              </tr>
              <tr>
                <td>Jeudi </td>
                <td><input type="text" name="jus[<?php echo $date4; ?>][dateJour]" value="<?php echo $date4; ?>" style="width:80px;" /></td>
              </tr>
              <tr>
                <td colspan="2"><textarea name="jus[<?php echo $date4; ?>][ingredients]" cols="50" rows="2"><?php echo $juss[$date4]['ingredients']; ?></textarea></td>
              </tr>
              <tr>
                <td>Vendredi </td>
                <td><input type="text" name="jus[<?php echo $date5; ?>][dateJour]" value="<?php echo $date5; ?>" style="width:80px;" /></td>
              </tr>
              <tr>
                <td colspan="2"><textarea name="jus[<?php echo $date5; ?>][ingredients]" cols="50" rows="2"><?php echo $juss[$date5]['ingredients']; ?></textarea></td>
              </tr>
              <tr>
                <td>Samedi </td>
                <td><input type="text" name="jus[<?php echo $date6; ?>][dateJour]" value="<?php echo $date6; ?>" style="width:80px;" /></td>
              </tr>
              <tr>
                <td colspan="2"><textarea name="jus[<?php echo $date6; ?>][ingredients]" cols="50" rows="2"><?php echo $juss[$date6]['ingredients']; ?></textarea></td>
              </tr>
            </table></td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:none;">
        <tr>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td colspan="2"><h2>La soupe  du jour (Diet)</h2></td>
              </tr>
              <tr>
                <td width="30">Lundi</td>
                <?php $date1 = date("d-m-Y", mktime(0,0,0,date("m"),date("d")-date("w")+1,date("Y"))); ?>
                <td width="99%"><input type="text" name="soupeDiet[<?php echo $date1; ?>][dateJour]" value="<?php echo $date1; ?>" style="width:80px;" /></td>
              </tr>
              <tr>
                <td colspan="2"><textarea name="soupeDiet[<?php echo $date1; ?>][ingredients]" cols="50" rows="2"><?php echo $soupesDiet[$date1]['ingredients']; ?></textarea></td>
              </tr>
              <tr>
                <td>Mardi</td>
                <?php $date2 = date("d-m-Y", mktime(0,0,0,date("m"),date("d")-date("w")+2,date("Y"))); ?>
                <td><input type="text" name="soupeDiet[<?php echo $date2; ?>][dateJour]" value="<?php echo $date2; ?>" style="width:80px;" /></td>
              </tr>
              <tr>
                <td colspan="2"><textarea name="soupeDiet[<?php echo $date2; ?>][ingredients]" cols="50" rows="2"><?php echo $soupesDiet[$date2]['ingredients']; ?></textarea></td>
              </tr>
              <tr>
                <td>Mercredi</td>
                <?php $date3 = date("d-m-Y", mktime(0,0,0,date("m"),date("d")-date("w")+3,date("Y"))); ?>
                <td><input type="text" name="soupeDiet[<?php echo $date3; ?>][dateJour]" value="<?php echo $date3; ?>" style="width:80px;" /></td>
              </tr>
              <tr>
                <td colspan="2"><textarea name="soupeDiet[<?php echo $date3; ?>][ingredients]" cols="50" rows="2"><?php echo $soupesDiet[$date3]['ingredients']; ?></textarea></td>
              </tr>
              <tr>
                <td>Jeudi </td>
                <?php $date4 = date("d-m-Y", mktime(0,0,0,date("m"),date("d")-date("w")+4,date("Y"))); ?>
                <td><input type="text" name="soupeDiet[<?php echo $date4; ?>][dateJour]" value="<?php echo $date4; ?>" style="width:80px;" /></td>
              </tr>
              <tr>
                <td colspan="2"><textarea name="soupeDiet[<?php echo $date4; ?>][ingredients]" cols="50" rows="2"><?php echo $soupesDiet[$date4]['ingredients']; ?></textarea></td>
              </tr>
              <tr>
                <td>Vendredi </td>
                <?php $date5 = date("d-m-Y", mktime(0,0,0,date("m"),date("d")-date("w")+5,date("Y"))); ?>
                <td><input type="text" name="soupeDiet[<?php echo $date5; ?>][dateJour]" value="<?php echo $date5; ?>" style="width:80px;" /></td>
              </tr>
              <tr>
                <td colspan="2"><textarea name="soupeDiet[<?php echo $date5; ?>][ingredients]" cols="50" rows="2"><?php echo $soupesDiet[$date5]['ingredients']; ?></textarea></td>
              </tr>
              <tr>
                <td>Samedi </td>
                <?php $date6 = date("d-m-Y", mktime(0,0,0,date("m"),date("d")-date("w")+6,date("Y"))); ?>
                <td><input type="text" name="soupeDiet[<?php echo $date6; ?>][dateJour]" value="<?php echo $date6; ?>" style="width:80px;" /></td>
              </tr>
              <tr>
                <td colspan="2"><textarea name="soupeDiet[<?php echo $date6; ?>][ingredients]" cols="50" rows="2"><?php echo $soupesDiet[$date6]['ingredients']; ?></textarea></td>
              </tr>
            </table></td>
          <td valign="top">&nbsp;</td>
        </tr>
        <tr>
        <td><h2>Salade</h2></td></tr>
        <tr>
        	<td valign="top">
            
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td colspan="2"><h2>Les l&eacute;gumes du jour</h2></td>
              </tr>
              <tr>
                <td width="30"><strong>Lundi</strong></td>
                <td width="99%"><input type="text" name="legumes[<?php echo $date1; ?>][dateJour]" value="<?php echo $date1; ?>" style="width:80px;" /></td>
              </tr>
              <tr>
                <td colspan="2">
                <?php /*?><textarea name="feculents[<?php echo $date1; ?>][ingredients]" cols="50" rows="2"><?php echo $feculents[$date1]['ingredients']; ?></textarea><?php */?>
                <input name="legumes[<?php echo $date1; ?>][ingredients][]" type="checkbox" value="Choux blancs|" <?php if($menuJour->estLegumeDuJour('Choux blancs',$date1,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Choux blancs
                <input name="legumes[<?php echo $date1; ?>][ingredients][]" type="checkbox" value="Choux rouges|" <?php if($menuJour->estLegumeDuJour('Choux rouges',$date1,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Choux rouges
                <input name="legumes[<?php echo $date1; ?>][ingredients][]" type="checkbox" value="Endives|" <?php if($menuJour->estLegumeDuJour('Endives',$date1,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Endives
                <input name="legumes[<?php echo $date1; ?>][ingredients][]" type="checkbox" value="Fenouil|" <?php if($menuJour->estLegumeDuJour('Fenouil',$date1,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Fenouil
                <input name="legumes[<?php echo $date1; ?>][ingredients][]" type="checkbox" value="Lentilles|" <?php if($menuJour->estLegumeDuJour('Lentilles',$date1,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Lentilles<br />
                <?php 
				//Extraire le légume qui n'est pas dans la liste normale des ingrédients 
				$listeLegumes = $menuJour->getMenuJour($date1,$_SESSION["sessionID_user"],'legumes');
				$listeLegumes = explode('|',$listeLegumes);
				$autre='';
				foreach($listeLegumes as $legume)
					{
					if(!in_array($legume,$commande->ingredients))
						{
						$autre = $legume;
						}
					}?>
                Autre : <input type="text" name="legumes[<?php echo $date1; ?>][ingredients][]" value="<?php echo $autre;?>" /><p>&nbsp;</p></td>
              </tr>
              <tr>
                <td><strong>Mardi</strong></td>
                <td><input type="text" name="legumes[<?php echo $date2; ?>][dateJour]" value="<?php echo $date2; ?>" style="width:80px;" />
                </td>
              </tr>
              <tr>
                <td colspan="2">
                <input name="legumes[<?php echo $date2; ?>][ingredients][]" type="checkbox" value="Choux blancs|" <?php if($menuJour->estLegumeDuJour('Choux blancs',$date2,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Choux blancs
                <input name="legumes[<?php echo $date2; ?>][ingredients][]" type="checkbox" value="Choux rouges|" <?php if($menuJour->estLegumeDuJour('Choux rouges',$date2,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Choux rouges
                <input name="legumes[<?php echo $date2; ?>][ingredients][]" type="checkbox" value="Endives|" <?php if($menuJour->estLegumeDuJour('Endives',$date2,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Endives
                <input name="legumes[<?php echo $date2; ?>][ingredients][]" type="checkbox" value="Fenouil|" <?php if($menuJour->estLegumeDuJour('Fenouil',$date2,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Fenouil
                <input name="legumes[<?php echo $date2; ?>][ingredients][]" type="checkbox" value="Lentilles|" <?php if($menuJour->estLegumeDuJour('Lentilles',$date2,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Lentilles
                <br />
                <?php 
				//Extraire le légume qui n'est pas dans la liste normale des ingrédients 
				$listeLegumes = $menuJour->getMenuJour($date2,$_SESSION["sessionID_user"],'legumes');
				$listeLegumes = explode('|',$listeLegumes);
				$autre='';
				foreach($listeLegumes as $legume)
					{
					if(!in_array($legume,$commande->ingredients))
						{
						$autre = $legume;
						}
					}?>
                Autre : <input type="text" name="legumes[<?php echo $date2; ?>][ingredients][]" value="<?php echo $autre;?>" /><p>&nbsp;</p></td>
              </tr>
              <tr>
                <td><strong>Mercredi</strong></td>
                <td><input type="text" name="legumes[<?php echo $date3; ?>][dateJour]" value="<?php echo $date3; ?>" style="width:80px;" /></td>
              </tr>
              <tr>
                <td colspan="2"><?php /*?><textarea name="feculents[<?php echo $date3; ?>][ingredients]" cols="50" rows="2"><?php echo $feculents[$date3]['ingredients']; ?></textarea><?php */?>
                <input name="legumes[<?php echo $date3; ?>][ingredients][]" type="checkbox" value="Choux blancs|" <?php if($menuJour->estLegumeDuJour('Choux blancs',$date3,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Choux blancs
                <input name="legumes[<?php echo $date3; ?>][ingredients][]" type="checkbox" value="Choux rouges|" <?php if($menuJour->estLegumeDuJour('Choux rouges',$date3,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Choux rouges
                <input name="legumes[<?php echo $date3; ?>][ingredients][]" type="checkbox" value="Endives|" <?php if($menuJour->estLegumeDuJour('Endives',$date3,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Endives
                <input name="legumes[<?php echo $date3; ?>][ingredients][]" type="checkbox" value="Fenouil|" <?php if($menuJour->estLegumeDuJour('Fenouil',$date3,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Fenouil
                <input name="legumes[<?php echo $date3; ?>][ingredients][]" type="checkbox" value="Lentilles|" <?php if($menuJour->estLegumeDuJour('Lentilles',$date3,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Lentilles<br />
                <?php 
				//Extraire le légume qui n'est pas dans la liste normale des ingrédients 
				$listeLegumes = $menuJour->getMenuJour($date3,$_SESSION["sessionID_user"],'legumes');
				$listeLegumes = explode('|',$listeLegumes);
				$autre='';
				foreach($listeLegumes as $legume)
					{
					if(!in_array($legume,$commande->ingredients))
						{
						$autre = $legume;
						}
					}?>
                Autre : <input type="text" name="legumes[<?php echo $date3; ?>][ingredients][]" value="<?php echo $autre;?>" /><p>&nbsp;</p></td>
              </tr>
              <tr>
                <td><strong>Jeudi</strong></td>
                <td><input type="text" name="legumes[<?php echo $date4; ?>][dateJour]" value="<?php echo $date4; ?>" style="width:80px;" /></td>
              </tr>
              <tr>
                <td colspan="2"><?php /*?><textarea name="feculents[<?php echo $date4; ?>][ingredients]" cols="50" rows="2"><?php echo $feculents[$date4]['ingredients']; ?></textarea><?php */?>
                <input name="legumes[<?php echo $date4; ?>][ingredients][]" type="checkbox" value="Choux blancs|" <?php if($menuJour->estLegumeDuJour('Choux blancs',$date4,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Choux blancs
                <input name="legumes[<?php echo $date4; ?>][ingredients][]" type="checkbox" value="Choux rouges|" <?php if($menuJour->estLegumeDuJour('Choux rouges',$date4,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Choux rouges
                <input name="legumes[<?php echo $date4; ?>][ingredients][]" type="checkbox" value="Endives|" <?php if($menuJour->estLegumeDuJour('Endives',$date4,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Endives
                <input name="legumes[<?php echo $date4; ?>][ingredients][]" type="checkbox" value="Fenouil|" <?php if($menuJour->estLegumeDuJour('Fenouil',$date4,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Fenouil
                <input name="legumes[<?php echo $date4; ?>][ingredients][]" type="checkbox" value="Lentilles|" <?php if($menuJour->estLegumeDuJour('Lentilles',$date4,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Lentilles<br />
                <?php 
				//Extraire le légume qui n'est pas dans la liste normale des ingrédients 
				$listeLegumes = $menuJour->getMenuJour($date4,$_SESSION["sessionID_user"],'legumes');
				$listeLegumes = explode('|',$listeLegumes);
				$autre='';
				foreach($listeLegumes as $legume)
					{
					if(!in_array($legume,$commande->ingredients))
						{
						$autre = $legume;
						}
					}?>
                Autre : <input type="text" name="legumes[<?php echo $date4; ?>][ingredients][]" value="<?php echo $autre;?>" /><p>&nbsp;</p></td>
              </tr>
              <tr>
                <td><strong>Vendredi</strong></td>
                <td><input type="text" name="legumes[<?php echo $date5; ?>][dateJour]" value="<?php echo $date5; ?>" style="width:80px;" /></td>
              </tr>
              <tr>
                <td colspan="2"><?php /*?><textarea name="feculents[<?php echo $date5; ?>][ingredients]" cols="50" rows="2"><?php echo $feculents[$date5]['ingredients']; ?></textarea><?php */?>
                <input name="legumes[<?php echo $date5; ?>][ingredients][]" type="checkbox" value="Choux blancs|" <?php if($menuJour->estLegumeDuJour('Choux blancs',$date5,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Choux blancs
                <input name="legumes[<?php echo $date5; ?>][ingredients][]" type="checkbox" value="Choux rouges|" <?php if($menuJour->estLegumeDuJour('Choux rouges',$date5,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Choux rouges
                <input name="legumes[<?php echo $date5; ?>][ingredients][]" type="checkbox" value="Endives|" <?php if($menuJour->estLegumeDuJour('Endives',$date5,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Endives
                <input name="legumes[<?php echo $date5; ?>][ingredients][]" type="checkbox" value="Fenouil|" <?php if($menuJour->estLegumeDuJour('Fenouil',$date5,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Fenouil
                <input name="legumes[<?php echo $date5; ?>][ingredients][]" type="checkbox" value="Lentilles|" <?php if($menuJour->estLegumeDuJour('Lentilles',$date5,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Lentilles<br />
                <?php 
				//Extraire le légume qui n'est pas dans la liste normale des ingrédients 
				$listeLegumes = $menuJour->getMenuJour($date5,$_SESSION["sessionID_user"],'legumes');
				$listeLegumes = explode('|',$listeLegumes);
				$autre='';
				foreach($listeLegumes as $legume)
					{
					if(!in_array($legume,$commande->ingredients))
						{
						$autre = $legume;
						}
					}?>
                Autre : <input type="text" name="legumes[<?php echo $date5; ?>][ingredients][]" value="<?php echo $autre;?>" /><p>&nbsp;</p></td>
              </tr>
              <tr>
                <td><strong>Samedi</strong></td>
                <td><input type="text" name="legumes[<?php echo $date6; ?>][dateJour]" value="<?php echo $date6; ?>" style="width:80px;" /></td>
              </tr>
              <tr>
                <td colspan="2"><?php /*?><textarea name="feculents[<?php echo $date6; ?>][ingredients]" cols="50" rows="2"><?php echo $feculents[$date6]['ingredients']; ?></textarea><?php */?>
                <input name="legumes[<?php echo $date6; ?>][ingredients][]" type="checkbox" value="Choux blancs|" <?php if($menuJour->estLegumeDuJour('Choux blancs',$date6,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Choux blancs
                <input name="legumes[<?php echo $date6; ?>][ingredients][]" type="checkbox" value="Choux rouges|" <?php if($menuJour->estLegumeDuJour('Choux rouges',$date6,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Choux rouges
                <input name="legumes[<?php echo $date6; ?>][ingredients][]" type="checkbox" value="Endives|" <?php if($menuJour->estLegumeDuJour('Endives',$date6,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Endives
                <input name="legumes[<?php echo $date6; ?>][ingredients][]" type="checkbox" value="Fenouil|" <?php if($menuJour->estLegumeDuJour('Fenouil',$date6,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Fenouil
                <input name="legumes[<?php echo $date6; ?>][ingredients][]" type="checkbox" value="Lentilles|" <?php if($menuJour->estLegumeDuJour('Lentilles',$date6,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Lentilles<br />
                <?php 
				//Extraire le légume qui n'est pas dans la liste normale des ingrédients 
				$listeLegumes = $menuJour->getMenuJour($date6,$_SESSION["sessionID_user"],'legumes');
				$listeLegumes = explode('|',$listeLegumes);
				$autre='';
				foreach($listeLegumes as $legume)
					{
					if(!in_array($legume,$commande->ingredients))
						{
						$autre = $legume;
						}
					}?>
                Autre : <input type="text" name="legumes[<?php echo $date6; ?>][ingredients][]" value="<?php echo $autre;?>" /><br /></td>
              </tr>
            </table>
            </td>
        	<td>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td colspan="2"><h2>Les f&eacute;culents du jour</h2></td>
              </tr>
              <tr>
                <td width="30"><strong>Lundi</strong></td>
                <td width="99%"><input type="text" name="feculents[<?php echo $date1; ?>][dateJour]" value="<?php echo $date1; ?>" style="width:80px;" /></td>
              </tr>
              <tr>
                <td colspan="2">
                <?php /*?><textarea name="feculents[<?php echo $date1; ?>][ingredients]" cols="50" rows="2"><?php echo $feculents[$date1]['ingredients']; ?></textarea><?php */?>
                <input name="feculents[<?php echo $date1; ?>][ingredients][]" type="checkbox" value="Blé|" <?php if($menuJour->estFeculentDuJour('Blé',$date1,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Bl&eacute;
                <input name="feculents[<?php echo $date1; ?>][ingredients][]" type="checkbox" value="Boulgour|" <?php if($menuJour->estFeculentDuJour('Boulgour',$date1,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Boulgour
                <input name="feculents[<?php echo $date1; ?>][ingredients][]" type="checkbox" value="Pates|" <?php if($menuJour->estFeculentDuJour('Pates',$date1,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;P&acirc;tes
                <input name="feculents[<?php echo $date1; ?>][ingredients][]" type="checkbox" value="Quinoa|" <?php if($menuJour->estFeculentDuJour('Quinoa',$date1,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Quinoa
                <input name="feculents[<?php echo $date1; ?>][ingredients][]" type="checkbox" value="Riz|" <?php if($menuJour->estFeculentDuJour('Riz',$date1,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Riz<br /><?php 
				//Extraire le légume qui n'est pas dans la liste normale des ingrédients 
				$listeFeculents = $menuJour->getMenuJour($date1,$_SESSION["sessionID_user"],'feculents');
				$listeFeculents = explode('|',$listeFeculents);
				$autre='';
				foreach($listeFeculents as $feculent)
					{
					if(!in_array($feculent,$commande->ingredients))
						{
						$autre = $feculent;
						}
					}?>
                Autre : <input type="text" name="feculents[<?php echo $date1; ?>][ingredients][]" value="<?php echo $autre;?>" /><p>&nbsp;</p></td>
              </tr>
              <tr>
                <td><strong>Mardi</strong></td>
                <td><input type="text" name="feculents[<?php echo $date2; ?>][dateJour]" value="<?php echo $date2; ?>" style="width:80px;" />
                </td>
              </tr>
              <tr>
                <td colspan="2"><?php /*?><textarea name="feculents[<?php echo $date2; ?>][ingredients]" cols="50" rows="2"><?php echo $feculents[$date2]['ingredients']; ?></textarea><?php */?>
                <input name="feculents[<?php echo $date2; ?>][ingredients][]" type="checkbox" value="Blé|" <?php if($menuJour->estFeculentDuJour('Blé',$date2,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Bl&eacute;
                <input name="feculents[<?php echo $date2; ?>][ingredients][]" type="checkbox" value="Boulgour|" <?php if($menuJour->estFeculentDuJour('Boulgour',$date2,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Boulgour
                <input name="feculents[<?php echo $date2; ?>][ingredients][]" type="checkbox" value="Pates|" <?php if($menuJour->estFeculentDuJour('Pates',$date2,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;P&acirc;tes
                <input name="feculents[<?php echo $date2; ?>][ingredients][]" type="checkbox" value="Quinoa|" <?php if($menuJour->estFeculentDuJour('Quinoa',$date2,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Quinoa
                <input name="feculents[<?php echo $date2; ?>][ingredients][]" type="checkbox" value="Riz|" <?php if($menuJour->estFeculentDuJour('Riz',$date2,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Riz<br /><?php 
				//Extraire le légume qui n'est pas dans la liste normale des ingrédients 
				$listeFeculents = $menuJour->getMenuJour($date2,$_SESSION["sessionID_user"],'feculents');
				$listeFeculents = explode('|',$listeFeculents);
				$autre='';
				foreach($listeFeculents as $feculent)
					{
					if(!in_array($feculent,$commande->ingredients))
						{
						$autre = $feculent;
						}
					}?>
                Autre : <input type="text" name="feculents[<?php echo $date2; ?>][ingredients][]" value="<?php echo $autre;?>" /><p>&nbsp;</p></td>
              </tr>
              <tr>
                <td><strong>Mercredi</strong></td>
                <td><input type="text" name="feculents[<?php echo $date3; ?>][dateJour]" value="<?php echo $date3; ?>" style="width:80px;" /></td>
              </tr>
              <tr>
                <td colspan="2"><?php /*?><textarea name="feculents[<?php echo $date3; ?>][ingredients]" cols="50" rows="2"><?php echo $feculents[$date3]['ingredients']; ?></textarea><?php */?>
                <input name="feculents[<?php echo $date3; ?>][ingredients][]" type="checkbox" value="Blé|" <?php if($menuJour->estFeculentDuJour('Blé',$date3,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Bl&eacute;
                <input name="feculents[<?php echo $date3; ?>][ingredients][]" type="checkbox" value="Boulgour|" <?php if($menuJour->estFeculentDuJour('Boulgour',$date3,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Boulgour
                <input name="feculents[<?php echo $date3; ?>][ingredients][]" type="checkbox" value="Pates|" <?php if($menuJour->estFeculentDuJour('Pates',$date3,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;P&acirc;tes
                <input name="feculents[<?php echo $date3; ?>][ingredients][]" type="checkbox" value="Quinoa|" <?php if($menuJour->estFeculentDuJour('Quinoa',$date3,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Quinoa
                <input name="feculents[<?php echo $date3; ?>][ingredients][]" type="checkbox" value="Riz|" <?php if($menuJour->estFeculentDuJour('Riz',$date3,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Riz<br /><?php 
				//Extraire le légume qui n'est pas dans la liste normale des ingrédients 
				$listeFeculents = $menuJour->getMenuJour($date3,$_SESSION["sessionID_user"],'feculents');
				$listeFeculents = explode('|',$listeFeculents);
				$autre='';
				foreach($listeFeculents as $feculent)
					{
					if(!in_array($feculent,$commande->ingredients))
						{
						$autre = $feculent;
						}
					}?>
                Autre : <input type="text" name="feculents[<?php echo $date3; ?>][ingredients][]" value="<?php echo $autre;?>" /><p>&nbsp;</p></td>
              </tr>
              <tr>
                <td><strong>Jeudi</strong></td>
                <td><input type="text" name="feculents[<?php echo $date4; ?>][dateJour]" value="<?php echo $date4; ?>" style="width:80px;" /></td>
              </tr>
              <tr>
                <td colspan="2"><?php /*?><textarea name="feculents[<?php echo $date4; ?>][ingredients]" cols="50" rows="2"><?php echo $feculents[$date4]['ingredients']; ?></textarea><?php */?>
                <input name="feculents[<?php echo $date4; ?>][ingredients][]" type="checkbox" value="Blé|" <?php if($menuJour->estFeculentDuJour('Blé',$date4,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Bl&eacute;
                <input name="feculents[<?php echo $date4; ?>][ingredients][]" type="checkbox" value="Boulgour|" <?php if($menuJour->estFeculentDuJour('Boulgour',$date4,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Boulgour
                <input name="feculents[<?php echo $date4; ?>][ingredients][]" type="checkbox" value="Pates|" <?php if($menuJour->estFeculentDuJour('Pates',$date4,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;P&acirc;tes
                <input name="feculents[<?php echo $date4; ?>][ingredients][]" type="checkbox" value="Quinoa|" <?php if($menuJour->estFeculentDuJour('Quinoa',$date4,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Quinoa
                <input name="feculents[<?php echo $date4; ?>][ingredients][]" type="checkbox" value="Riz|" <?php if($menuJour->estFeculentDuJour('Riz',$date4,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Riz<br /><?php 
				//Extraire le légume qui n'est pas dans la liste normale des ingrédients 
				$listeFeculents = $menuJour->getMenuJour($date4,$_SESSION["sessionID_user"],'feculents');
				$listeFeculents = explode('|',$listeFeculents);
				$autre='';
				foreach($listeFeculents as $feculent)
					{
					if(!in_array($feculent,$commande->ingredients))
						{
						$autre = $feculent;
						}
					}?>
                Autre : <input type="text" name="feculents[<?php echo $date4; ?>][ingredients][]" value="<?php echo $autre;?>" /><p>&nbsp;</p></td>
              </tr>
              <tr>
                <td><strong>Vendredi</strong></td>
                <td><input type="text" name="feculents[<?php echo $date5; ?>][dateJour]" value="<?php echo $date5; ?>" style="width:80px;" /></td>
              </tr>
              <tr>
                <td colspan="2"><?php /*?><textarea name="feculents[<?php echo $date5; ?>][ingredients]" cols="50" rows="2"><?php echo $feculents[$date5]['ingredients']; ?></textarea><?php */?>
                <input name="feculents[<?php echo $date5; ?>][ingredients][]" type="checkbox" value="Blé|" <?php if($menuJour->estFeculentDuJour('Blé',$date5,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Bl&eacute;
                <input name="feculents[<?php echo $date5; ?>][ingredients][]" type="checkbox" value="Boulgour|" <?php if($menuJour->estFeculentDuJour('Boulgour',$date5,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Boulgour
                <input name="feculents[<?php echo $date5; ?>][ingredients][]" type="checkbox" value="Pates|" <?php if($menuJour->estFeculentDuJour('Pates',$date5,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;P&acirc;tes
                <input name="feculents[<?php echo $date5; ?>][ingredients][]" type="checkbox" value="Quinoa|" <?php if($menuJour->estFeculentDuJour('Quinoa',$date5,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Quinoa
                <input name="feculents[<?php echo $date5; ?>][ingredients][]" type="checkbox" value="Riz|" <?php if($menuJour->estFeculentDuJour('Riz',$date5,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Riz<br /><?php 
				//Extraire le légume qui n'est pas dans la liste normale des ingrédients 
				$listeFeculents = $menuJour->getMenuJour($date5,$_SESSION["sessionID_user"],'feculents');
				$listeFeculents = explode('|',$listeFeculents);
				$autre='';
				foreach($listeFeculents as $feculent)
					{
					if(!in_array($feculent,$commande->ingredients))
						{
						$autre = $feculent;
						}
					}?>
                Autre : <input type="text" name="feculents[<?php echo $date5; ?>][ingredients][]" value="<?php echo $autre;?>" /><p>&nbsp;</p></td>
              </tr>
              <tr>
                <td><strong>Samedi</strong></td>
                <td><input type="text" name="feculents[<?php echo $date6; ?>][dateJour]" value="<?php echo $date6; ?>" style="width:80px;" /></td>
              </tr>
              <tr>
                <td colspan="2"><?php /*?><textarea name="feculents[<?php echo $date6; ?>][ingredients]" cols="50" rows="2"><?php echo $feculents[$date6]['ingredients']; ?></textarea><?php */?>
                <input name="feculents[<?php echo $date6; ?>][ingredients][]" type="checkbox" value="Blé|" <?php if($menuJour->estFeculentDuJour('Blé',$date6,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Bl&eacute;
                <input name="feculents[<?php echo $date6; ?>][ingredients][]" type="checkbox" value="Boulgour|" <?php if($menuJour->estFeculentDuJour('Boulgour',$date6,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Boulgour
                <input name="feculents[<?php echo $date6; ?>][ingredients][]" type="checkbox" value="Pates|" <?php if($menuJour->estFeculentDuJour('Pates',$date6,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;P&acirc;tes
                <input name="feculents[<?php echo $date6; ?>][ingredients][]" type="checkbox" value="Quinoa|" <?php if($menuJour->estFeculentDuJour('Quinoa',$date6,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Quinoa
                <input name="feculents[<?php echo $date6; ?>][ingredients][]" type="checkbox" value="Riz|" <?php if($menuJour->estFeculentDuJour('Riz',$date6,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Riz<br /><?php 
				//Extraire le légume qui n'est pas dans la liste normale des ingrédients 
				$listeFeculents = $menuJour->getMenuJour($date6,$_SESSION["sessionID_user"],'feculents');
				$listeFeculents = explode('|',$listeFeculents);
				$autre='';
				foreach($listeFeculents as $feculent)
					{
					if(!in_array($feculent,$commande->ingredients))
						{
						$autre = $feculent;
						}
					}?>
                Autre : <input type="text" name="feculents[<?php echo $date6; ?>][ingredients][]" value="<?php echo $autre;?>" /></td>
              </tr>
            </table>
            </td>
            
        </tr>
        <tr>
        	<td>
        	<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td colspan="2"><h2>Les graines du jour</h2></td>
              </tr>
              <tr>
                <td width="30"><strong>Lundi</strong></td>
                <td width="99%"><input type="text" name="graines[<?php echo $date1; ?>][dateJour]" value="<?php echo $date1; ?>" style="width:80px;" /></td>
              </tr>
              <tr>
                <td colspan="2">
                <input name="graines[<?php echo $date1; ?>][ingredients][]" type="checkbox" value="Amandes|" <?php if($menuJour->estGraineDuJour('Amandes',$date1,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Amandes
                <input name="graines[<?php echo $date1; ?>][ingredients][]" type="checkbox" value="Cranberries|" <?php if($menuJour->estGraineDuJour('Cranberries',$date1,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Cranberries
                <input name="graines[<?php echo $date1; ?>][ingredients][]" type="checkbox" value="Noix|" <?php if($menuJour->estGraineDuJour('Noix',$date1,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Noix
                <input name="graines[<?php echo $date1; ?>][ingredients][]" type="checkbox" value="Pralin|" <?php if($menuJour->estGraineDuJour('Pralin',$date1,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Pralin
                <input name="graines[<?php echo $date1; ?>][ingredients][]" type="checkbox" value="Tournesol|" <?php if($menuJour->estGraineDuJour('Tournesol',$date1,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Tournesol<br /><?php 
				//Extraire le légume qui n'est pas dans la liste normale des ingrédients 
				$listeGraines = $menuJour->getMenuJour($date1,$_SESSION["sessionID_user"],'graines');
				$listeGraines = explode('|',$listeGraines);
				$autre='';
				foreach($listeGraines as $graine)
					{
					if(!in_array($graine,$commande->ingredients))
						{
						$autre = $graine;
						}
					}?>
                Autre : <input type="text" name="graines[<?php echo $date1; ?>][ingredients][]" value="<?php echo $autre;?>" /><p>&nbsp;</p></td>
              </tr>
              <tr>
                <td><strong>Mardi</strong></td>
                <td><input type="text" name="graines[<?php echo $date2; ?>][dateJour]" value="<?php echo $date2; ?>" style="width:80px;" />
                </td>
              </tr>
              <tr>
                <td colspan="2">
                <input name="graines[<?php echo $date2; ?>][ingredients][]" type="checkbox" value="Amandes|" <?php if($menuJour->estGraineDuJour('Amandes',$date2,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Amandes
                <input name="graines[<?php echo $date2; ?>][ingredients][]" type="checkbox" value="Cranberries|" <?php if($menuJour->estGraineDuJour('Cranberries',$date2,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Cranberries
                <input name="graines[<?php echo $date2; ?>][ingredients][]" type="checkbox" value="Noix|" <?php if($menuJour->estGraineDuJour('Noix',$date2,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Noix
                <input name="graines[<?php echo $date2; ?>][ingredients][]" type="checkbox" value="Pralin|" <?php if($menuJour->estGraineDuJour('Pralin',$date2,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Pralin
                <input name="graines[<?php echo $date2; ?>][ingredients][]" type="checkbox" value="Tournesol|" <?php if($menuJour->estGraineDuJour('Tournesol',$date2,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Tournesol<br /><?php 
				//Extraire le légume qui n'est pas dans la liste normale des ingrédients 
				$listeGraines = $menuJour->getMenuJour($date2,$_SESSION["sessionID_user"],'graines');
				$listeGraines = explode('|',$listeGraines);
				$autre='';
				foreach($listeGraines as $graine)
					{
					if(!in_array($graine,$commande->ingredients))
						{
						$autre = $graine;
						}
					}?>
                Autre : <input type="text" name="graines[<?php echo $date2; ?>][ingredients][]" value="<?php echo $autre;?>" /><p>&nbsp;</p></td>
              </tr>
              <tr>
                <td><strong>Mercredi</strong></td>
                <td><input type="text" name="graines[<?php echo $date3; ?>][dateJour]" value="<?php echo $date3; ?>" style="width:80px;" /></td>
              </tr>
              <tr>
                <td colspan="2">
                <input name="graines[<?php echo $date3; ?>][ingredients][]" type="checkbox" value="Amandes|" <?php if($menuJour->estGraineDuJour('Amandes',$date3,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Amandes
                <input name="graines[<?php echo $date3; ?>][ingredients][]" type="checkbox" value="Cranberries|" <?php if($menuJour->estGraineDuJour('Cranberries',$date3,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Cranberries
                <input name="graines[<?php echo $date3; ?>][ingredients][]" type="checkbox" value="Noix|" <?php if($menuJour->estGraineDuJour('Noix',$date3,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Noix
                <input name="graines[<?php echo $date3; ?>][ingredients][]" type="checkbox" value="Pralin|" <?php if($menuJour->estGraineDuJour('Pralin',$date3,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Pralin
                <input name="graines[<?php echo $date3; ?>][ingredients][]" type="checkbox" value="Tournesol|" <?php if($menuJour->estGraineDuJour('Tournesol',$date3,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Tournesol<br /><?php 
				//Extraire le légume qui n'est pas dans la liste normale des ingrédients 
				$listeGraines = $menuJour->getMenuJour($date3,$_SESSION["sessionID_user"],'graines');
				$listeGraines = explode('|',$listeGraines);
				$autre='';
				foreach($listeGraines as $graine)
					{
					if(!in_array($graine,$commande->ingredients))
						{
						$autre = $graine;
						}
					}?>
                Autre : <input type="text" name="graines[<?php echo $date3; ?>][ingredients][]" value="<?php echo $autre;?>" /><p>&nbsp;</p></td>
              </tr>
              <tr>
                <td><strong>Jeudi</strong></td>
                <td><input type="text" name="graines[<?php echo $date4; ?>][dateJour]" value="<?php echo $date4; ?>" style="width:80px;" /></td>
              </tr>
              <tr>
                <td colspan="2">
                <input name="graines[<?php echo $date4; ?>][ingredients][]" type="checkbox" value="Amandes|" <?php if($menuJour->estGraineDuJour('Amandes',$date4,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Amandes
                <input name="graines[<?php echo $date4; ?>][ingredients][]" type="checkbox" value="Cranberries|" <?php if($menuJour->estGraineDuJour('Cranberries',$date4,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Cranberries
                <input name="graines[<?php echo $date4; ?>][ingredients][]" type="checkbox" value="Noix|" <?php if($menuJour->estGraineDuJour('Noix',$date4,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Noix
                <input name="graines[<?php echo $date4; ?>][ingredients][]" type="checkbox" value="Pralin|" <?php if($menuJour->estGraineDuJour('Pralin',$date4,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Pralin
                <input name="graines[<?php echo $date4; ?>][ingredients][]" type="checkbox" value="Tournesol|" <?php if($menuJour->estGraineDuJour('Tournesol',$date4,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Tournesol<br /><?php 
				//Extraire le légume qui n'est pas dans la liste normale des ingrédients 
				$listeGraines = $menuJour->getMenuJour($date4,$_SESSION["sessionID_user"],'graines');
				$listeGraines = explode('|',$listeGraines);
				$autre='';
				foreach($listeGraines as $graine)
					{
					if(!in_array($graine,$commande->ingredients))
						{
						$autre = $graine;
						}
					}?>
                Autre : <input type="text" name="graines[<?php echo $date4; ?>][ingredients][]" value="<?php echo $autre;?>" /><p>&nbsp;</p></td>
              </tr>
              <tr>
                <td><strong>Vendredi</strong></td>
                <td><input type="text" name="graines[<?php echo $date5; ?>][dateJour]" value="<?php echo $date5; ?>" style="width:80px;" /></td>
              </tr>
              <tr>
                <td colspan="2"><?php /*?><textarea name="feculents[<?php echo $date5; ?>][ingredients]" cols="50" rows="2"><?php echo $feculents[$date5]['ingredients']; ?></textarea><?php */?>
                <input name="graines[<?php echo $date5; ?>][ingredients][]" type="checkbox" value="Amandes|" <?php if($menuJour->estGraineDuJour('Amandes',$date5,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Amandes
                <input name="graines[<?php echo $date5; ?>][ingredients][]" type="checkbox" value="Cranberries|" <?php if($menuJour->estGraineDuJour('Cranberries',$date5,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Cranberries
                <input name="graines[<?php echo $date5; ?>][ingredients][]" type="checkbox" value="Noix|" <?php if($menuJour->estGraineDuJour('Noix',$date5,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Noix
                <input name="graines[<?php echo $date5; ?>][ingredients][]" type="checkbox" value="Pralin|" <?php if($menuJour->estGraineDuJour('Pralin',$date5,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Pralin
                <input name="graines[<?php echo $date5; ?>][ingredients][]" type="checkbox" value="Tournesol|" <?php if($menuJour->estGraineDuJour('Tournesol',$date5,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Tournesol<br /><?php 
				//Extraire le légume qui n'est pas dans la liste normale des ingrédients 
				$listeGraines = $menuJour->getMenuJour($date5,$_SESSION["sessionID_user"],'graines');
				$listeGraines = explode('|',$listeGraines);
				$autre='';
				foreach($listeGraines as $graine)
					{
					if(!in_array($graine,$commande->ingredients))
						{
						$autre = $graine;
						}
					}?>
                Autre : <input type="text" name="graines[<?php echo $date5; ?>][ingredients][]" value="<?php echo $autre;?>" /><p>&nbsp;</p></td>
              </tr>
              <tr>
                <td><strong>Samedi</strong></td>
                <td><input type="text" name="graines[<?php echo $date6; ?>][dateJour]" value="<?php echo $date6; ?>" style="width:80px;" /></td>
              </tr>
              <tr>
                <td colspan="2">
                <input name="graines[<?php echo $date6; ?>][ingredients][]" type="checkbox" value="Amandes|" <?php if($menuJour->estGraineDuJour('Amandes',$date6,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Amandes
                <input name="graines[<?php echo $date6; ?>][ingredients][]" type="checkbox" value="Cranberries|" <?php if($menuJour->estGraineDuJour('Cranberries',$date6,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Cranberries
                <input name="graines[<?php echo $date6; ?>][ingredients][]" type="checkbox" value="Noix|" <?php if($menuJour->estGraineDuJour('Noix',$date6,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Noix
                <input name="graines[<?php echo $date6; ?>][ingredients][]" type="checkbox" value="Pralin|" <?php if($menuJour->estGraineDuJour('Pralin',$date6,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Pralin
                <input name="graines[<?php echo $date6; ?>][ingredients][]" type="checkbox" value="Tournesol|" <?php if($menuJour->estGraineDuJour('Tournesol',$date6,$_SESSION["sessionID_user"])){ echo "checked='checked'"; }?>/>&nbsp;Tournesol<br /><?php 
				//Extraire le légume qui n'est pas dans la liste normale des ingrédients 
				$listeGraines = $menuJour->getMenuJour($date6,$_SESSION["sessionID_user"],'graines');
				$listeGraines = explode('|',$listeGraines);
				$autre='';
				foreach($listeGraines as $graine)
					{
					if(!in_array($graine,$commande->ingredients))
						{
						$autre = $graine;
						}
					}?>
                Autre : <input type="text" name="graines[<?php echo $date6; ?>][ingredients][]" value="<?php echo $autre;?>" /><p>&nbsp;</p></td>
              </tr>
            </table>
            </td>
        </tr>
        <tr>
        	<td>
        	<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td colspan="2"><h2>Les desserts du jour</h2></td>
              </tr>
              <tr>
                <td width="30"><strong>Lundi</strong></td>
                <td width="99%"><input type="text" name="desserts[<?php echo $date1; ?>][dateJour]" value="<?php echo $date1; ?>" style="width:80px;" />
                <input type="hidden" name="desserts2[<?php echo $date1;?>][dateJour]" value="<?php echo $date1;?>" /></td>
              </tr>
              <tr>
                <td colspan="2">
                Dessert 1 : <input type="text" name="desserts[<?php echo $date1; ?>][ingredients][]" value="<?php echo $yaourt[$date1]['ingredients'];?>" /><br />
                Dessert 2 : <input type="text" name="desserts2[<?php echo $date1; ?>][ingredients][]" value="<?php echo $yaourt2[$date1]['ingredients'];?>" /><p>&nbsp;</p></td>
              </tr>
              <tr>
                <td><strong>Mardi</strong></td>
                <td><input type="text" name="desserts[<?php echo $date2; ?>][dateJour]" value="<?php echo $date2; ?>" style="width:80px;" />
                <input type="hidden" name="desserts2[<?php echo $date2;?>][dateJour]" value="<?php echo $date2;?>" />
                </td>
              </tr>
              <tr>
                <td colspan="2">
                Dessert 1 : <input type="text" name="desserts[<?php echo $date2; ?>][ingredients][]" value="<?php echo $yaourt[$date2]['ingredients'];?>" /><br />
                Dessert 2 : <input type="text" name="desserts2[<?php echo $date2; ?>][ingredients][]" value="<?php echo $yaourt2[$date2]['ingredients'];?>" /><p>&nbsp;</p></td>
              </tr>
              <tr>
                <td><strong>Mercredi</strong></td>
                <td><input type="text" name="desserts[<?php echo $date3; ?>][dateJour]" value="<?php echo $date3; ?>" style="width:80px;" />
                <input type="hidden" name="desserts2[<?php echo $date3;?>][dateJour]" value="<?php echo $date3;?>" /></td>
              </tr>
              <tr>
                <td colspan="2">
                Dessert 1 : <input type="text" name="desserts[<?php echo $date3; ?>][ingredients][]" value="<?php echo $yaourt[$date3]['ingredients'];?>" /><br />
                Dessert 2 : <input type="text" name="desserts2[<?php echo $date3; ?>][ingredients][]" value="<?php echo $yaourt2[$date3]['ingredients'];?>" /><p>&nbsp;</p></td>
              </tr>
              <tr>
                <td><strong>Jeudi</strong></td>
                <td><input type="text" name="desserts[<?php echo $date4; ?>][dateJour]" value="<?php echo $date4; ?>" style="width:80px;" />
                <input type="hidden" name="desserts2[<?php echo $date4;?>][dateJour]" value="<?php echo $date4;?>" /></td>
              </tr>
              <tr>
                <td colspan="2">
                Dessert 1 : <input type="text" name="desserts[<?php echo $date4; ?>][ingredients][]" value="<?php echo $yaourt[$date4]['ingredients'];?>" /><br />
                Dessert 2 : <input type="text" name="desserts2[<?php echo $date4; ?>][ingredients][]" value="<?php echo $yaourt2[$date4]['ingredients'];?>" /><p>&nbsp;</p></td>
              </tr>
              <tr>
                <td><strong>Vendredi</strong></td>
                <td><input type="text" name="desserts[<?php echo $date5; ?>][dateJour]" value="<?php echo $date5; ?>" style="width:80px;" />
                <input type="hidden" name="desserts2[<?php echo $date5;?>][dateJour]" value="<?php echo $date5;?>" /></td>
              </tr>
              <tr>
                <td colspan="2">
                Dessert 1 : <input type="text" name="desserts[<?php echo $date5; ?>][ingredients][]" value="<?php echo $yaourt[$date5]['ingredients'];?>" /><br />
                Dessert 2 : <input type="text" name="desserts2[<?php echo $date5; ?>][ingredients][]" value="<?php echo $yaourt2[$date5]['ingredients'];?>" /><p>&nbsp;</p></td>
              </tr>
              <tr>
                <td><strong>Samedi</strong></td>
                <td><input type="text" name="desserts[<?php echo $date6; ?>][dateJour]" value="<?php echo $date6; ?>" style="width:80px;" />
                <input type="hidden" name="desserts2[<?php echo $date6;?>][dateJour]" value="<?php echo $date6;?>" /></td>
              </tr>
              <tr>
                <td colspan="2">
                Dessert 1 : <input type="text" name="desserts[<?php echo $date6; ?>][ingredients][]" value="<?php echo $yaourt[$date6]['ingredients'];?>" /><br />
                Dessert 2 : <input type="text" name="desserts2[<?php echo $date6; ?>][ingredients][]" value="<?php echo $yaourt2[$date6]['ingredients'];?>" /><p>&nbsp;</p></td>
              </tr>
            </table>
            </td>
        </tr>
      </table>
      <input type="submit" name="ok" value="Enregistrer" />
      <br />
    </form>
    <!-- InstanceEndEditable --> </div>
  <div class="ajusteur"></div>
</div>
</body>
<!-- InstanceEnd --></html>
