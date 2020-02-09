<?
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/classes.inc.php';
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/includes/classes/paquetage.inc.php';

$pointDeVente = new Tbq_user();
$pointsDeVente = $pointDeVente->lister();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Questionnaire Fraish</title>
<meta name="description" content="La boutique Fraish" />
<meta name="keywords" content="boutique Fraish" />
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
<script type="text/javascript">
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
//-->
</script>
<style type="text/css">
.select50 {
	width:50px;
}
#questionnaire {
	background-image:url(/boutique/images/fond-formulaire.gif);
	background-repeat:no-repeat;
	padding-top:30px;
	padding-bottom:30px;
}
label {
	color:#000000;
	font-style:normal;
	width:220px !important;
}
</style>
</head>
<body>
<div id="page">
  <div id="enTeteQ">&nbsp;
  </div>
  <div id="contenu">
  <h1>Questionnaire</h1>
    <form name="formulaire" id="formulaire" action="scripts/valider-questionnaire.php" method="post" onsubmit="return lsjs_verifierFormulaire2(this);">
      <h3>Votre avis nous int&eacute;resse !</h3>
      <strong>Veuillez compl&eacute;ter le formulaire ci-dessous.</strong> <br />
      <br />
      <?php
			if ($_GET['message']=='ok')
				{
				?><p align="center"><strong>Vos commentaires ont &eacute;t&eacute; pris en compte.<br />
      Merci de votre participation.</strong><br />
      <br />
      </p><?php 
				}
			?>
     <div id="questionnaire">
      <p>
        <label for="nom" title="Votre nom">Votre nom :</label>
        <input name="nom" type="text" id="nom" class="input300" value="" size="30" />
      </p>
      <p>
        <label for="prenom" title="Votre prenom">Votre prénom :</label>
        <input name="prenom" type="text" id="prenom" class="input300" value="" size="30" />
      </p>
      <p>
        <label for="email" title="Votre adresse email">Votre adresse email* :</label>
        <input name="email" type="text" id="email" class="input300" value="" size="30" />
      </p>      
      <p>
        <label for="pointVente" title="Point de vente">Point de vente* :</label>
        <select name="pointVente" id="pointVente"><?php foreach ($pointsDeVente as $point) { ?><option value="<?php echo $point->pointDeVente;?>"><?php echo $point->pointDeVente;?></option><?php } ?></select>
      </p>
      <p>&nbsp;</p>      
      <p>
        <label for="Satisfaction" title="Satisfaction globale">Satisfaction globale :</label>
        <select name="notes[satisfaction]" id="notes[satisfaction]" class="select50">
          <option value=1>1</option>
          <option value=2>2</option>
          <option value=3>3</option>
          <option value=4>4</option>
          <option value=5>5</option>
          <option value=6>6</option>
          <option value=7>7</option>
          <option value=8>8</option>
          <option value=9>9</option>
          <option value=10 selected>10</option>
        </select>
      </p>
      <p>
        <label for="attente" title="Temps d'attente">Temps d'attente :</label>
        <select name="notes[attente]" id="notes[attente]" class="select50">
          <option value=1>1</option>
          <option value=2>2</option>
          <option value=3>3</option>
          <option value=4>4</option>
          <option value=5>5</option>
          <option value=6>6</option>
          <option value=7>7</option>
          <option value=8>8</option>
          <option value=9>9</option>
          <option value=10 selected>10</option>
        </select>
      </p>
      <p>
        <label for="qualite" title="Qualit&eacute; des produits">Qualit&eacute; des produits :</label>
        <select name="notes[qualite]" id="notes[qualite]" class="select50">
          <option value=1>1</option>
          <option value=2>2</option>
          <option value=3>3</option>
          <option value=4>4</option>
          <option value=5>5</option>
          <option value=6>6</option>
          <option value=7>7</option>
          <option value=8>8</option>
          <option value=9>9</option>
          <option value=10 selected>10</option>
        </select>
      </p>
      <p>
        <label for="diversite" title="Diversit&eacute; des recettes">Diversit&eacute; des recettes :</label>
        <select name="notes[diversite]" id="notes[diversite]" class="select50">
          <option value=1>1</option>
          <option value=2>2</option>
          <option value=3>3</option>
          <option value=4>4</option>
          <option value=5>5</option>
          <option value=6>6</option>
          <option value=7>7</option>
          <option value=8>8</option>
          <option value=9>9</option>
          <option value=10 selected>10</option>
        </select>
      </p>
      <p>
        <label for="accueil" title="Accueil">Accueil :</label>
        <select name="notes[accueil]" id="notes[accueil]" class="select50">
          <option value=1>1</option>
          <option value=2>2</option>
          <option value=3>3</option>
          <option value=4>4</option>
          <option value=5>5</option>
          <option value=6>6</option>
          <option value=7>7</option>
          <option value=8>8</option>
          <option value=9>9</option>
          <option value=10 selected>10</option>
        </select>
      </p>
      <p>
        <label for="ambiance" title="Ambiance g&eacute;n&eacute;rale">Ambiance g&eacute;n&eacute;rale :</label>
        <select name="notes[ambiance]" id="notes[ambiance]" class="select50">
          <option value=1>1</option>
          <option value=2>2</option>
          <option value=3>3</option>
          <option value=4>4</option>
          <option value=5>5</option>
          <option value=6>6</option>
          <option value=7>7</option>
          <option value=8>8</option>
          <option value=9>9</option>
          <option value=10 selected>10</option>
        </select>
      </p>
      <p>
        <label for="salade" title="Votre avis sur les salades">Votre avis sur les salades :</label>
        <select name="notes[salade]" id="notes[salade]" class="select50">
          <option value=1>1</option>
          <option value=2>2</option>
          <option value=3>3</option>
          <option value=4>4</option>
          <option value=5>5</option>
          <option value=6>6</option>
          <option value=7>7</option>
          <option value=8>8</option>
          <option value=9>9</option>
          <option value=10 selected>10</option>
        </select>
      </p>
      <p>
        <label for="salade" title="Votre avis sur les soupes">Votre avis sur les soupes :</label>
        <select name="notes[soupes]" id="notes[soupes]" class="select50">
          <option value=1>1</option>
          <option value=2>2</option>
          <option value=3>3</option>
          <option value=4>4</option>
          <option value=5>5</option>
          <option value=6>6</option>
          <option value=7>7</option>
          <option value=8>8</option>
          <option value=9>9</option>
          <option value=10 selected>10</option>
        </select>
      </p>      
      <p>
        <label for="boisson" title="Votre avis sur les boissons">Votre avis sur les jus et smoothies :</label>
        <select name="notes[boisson]" id="notes[boisson]" class="select50">
          <option value=1>1</option>
          <option value=2>2</option>
          <option value=3>3</option>
          <option value=4>4</option>
          <option value=5>5</option>
          <option value=6>6</option>
          <option value=7>7</option>
          <option value=8>8</option>
          <option value=9>9</option>
          <option value=10 selected>10</option>
        </select>
      </p>
      <p>
        <label for="comentaire" title="Vos commentaires"><strong>Vos commentaires :</strong></label>
        <textarea name="commentaire" cols="40" rows="6" id="commentaire" class="input300"></textarea>
      </p>
      <p style="margin:0 0 20px 50px;"><input name="mailing" type="checkbox" value="1" checked="checked">
        Je souhaite  &ecirc;tre inform&eacute; des 
      nouveaut&eacute;s et promotions de la boutique.</p>
      <p><input name="obligatoire" type="hidden" id="obligatoire" value="email-votre adresse email" />
        <input type="submit" name="Enregistrer" id="Enregistrer" value="Enregistrer" class="bouton" />
      </p>
      </div>
    </form>
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
