<?php
session_start();
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/classes.inc.php';
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/includes/classes/paquetage.inc.php';

$client = new Tbq_client($_SESSION['ID_client']);

$clientSpecifique = new Tbq_client_specifique();
$gouts = $clientSpecifique->detailClient($_SESSION['ID_client']);

$tabAime = explode(', ', $gouts['aime']);
$tabMoyen = explode(', ', $gouts['moyen']);
$tabDeteste = explode(', ', $gouts['deteste']);

$pointDeVente = new Tbq_user();
$pointsDeVente = $pointDeVente->lister();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Fraish création compte</title>
<meta name="Description" content="La boutique Fraish" />
<meta name="Keywords" content="boutique Fraish" />
<link rel="stylesheet" type="text/css" href="/includes/styles/global.css" />
<link rel="stylesheet" type="text/css" href="/includes/styles/admin.css" />
<link rel="stylesheet" type="text/css" href="/includes/styles/formulaire.css" />
<script language="JavaScript" type="text/javascript" src="/includes/javascript/globals.js"></script>
<script language="JavaScript" type="text/javascript" src="/includes/javascript/site.js"></script>
<script language="JavaScript" type="text/javascript" src="/includes/javascript/flashobject.js"></script>
<script language="JavaScript" type="text/javascript" src="/includes/javascript/navigation.js"></script>
<script language="JavaScript" type="text/javascript" src="/includes/javascript/mm.js"></script>
<script language="JavaScript" type="text/javascript" src="/includes/javascript/formulaire.js"></script>
<script language="JavaScript" type="text/javascript" src="/includes/javascript/masques.js"></script>
<script language="JavaScript" type="text/javascript" src="/boutique/includes/javascript/bq_front-boutique.js"></script>
<script language="JavaScript" type="text/javascript" src="/includes/javascript/preload-fr.js"></script>
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />
<link rel="icon" type="image/x-icon" href="/favicon.ico" />
</head>
<body>
<div id="page">
  <div id="enTete">&nbsp;
  </div>
  <div id="contenu">
  <h1>Inscription</h1>
  <?php
$etape=1;
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/Library/bq_etapes.php';
?>
    <h3>&gt;&gt; Nouveau  client : Cr&eacute;ation de votre compte</h3>
    <p>Veuillez compl&eacute;tez le formulaire ci-dessous (* champs obligatoire) : </p>
    <p>Votre e-mail sera votre identifiant &agrave; la boutique Fraish. Votre mot de passe, <strong>de 5 caract&egrave;res minimum</strong>, vous permettra d'acc&eacute;der &agrave; votre espace personnalis&eacute; pour le suivi de votre commande. </p>
    <?php
switch($_GET['erreur'])
	{
	case 'clientExistant':?>
    	<p><strong><br />
  		Vous disposez déjà d'un compte client pour la boutique Fraish ! <a href="login.php">Cliquez-ici</a> pour vous identifier.<br />
      	Si vous avez oubli&eacute; votre mot de passe, <a href="javascript:demanderCodes('fr');" title="Demander vos codes de la boutique Fraish">cliquez-ici</a>.<br />  
      	<br />
    	</strong></p><?php
		break;
	
	/*case 'codeEntrepriseInvalide':?>
    	<p><strong><br />
  		<font style="color:#C00">Le code entreprise que vous avez renseign&eacute; n'est pas valide !</font><br />
      	<br />
    	</strong></p><?php
		break;*/
	}?>  
    
    
    <form name="formulaireCommander" id="formulaireCommander" action="scripts/valider-etape1.php" method="post" onSubmit="return lsjs_verifierFormulaire(this, this.motDePasse, this.motDePasseConfirmation)" >
      <fieldset>
      <input name="dateInscription" type="hidden" id="dateInscription" value="<? if ($client->dateInscription) { echo $client->dateInscription; } else { echo date("Y-m-d"); } ?>"/>
      <p>
        <label for="emailFacturation" title="email" class="obligatoire">Votre e-mail* : </label>
        <input name="emailFacturation" type="text" id="emailFacturation" class="input300" value="<? echo $client->emailFacturation;?>" size="35" />
      </p>
      <p>
        <label for="motDePasse" title="mot de passe" class="obligatoire">Votre mot de passe* : </label>
        <input name="motDePasse" type="password" id="motDePasse" class="input300" value="<? echo $client->motDePasse;?>" size="35" />
      </p>
      <p>
        <label for="motDePasse" title="confirmation mot de passe" class="obligatoire">Confirmez  mot de passe* : </label>
        <input name="motDePasseConfirmation" class="input300" type="password" id="motDePasseConfirmation" value="<? echo $client->motDePasse;?>" size="35" />
      </p>
      </fieldset>
      <fieldset>
      <p>
        <label for="nomFacturation" title="nom" class="obligatoire">Votre nom* : </label>
        <select name="civiliteFacturation" id="civiliteFacturation">
          <option value="M."  <? 
								if ($client->civiliteFacturation=="M." || $client->civiliteFacturation=="")
									{echo ' selected';}
								?>>M.</option>
          <option value="Mme" <? 
								if ($client->civiliteFacturation=="Mme")
									{echo ' selected';}
								?>>Mme</option>
        </select>
        <input name="nomFacturation" type="text" id="nomFacturation" class="input300" value="<? echo $client->nomFacturation;?>" size="35" onBlur="this.value=this.value.toUpperCase();" />
      </p>
      <p>
        <label for="prenomFacturation" title="prenom" class="obligatoire">Votre pr&eacute;nom* : </label>
        <input name="prenomFacturation" type="text" id="prenomFacturation" class="input300" value="<? echo $client->prenomFacturation;?>" size="35" />
      </p>
      <p>
        <label for="dateDeNaissance" title="dateDeNaissance" class="obligatoire">Votre date de naissance* : </label>
        <input name="dateDeNaissance" type="text" id="dateDeNaissance" class="input300" value="<? echo $client->dateDeNaissance;?>" size="10" onKeyPress="verifierMasqueSaisie(this,'##-##-####');" />
        &nbsp;&nbsp;<em>format 01-01-2008.</em></p>
      <p>
        <label for="telFacturation" title="telephone">Votre t&eacute;l&eacute;phone : </label>
        <input name="telFacturation" type="text" id="telFacturation" class="input300" value="<? echo $client->telFacturation;?>" size="20" onKeyPress="verifierMasqueSaisie(this,'##-##-##-##-##');" />
      </p>
      <p>
        <label for="societe" title="societe">Votre soci&eacute;t&eacute; / organisme : </label>
        <input name="societe" type="text" id="societe" class="input300" value="<? echo $client->societe;?>" size="35" />
      </p>
      <p>
        <label for="adresseFacturation" title="Adresse de facturation" class="obligatoire">Adresse* : </label>
        <input name="adresseFacturation" type="text" id="adresseFacturation" class="input300" size="35" value="<? echo $client->adresseFacturation;?>" />
      </p>
      <p>
        <label for="adresseFacturation2" title="Compl&eacute;ment d'adresse">Compl&eacute;ment d'adresse : </label>
        <input name="adresseFacturation2" type="text" id="adresseFacturation2" class="input300" size="35" value="<? echo $client->adresseFacturation2;?>" />
      </p>
      <p>
        <label for="codePostalFacturation" title="Code Postal" class="obligatoire">Code Postal* : </label>
        <input name="codePostalFacturation" type="text" id="codePostalFacturation" class="input300" value="<? echo $client->codePostalFacturation;?>" size="10" />
      </p>
      <p>
        <label for="villeFacturation" title="Ville" class="obligatoire">Ville* : </label>
        <input name="villeFacturation" type="text" id="villeFacturation" class="input300" value="<? echo $client->villeFacturation;?>" size="35" onBlur="this.value=this.value.toUpperCase();" />
      </p>
      <p>
        <label for="ID_pointDeVentePrefere" title="Ville" class="obligatoire">Votre point de vente pr&eacute;f&eacute;r&eacute;* : </label>
        <select name="ID_pointDeVentePrefere"><?php foreach ($pointsDeVente as $point) { ?><option value="<?php echo $point->ID;?>" <?php if ($client->ID_pointDeVentePrefere==$point->ID) { echo 'selected="selected"'; } ?>><?php echo $point->pointDeVente;?></option><?php } ?></select>
      </p>
     <?php /*?> <p>
      <label for="codeEntreprise" title="Code entreprise">Votre code entreprise : </label>
      <input type="text" name="codeEntreprise" value="<?php echo $client->codeEntreprise;?>" class="input300" /><br />En renseignant ce code, vous pourrez choisir d'&ecirc;tre livr&eacute; sur le point de livraison le plus proche de votre entreprise.<br />
      Si vous choisissez l'option livraison lors d'une r&eacute;servation, cela engendra un co&ucirc;t suppl&eacute;mentaire de 0,90 &euro;.</p> <?php */?>
      </fieldset>
      <p>&nbsp;</p>
      <h3>Un Complément d'informations sur vos go&ucirc;ts:</h3>
      <fieldset>
      <? $cpt = 0;
	   $cpt1 = 0;
	   $cpt2 = 0; ?>
      <div id="aliments">
        <p><strong>Parmis ces aliments : </strong></p>
        <p>Salade verte</p>
        <p>Carottes</p>
        <p>Champignons</p>
        <p>Ma&iuml;s</p>
        <p>Courgettes</p>
        <p>Betteraves</p>
        <p>Tomates</p>
        <p>Concombres</p>
        <p>Haricots verts</p>
        <p>Olives</p>
        <p>Oeuf</p>
        <p>Poivrons</p>
        <p>Coeurs d'artichaut</p>
        <p>Croutons</p>
        <p>Fourme d'Ambert</p>
        <p>Emmental</p>
        <p>Fenouil</p>
        <p>Endives</p>
        <p>Choux blancs</p>
        <p>Choux rouges</p>
        <p>Lentilles</p>
        <p>Riz</p>
        <p>Pates</p>
        <p>Blé</p>
        <p>Boulgour</p>
        <p>Quinoa</p>
        <p>Cranberries</p>
        <p>Pralin</p>
        <p>Tournesol</p>
        <p>Noix</p>
        <p>Amandes</p>
        <p></p>
      </div>
      <div id="aime">
        <p><strong> j'adore </strong></p>
        <p>
          <input type="radio" name="questionnaire[salade_verte]" id="salade_verte" value="aime|Salade verte" <?php if (in_array('Salade verte', $tabAime)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[carottes]" id="carottes" value="aime|Carottes" <?php if (in_array('Carottes', $tabAime)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[champignons]" id="champignons" value="aime|Champignons" <?php if (in_array('Champignons', $tabAime)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[mais]" id="mais" value="aime|Maïs" <?php if (in_array('Maïs', $tabAime)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[courgettes]" id="courgettes" value="aime|Courgettes" <?php if (in_array('Courgettes', $tabAime)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[betteraves]" id="betteraves" value="aime|Betteraves" <?php if (in_array('Betteraves', $tabAime)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[tomates]" id="tomates" value="aime|Tomates" <?php if (in_array('Tomates', $tabAime)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[concombres]" id="concombres" value="aime|Concombres" <?php if (in_array('Concombres', $tabAime)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[haricots_verts]" id="haricots_verts" value="aime|Haricots verts" <?php if (in_array('Haricots verts', $tabAime)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[olives]" id="olives" value="aime|Olives" <?php if (in_array('Olives', $tabAime)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[oeuf]" id="oeuf" value="aime|Oeuf" <?php if (in_array('Oeuf', $tabAime)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[poivrons]" id="poivrons" value="aime|Poivrons" <?php if (in_array('Poivrons', $tabAime)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[coeurs_artichaut]" id="coeurs_artichaut" value="aime|Coeurs d'artichaut" <?php if (in_array('Coeurs d\'artichaut', $tabAime)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[croutons]" id="croutons" value="aime|Croutons" <?php if (in_array('Croutons', $tabAime)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[fourme_ambert]" id="fourme_ambert" value="aime|Fourme d'Ambert" <?php if (in_array('Fourme d\'Ambert', $tabAime)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[emmental]" id="emmental" value="aime|Emmental" <?php if (in_array('Emmental', $tabAime)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[fenouil]" id="fenouil" value="aime|Fenouil" <?php if (in_array('Fenouil', $tabAime)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[endives]" id="endives" value="aime|Endives" <?php if (in_array('Endives', $tabAime)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[choux_blancs]" id="choux_blancs" value="aime|Choux blancs" <?php if (in_array('Choux blancs', $tabAime)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[choux_rouges]" id="choux_rouges" value="aime|Choux rouges" <?php if (in_array('Choux rouges', $tabAime)) { echo 'checked="checked"'; } ?> />
        </p>        
        <p>
          <input type="radio" name="questionnaire[lentilles]" id="lentilles" value="aime|Lentilles" <?php if (in_array('Lentilles', $tabAime)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[riz]" id="riz" value="aime|Riz" <?php if (in_array('Riz', $tabAime)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[pates]" id="pates" value="aime|Pates" <?php if (in_array('Pates', $tabAime)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[ble]" id="ble" value="aime|Blé" <?php if (in_array('Blé', $tabAime)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[boulgour]" id="boulgour" value="aime|Boulgour" <?php if (in_array('Boulgour', $tabAime)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[quinoa]" id="quinoa" value="aime|Quinoa" <?php if (in_array('Quinoa', $tabAime)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[cranberries]" id="cranberries" value="aime|Cranberries" <?php if (in_array('Cranberries', $tabAime)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[pralin]" id="pralin" value="aime|Pralin" <?php if (in_array('Pralin', $tabAime)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[tournesol]" id="tournesol" value="aime|Tournesol" <?php if (in_array('Tournesol', $tabAime)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[noix]" id="noix" value="aime|Noix" <?php if (in_array('Noix', $tabAime)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[amandes]" id="amandes" value="aime|Amandes" <?php if (in_array('Amandes', $tabAime)) { echo 'checked="checked"'; } ?> />
        </p>
      </div>
      <div id="moyen">
        <p><strong> j'aime </strong></p>
        <p>
          <input type="radio" name="questionnaire[salade_verte]" id="salade_verte" value="moyen|Salade verte" <?php if (in_array('Salade verte', $tabMoyen)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[carottes]" id="carottes" value="moyen|Carottes" <?php if (in_array('Carottes', $tabMoyen)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[champignons]" id="champignons" value="moyen|Champignons" <?php if (in_array('Champignons', $tabMoyen)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[mais]" id="mais" value="moyen|Maïs" <?php if (in_array('Maïs', $tabMoyen)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[courgettes]" id="courgettes" value="moyen|Courgettes" <?php if (in_array('Courgettes', $tabMoyen)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[betteraves]" id="betteraves" value="moyen|Betteraves" <?php if (in_array('Betteraves', $tabMoyen)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[tomates]" id="tomates" value="moyen|Tomates" <?php if (in_array('Tomates', $tabMoyen)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[concombres]" id="concombres" value="moyen|Concombres" <?php if (in_array('Concombres', $tabMoyen)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[haricots_verts]" id="haricots_verts" value="moyen|Haricots verts" <?php if (in_array('Haricots verts', $tabMoyen)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[olives]" id="olives" value="moyen|Olives" <?php if (in_array('Olives', $tabMoyen)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[oeuf]" id="oeuf" value="moyen|Oeuf" <?php if (in_array('Oeuf', $tabMoyen)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[poivrons]" id="poivrons" value="moyen|Poivrons" <?php if (in_array('Poivrons', $tabMoyen)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[coeurs_artichaut]" id="coeurs_artichaut" value="moyen|Coeurs d'artichaut" <?php if (in_array('Coeurs d\'artichaut', $tabMoyen)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[croutons]" id="croutons" value="moyen|Croutons" <?php if (in_array('Croutons', $tabMoyen)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[fourme_ambert]" id="fourme_ambert" value="moyen|Fourme d'Ambert" <?php if (in_array('Fourme d\'Ambert', $tabMoyen)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[emmental]" id="emmental" value="moyen|Emmental" <?php if (in_array('Emmental', $tabMoyen)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[fenouil]" id="fenouil" value="moyen|Fenouil" <?php if (in_array('Fenouil', $tabMoyen)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[endives]" id="endives" value="moyen|Endives" <?php if (in_array('Endives', $tabMoyen)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[choux_blancs]" id="choux_blancs" value="moyen|Choux blancs" <?php if (in_array('Choux blancs', $tabMoyen)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[choux_rouges]" id="choux_rouges" value="moyen|Choux rouges" <?php if (in_array('Choux rouges', $tabMoyen)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[lentilles]" id="lentilles" value="moyen|Lentilles" <?php if (in_array('Lentilles', $tabMoyen)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[riz]" id="riz" value="moyen|Riz" <?php if (in_array('Riz', $tabMoyen)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[pates]" id="pates" value="moyen|Pates" <?php if (in_array('Pates', $tabMoyen)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[ble]" id="ble" value="moyen|Blé" <?php if (in_array('Blé', $tabMoyen)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[boulgour]" id="boulgour" value="moyen|Boulgour" <?php if (in_array('Boulgour', $tabMoyen)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[quinoa]" id="quinoa" value="moyen|Quinoa" <?php if (in_array('Quinoa', $tabMoyen)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[cranberries]" id="cranberries" value="moyen|Cranberries" <?php if (in_array('Cranberries', $tabMoyen)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[pralin]" id="pralin" value="moyen|Pralin" <?php if (in_array('Pralin', $tabMoyen)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[tournesol]" id="tournesol" value="moyen|Tournesol" <?php if (in_array('Tournesol', $tabMoyen)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[noix]" id="noix" value="moyen|Noix" <?php if (in_array('Noix', $tabMoyen)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[amandes]" id="amandes" value="moyen|Amandes" <?php if (in_array('Amandes', $tabMoyen)) { echo 'checked="checked"'; } ?> />
        </p>        
      </div>
      <div id="deteste">
        <p><strong> j'aime pas</strong></p>
        <p>
          <input type="radio" name="questionnaire[salade_verte]" id="salade_verte" value="deteste|Salade verte" <?php if (in_array('Salade verte', $tabDeteste)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[carottes]" id="carottes" value="deteste|Carottes" <?php if (in_array('Carottes', $tabDeteste)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[champignons]" id="champignons" value="deteste|Champignons" <?php if (in_array('Champignons', $tabDeteste)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[mais]" id="mais" value="deteste|Maïs" <?php if (in_array('Maïs', $tabDeteste)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[courgettes]" id="courgettes" value="deteste|Courgettes" <?php if (in_array('Courgettes', $tabDeteste)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[betteraves]" id="betteraves" value="deteste|Betteraves" <?php if (in_array('Betteraves', $tabDeteste)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[tomates]" id="tomates" value="deteste|Tomates" <?php if (in_array('Tomates', $tabDeteste)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[concombres]" id="concombres" value="deteste|Concombres" <?php if (in_array('Concombres', $tabDeteste)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[haricots_verts]" id="haricots_verts" value="deteste|Haricots verts" <?php if (in_array('Haricots verts', $tabDeteste)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[olives]" id="olives" value="deteste|Olives" <?php if (in_array('Olives', $tabDeteste)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[oeuf]" id="oeuf" value="deteste|Oeuf" <?php if (in_array('Oeuf', $tabDeteste)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[poivrons]" id="poivrons" value="deteste|Poivrons" <?php if (in_array('Poivrons', $tabDeteste)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[coeurs_artichaut]" id="coeurs_artichaut" value="deteste|Coeurs d'artichaut" <?php if (in_array('Coeurs d\'artichaut', $tabDeteste)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[croutons]" id="croutons" value="deteste|Croutons" <?php if (in_array('Croutons', $tabDeteste)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[fourme_ambert]" id="fourme_ambert" value="deteste|Fourme d'Ambert" <?php if (in_array('Fourme d\'Ambert', $tabDeteste)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[emmental]" id="emmental" value="deteste|Emmental" <?php if (in_array('Emmental', $tabDeteste)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[fenouil]" id="fenouil" value="deteste|Fenouil" <?php if (in_array('Fenouil', $tabDeteste)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[endives]" id="endives" value="deteste|Endives" <?php if (in_array('Endives', $tabDeteste)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[choux_blancs]" id="choux_blancs" value="deteste|Choux blancs" <?php if (in_array('Choux blancs', $tabDeteste)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[choux_rouges]" id="choux_rouges" value="deteste|Choux rouges" <?php if (in_array('Choux rouges', $tabDeteste)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[lentilles]" id="lentilles" value="deteste|Lentilles" <?php if (in_array('Lentilles', $tabDeteste)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[riz]" id="riz" value="deteste|Riz" <?php if (in_array('Riz', $tabDeteste)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[pates]" id="pates" value="deteste|Pates" <?php if (in_array('Pates', $tabDeteste)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[ble]" id="ble" value="deteste|Blé" <?php if (in_array('Blé', $tabDeteste)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[boulgour]" id="boulgour" value="deteste|Boulgour" <?php if (in_array('Boulgour', $tabDeteste)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[quinoa]" id="quinoa" value="deteste|Quinoa" <?php if (in_array('Quinoa', $tabDeteste)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[cranberries]" id="cranberries" value="deteste|Cranberries" <?php if (in_array('Cranberries', $tabDeteste)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[pralin]" id="pralin" value="deteste|Pralin" <?php if (in_array('Pralin', $tabDeteste)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[tournesol]" id="tournesol" value="deteste|Tournesol" <?php if (in_array('Tournesol', $tabDeteste)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[noix]" id="noix" value="deteste|Noix" <?php if (in_array('Noix', $tabDeteste)) { echo 'checked="checked"'; } ?> />
        </p>
        <p>
          <input type="radio" name="questionnaire[amandes]" id="amandes" value="deteste|Amandes" <?php if (in_array('Amandes', $tabDeteste)) { echo 'checked="checked"'; } ?> />
        </p>        
      </div>
      </fieldset>
      <p><br />
        <input name="newsletter" type="checkbox" class="caseacocher" id="newsletter" value="1" <?
if ($client->newsletter=='1')
	{ echo 'checked="checked"'; }
?> />
        Je souhaite  &ecirc;tre inform&eacute; des nouveaut&eacute;s et promotions de la boutique Fraish.</p>
      <?php
			if (! $client->ID)
				{ ?>
      <p>
        <input type="submit" name="continuer" id="continuer" value="Créer mon compte" class="bouton" />
      </p>
      <?php }
			else 
				{ ?>
      <p>
        <input type="submit" name="continuer" id="continuer" value="Enregistrer" class="bouton" />
      </p>
      <?php } ?>
      <input type="hidden" name="ID_client_specifique" value="<?php echo $gouts['ID']; ?>" />
      <input name="obligatoire" type="hidden" id="obligatoire" value="emailFacturation-Votre adresse email|motDePasse-Votre mot de passe|motDePasseConfirmation-Confirmez votre mot de passe|nomFacturation-Votre nom|prenomFacturation-Votre prenom|dateDeNaissance-Votre date de naissance|adresseFacturation-Votre adresse|codePostalFacturation-Votre code postal|villeFacturation-Votre ville|salade_verte-Salade verte|carottes-Carottes|champignons-Champignons|mais-Maïs|courgettes-Courgettes|betteraves-Betteraves|tomates-Tomates|concombres-Concombres|haricots_verts-Haricots verts|olives-Olives|oeuf-Oeuf|poivrons-Poivrons|coeurs_artichaut-Coeurs d'artichaut|croutons-Croutons|fourme_ambert-Fourme d'Ambert|emmental-Emmental|fenouil-Fenouil|endives-Endives|choux_blancs-Choux blancs|choux_rouges-Choux rouges|lentilles-Lentilles|riz-Riz|pates-Pates|ble-Blé|boulgour-Boulgour|quinoa-Quinoa|cranberries-Cranberries|pralin-Pralin|tournesol-Tournesol|noix-Noix|amandes-Amandes" />
    </form>
    <p><a href="/boutique/fr/login.php">&lt; retour</a></p>
    <p>&nbsp;</p>
  </div>
</div>
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-1956792-20";
urchinTracker();
</script>
</body>
</html>
