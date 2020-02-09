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


<div style="display: block; float: left;">

<form name="formulaire" method="post" enctype="multipart/form-data">
Saisissez votre titre :<br />
<input type="text" name="titre" size="60" />
<br /><br />
Saisissez la date :<br />
<input type="text" id="datepicker" name="datee" />
  
<br /><br />
Saisissez votre texte :<br />
<textarea name="content" cols="83" rows="25" id="content" class="tinymce"></textarea>
<br /><br />
<input type="file" name="photo" class="bouton"><br /><i>(Image au format JPEG)</i>
<br /><br />

<input type="checkbox" name="mailing" value="oui" /> <b>Envoyer un mail aux franchisés pour les informer d'une nouvelle actualité</b> <br />

<br />
<br />
<input type="submit" name="Submit" value="Valider" class="bouton">&nbsp;&nbsp;<input type="button" onclick="annuler();" value="Annuler" class="bouton">
<input type="hidden" name="fonction" value="traiterNouvelleActu">
</form>

</div>