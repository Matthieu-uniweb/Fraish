<div style="display: block; float: left; clear: right;">

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

function supprimer(id){
	if (confirm("Voulez vous réellement supprimer cet actualité ?")){
			window.location.replace('?fonction=traiterSupprimerActu&idactu='+id);			
		}
}	

</script>


<table class="contenu" >
<tr><td colspan="3" class="sousTitre" >Gestion des actualités<br><br></td></tr>
<!-- BEGIN actus -->
<tr style="background-color: #{actus.bgcolor};">
	<td>{actus.texte}</td>
	<td><a class="fo" href="?fonction=demandeModifierActu&id_actu={actus.idactu}">Modifier</a></td>
	<td><a class="fo" href="#" onclick="javascript:supprimer({actus.idactu});return false;">Supprimer</a></td>
</tr>
<!-- END actus -->	
<tr><td colspan="3"><a class="fo" href="?fonction=demandeNouvelleActu"><br><br>+ Ajouter une actualité</a></td></tr>
</table>

</div>

