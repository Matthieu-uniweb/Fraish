

<script type="text/javascript">
	
function change_statut_article(targ,selObj,restore)
{
	document.location='?fonction=traiterStatutArticle&article='+selObj.name+'&en_ligne='+selObj.value;
}

function supprimerCat(id){
	if (confirm("Voulez vous réellement supprimer cette catégorie (ainsi que ses sous catégories et produits) ?")){
			window.location.replace('?fonction=traiterSupprimerCategorie&id_cat='+id);
		}
}	

function supprimerSsCat(id){
	if (confirm("Voulez vous réellement supprimer cette sous-catégorie (ainsi que ses produits)?")){	
			window.location.replace('?fonction=traiterSupprimerSsCategorie&id_ss_cat='+id);			
		}
}
</script>


<div style="display: block; float: left;">
Gestion de l'arborescence <br ><br >




<a href="?fonction=ajouterCategorie" class="fo"><img src="styles/admin/picto/add.jpg" /> Ajouter une nouvelle catégorie</a>
<table>
<!-- BEGIN categories -->
<tr style="background-color: #dddddd;">	
	<td colspan="2" width="500" >{categories.titre}</td>  
	<td>
		<a class="fo" href="#" onclick="javascript:supprimerCat({categories.id});return false;"><img src="styles/admin/picto/delete.jpg" alt="supprimer" /></a>
		<a class="fo" href="?fonction=demandeModifierCategorie&id_cat={categories.id}" ><img src="styles/admin/picto/edit.jpg" alt="modifier" /></a>		
	</td>
</tr>

	<!-- BEGIN sscategories -->
	<tr>
		<td width="50">&nbsp;</td>  
		<td>{categories.sscategories.titre}</td>  
		<td>
			<a class="fo" href="#" onclick="javascript:supprimerSsCat({categories.sscategories.id});return false;"><img src="styles/admin/picto/delete.jpg" alt="supprimer" /></a>
			<a class="fo" href="?fonction=demandeModifierSsCategorie&id_ss_cat={categories.sscategories.id}" ><img src="styles/admin/picto/edit.jpg" alt="modifier" /></a>			
		</td>
	</tr>
	<!-- END sscategories -->	
	
	<tr>
		<td width="50">&nbsp;</td> 
		<td colspan="2"><a href="?fonction=ajouterSsCategorie&cat={categories.id}" class="fo"><img src="styles/admin/picto/add.jpg" /> Ajouter une nouvelle sous-catégorie</a></td>		
	</tr>	

<!-- END categories -->  

</table>
<br /><br /><br /><br />




</div>

