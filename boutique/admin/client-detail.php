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
<style type="text/css">
h3 {
	font-size:12px !important;
}
</style>
<script language="javascript" type="text/javascript">
<!--//
function supprimerClient(ID_client)
	{
	var ok = confirm("Voulez vous supprimer ce client ? \nCette action est irréversible !");
	if(ok==1)
		{
		document.getElementById('formClient').fonction.value = 'supprimerClient';
		document.getElementById('formClient').ID_client.value = ID_client;
		document.getElementById('formClient').submit();
		}
	}
function supprimerApprovisionnement(ID_appro)
	{
	var ok = confirm("Voulez vous supprimer cet approvisionnement ? \nCette action est irréversible !");
	if(ok==1)
		{
		document.getElementById('formClient').fonction.value = 'supprimerApprovisionnement';
		document.getElementById('formClient').ID_approvisionnement.value = ID_appro;
		document.getElementById('formClient').submit();
		}
	}
function validerApprovisionnement(ID_appro)
	{
	document.getElementById('formClient').fonction.value = 'validerApprovisionnement';
	document.getElementById('formClient').ID_approvisionnement.value = ID_appro;
	document.getElementById('formClient').submit();
	}
//-->
</script>
<?
$client = new Tbq_client($_GET['ID_client']);
$appro = new Tbq_approvisionnement();

/*switch($_POST['fonction'])
	{
	case 'supprimerApprovisionnement':
		$appro = new Tbq_approvisionnement($_POST['ID_approvisionnement']);
		$appro->supprimer();?>
        <script type="text/javascript" language="javascript">
		<!--//
		document.location.href = '#approvisionnements';
		//-->
		</script><?php
		break;
	
	case 'validerApprovisionnement':
		$appro = new Tbq_approvisionnement($_POST['ID_approvisionnement']);
		$appro->valider();
		$appro->genererMailDemandeAppro('/boutique/fr/emails/envoi-commande/envoi-appro-ok.php');?>
        <script type="text/javascript" language="javascript">
		<!--//
		//Pour ne pas répéter l'ajout au solde client, on évite le raffraichissement de la page
		document.location.href = 'client-detail.php?ID_client=<?php echo $client->ID;?>#approvisionnements';
		//-->
		</script><?php
		break;
	}*/

$commande=new Tbq_commande();
$listeCommandes = $commande->listerToutesCommandes($client->ID, $_SESSION["sessionID_user"]);
$listeCommandesEnCours = $commande->listerCommandeAdmin($client->ID, 'en_cours', $_SESSION["sessionID_user"]);
$listeCommandesLivrees = $commande->listerCommandeAdmin($client->ID, 'livree', $_SESSION["sessionID_user"]);
$listeCommandesAbandonnees = $commande->listerCommandeAdmin($client->ID, 'abandonnee', $_SESSION["sessionID_user"]);


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
<form id="formClient" action="scripts/valider-appro.php" method="post">
<input type="hidden" name="fonction" value="" />
<input type="hidden" name="ID_approvisionnement" value="" />
<input type="hidden" name="ID_client" value="<?php echo $client->ID;?>" />
</form>
<h1>Les clients</h1>
    <h2>D&eacute;tail</h2>
    <p>&nbsp;</p>
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td align="center"></td>
        <td align="center"><? echo "Nombre de commandes totales <br />".number_format(sizeof($listeCommandes), 0, ',', ' '); ?></td>
        <td align="center"><? echo "Nombre de commandes en cours <br />".number_format(sizeof($listeCommandesEnCours), 0, ',', ' '); ?></td>
        <td align="center"><? echo "Nombre de commandes Abandonnées <br />".number_format(sizeof($listeCommandesAbandonnees), 0, ',', ' '); ?></td>
        <td align="center"><? echo "Nombre de commandes Livrées <br />".number_format(sizeof($listeCommandesLivrees), 0, ',', ' '); ?></td>
      </tr>
    </table>
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td valign="top"><h2>Coordonn&eacute;es de facturation</h2>
          <p><? echo '<b>'.$client->civiliteFacturation.' '.$client->nomFacturation.' '.$client->prenomFacturation.'</b><br />'.nl2br($client->adresseFacturation);
			if ($client->adresseFacturation2)
				{	echo '<br />'.nl2br($client->adresseFacturation2); }
			?><br />
            Soci&eacute;t&eacute; : <? echo $client->societe;?><br />
            <? echo $client->codePostalFacturation;?> <? echo $client->villeFacturation;?> <br />
            Tel : <? echo $client->telFacturation;?><br />
            E-mail : <? echo $client->emailFacturation;?><br />
            Date de naissance : <?php echo $client->dateDeNaissance;?></p></td>
      </tr>
    </table>
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td valign="top"><h2>Ses go&ucirc;ts sont :</h2>
          <?
  $gout = new Tbq_client_specifique();
  $listeGout = $gout->listerGout($client->ID);
  ?>
          <ul>
            <?
	foreach($listeGout as $gouts)
	 {
	 ?>
            <li>
              <h3>Il adore : </h3>
              <? echo $gouts['aime']; ?></li>
            <li>
              <h3>Il aime : </h3>
              <? echo $gouts['moyen']; ?></li>
            <li>
              <h3>Il d&eacute;teste : </h3>
              <? echo $gouts['deteste']; ?></li>
            <? } // FIN foreach($listeGout as $gouts) ?>
          </ul></td>
      </tr>
    </table>
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td valign="top"><h2>Compte client</h2>
          <p>Login: <? echo $client->emailFacturation;?></p>
          <p>Passe: <? echo $client->motDePasse;?></p>
          <p><a style="color: #ff0000; font-weight: bold; font-size: 12px;" href="javascript:supprimerClient('<?php echo $client->ID;?>');">Supprimer ce client</a></p></td>
      </tr>
    </table>
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td valign="top"><h2>Ses commandes</h2>
          <h3>Ses r&eacute;servations en cours.</h3>
          <ul>
          <?
	 if (count($listeCommandesEnCours) == 0)
	 	{
		?>
          <li>Le client n'a aucune r&eacute;servations en cours.</li>
          <?
		} // FIN if (count($commandesEnCours) == 0)
	else
		{
	 foreach($listeCommandesEnCours as $commandesEnCours)
	 	{
	 ?>
            <li><a href="commande-detail.php?ID_client=<? echo $listeCommandesEnCours;?>&ID_commande=<? echo $commandesEnCours['ID']; ?>" target="_blank">R&eacute;servations n&deg;<strong><? echo $commandesEnCours['ID_commande_fraish']; ?></strong> pour le <? echo $commandesEnCours['dateReservation']; ?> (effectu&eacute;e le <? echo T_LAETIS_site::dateHeureFormatFrancais($commandesEnCours['dateCommande']); ?>)</a> </li>
            <? } // FIN foreach($listeCommandesEnCours as $commandesEnCours) ?>          
          <? } // FINE else ?>
    </ul>
          <h3>Ses r&eacute;servations livr&eacute;es.</h3>
          <ul>
          <?
	 if (count($listeCommandesLivrees) == 0)
	 	{
		?>
          <li>Le client n'a aucune r&eacute;servations &eacute;ffectu&eacute;es. </li>
          <?
		} // FIN if (count($commandesEffectuees) == 0)
	else
		{
		foreach($listeCommandesLivrees as $commandesLivrees)
	 	{
	 ?>
            <li><a href="commande-detail.php?ID_client=<? echo $listeCommandesLivrees;?>&ID_commande=<? echo $commandesLivrees['ID']; ?>">R&eacute;servations n&deg;<strong><? echo $commandesLivrees['ID_commande_fraish']; ?></strong> pour le <? echo $commandesLivrees['dateReservation']; ?> (effectu&eacute;e le <? echo T_LAETIS_site::dateHeureFormatFrancais($commandesLivrees['dateCommande']); ?>)</a> </li>
            <? } // FIN for ($i=0; $i<count($commandesEffectuees); $i++) ?>
          <? } // FINE else ?>
          </ul>
          <h3>Ses r&eacute;servations abandonn&eacute;es.</h3>
          <ul>
          <?
	 if (count($listeCommandesAbandonnees) == 0)
	 	{
		?>
          <li>Le client n'a aucune r&eacute;servations abandonn&eacute;e. </li>
          <?
		} // FIN if (count($listeCommandesAbandonnees) == 0)
	else
		{
	 foreach($listeCommandesAbandonnees as $commandesAbandonnees)
	 	{
	 ?>
            <li><a href="commande-detail.php?ID_client=<? echo $listeCommandesAbandonnees;?>&ID_commande=<? echo $commandesAbandonnees['ID']; ?>">R&eacute;servations n&deg;<strong><? echo $commandesAbandonnees['ID_commande_fraish']; ?></strong> pour le <? echo $commandesAbandonnees['dateReservation']; ?> (effectu&eacute;e le <? echo T_LAETIS_site::dateHeureFormatFrancais($commandesAbandonnees['dateCommande']); ?>)</a> </li>
            <? } // FIN for ($i=0; $i<count($commandesAbandonnees); $i++) ?>
          <? } // FINE else ?></ul></td>
      </tr>
    </table>
    <a href="#" name="approvisionnements"></a>
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td valign="top"><h2>Ses approvisionnements de crédit compte Fraish</h2>
        <p>Cr&eacute;dit utilis&eacute; : <?php echo $client->getMontantCommandesAvecCredit();//echo Tbq_approvisionnement::getSommeApproSelonClient($client->ID)-$client->soldeCompte;?> &euro;&nbsp;&nbsp;&nbsp;
        Cr&eacute;dit restant : <?php echo $client->soldeCompte;?> &euro;</p></td>
      </tr>
      <tr>
      	<td>
        <form name="formCredit" action="scripts/crediter-compte.php" method="post">
        <input type="hidden" name="fonction" value="crediterCompte" />
        <input type="hidden" name="ID_typ_paiement" value="" />
        <input type="hidden" name="ID_client" value="<?php echo $client->ID;?>" />
        <h2>Cr&eacute;diter le compte :</h2> 
       - <strong>Titres restaurant :</strong> <input type="text" name="nbTitres" value="nb" style="width:20px;" onfocus="javascript:this.value='';" /> titre(s) d'une valeur de <input type="text" name="valeurTitre" value="valeur" style="width:35px;" onfocus="javascript:this.value='';" /> &euro;&nbsp;<input type="button" value="cr&eacute;diter" class="bouton" onclick="javascript:document.forms['formCredit'].ID_typ_paiement.value = 3; document.forms['formCredit'].submit();" />
       <p>&nbsp;</p>
       - <strong>Ch&egrave;que :</strong> n&deg; <input type="text" name="numCheque" value="num chèque" onfocus="javascript:this.value='';" /> d'une valeur de <input type="text" value="valeur" name="montantCheque" style="width:35px;" onfocus="javascript:this.value='';" /> &euro; <input type="button" value="Cr&eacute;diter" class="bouton" onclick="javascript:document.forms['formCredit'].ID_typ_paiement.value = 2; document.forms['formCredit'].submit();" /><p>&nbsp;</p>
       - <strong>Esp&eacute;ces :</strong> <input type="text" name="montantEspeces" value="valeur" style="width:35px;" onfocus="javascript:this.value='';" /> &euro; <input type="button" value="Cr&eacute;diter" class="bouton" onclick="javascript:document.forms['formCredit'].ID_typ_paiement.value = 4; document.forms['formCredit'].submit();" />
       <p>&nbsp;</p>
       - <strong>Offert :</strong> <input type="text" name="montantOffert" value="valeur" style="width:35px;" onfocus="javascript:this.value='';" /> &euro; <input type="button" value="Cr&eacute;diter" class="bouton" onclick="javascript:document.forms['formCredit'].ID_typ_paiement.value = 6; document.forms['formCredit'].submit();" />
       <?php /*?>&nbsp;&nbsp;Un mail sera automatiquement envoy&eacute; au client pour lui signaler l'offre.<?php */?><p>&nbsp;</p>
       - <strong>Reprise d'avoir :</strong> <input type="text" name="montantRepriseAvoir" value="valeur" style="width:35px;" onfocus="javascript:this.value='';" /> &euro; <input type="button" value="Cr&eacute;diter" class="bouton" onclick="javascript:document.forms['formCredit'].ID_typ_paiement.value = 7; document.forms['formCredit'].submit();" />
       <p>&nbsp;</p>
       - <strong style="color: #ff0000;">Modifier crédit :</strong> <input type="text" name="soldeCompte" value="<?php echo $client->soldeCompte;?>" style="width:35px;" /> &euro; <input type="button" value="Mettre à jour" class="bouton" onclick="javascript:document.forms['formCredit'].ID_typ_paiement.value = 99; document.forms['formCredit'].submit();" />
       
       
       
       
       
       
       
       
        </form>
        <p>&nbsp;</p><?php
		if($_GET['messAppro'])
			{?>
	        <p style="color:#FF0000;"><?php echo $_GET['messAppro'];?></p> <?php
			}?>
        </td>
      </tr>
      <tr>
      	<td>
        <h2>Approvisionnements validés : <?php echo Tbq_approvisionnement::getSommeApproSelonClient($client->ID);?> &euro;</h2>
       	<?php 
		$listeApprosValides = $appro->lister($client->ID,1);
		$listeApprosNonValides = $appro->lister($client->ID,0);?>
		<ul><?php
		if($listeApprosValides)
			{
			foreach($listeApprosValides as $itemAppro)
				{
				$itemAppro = new Tbq_approvisionnement($itemAppro->ID);?>
        		<li>Approvisionnement de <?php echo $itemAppro->montant;?> &euro; par <?php echo $itemAppro->getLabelTypePaiement();?> le <?php echo T_LAETIS_site::convertirDate($itemAppro->date);?></li><?php
				}
			}
		else
			{?>
            <li>Pas d'approvisionnement valid&eacute;</li><?php
			}?>
        </ul>
        
        <h2>Approvisionnement non validés ou en attente</h2>
        <ul><?php
		if($listeApprosNonValides)
			{
			foreach($listeApprosNonValides as $itemAppro)
				{?>
            	<li><?php echo $itemAppro->getDescriptif();?><br /><?php echo $itemAppro->getDetailPaiement();?> - <a href="javascript:validerApprovisionnement('<?php echo $itemAppro->ID;?>');">valider</a> &nbsp;<a href="javascript:supprimerApprovisionnement('<?php echo $itemAppro->ID;?>');">supprimer</a></li><?php
				}
			}
		else
			{?>
            <li>Pas d'approvisionnement non valid&eacute; ou en attente</li><?php
			}?>
        </ul>
        </td>
      </tr>
    </table>
    <!-- InstanceEndEditable --> </div>
  <div class="ajusteur"></div>
</div>
</body>
<!-- InstanceEnd --></html>
