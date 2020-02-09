<?php
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

switch($_REQUEST['fonction'])
	{
	case 'basculerEtat':
		$sondage = new Tbq_sondage($_GET['ID_sondage']);
		$sondage->basculerEtat();
		break;
	case 'supprimer':
		$sondage = new Tbq_sondage($_POST['ID_sondage']);
		$sondage->supprimer();
		break;
	}
	
$listeSondages = Tbq_sondage::lister();
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
<script type="text/javascript" language="javascript">
<!--//
function supprimerSondage(ID_sondage)
	{
	var ok = confirm("Voulez-vous supprimer cette question ?\nVous effacerez également les résultats correspondant à cette question.\nCette action est irréversible.\n");
	if(ok==1)
		{
		document.getElementById('formActionSondage').fonction.value = 'supprimer';
		document.getElementById('formActionSondage').ID_sondage.value = ID_sondage;
		document.getElementById('formActionSondage').submit();
		}
	}
//-->
</script><!-- InstanceEndEditable -->
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
  <form id="formActionSondage" method="post" action="">
  	<input type="hidden" name="fonction" value="" />
    <input type="hidden" name="ID_sondage" value="" />
  </form>
    <h1>Les sondages</h1>
    <h2>Liste des questions de sondage</h2>
    <p>&nbsp;</p>
    <p><a href="sondage-resultats.php" title="Voir les r&eacute;sultats des sondages">&gt; R&eacute;sultats des sondages</a></p>
    <p><a href="sondage-detail.php" title="Ajouter une question de sondage">&gt; Ajouter une question</a></p>
    <p>&nbsp;</p>    
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tbody>
          <tr>
            <th>Question</th>
            <th>Etat</th>
            <th>Actions</th>
          </tr>
        </tbody><?php
		if($listeSondages)
			{
			foreach($listeSondages as $sondage)
				{?>
                <tbody>
                <tr>
                	<td><a href="sondage-detail.php?ID_sondage=<?php echo $sondage->ID;?>"><?php echo $sondage->question;?></a></td>
                    <td><?php
					if($sondage->actif==1)
						{?>
                        <span style="color:#390;">Activ&eacute;</span><?php
						$lib_action = "D&eacute;sactiver";
						}
					else
						{
						$lib_action = "Activer";?>
						<span style="color:#C00;">D&eacute;sactiv&eacute;</span><?php
						}?></td>
                    <td>
                    <a href="sondage-lister.php?ID_sondage=<?php echo $sondage->ID;?>&amp;fonction=basculerEtat" title="<?php echo $lib_action;?> la question">&gt; <?php echo $lib_action;?></a><br />
                    <a href="sondage-detail.php?ID_sondage=<?php echo $sondage->ID;?>">&gt; Modifier</a><br />
                    <a href="javascript:supprimerSondage('<?php echo $sondage->ID;?>');">&gt; Supprimer</a>                    
                    </td>
                </tr>
                </tbody>
                <?php
				}
			}?>
    <!-- InstanceEndEditable --> </div>
  <div class="ajusteur"></div>
</div>
</body>
<!-- InstanceEnd --></html>
