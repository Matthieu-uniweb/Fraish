

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


<div style="display: block; float: left;">
Gestion des contenus des pages du site <br ><br >

<a class="fo" href="?fonction=demandeNouvelContent"><br><br>+ Saisir les contenus d'une page</a>


</div>

