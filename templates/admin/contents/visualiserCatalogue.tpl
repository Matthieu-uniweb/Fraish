<script>
function modifier_article(gamme,rayon,article)
	{
		document.location='?fonction=demandeModifierArticle&gamme='+gamme+'&rayon='+rayon+'&article='+article;
	}

function change_gamme(show_gamme)
	{		
		if(show_gamme.style.display == "none"){
			show_gamme.style.display = "";
		}else {
	        show_gamme.style.display = "none";       
		}	    		
	}

function change_rayon(show_rayon)
	{		
		if(show_rayon.style.display == "none"){
			show_rayon.style.display = "";
		}else {
	        show_rayon.style.display = "none";       
		}	    		
	}
	
function change_statut_article(targ,selObj,restore)
{
	document.location='?fonction=traiterStatutArticle&article='+selObj.name+'&en_ligne='+selObj.value;
}

</script>
<table class="contenu" width="99%">
<tr><td colspan="2" class="sousTitre" >Visualiser mon catalogue</td></tr>

<tr><td colspan="2">&nbsp;</td></tr>

<!-- BEGIN gamme -->
<tr><td bgcolor="#F2F2F2" height="25" colspan="2" style="border-bottom-style:solid; border-bottom-width:1px; border-bottom-color:#e8b601;"><font color="#e8b601">&nbsp;#</font>&nbsp;<a href="javascript:change_gamme(show_{gamme.id});" class="fonction" title="Visualiser la gamme : {gamme.nom}"><b>{gamme.nom}</b></a>&nbsp;&nbsp;- <i>cette gamme contient {gamme.nb_rayon} rayon(s) </i></td></tr>

<tr><td colspan="2">
<span id="show_{gamme.id}" style="display:none;">
<table class="contenu" width="100%">
	<!-- BEGIN rayon -->
	<tr><td width="10%"></td>
	<td valign="top" width="90%" bgcolor="#F2F2F2" height="18" style="border-bottom-style:solid; border-bottom-width:1px; border-bottom-color:#333333;">&nbsp;#&nbsp;<b>{gamme.rayon.nom}</b>&nbsp;&nbsp;- <i>ce rayon contient {gamme.rayon.nb_article} article(s) </i></td></tr>	
	<!-- BEGIN article -->
	<tr><td width="10%"></td>
	<td valign="top" width="90%">
		<table class="contenu" width="99%">
			<tr>
				<td valign="top" width="35%" align="center">{gamme.rayon.article.photo}<br><br><input type="button" onclick="modifier_article('{gamme.id}','{gamme.rayon.id}','{gamme.rayon.article.id}');" value="Modifier cet article" class="bouton"></td>
				<td valign="top" width="65%"><b>{gamme.rayon.article.nom}</b><br>{gamme.rayon.article.prix}&nbsp;&euro;<br>
				(Vendu par {gamme.rayon.article.quantite_mini}, soit {gamme.rayon.article.prix_unitaire} l'unité)
				<br><br>{gamme.rayon.article.description}<br>
				<br>
				<u>Etat de l'article :</u> {gamme.rayon.article.etat_article}<br>
				<u>En ligne :</u> <input name="en_ligne_{gamme.rayon.article.id}" value="1" type="radio" {gamme.rayon.article.en_ligne} onClick="change_statut_article('parent',this,0);">Oui&nbsp;<input name="en_ligne_{gamme.rayon.article.id}" value="0" type="radio" {gamme.rayon.article.hors_ligne} onClick="change_statut_article('parent',this,0);">Non&nbsp;
				</td>
			</tr>
			<tr><td colspan="2" style="border-bottom-style:solid; border-bottom-width:1px; border-bottom-color:#999999;">&nbsp;</td></tr>
		</table>
	</td></tr>
	<!-- END article -->	
	<!-- END rayon -->
</table>
</span>
</td></tr>

<!-- END gamme -->
</table>