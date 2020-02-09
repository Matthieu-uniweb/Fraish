<?php
header("Expires: 0"); 
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache");
header("Cache-Control: post-check=0,pre-check=0");
header("Cache-Control: max-age=0");
header("Pragma: no-cache");
header('Content-type: text/html; charset=UTF-8'); 
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
<script src="/boutique/includes/plugins/zpcal/zapatec.js" type="text/javascript"></script>
<script src="/boutique/includes/plugins/zpcal/src/calendar.js" type="text/javascript"></script>
<script src="/boutique/includes/plugins/zpcal/lang/calendar-fr.js" type="text/javascript"></script>
<link href="/boutique/includes/plugins/zpcal/themes/winter.css" rel="stylesheet" type="text/css" />
<?
$commandes = new Tbq_commande();
$demain = date("Y-m-d", strtotime('+1 day'));
if (! $_GET['dateSeuleInsertion'])
	{
	$_GET['dateSeuleInsertion'] = date("Y-m-d");
	}

// Liste des commandes
$resultats = $commandes->listerTousesCommandes($_GET);
$user = new Tbq_user($_SESSION["sessionID_user"]);
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
  <h1>Les r&eacute;servations de <?php echo $user->pointDeVente;?></h1>
    <p>Date de la r&eacute;servation: <?php echo T_LAETIS_site::dateEnFrancais($_GET['dateSeuleInsertion']); ?></p>
    <p>&nbsp;</p>
    <!--<p><a href="scripts/exporter.php?dateSeuleInsertion=<?php /* echo $_GET['dateSeuleInsertion']; */ ?>">&gt; Exporter les commandes</a></p>-->
    <p><a href="commandes-lister.php?statut=en_cours,abandonnee&dateSeuleInsertion=<?php echo $_GET['dateSeuleInsertion']; ?>" target="_blank">&gt; Voir les commandes</a></p>
    <!--<p><a href="commandes-lister-v2.php?statut=en_cours&dateSeuleInsertion=<?php echo $_GET['dateSeuleInsertion']; ?>&livraison=afficherNonLivraison" target="_blank">&gt; Voir les commandes v2 &agrave; retirer sur le point de vente</a></p>-->
    <p><a href="commandes-lister-v3.php?statut=en_cours&dateSeuleInsertion=<?php echo $_GET['dateSeuleInsertion']; ?>&livraison=afficherNonLivraison" target="_blank">&gt; Voir les commandes v3 &agrave; retirer sur le point de vente</a></p>
    <!--<p><a href="commandes-lister-v2.php?statut=en_cours&dateSeuleInsertion=<?php echo $_GET['dateSeuleInsertion']; ?>&livraison=afficherLivraison" target="_blank">&gt; Voir les commandes v2 &agrave; livrer</a></p>-->
    <p align="center"><a href="commande-jour.php?dateSeuleInsertion=<?php echo $demain; ?>">&gt; Les r&eacute;servation de demain</a></p>
    <br />
      <br />
    <form name="formDate" id="formDate" action="commande-jour.php" method="get">
      <input name="dateSeuleInsertion" type="text" id="dateSeuleInsertion" value="" />
      <a href="javascript:;" class="boutonCalendrier"><img src="../images/calendrier.gif" alt="Choisir une date" id="imgdateSeuleInsertion" title="Calendrier" style="display:inline" /></a>
      <script type="text/javascript">
						<!--
						Zapatec.Calendar.setup (
							{
							firstDay          : 1,
							showOthers        : true,
							electric          : false,
							inputField        : "dateSeuleInsertion",
							button            : "imgdateSeuleInsertion",
							ifFormat          : "%Y-%m-%d",
							daFormat          : "%Y-%m-%d",
							align : "br"
							} 
						);
						//-->
						</script>
      <input type="submit" name="ok" value="ok" />
    </form>
    </p>
    <div class="ajusteur"></div>
    <p>&nbsp;</p>
    <form name="formulaire" id="formulaire" enctype="multipart/form-data" action="scripts/sauver_commande.php" method="post">
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tbody>
          <tr>
            <th style="width:75px">N&deg; <br />
              commande<br />
              du jour</th>
            <th style="width:150px">Client</th>
            <th style="width:100px">Date de r&eacute;servation</th>
            <th style="width:100px">Statut</th>
            <th style="width:50px;">Paiement</th>
            <th>Livraison</th>
            <th style="width:100px">Action</th>
          </tr>
        </tbody>
        <?
if (! $resultats)
	{
	?>
        <tr>
          <td colspan="6" align="center" class="infos"><< Aucune commande >></td>
        </tr>
        <? 
	}
else
	{
foreach($resultats as $commande)
	{
	$client = new Tbq_client($commande['ID_client']);
	?>
        <tbody id="ligne<?php echo $commandes->ID;?>">
          <tr class="<?php echo $classe;?>">
            <td><a href="commande-detail.php?ID_commande=<?php echo $commande['ID']; ?>" target="_blank">n&deg;<?php echo $commande['ID_commande_fraish']; ?></a></td>
            <td><? 
		if(strlen($client->nomFacturation) > 1)
			{
		?><a href="client-detail.php?ID_client=<?php echo $client->ID;?>"><?php echo $client->nomFacturation.' '.$client->prenomFacturation; ?></a><?
			} 
		if($client->soldeCompte<0)
			{?>
			<br/><font style="color:#FF0000;">Compte Fraish en n&eacute;gatif !</font><?php
			}
		if(Tbq_approvisionnement::getNbApproEnAttente($client->ID)>0)
			{?>
            <br /><a href="/boutique/admin/client-detail.php?ID_client=<?php echo $client->ID;?>#approvisionnements" style="color:#090;"><?php echo Tbq_approvisionnement::getNbApproEnAttente($client->ID);?> demande(s) de recharge en attente</a><?php
			}
	?></td>
            <td><?php echo T_LAETIS_site::dateFormatFrancais($commande['dateReservation']); ?></td>
            <td><select name="statut[<?php echo $commande['ID']; ?>]" style="width:120px;">
                <option value="en_cours" <? if ($commande['statut']=='en_cours') { echo 'selected="selected"'; } ?>>en cours</option>
                <option value="livree" <? if ($commande['statut']=='livree') { echo 'selected="selected"'; } ?>>livree</option>
                <option value="non livree "<? if ($commande['statut']=='non livree') { echo 'selected="selected"'; } ?>>non livree</option>
                <option value="abandonnee" <? if ($commande['statut']=='abandonnee') { echo 'selected="selected"'; } ?>>abandonnee</option>
                <option style="color: #ff0000;" value="annulee" <? if ($commande['statut']=='annulee') { echo 'selected="selected"'; } ?>>annulee</option>
              </select></td>
            <td><?php echo Tbq_commande::getLabelTypePaiement($commande['ID']);?></td>
            <td><?php 
			if($commande['ID_pointLivraison']>0)
				{
				$ptLivraison = new Tbq_pointLivraison($commande['ID_pointLivraison']);
				echo $ptLivraison->nom;
				}
			else
				{
				echo 'Kiosque Fraish';
				}?></td>
            <td><a href="javascript:supprimerCommande(<?php echo $commande['ID']; ?>);">Supprimer</a></td>
          </tr>
        </tbody>
        <?
	  } // FIN foreach($resultats as $commandes)		
		} 
?>
      </table>
      <select name="choixStatut" onchange="choisirListe(this.options[selectedIndex].value);">
      	<option value="" selected="selected">Statut</option>
      	<option value="0">Toutes en cours</option>
        <option value="1">Toutes livréees</option>
        <option value="2">Toutes non livréees</option>
        <option value="3">Toutes abandonnées</option>      
      </select>
      <p align="center">
        <input type="submit" name="Submit" value="Sauver" class="bouton" />
      </p>
    </form>
    <p>&nbsp;</p>
<p>Pour acc&eacute;der au <strong>détail d'une r&eacute;servation</strong>, cliquez sur son num&eacute;ro.<br />
      Pour <strong>modifier le statut</strong> d'une ou plusieurs r&eacute;servations, choisissez le nouveau statut dans la liste d&eacute;roulante, puis cliquez sur le bouton &quot;Sauver&quot; en bas de la page. Pour <strong>supprimer une r&eacute;servation </strong> cliquez sur le lien &quot;Supprimer&quot;.<br />
    </p>   
    <p>&nbsp;</p> 
    <p><strong>L&eacute;gende des statuts de r&eacute;servation:</strong></p>
    <p>- <em>en cours</em>=&gt; La commande est en p&eacute;paration.</p>    
    <p>- <strong><em>livr&eacute;e</em></strong> =&gt; rempli par l'administrateur de la boutique, lorsque le client est venu r&eacute;cup&eacute;rer sa commande.</p>
    <p>- <em>non livr&eacute;e</em> =&gt; rempli par l'administrateur de la boutique lorsque le client n'est pas venu chercher sa commande.</p>
    <p>- <em>abandonn&eacute;e</em> =&gt; rempli par le client lorsqu'il n'a pas finalisé sa commande par le paiement.</p>
    <p>- <em>annul&eacute;e</em> =&gt; rempli par le client lorsqu'il a annul&eacute; sa commande.</p>
    <!-- InstanceEndEditable --> </div>
  <div class="ajusteur"></div>
</div>
</body>
<!-- InstanceEnd --></html>
