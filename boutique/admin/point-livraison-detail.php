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

$ptLivraison = new Tbq_pointLivraison($_GET['ID_pointLivraison']);

switch($_POST['fonction'])
	{
	case 'valider':
		$ptLivraison->enregistrer($_POST);
		break;
	}
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
<!-- InstanceBeginEditable name="head" --><!-- InstanceEndEditable -->
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
    <h1>Les points de livraison</h1>
    <h2>D&eacute;tail d'un point de livraison</h2>
    <p>&nbsp;</p>
    <a href="points-livraison-lister.php">&lt; Retour &agrave; la liste des points de livraison</a>
    <p>&nbsp;</p>
    <form action="" method="post" onsubmit="javascript:return lsjs_verifierFormulaire2(this);">
    	<input type="hidden" name="ID" value="<?php echo $ptLivraison->ID;?>" />
        <input type="hidden" name="fonction" value="valider" />
        <input type="hidden" name="obligatoire" value="nom-Le libellé du point de livraison|ID_pointDeVente-Le point de vente qui préparera les menus" />
        <table>
        	<tr>
            	<td>Libell&eacute;* : </td>
                <td><input type="text" name="nom" value="<?php echo $ptLivraison->nom;?>" /></td>
            </tr>
            <tr>
            	<td>Adresse (ligne1) : </td>
                <td><input type="text" name="adresse1" value="<?php echo $ptLivraison->adresse1;?>" /></td>
            </tr>
            <tr>
            	<td>Adresse (ligne2) : </td>
                <td><input type="text" name="adresse2" value="<?php echo $ptLivraison->adresse2;?>" /></td>
            </tr>
            <tr>
            	<td>Code postal : </td>
                <td><input type="text" name="codePostal" value="<?php echo $ptLivraison->codePostal;?>" /></td>
            </tr>
            <tr>
            	<td>Ville : </td>
                <td><input type="text" name="ville" value="<?php echo $ptLivraison->ville;?>" /></td>
            </tr>
            <tr>
                	<td>Les menus seront pr&eacute;par&eacute;s par* : </td>
                    <td>
					<select name="ID_pointDeVente">
						<option></option><?php
					$listePointsDeVentes = Tbq_user::lister();
					foreach($listePointsDeVentes as $ptDeVente)
						{?>
                        <option value="<?php echo $ptDeVente->ID;?>" <?php 
						if($ptDeVente->ID == $ptLivraison->ID_pointDeVente)
							{
							echo 'selected="selected"';
							}?>><?php echo $ptDeVente->pointDeVente;?></option>
                        <?php
						}
                    ?></td>
                </tr>
            <tr>
            	<td>&nbsp;</td>
                <td><input type="submit" value="Sauver" class="bouton" /></td>
            </tr>
        </table><?php
		//IF consultation pt livraison
		if($ptLivraison->ID)
			{?>
        	<h2>Entreprise affect&eacute;es &agrave; ce point de livraison</h2>
            <table>
                <tr>
                    <th>Entreprise</td>
                    <th>Code</th>
                </tr><?php
                $listeEntreprises = $ptLivraison->getEntreprisesSelonPointLivraison();
                if($listeEntreprises)
                    {
                    foreach($listeEntreprises as $entreprise)
                        {?>
                        <tr>
                            <td><a href="entreprise-detail.php?ID_entreprise=<?php echo $entreprise->ID;?>" title="Acc&eacute;der &agrave; la fiche de l'entreprise"><?php echo $entreprise->nom;?></a></td>
                            <td><a href="entreprise-detail.php?ID_entreprise=<?php echo $entreprise->ID;?>" title="Acc&eacute;der &agrave; la fiche de l'entreprise"><?php echo $entreprise->code;?></a></td>
                        </tr><?php
                        }
                    }
                else
                    {?>
                    <tr>
                        <td colspan="2">Pas d'entreprise li&eacute;e &agrave; ce point de livraison...</td>
                    </tr><?php
                    }
                ?>
            </table><?php
			}//FIN IF consultation pt livraison?>
    </form>
    <!-- InstanceEndEditable --> </div>
  <div class="ajusteur"></div>
</div>
</body>
<!-- InstanceEnd --></html>
