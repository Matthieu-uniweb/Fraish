<?
session_start();
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/classes.inc.php';
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/includes/classes/paquetage.inc.php';
if (! $_SESSION['ID_client'])
	{ header("Location: ../login.php"); }
$client = new Tbq_client($_SESSION['ID_client']);
$commande = new Tbq_commande($_GET['ID_commande']);
$prix = $commande->prix;
//echo $_SESSION['aDejaCommande'];
if($_SESSION['aDejaCommande'])//Evite les trous de num commande et les débits multiples
	{
	$_SESSION['aDejaCommande'] = false;
	header('Location:/boutique/fr/espace-client/espace-client.php');
	}
?>
<script type="text/javascript" language="javascript">
var sortie = 0;
</script><?php

switch($_POST['fonction'])
	{
	case 'paiementTitresResto':
		$_POST['valeurTitre'] = str_replace(',','.',$_POST['valeurTitre']);
		$_POST['montant'] = $_POST['valeurTitre']*$_POST['nbTitres'];

	case 'paiementEspeces':
	case 'paiementCheque':
		$appro = new Tbq_approvisionnement();
		$_POST['ID_client'] = $client->ID;
		$_POST['ID_commande'] = $commande->ID;
		$_POST['montant'] = str_replace(',','.',$_POST['montant']);
		if($appro->enregistrer($_POST))
			{
			$montantAppro = $_POST['montant'];
			include_once rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/Library/bq_remise-approvisionnement.php';
			
			$affichRecapImpression=true;
			}
		else
			{
			$affichRecapImpression=false;
			}
			
		//envoyer le mail pour l'approvisionnement
		$appro->genererMailDemandeAppro("/boutique/fr/emails/envoi-commande/envoi-appro.php",$appro->ID, $client->ID);
		
		if($_GET['ID_commande'] && !$_SESSION['aDejaCommande'])
			{
			$_SESSION['aDejaCommande'] = true;
			$commande->setIDPaiement(5);
			$commande->setIDCommandeFraish();
			$commande->modifierStatut($commande->ID,'en_cours');
			$commande->validerPaiementCompteFraish();
			$commande->genererEmailReservation("/boutique/fr/emails/envoi-commande/envoi-commande.php", $client->ID);
			$commande->statut = 'en_cours';
			}?>
        <script type="text/javascript" language="javascript">
		sortie=1;
		</script><?php
		break;
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Fraish r&eacute;servation</title>
<link rel="stylesheet" type="text/css" href="/includes/styles/admin.css" />
<link rel="stylesheet" type="text/css" href="/includes/styles/formulaire.css" />
<link rel="stylesheet" type="text/css" href="/includes/styles/global.css" />
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />
<link rel="icon" type="image/x-icon" href="/favicon.ico" />
<link rel="stylesheet" type="text/css" href="/includes/styles/espace-client.css" />

<!-- On inclut la librairie openrico / prototype -->
<script type="text/javascript" src="/includes/javascript/globals.js"></script>
<script type="text/javascript" src="/includes/javascript/masques.js"></script>
<script src="/boutique/includes/javascript/bq_admin-boutique.js" type="text/javascript"></script>
<script src="/includes/javascript/formulaire.js" type="text/javascript"></script>
<script type="text/javascript" language="javascript">
<!--//

function afficherPaiement(divPaiement)
	{
	<?php
	/*if(!$client->peutCommander())
		{?>
	typesPaiement = new Array('paiementCarteBancaire');<?php
		}
	else
		{*/?>
	typesPaiement = new Array(/*'paiementCarteBancaire',*/'paiementCheque','paiementTitresResto');/*,'paiementEspeces'*/<?php
		//}?>
	for(i=0;typesPaiement[i];i++)
		{
		document.getElementById(typesPaiement[i]).style.display='none';
		}
	document.getElementById(divPaiement).style.display='block';
	}
function controleMontant(objet)
	{ 
	objet.value = objet.value.replace(',','.');
	if(objet.value<999999 && objet.value>0 && objet.value!='')
		{
		<?php
		if($commande->ID>0)
			{?>
			var recharge = parseFloat(objet.value);
			var prixCommande = parseFloat(document.getElementById('prixCommande').value);
			//alert('test : '+recharge+'/'+prixCommande);
			if( recharge < prixCommande)
				{
				alert("Vous devez recharger au minimum <?php echo $prix;?> €, correspondant au montant de votre commande");
				objet.value = <?php echo $prix;?>;
				return false;
				}
			<?php
			}
		?>
		}
	else
		{
		alert('Veuillez indiquer une somme valide !');
		focus(objet);
		return false;
		}
	}
function controleMontantTitreResto()
	{
	var valeur = parseFloat(document.forms['frmTitreResto'].valeurTitre.value.replace(',','.'));
	document.forms['frmTitreResto'].valeurTitre.value = valeur;
	var nbTickets = document.forms['frmTitreResto'].nbTitres.value;
	var prixCommande = parseFloat(document.getElementById('prixCommande').value);
	var message='';
	if(nbTickets=='')
		{
		message = 'Veuillez indiquer le nombre de titres restaurant et la valeur unitaire';
		}
	if(valeur=='')
		{
		message = 'Veuillez indiquer le nombre de titres restaurant et la valeur unitaire';
		}
	if(message)
		{
		alert(message); return false;
		}
	if((valeur*nbTickets) < prixCommande)
		{
			<?php
		if($commande->ID>0)
			{?>
		alert("Vous devez recharger au minimum <?php echo $prix;?> €, correspondant au montant de votre commande");
		return false;<?php
			}?>
		}
	//document.forms['frmTitreResto'].submit();
	
	}
window.onunload = function ()
	{<?php
	if($commande->ID>0)
		{?>
	if(sortie==0)
		{
		var ok = confirm("Voulez-vous abandonner votre commande Fraish ? \nSi vous cliquez sur 'Ok', votre commande ne sera pas préparée.\nSi vous cliquez sur 'Annuler', vous pourrez accéder au paiement de votre commande.");

		if(ok==false)
			{
			document.location.href = this.document.location.href;
			}
		}<?php
		}?>
	}
//-->
</script>
<style type="text/css">
<!--
.Style1 {
	color: #990000
}
table {
	margin-left:100px;
}
-->
</style>
</head>
<body>
<div id="page" style="height:800px;">
<a href="espace-client.php">&lt; Retour</a>
<div id="enTete">&nbsp;
</div>
<div id="contenu">
<h1><?php
if($commande->statut=='en_cours')
	{?>
    Votre commande a bien &eacute;t&eacute; prise en compte<?php
	}
else
	{?>Votre espace client<?php
	}?></h1>
<?php
if($_GET['ID_commande'])
	{
	?>
<?php
$etape=5;
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/Library/bq_etapes.php';
?>
    <?php
	}?>
<h2><?php
if(basename($_SERVER['HTTP_REFERER'])=='espace-client.php')
	{?>
	Approvisionnement de votre compte Fraish<?php
	}
else
	{?>
	Total de votre commande : <?php echo $prix;?>&nbsp;&euro;<?php
	}?></h2>
<p>&nbsp;</p><?php
if(!$affichRecapImpression)//Saisie de l'approvisionnement
	{?>
    <div style="position:absolute; left:640px;" id="le-saviez-vous"><img src="/images/site/le-saviez-vous.jpg" width="150"/>
    <?php /*?><p><img src="/images/site/titre-paiement-cb.jpg" width="115" /><br />Vous pouvez payer juste la somme de votre menu du jour en ligne avec CB.</p><?php */?>
 
    <p><?php /*?><img src="/images/site/ou.jpg" /><?php */?><img src="/images/site/titre-paiement-compte.jpg" width="115" /><br />FRAISH vous a réservé un espace personnel  ou vous pouvez créditer votre compte  et l'utiliser comme votre porte monnaie !!<br />
    A l'&eacute;tape <img src="/images/site/etape5-paiement.jpg" width="80" />, vous cliquez sur le paiement de votre choix.
    <?php /*?><img src="/images/site/ex-paiement-compte.jpg" width="220" /><?php */?>
    </p>
    <p>Un formulaire apparait. Vous le remplissez avec la somme de votre choix et le paiement de votre choix.<br />Imprimez le formulaire.<br /><strong>Rendez-vous dans votre point de vente avec votre formulaire rempli et votre règlement, votre premier menu vous attend.</strong><br />24 heures après, votre compte sera crédité et accessible sur votre profil FRAISH.<br />
Pour les commandes suivantes, cliquez sur <strong>&ldquo;je paie avec mon compte&rdquo;</strong><img src="/images/site/ex-paiement-compte-credite.jpg" width="220" /></p></div>
    <h4><strong>Mon compte est &agrave; <?php echo $client->soldeCompte;?> &euro;</strong></h4>
    <p>&nbsp;</p>
    <h3>Je recharge mon compte Fraish</h3>
    
    <?php /*?><a href="javascript:afficherPaiement('paiementCarteBancaire');" style="text-decoration:underline;" title="Approvisionnement par carte bancaire"><img src="/images/icones/rondelle.gif" align="absmiddle" />&nbsp;<strong style="text-decoration:underline;">Par Carte Bancaire</strong></a><?php */?>
    <?php /*?><div id="paiementCarteBancaire">
    <form method="post" action="/includes/paiement/call_request.php" onSubmit="return controleMontant(this.montant);"><?php //return lsjs_verifierFormulaire2(this);?>
    <input type="hidden" name="obligatoire" value="montant-La somme de votre recharge" />
    <input type="hidden" name="fonction" value="rechargeCartebancaire" />
    <input type="hidden" name="ID_typ_paiement" value="1" />
    <input type="hidden" name="ID" value="<?php echo $appro->ID;?>" />
    <input type="hidden" name="prixCommande" id="prixCommande" value="<?php echo $prix;?>" />
    
    <table>
    	<tr>
        	<td align="right" valign="top">Somme* :</td>
            <td><input type="text" name="montant" class="input300" onChange="javascript:controleMontant(this);" value="" /> &euro;<?php
            if($_GET['ID_commande'])
				{?>
                <!--<br />Cette somme sera ajoutée au montant de votre commande.--><?php 
				}?></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><input type="submit" value="Valider" class="bouton" onClick="javascript:sortie=1;" /></td>
        </tr>
    </table>
    </form>
    
    </div><?php */?>
    <?php
if(!$client->peutCommander())//IF oblige la réapro par CB si le client a des dettes
	{?>
    <?php /*?><p>Votre solde compte Fraish est n&eacute;gatif, vous ne pouvez r&eacute;approvisionner que par carte bancaire.</p><?php */?>
	<p>Votre solde compte Fraish est n&eacute;gatif, vous ne pouvez r&eacute;approvisionner que sur le kiosque Labège.</p><?php
	}
else
	{?>
    
    <div class="ajusteur"></div>
    <a href="javascript:afficherPaiement('paiementCheque');" style="text-decoration:underline;" title="Approvisionnement par ch&egrave;que"><img src="/images/icones/rondelle.gif" align="absmiddle" />&nbsp;<strong style="text-decoration:underline;">Par Ch&egrave;que</strong></a>
    <div id="paiementCheque">
    <form name="" method="post" action="" onSubmit="return controleMontant(this.montant);">
    <input type="hidden" name="obligatoire" value="montant-La somme de votre recharge" />
    <input type="hidden" name="fonction" value="paiementCheque" />
    <input type="hidden" name="ID_typ_paiement" value="2" />
    <input type="hidden" name="ID" value="<?php echo $appro->ID;?>" />
    <table>
        <tr>
            <td align="right">Num&eacute;ro du ch&egrave;que :</td><td><input type="text" name="numCheque" class="input300" /></td>
        </tr>
        <tr>
            <td align="right">Somme* :</td><td><input type="text" name="montant" class="input300" onChange="javascript:controleMontant(this);" /> &euro;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><input type="submit" value="Valider" class="bouton" onClick="javascript:sortie=1;" /></td>
        </tr>
    </table>
    </form>
    </div>
    <div class="ajusteur"></div>
    <a href="javascript:afficherPaiement('paiementTitresResto');" style="text-decoration:underline;" title="Approvisionnement par titres restaurants"><img src="/images/icones/rondelle.gif" align="absmiddle" />&nbsp;<strong style="text-decoration:underline;">Par Titres Restaurant</strong></a>
    <div id="paiementTitresResto">
    <form name="frmTitreResto" method="post" action="" onSubmit="javascript:return controleMontantTitreResto();"><?php //return lsjs_verifierFormulaire2(this);?>
    <input type="hidden" name="obligatoire" value="nbTitres-Le nombre de titres restaurant|valeurTitre-La valeur unitaire d'un titre restaurant" />
    <input type="hidden" name="fonction" value="paiementTitresResto" />
    <input type="hidden" name="ID_typ_paiement" value="3" />
    <input type="hidden" name="ID" value="<?php echo $appro->ID;?>" />
    <table>
        <tr>
            <td align="right">Nombre de titres restaurant* :</td><td><input type="text" name="nbTitres" class="input300" /><?php //onChange="javascript:controleMontant(this);"?></td>
        </tr>
        <tr>
            <td align="right">Somme &agrave; l'unit&eacute;* :</td><td><input type="text" name="valeurTitre" class="input300" /> &euro;<?php //onChange="javascript:controleMontant(this);"?></td>    
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><input type="submit" value="Valider" class="bouton" onClick="javascript:sortie=1;" /></td>
        </tr>
    </table>
    </form>
    </div>
    <?php /*?><div class="ajusteur"></div>
    <a href="javascript:afficherPaiement('paiementEspeces');" style="text-decoration:underline;" title="Approvisionnement par esp&egrave;ces"><img src="/images/icones/rondelle.gif" align="absmiddle" />&nbsp;<strong style="text-decoration:underline;">Par Esp&egrave;ces</strong></a><?php */?>
    <?php /*?><div id="paiementEspeces">
    <form name="" method="post" action="" onSubmit="return controleMontant(this.montant);"><?php //lsjs_verifierFormulaire2(this)?>
    <input type="hidden" name="obligatoire" value="montant-La somme de votre recharge" />
    <input type="hidden" name="fonction" value="paiementEspeces" />
    <input type="hidden" name="ID_typ_paiement" value="4" />
    <input type="hidden" name="ID" value="<?php echo $appro->ID;?>" />
    <table>
        <tr>
            <td align="right">Somme* :</td><td><input type="text" name="montant" class="input300" onBlur="javascript:controleMontant(this);"/> &euro;</td>    
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><input type="submit" value="Valider" class="bouton" onClick="javascript:sortie=1;" /></td>
        </tr>
    </table>
    </form>
    </div><?php */?>
    <p>&nbsp;</p>
    <p>*champs obligatoires</p>
	<p>&nbsp;</p>
	<p>Pour les recharges par chèque, titres restaurant et espèces,<br />l'approvisionnement de votre compte client sera effectif après réception du paiement.</p>
	 <?php
	}//FIN IF oblige la réappro par CB?>
    <?php
	}//FIN IF saisie de l'approvisionnement
else //Affichage du récap de l'appro, à imprimer et amener au point de vente Fraish
	{
?>
    <?php
	/*if($commande)
		{?>
        <h3 style="color:#76BD48;">Votre commande a bien &eacute;t&eacute; prise en compte</h3>
		<p>&nbsp;</p><?php
		}*/
	?>
	<h3>R&eacute;capitulatif de votre approvisionnement</h3>
	<h4>Merci d'imprimer le r&eacute;capitulatif ci-dessous<br />et de le déposer au point de vente Fraish lors du retrait de votre menu.</h4>
    <div class="ajusteur"></div>
    <?php /*?><a href="javascript:printAll();" class="bouton" title="Imprimer">Imprimer</a><?php */?>
    <a href="/boutique/fr/espace-client/imprimer-appro.php?ID_appro=<?php echo $appro->ID;?>" target="_blank" class="bouton" title="Imprimer">Imprimer</a>
	<p>&nbsp;</p>
    <form>
    	<input type="hidden" name="ID" value="<?php echo $appro->ID;?>" />
    </form><?php
	
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/Library/form-approvisionnement.php';?>
    <table>
        <tr>
        	<td>
            <a href="/boutique/fr/espace-client/imprimer-appro.php?ID_appro=<?php echo $appro->ID;?>" target="_blank" class="bouton" title="Imprimer">Imprimer</a>
            </td>
            <td>
            <a href="/boutique/fr/espace-client/espace-client.php" class="bouton" title="Retour &agrave; l'espace client">Retour &agrave; l'espace client</a>
            </td>
        </tr>
	</table>
    <p>&nbsp;</p>
    <hr />
	<p>Attention : L'utilisateur est informé, conformément &agrave; l'article 27 de la loi informatique, fichiers et libertés du 6 janvier 1978 que les informations qu'il communique sont destinées &agrave; FRAISH &agrave; des fins de gestion administrative et commerciale. L'utilisateur est inform&eacute; qu'il dispose d'un droit d'acc&egrave;s et de rectification relativement &agrave; l'ensemble des données nominatives le concernant en &eacute;crivant &agrave; :<br /> GROUP FRAISH ROUTE DE LA BELAUTIE 81140 CAHUZAC-SUR-VERE.<br />
    En acceptant la présente recharge de compte commande sur site,<br />je reconnais avoir pris connaissance des <a href="/fr/informations/conditions-vente.php" target="_blank">conditions générales d'utilisation sur le site FRAISH</a>.</p>
	<script type="text/javascript" language="javascript">
	<!--//
	window.onload = window.open('imprimer-appro.php?ID_appro=<?php echo $appro->ID;?>','impression-formulaire');
	//-->
	</script><?php	
	}?>
<p>&nbsp;</p>
</div>

<?php
if($_GET['mode'])
	{?>
    <script language="javascript" type="text/javascript">
	afficherPaiement('<?php echo $_GET['mode'];?>');
	</script>
    <?php
	}
?>
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-1956792-20";
urchinTracker();
</script>
</div>
</body>
</html>
