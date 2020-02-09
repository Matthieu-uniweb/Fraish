<script>
function annuler(){
	window.location.replace("?fonction=afficherMenu");
}

function verif()
{	
	if (document.formulaire.titre.value==''){
		alert ('Vous devez saisir le titre de la nouvelle catégorie');
		return false;
	}
	
	else{
		return true;
	}
}

</script>


<div style="display: block; float: left;">


<form name="formulaire" method="post" enctype="multipart/form-data" onsubmit="return verif();return false;">

Saisissez le nouveau titre de la catégorie :<br />
<input type="text" name="titre" size="60" />
  
<br /><br />

<br /><br />
<input type="submit" name="Submit" value="Valider" class="bouton">&nbsp;&nbsp;<input type="button" onclick="annuler();" value="Annuler" class="bouton">
<input type="hidden" name="fonction" value="traiterModifierCategorie">
<input type="hidden" name="id_cat" value="{cat}">
</form>

</div>