<script>
function annuler(){
	window.location.replace("?fonction=demandeModifierEvt");
}

function gotoCategorie(targ,selObj,restore)
{
	document.location='?fonction=demandeNouvelEvt&categorie='+selObj.options[selObj.selectedIndex].value;
}

function verif()
{
		if (document.forms['formulaire'].elements['categorie'].selectedIndex=='0')
		{
			alert('Choisir une cat�gorie');
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
		alert ('Vous devez saisir un nom d\'article');
		return false;
	}
	else
	{
		return true;
	}
}
</script>
<form name="formulaire" method="post" onsubmit="return verif();return false;" enctype="multipart/form-data">
<table class="contenu">
<tr><td colspan="2" class="sousTitre" >G�rer mon �v�nementiel</td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="98%" valign="top">
		<table class="contenu">
		<tr>
			<td width="20%" valign="middle" align="right"><b>Cat�gorie :</b></td>
			<td width="80%">
			<select name="categorie" onChange="gotoCategorie('parent',this,0);" class="select">
			<option>Liste des cat�gories</option>
			<!-- BEGIN categorie -->
			<option value="{categorie.id}" {categorie.selected} >{categorie.nom}</option>
			<!-- END categorie -->
			</select>
			</td>
		</tr>		
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
			<td class="sousTitre" colspan="2" style="background-color:#e7e6e2"><img src="styles/admin/picto/bloc_note.png" style="vertical-align:middle">&nbsp;Gestion des textes  de l'�v�nement</td>
		</tr>
		<tr><td style="height:7px; background-color:#e8b601" colspan="2"></td></tr>
		<tr>
			<td width="20%" valign="middle" align="right"><b>Nom :</b></td>
			<td width="80%"><input type="text" name="nom" value="{nom}" size="87"></td>
		</tr>
		<tr>
		<td width="20%" valign="middle" align="right"><b>Date :</b></td>
		<td width="80%"><input type="text" name="date" size="8" value="{date}" readonly="yes">&nbsp;
			<a href="#" onClick="javascript:window.open('class/commun/calendrier.php?form=formulaire&elem=date','Calendrier','width=200,height=250')"><img src="styles/admin/calendrier.gif" border="0"></a>
		</td>
		</tr>
		<tr>
			<td align="right" valign="top"><b>Description :</b></td>
			<td>{editor_1}</td>
		</tr>
		<tr>
			<td align="right" valign="top"><b>Texte :</b></td>
			<td>{editor_2}</td>
		</tr>		
		<tr>
			<td width="20%" valign="middle" align="right"><b>En ligne :</b></td>
			<td width="80%">
			<input name="en_ligne" value="1" type="radio" checked>Oui&nbsp;<input name="en_ligne" value="0" type="radio">Non
			</td>
		</tr>			
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
			<td width="20%"></td>
			<td width="80%" style="display:{display_une};" valign="middle">
			<input type="checkbox" value="1" name="a_la_une" style="vertical-align:middle;">&nbsp;Mettre � la Une
			</td>
		</tr>
		
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
			<td class="sousTitre" colspan="2" style="background-color:#e7e6e2"><img src="styles/admin/picto/dossier_photos.png" style="vertical-align:middle">&nbsp;Gestion des photos de l'�v�nement</td>
		</tr>
		<tr><td style="height:7px; background-color:#e8b601" colspan="2"></td></tr>
		<tr>
			<td align="right" valign="top"><b>Photo :</b></td>
			<td width="80%"><input type="file" name="photo" class="bouton"></td>
		</tr>
		
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
			<td class="sousTitre" colspan="2" style="background-color:#e7e6e2"><img src="styles/admin/picto/pdf.png" style="vertical-align:middle">&nbsp;Gestion des documents PDF de l'article</td>
		</tr>
		<tr><td style="height:7px; background-color:#e8b601" colspan="2"></td></tr>
		<tr>
			<td align="right" valign="top"><b>PDF associ� :</b></td>
			<td width="82%"><input type="file" name="pdf" class="bouton"></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type="submit" name="Submit" value="Valider" class="bouton">&nbsp;&nbsp;<input type="button" onclick="annuler();" value="Annuler" class="bouton"></td>
		</tr>
		</table>
	</td>	
</tr>
</table>
<input type="hidden" name="fonction" value="traiterNouvelEvt">
</form>