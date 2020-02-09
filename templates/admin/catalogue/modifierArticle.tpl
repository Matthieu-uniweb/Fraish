<script>
	function supprimer_doc(doc){
	if (confirm("Voulez vous r�ellement supprimer ce document associ� ?")){
			window.location.replace('?fonction=traiterSupprimerDocument&document='+doc+'&article='+formulaire.article.value+'&gamme='+formulaire.gamme.value+'&rayon='+formulaire.rayon.value);			
		}
}

function nouveau(){
	window.location.replace("?fonction=demandeNouvelArticle");
}

function supprimer(){
	if (document.formulaire.elements['gamme'].selectedIndex=='0' || document.formulaire.elements['rayon'].selectedIndex=='0' || document.formulaire.elements['article'].selectedIndex=='0'){
			alert('Vous devez choisir un article');
	}else{
		if (confirm("Voulez vous r�ellement supprimer cet article ?")){
			window.location.replace('?fonction=traiterSupprimerArticle&article='+formulaire.article.value+'&gamme='+formulaire.gamme.value+'&rayon='+formulaire.rayon.value);			
		}
	}	
}

function gotoGamme(targ,selObj,restore)
{
	document.location='?fonction=demandeModifierArticle&gamme='+selObj.options[selObj.selectedIndex].value;
}

function gotoRayon(targ,selObj,restore)
{
	document.location='?fonction=demandeModifierArticle&gamme='+document.formulaire.gamme.value+'&rayon='+selObj.options[selObj.selectedIndex].value;
}

function gotoArticle(targ,selObj,restore)
{
	document.location='?fonction=demandeModifierArticle&gamme='+document.formulaire.gamme.value+'&rayon='+document.formulaire.rayon.value+'&article='+selObj.options[selObj.selectedIndex].value;
}

function verifRayon()
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

function verifSaisie()
{
	test = 0; 
	if (document.formulaire.nom.value=='')
	{
		test = 1;
	}
	if (test==1)
	{
		alert ('Vous devez saisir un titre');
		return false;
	}
	else
	{
		return true;
	}
}
</script>
<form name="formulaire" method="post" onsubmit="return verifRayon();return false;" enctype="multipart/form-data">
<table class="contenu">
<tr><td colspan="2" class="sousTitre" >G�rer mes articles</td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="98%" valign="top">
		<table class="contenu">
		<tr>
			<td width="18%" valign="middle" align="right"></td>
			<td width="82%">
			<input type="button" onclick="nouveau();" value="Nouvel Article" class="bouton">
			</td>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
			<td width="18%" valign="middle" align="right"><b>Rubriques :</b></td>
			<td width="82%">
			<select name="gamme" onChange="gotoGamme('parent',this,0);" class="select">
			<option>Liste des Rubriques</option>
			<!-- BEGIN gamme -->
			<option value="{gamme.id}" {gamme.selected} >{gamme.nom}</option>
			<!-- END gamme -->
			</select>
			</td>
		</tr>
		<tr>
			<td width="18%" valign="middle" align="right"><b>Sous-rubriques :</b></td>
			<td width="82%">
			<select name="rayon" onChange="gotoRayon('parent',this,0);" class="select">
			<option>Liste des Sous-rubriques</option>
			<!-- BEGIN rayon -->
			<option value="{rayon.id}" {rayon.selected} >{rayon.nom}</option>
			<!-- END rayon -->
			</select>
			</td>
		</tr>
		<tr>
			<td width="18%" valign="middle" align="right"><b>Article :</b></td>
			<td width="82%">
			<select name="article" onChange="gotoArticle('parent',this,0);" class="select">
			<option>Liste des articles</option>
			<!-- BEGIN article -->
			<option value="{article.id}" {article.selected} >{article.nom}</option>
			<!-- END article -->
			</select>
			</td>
		</tr>
		
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
			<td class="sousTitre" colspan="2" style="background-color:#e7e6e2"><img src="styles/admin/picto/bloc_note.png" style="vertical-align:middle">&nbsp;Gestion des textes  de l'article</td>
		</tr>
		<tr><td style="height:7px; background-color:#e8b601" colspan="2"></td></tr>
		<tr>
			<td width="18%" valign="middle" align="right"><b>Nom :</b></td>
			<td width="82%"><input type="text" name="nom" value="{nom}" size="87"></td>
		</tr>
		<tr>
		<td width="20%" valign="middle" align="right"><b>Date :</b></td>
		<td width="80%"><input type="text" name="date" size="8" value="{date}" readonly="yes">&nbsp;
			<a href="#" onClick="javascript:window.open('class/commun/calendrier.php?form=formulaire&elem=date','Calendrier','width=200,height=250')"><img src="styles/admin/calendrier.gif" border="0"></a>
		</td>
		</tr>
		<!--
		<tr>
			<td align="right" valign="top"><b>Description :</b></td>
			<td>{editor_1}</td>
		</tr>
		-->
		<tr>
			<td align="right" valign="top"><b>Texte :</b></td>
			<td>{editor_2}</td>
		</tr>
		<tr>
			<td width="18%" valign="middle" align="right"><b>En ligne :</b></td>
			<td width="82%">
			<input name="en_ligne" value="1" type="radio" {en_ligne}>Oui&nbsp;<input name="en_ligne" value="0" type="radio" {hors_ligne}>Non
			</td>
		</tr>	
		
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
			<td class="sousTitre" colspan="2" style="background-color:#e7e6e2"><img src="styles/admin/picto/dossier_photos.png" style="vertical-align:middle">&nbsp;Gestion des photos de l'article</td>
		</tr>
		<tr><td style="height:7px; background-color:#e8b601" colspan="2"></td></tr>
		<!-- BEGIN photos -->	
		<tr>
			<td align="right" valign="top"></td>
			<td width="82%">&nbsp;{photos.img}</td>
		</tr>
		<tr>
			<td align="right" valign="top"><b>{photos.title} :</b></td>
			<td width="82%">&nbsp;<input type="file" name="photo_{photos.num}" class="bouton"><br><i>(Image au format JPEG)</i></td>
		</tr>
		<!-- END photos -->
		
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
			<td class="sousTitre" colspan="2" style="background-color:#e7e6e2"><img src="styles/admin/picto/pdf.png" style="vertical-align:middle">&nbsp;Gestion des documents PDF de l'article</td>
		</tr>
		<tr><td style="height:7px; background-color:#e8b601" colspan="2"></td></tr>
		<tr>
			<td align="right" valign="top"><b>PDF associ� :</b></td>
			<td width="82%">{pdf}&nbsp;<input type="file" name="pdf" class="bouton"></td>
		</tr>
		
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;<input type="submit" name="Submit" value="Modifier" class="bouton">&nbsp;&nbsp;<input type="button" onclick="supprimer();" value="Supprimer" class="bouton"></td>
		</tr>
		</table>
	</td>
</tr>
</table>
<input type="hidden" name="fonction" value="traiterModifierArticle">
</form>