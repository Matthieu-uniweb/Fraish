<script>
function nouvelle(){
	window.location.replace("?fonction=demandeNouvelleGamme");
}

function supprimer(){
	if (confirm("Voulez vous réellement supprimer cette gamme ?")){
		if (document.formulaire.elements['gamme'].selectedIndex=='0'){
			alert('Vous devez choisir une gamme');
		}else{
			window.location.replace('?fonction=traiterSupprimerGamme&gamme='+formulaire.gamme.value);			
		}
	}	
}

function goto(targ,selObj,restore)
{
	document.location='?fonction=demandeModifierGamme&gamme='+selObj.options[selObj.selectedIndex].value;
}
function showImage()
{
	document.getElementById('bouton').style.visibility='visible';
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
<form name="formulaire" method="get" onsubmit="return verifSaisie();return false;" >
<table class="contenu">
<tr><td colspan="2" class="sousTitre" >Gérer mes rubriques</td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="69%" valign="top">
		<table class="contenu">
		<tr>
			<td width="18%" valign="middle" align="right"></td>
			<td width="82%">
			<input type="button" onclick="nouvelle();" value="Nouvelle rubrique" class="bouton">
			</td>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
			<td width="18%" valign="middle" align="right"><b>Rubrique :</b></td>
			<td width="82%">
			<select name="gamme" onChange="goto('parent',this,0);" class="select">
			<option>Liste des rubriques</option>
			<!-- BEGIN gamme -->
			<option value="{gamme.id}" {gamme.selected} >{gamme.nom}</option>
			<!-- END gamme -->
			</select>
			</td>
		</tr>
		<tr>
			<td width="18%" valign="middle" align="right"><b>Nom :</b></td>
			<td width="82%"><input type="text" name="nom" size="39" value="{nom}"></td>
		</tr>
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
			<td><input type="submit" name="Submit" value="Modifier" class="bouton">&nbsp;&nbsp;<input type="button" onclick="supprimer();" value="Supprimer" class="bouton"></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td class="alert">{message}</td>
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
<input type="hidden" name="fonction" value="traiterModifierGamme">
</form>
