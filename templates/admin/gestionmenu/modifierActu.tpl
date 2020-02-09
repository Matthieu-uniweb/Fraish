<script>
function annuler(){
	window.location.replace("?fonction=listerActus");
}

function verifSaisie()
{
	test = 0; 
	if (document.formulaire.content.value=='')
	{
		test = 1;
	}
	if (test==1)
	{
		alert ('Vous devez saisir le texte de votre actualité');
		return false;
	}
	else
	{
		return true;
	}
}

</script>

<script type="text/javascript" src="./js/jquery-1.5.min.js"></script>
<script type="text/javascript" src="./js/tiny_mce/jquery.tinymce.js"></script>
<script type="text/javascript" src="./js/tmce.js"></script>

<div style="display: block; float: left;">

<form name="formulaire" method="post" onsubmit="return verifSaisie();return false;" enctype="multipart/form-data">
  Saisissez votre titre :<br />
<input type="text" name="titre" value="{titre}" size="60" />
<br /><br />
Saisissez votre texte :<br />
<textarea name="content" cols="83" rows="25"  id="content" class="tinymce">{texte}</textarea>
<br /><br />
{photo}<br /><br />
<input type="file" name="photo" class="bouton"><br /><i>(Image au format JPEG)</i>
<br /><br />
<input type="submit" name="Submit" value="Valider" class="bouton">&nbsp;&nbsp;<input type="button" onclick="annuler();" value="Annuler" class="bouton">
<input type="hidden" name="fonction" value="traiterModifierActu">
<input type="hidden" name="id_actu" value="{id_actu}">
<input type="hidden" name="id_photo" value="{id_photo}">
</form>

</div>