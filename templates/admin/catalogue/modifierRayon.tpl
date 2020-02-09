<script>
function nouveau(){
	window.location.replace("?fonction=demandeNouveauRayon");
}

function supprimer(){
	if (confirm("Voulez vous réellement supprimer cette sous-rubrique ?")){
		if (document.formulaire.elements['gamme'].selectedIndex=='0' || document.formulaire.elements['rayon'].selectedIndex=='0' ){
			alert('Vous devez choisir une rubrique et une sous-rubrique');
		}else{
			window.location.replace('?fonction=traiterSupprimerRayon&rayon='+formulaire.rayon.value);			
		}
	}	
}

function gotoGamme(targ,selObj,restore)
{
	document.location='?fonction=demandeModifierRayon&gamme='+selObj.options[selObj.selectedIndex].value;
}

function gotoRayon(targ,selObj,restore)
{
	document.location='?fonction=demandeModifierRayon&gamme='+document.formulaire.gamme.value+'&rayon='+selObj.options[selObj.selectedIndex].value;
}

function verifRayon()
{
		if (document.forms['formulaire'].elements['gamme'].selectedIndex=='0')
		{
			alert('Choisir une gamme');
			return false;
		}
		else
		{
			return verifSaisie();
		}
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
		alert ('Vous devez saisir un nom de sous-rubrique');
		return false;
	}
	else
	{
		return true;
	}
}
</script>
<form name="formulaire" method="get" onsubmit="return verifRayon();return false;">
<table class="contenu">
<tr><td colspan="2" class="sousTitre" >Gérer mes sous-rubriques</td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="69%" valign="top">
		<table class="contenu">
		<tr>
			<td width="25%" valign="middle" align="right"></td>
			<td width="75%">
			<input type="button" onclick="nouveau();" value="Nouvelle sous-rubrique" class="bouton">
			</td>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
			<td width="25%" valign="middle" align="right"><b>Rubrique :</b></td>
			<td width="75%">
			<select name="gamme" onChange="gotoGamme('parent',this,0);" class="select">
			<option>Liste des Rubriques</option>
			<!-- BEGIN gamme -->
			<option value="{gamme.id}" {gamme.selected} >{gamme.nom}</option>
			<!-- END gamme -->
			</select>
			</td>
		</tr>
		<tr>
			<td width="25%" valign="middle" align="right"><b>Sous-rubrique :</b></td>
			<td width="75%">
			<select name="rayon" onChange="gotoRayon('parent',this,0);" class="select">
			<option>Liste des sous-rubriques</option>
			<!-- BEGIN rayon -->
			<option value="{rayon.id}" {rayon.selected} >{rayon.nom}</option>
			<!-- END rayon -->
			</select>
			</td>
		</tr>
		<tr>
			<td width="25%" valign="middle" align="right"><b>Nom :</b></td>
			<td width="75%"><input type="text" name="nom" value="{nom}" size="39"></td>
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
			<td>Toutes les sous-rubriques de la rubrique ({nb_rayon})</td>
		</tr>
		
		<tr>
			<td>
			<select size="16" class="contenu">
			<!-- BEGIN rayon -->
			<option>{rayon.nom}</option>
			<!-- END rayon -->
			</select>
			</td>
		</tr>
		</table>
	</td>
</tr>
</table>
<input type="hidden" name="fonction" value="traiterModifierRayon">
</form>