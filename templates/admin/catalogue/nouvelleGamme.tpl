<script>
function annuler(){
	window.location.replace("?fonction=demandeModifierGamme");
}

function verifSaisie()
{
	test = 0; 
	if (document.formulaire.nom.value=='')
	{
		test = 1;
	}
	if (test==1)
	{
		alert ('Vous devez saisir un nom.');
		return false
	}
	else
	{
		return true;
	}
}
</script>
<form name="formulaire" method="get" onsubmit="return verifSaisie();return false;">
<table class="contenu">
<tr><td colspan="2" class="sousTitre" >Gérer mes rubriques</td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="69%" valign="top">
		<table class="contenu">
		<tr>
			<td width="18%" valign="middle" align="right"><b>Nom :</b></td>
			<td width="82%"><input type="text" name="nom" size="39" value="{nom}"></td>
		</tr>
		<!--
		<tr>
			<td align="right" valign="top">Description</td>
			<td><textarea name="description" cols="30" rows="10" id="description">{description}</textarea></td>
		</tr>
		-->
		<tr>
			<td align="right" valign="top"><b>Affichage :</b></td>
			<td>
			<select name="ordre_aff" class="select">
			<!-- BEGIN ordre_aff -->
			<option value="{ordre_aff.value}" {ordre_aff.selected} >{ordre_aff.value}</option>
			<!-- END ordre_aff -->
			</select>
			</td>
		</tr>
		<tr>
			<td width="18%" valign="middle" align="right"><b>En ligne :</b></td>
			<td width="82%">
			<input name="en_ligne" value="1" type="radio" {en_ligne}>Oui&nbsp;<input name="en_ligne" value="0" type="radio" {hors_ligne}>Non
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type="submit" name="Submit" value="Valider" class="bouton">&nbsp;&nbsp;<input type="button" onclick="annuler();" value="Annuler" class="bouton"></td>
		</tr>
		</table>
	</td>
	<td width="1%">&nbsp;</td>
	<td width="30%" valign="top">
		<table class="contenu">
		<tr>
			<td>Toutes les rubriques ({nb_gamme})</td>
		</tr>
		
		<tr>
			<td>
			<select size="12" class="contenu">
			<!-- BEGIN gamme -->
			<option>{gamme.nom}</option>
			<!-- END gamme -->
			</select>
			</td>
		</tr>
		</table>
	</td>
</tr>
</table>
<input type="hidden" name="fonction" value="traiterNouvelleGamme">
</form>