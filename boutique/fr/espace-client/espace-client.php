<?
session_start();

if (! $_SESSION['ID_client'])
	{ header("Location: ../login.php"); }

include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/classes.inc.php';
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/includes/classes/paquetage.inc.php';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Fraish espace client</title>
<meta name="description" content="La boutique Fraish" />
<meta name="keywords" content="boutiqueFraish" />
<link rel="stylesheet" type="text/css" href="/includes/styles/global.css" />
<link rel="stylesheet" type="text/css" href="/includes/styles/admin.css" />
<link rel="stylesheet" type="text/css" href="/includes/styles/formulaire.css" />
<script type="text/javascript" src="/includes/javascript/globals.js"></script>
<script type="text/javascript" src="/includes/javascript/site.js"></script>
<script type="text/javascript" src="/includes/javascript/flashobject.js"></script>
<script type="text/javascript" src="/includes/javascript/navigation.js"></script>
<script type="text/javascript" src="/includes/javascript/mm.js"></script>
<script type="text/javascript" src="/includes/javascript/formulaire.js"></script>
<script type="text/javascript" src="/boutique/includes/javascript/bq_front-boutique.js"></script>
<script type="text/javascript" src="/includes/javascript/preload-fr.js"></script>
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />
<link rel="icon" type="image/x-icon" href="/favicon.ico" />
<?php
$client = new Tbq_client($_SESSION['ID_client']);
$commande = new Tbq_commande();
$favori = new Tbq_client_favori();
$appro = new Tbq_approvisionnement();
$menuFavori = $favori->getMenuFavori($_SESSION['ID_client']);
?>
<script language="javascript">
function annulerCommande(ID_commande)
	{
	var ok = confirm("Etes vous sur de vouloir annuler cette commande ?");
	if(ok==1)
		{
		document.forms['enCours'].ID_commande.value = ID_commande;
		document.forms['enCours'].submit();
		}
	}
</script>
</head>
<body>
<div id="page">
  <div id="enTete">&nbsp;
  </div>
  <div id="contenu">
  <h1>Votre espace client</h1>
  <?php 
  $etape=1;
  include_once rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/Library/bq_etapes.php';?>
    <?php /*?><p>Bienvenue <? echo $client->civiliteFacturation.' '.$client->prenomFacturation.' '.$client->nomFacturation; ?>,</p><?php */?>
   
    <?php 
if($client->peutCommander())
	{?>
     <?php /*?><p>Si vous souhaitez r&eacute;server un menu, cliquez sur le bouton ci-dessous, et compl&eacute;tez le formulaire.</p><?php */?>
     <p><em><?php
     $visuMenuJour = new Tbq_menuJour();
	 if($menuFavori->ID_pointDeVente)
	 	{
		echo $visuMenuJour->getDescriptifMenusJour($menuFavori->ID_pointDeVente);
		}?>
     </em></p>
    <a href="reserver-formule.php" class="boutonReserve" style="padding-top:6px;">Je choisis mon menu</a>
    <?php
	if ($menuFavori->ID)
		{ 
		?><a href="reserver-ingredients.php?ID_menuFavori=<?php echo $menuFavori->ID;?>" class="commandeFavori" title="Commander mon menu favori"></a><?php 
		} 
	}
else
	{?>
	<p style="color:#FF0000;">Votre cr&eacute;dit compte Fraish est n&eacute;gatif, vous ne pouvez pas effectuer de r&eacute;servation.<br />
    Merci de r&eacute;approvisionner votre compte par carte bancaire ou sur le kiosque Fraish.</p>
	<a href="/boutique/fr/espace-client/paiement-formulaire-credit.php?mode=paiementCarteBancaire" title="Approvisionner mon compte Fraish" style="background-color:#9BA906; color:#fff; padding-right:5px; padding-bottom:3px; padding-top:2px; font-weight:bold; text-decoration:none;">&gt; J'approvisionne mon compte par carte bancaire</a><?php
	}?>
    <p>&nbsp;</p>
   
    <h3>Mes commandes en cours.</h3>
    <?
	 $listeCommandesEnCours = $commande->listerCommande($_SESSION['ID_client'], 'en_cours');
	 $listeCommandesLivrees = $commande->listerCommande($_SESSION['ID_client'], 'livree');
	 $listeCommandesAbandonnees = $commande->listerCommande($_SESSION['ID_client'], 'abandonnee');
	 if (count($listeCommandesEnCours) == 0)
	 	{?>
        <p>Vous n'avez aucune r&eacute;servation en cours.<br />
          V&eacute;rifiez dans vos r&eacute;servations archiv&eacute;es ci-dessous.</p><?
		} // FIN if (count($commandesEnCours) == 0)
	else
		{?>

    
          
    <ul><?
	 foreach($listeCommandesEnCours as $commandesEnCours)
	 	{
		$itemCommande = new Tbq_commande($commandesEnCours['ID']);?>      
        <li><a href="afficher_commande.php?ID_commande=<? echo $commandesEnCours['ID']; ?>" target="_blank">R&eacute;servations n&deg;<strong><? echo $commandesEnCours['ID_commande_fraish']; ?></strong> pour le <? echo T_LAETIS_site::dateEnFrancais($commandesEnCours['dateReservation']); ?> (effectu&eacute;e le <? echo T_LAETIS_site::dateHeureFormatFrancais($commandesEnCours['dateCommande']); ?>)</a><?php
		
		if($itemCommande->peutAnnuler())//IF paiement compte fraish, possibilité d'annuler
			{?>
<form name="enCours" id="enCours" enctype="multipart/form-data" action="scripts/sauver_commande.php" method="post" onsubmit="return window.confirm('Etes vous sûr de vouloir annuler cette commande ?')" style="display:inline;">
    <input name="statut[<? echo $commandesEnCours['ID']; ?>]" type="hidden" value="annulee" />
    <input name="ID_client" type="hidden" value="<?php echo $_SESSION['ID_client']; ?>" />
    <input name="ID_commande" type="hidden" value="<? echo $commandesEnCours['ID']; ?>" />
    <input name="ID_typ_paiement" type="hidden" value="<? echo $commandesEnCours['ID_typ_paiement']; ?>" />          
    <input type="submit" name="Submit" value="Annuler" class="boutonAbandonnee"/>
</form>
            <?php /*- <a href="javascript:annulerCommande('<?php echo $itemCommande->ID;?>');">Annuler</a>*/?>
            <?php
			}?>
        </li>      
      <? }// FIN foreach($listeCommandesEnCours as $commandesEnCours) ?>
    </ul>
    <?php /*?><a href="/boutique/fr/espace-client/lister-resa-encours.php" title="Vos r&eacute;servations en cours">&gt; Cliquez-ici pour visualiser les r&eacute;servations en cours de traitement</a><?php */?>
    
    
    <? } // FINE else ?>
    <p>&nbsp;</p>
    <h3>Les approvisionnements de mon compte, j'imprime mes formulaires</h3><?php
	//$listeApprosAttente = $appro->lister($client->ID,0);
	$listeApprosAttente=$appro->listerSaufOffert($client->ID);
	if($listeApprosAttente)
		{
		foreach($listeApprosAttente as $approAttente)
			{?>
            <p><strong style="color:#F00;">En attente</strong> : <?php echo $approAttente->getDescriptif();?> - <a href="imprimer-appro.php?ID_appro=<?php echo $approAttente->ID;?>" target="_blank" class="bouton" title="Imprimer le formulaire d'approvisionnement &agrave; pr&eacute;senter sur le point de vente" style="display:inline; padding-right:2px; padding-bottom:2px;">Imprimer le formulaire</a></p>
            <?php
			}
		}
	$listeAppros = $appro->lister($client->ID,1);
    if($listeAppros)
    	{?>
        <a href="/boutique/fr/espace-client/historique-appro.php" title="Voir votre historique d'approvisionnement du compte Fraish">&gt; Cliquez-ici pour visualiser tout votre historique d'approvisionnement de votre compte Fraish.</a>
        <?php
       	}
    else
    	{?>
        <p>Vous n'avez pas effectu&eacute; d'approvisionnements de votre compte ou bien ils n'ont pas encore été validés.</p><?php
       	}?>
    <p>&nbsp;</p>
    <h3>Mes commandes, j'imprime mes factures.</h3>
    <?
	 $listeCommandesLivrees = $commande->listerCommande($_SESSION['ID_client'], 'livree');
	 if (count($listeCommandesLivrees) == 0)
	 	{
		?>
    <p>Vous n'avez aucune r&eacute;servation &eacute;ffectu&eacute;e. </p>
    <?
		} // FIN if (count($commandesEffectuees) == 0)
	else
		{
		?>
    <a href="/boutique/fr/espace-client/lister-resa-effectuees.php" title="Voir vos r&eacute;servations effectu&eacute;es">&gt; Cliquez-ici pour visualiser les r&eacute;servations effectu&eacute;es et acc&eacute;der &agrave; vos factures.</a>
    
    <? } // FINE else ?>
    <?php /*?><p>&nbsp;</p>
    <h3>Vos r&eacute;servations abandonn&eacute;es.</h3>
    <?
	 $listeCommandesAbandonnees = $commande->listerCommande($_SESSION['ID_client'], 'abandonnee');
	 if (count($listeCommandesAbandonnees) == 0)
	 	{
		?>
    <p>Vous n'avez aucune r&eacute;servation abandonn&eacute;e. </p>
    <?
		} // FIN if (count($listeCommandesAbandonnees) == 0)
	else
		{
		?>
    <a href="/boutique/fr/espace-client/lister-resa-abandonnees.php" title="Voir vos r&eacute;servations abandon&eacute;es">&gt; Cliquez-ici pour visualiser vos r&eacute;servations abandonn&eacute;es.</a>
    
    <? } // FINE else ?><?php */?>
    
  <?php include_once rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/Library/bq_info-recharge.php';?>
    <div id="monEspace">
    <h3>Gestion de mon espace</h3>
    <p><a href="../creation-compte-etape1.php">> Je modifie mon profil</a></p>
    <?php
		if ($menuFavori->ID)
			{ ?><p><a href="menu-favori-ingredients.php?ID_menuFavori=<?php echo $menuFavori->ID; ?>">> Je modifie mon menu favori</a></p><?php } // FIN if ($menuFavori) ?>
    <p>&nbsp;</p>
    <h3>Mon cr&eacute;dit compte Fraish</h3>
 	<p>Mon solde est de <?php 
	if($client->soldeCompte<0)
		{?>
		<font style="color:#FF0000"><?php
		}?>
        <strong><?php
		echo $client->soldeCompte;?> &euro;</strong><?php
    if($client->soldeCompte<0)
		{?>
        </font><?php
		}?></p>
    <p><a href="/boutique/fr/espace-client/paiement-formulaire-credit.php">&gt; J'approvisionne mon compte</a></p>
    </div>
    <?php /*?><p><a href="/boutique/fr/espace-client/index.php">&lt; retour</a></p>
    <p>&nbsp;</p><?php */?>
  </div>
  <?php
		if (! $menuFavori->ID)
			{ ?><div id="favori">
            <a href="<?php //menu-favori.php?>menu-favori-formule.php" title="Pré-enregistez votre menu favori"><img src="/boutique/images/menu-favori.jpg" width="259" height="173" title="Pré-enregistez votre menu favori" alt="Pré-enregistez votre menu favori" /></a>
            </div>
  <?php } // FIN if (! $menuFavori) ?>
  
  <div style="height:50px; margin-left:20px;"><a href="/index.php" title="Retour &agrave; l'accueil du site Fraish" class="boutonRetour">&lt; Site Fraish</a></div>
</div>
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-1956792-20";
urchinTracker();
</script>
</body>
</html>