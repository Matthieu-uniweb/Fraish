<script>
function verifSaisie()
{
	test = 0; 
	if (document.formulaire.table.value==''){
		test = 1;
	}
	if (test==1){
		alert ('Vous devez saisir le nom de la table');
		return false;
	}else{
		return true;
	}
}
</script>
<form name="formulaire" method="post" onsubmit="return verif();return false;" enctype="multipart/form-data">
<table class="contenu">
<tr><td colspan="2" class="sousTitre" >Migrer mes articles</td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="98%" valign="top">
		<table class="contenu">
		<tr>
			<td width="18%" valign="middle" align="right"><b>Table :</b></td>
			<td width="82%"><input type="text" name="table" value="{table}" size="20" maxlength="32"></td>
		</tr>
		<tr>
			<td width="18%" valign="middle" align="right"><b>Rayon :</b></td>
			<td width="82%"><input type="text" name="rayon" value="{rayon}" size="6" maxlength="5"></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type="submit" name="Submit" value="Valider" class="bouton"></td>
		</tr>
		</table>
	</td>	
</tr>
</table>
<input type="hidden" name="fonction" value="traiterMigrationArticle">
</form>