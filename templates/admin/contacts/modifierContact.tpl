<script>
function annuler(){
	window.location.replace("?fonction=listerContacts");
}

</script>

<script type="text/javascript" src="./js/jquery-1.5.min.js"></script>
<script type="text/javascript" src="./js/tiny_mce/jquery.tinymce.js"></script>
<script type="text/javascript" src="./js/tmce.js"></script>

<div style="display: block; float: left;">

<form name="formulaire" method="post" onsubmit="return verifSaisie();return false;" enctype="multipart/form-data">
	
	
	Ville : <br />
	<input type="text" name="ville" value="{ville}" size="60" />
	<br />
	Prenom :<br />
	<input type="text" name="prenom" value="{prenom}" size="60" />
	<br />
	nom :<br />
	<input type="text" name="nom" value="{nom}" size="60" />
	<br />
	Téléphone :<br />
	<input type="text" name="tel" value="{tel}" size="60" />
	<br />
	Email :<br />
	<input type="text" name="email" value="{email}" size="60" />
	<br />
	Responsable :<br /> 
	<input type="text" name="resp" value="{resp}" size="60" />
	
	
  

<br /><br />
<input type="submit" name="Submit" value="Valider" class="bouton">&nbsp;&nbsp;<input type="button" onclick="annuler();" value="Annuler" class="bouton">
<input type="hidden" name="fonction" value="traiterModifierContacts">
<input type="hidden" name="id_contact" value="{id_contact}">

</form>

</div>