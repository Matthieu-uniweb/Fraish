
<script>

function gotoGamme(targ,selObj,restore)
{
	document.location='?fonction=demandeNouvelContent&id_rub='+selObj.options[selObj.selectedIndex].value;
}


function verif()
{
		if (document.forms['formulaire'].elements['gamme'].selectedIndex=='0')
		{
			alert('Choisir une rubrique');
			return false;
		}
		else
		{
			return verifSaisie();
		}
}


</script>

<div style="display: block; float: left;">

Saisie des contenus d'une page

<form name="formulaire" method="post" onsubmit="return verif();return false;" enctype="multipart/form-data">
  
  
  Rubrique : 
  <select name="rubrique" onChange="gotoGamme('parent',this,0);" class="select">
      <option>Liste des rubriques</option>
      <!-- BEGIN rub -->
      <option value="{rub.id}" {rub.selected} >{rub.nom}</option>
      <!-- END rub -->
  </select>
  <br /><br />
    
  
Saisissez votre titre :<br />
<input type="text" name="titre" size="60" value="{titre}" />
  
<br /><br />
Saisissez votre texte :<br />
<textarea name="content" cols="83" rows="25" id="content" class="tinymce">{texte}</textarea>


<br /><br />
<input type="submit" name="Submit" value="Valider" class="bouton">
<input type="hidden" name="id_content" value="{id_content}">
<input type="hidden" name="fonction" value="traiterNouvelContent">
</form>

</div>


