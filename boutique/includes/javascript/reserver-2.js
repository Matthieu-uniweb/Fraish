function affichageMenuSoupes()
{
	document.getElementById('tableauSoupes').style.visibility = "visible";
	document.getElementById('tableauSoupes').style.display= "block";
	document.getElementById('tableauSalades').style.visibility = "hidden";
	document.getElementById('tableauSalades').style.display = "none";
	document.getElementById('tableauSalades2').style.visibility = "hidden";
	document.getElementById('tableauSalades2').style.display = "none";
	document.getElementById('tableauSalades3').style.visibility = "hidden";
	document.getElementById('tableauSalades3').style.display = "none";	
	document.getElementById('choixMenuD').style.visibility = "visible";
	document.getElementById('choixMenuG').style.visibility = "visible";
	return true;
}
function affichageMenuSalades()
{
	document.getElementById('tableauSalades').style.visibility = "visible";
	document.getElementById('tableauSalades').style.display = "block";
	document.getElementById('tableauSalades2').style.visibility = "visible";
	document.getElementById('tableauSalades2').style.display = "block";
	document.getElementById('tableauSalades3').style.visibility = "visible";
	document.getElementById('tableauSalades3').style.display = "block";	
	document.getElementById('tableauSoupes').style.visibility = "hidden";
	document.getElementById('tableauSoupes').style.display= "none";
	document.getElementById('choixMenuG').style.visibility = "visible";
	document.getElementById('choixMenuD').style.visibility = "visible";
	return true;
}
function affichageSmoothies()
{
	document.getElementById('tableauSmoothies').style.visibility = "visible";
	document.getElementById('tableauSmoothies').style.display = "block";
	document.getElementById('tableauJusDeFruits').style.visibility = "hidden";
	document.getElementById('tableauJusDeFruits').style.display= "none";
	document.getElementById('pain').style.visibility = "visible";
	document.getElementById('pied').style.visibility = "visible";
	return true;
}
function affichageJusDeFruits()
{
	document.getElementById('tableauJusDeFruits').style.visibility = "visible";
	document.getElementById('tableauJusDeFruits').style.display= "block";
	document.getElementById('tableauSmoothies').style.visibility = "hidden";
	document.getElementById('tableauSmoothies').style.display = "none";
	document.getElementById('pain').style.visibility = "visible";
	document.getElementById('pied').style.visibility = "visible";
	return true;
}
function afficherCommentaire()
	{
	document.getElementById('commentaire').style.display= "block";
	return true;
	}
function afficherMyJusDeFruit()
	{
	document.getElementById('myingredientsJusDeFruits').style.display= "block";
	return true;
	}
function afficherMySmoothies()
	{
	document.getElementById('myingredientsSmoothies').style.display= "block";
	return true;
	}

tinyMCE.init ({
	mode : "exact",
	elements : "texte",
	width : "350px",
	height: "180px",
	theme : "advanced", 
	plugins: "simplebrowser,inlinepopups,advlink,advimage",
	apply_source_formatting : true, 
	browsers : "msie,gecko,opera",
	save_on_tinymce_forms : true,
	language : "fr", 
	theme_advanced_path : true,
	theme_advanced_toolbar_location : "top", 
	theme_advanced_toolbar_align : "left", 
	force_p_newlines : false,
	force_br_newlines : true,
	relative_urls : false,
	style_body : 'editeur',
	theme_advanced_buttons1 : "bold,italic,separator,image,separator,link,unlink",
	theme_advanced_buttons2 : "",
	theme_advanced_buttons3 : "",
	content_css : "/includes/styles/contenu.css",
	valid_elements : "a[href|target|title],-strong/-b,-em/-i,br,img[id|style|class|src|alt=|title|width|height]",
	/* Paramètres exemple et conseillés pour le module Explorateur/Envoi de fichier */
	plugin_simplebrowser_width : '600', //default
	plugin_simplebrowser_height : '350', //default
	plugin_simplebrowser_browselinkurl : '/extranet/includes/plugins/tinymce/jscripts/tiny_mce/plugins/simplebrowser/browser.html?Connector=/extranet/includes/plugins/tinymce/jscripts/tiny_mce/plugins/simplebrowser/connectors/php/connector.php?ServerPath=/uploads/actualites/',
	plugin_simplebrowser_browseimageurl : '/extranet/includes/plugins/tinymce/jscripts/tiny_mce/plugins/simplebrowser/browser.html?Type=images&Connector=/extranet/includes/plugins/tinymce/jscripts/tiny_mce/plugins/simplebrowser/connectors/php/connector.php?ServerPath=/uploads/actualites/'
});

function lsjs_controleDates(heureServeur) 
	{
	//alert('heureServeur :'+heureServeur);
	var tempObjJourSelect=document.getElementById('jour');
	var tempObjMoisSelect=document.getElementById('mois');
	
	//heure du serveur
	var date = new Date(heureServeur);
	var jour = date.getDate();
	var mois = date.getMonth();
	mois = mois + 1;
		
	var annee = date.getFullYear();
	var heure = date.getHours();
	var minute = date.getMinutes();
	
	//si mois anterieur selectionné alors année suivante
	var tempJour = tempObjJourSelect.options[tempObjJourSelect.selectedIndex].value;
	var tempMois = tempObjMoisSelect.options[tempObjMoisSelect.selectedIndex].value;
	var tempAnnee = tempMois>=mois ? annee : annee+1;
	dateRes = tempJour + "-" + tempMois + "-" + tempAnnee;
	document.getElementById('dateReservation').value=dateRes;

	var jourSelect = tempJour;
	var moisSelect = tempMois;
	var anneeSelect = tempAnnee;
	
	if(moisSelect == mois && jourSelect < jour)
			{
				if( 0 < mois && mois < 10)
				{
					mois = '0'+mois;
				}
				if( 0 < jour && jour < 10)
				{
					jour = '0'+jour;
				}
				//alert('la date est antérieure à : '+jour+'-'+mois+'-'+annee');
				alert('Nous vous informons que notre formulaire de commande par internet est disponible jusqu\'à 11h30 le jour même,\n vous avez toutefois la possibilité de passer commande par téléphone au 0 810 811 708 jusqu\'à 12h00.');
				/*var tempAnnee = annee+1;
		dateRes = tempJour + "-" + tempMois + "-" + tempAnnee;
		document.getElementById('dateReservation').value=dateRes;*/
				return false;
			}
		
		if(anneeSelect == annee && moisSelect == mois && jourSelect == jour && heure >= 12)
		{
			alert('Nous vous informons que notre formulaire de commande par internet est disponible jusqu\'à 11h30 le jour même,\n vous avez toutefois la possibilité de passer commande par téléphone au 0 810 811 708 jusqu\'à 12h00.');
			/*var tempJour = jour+1;
			dateRes = "0"+tempJour + "-" + tempMois + "-" + tempAnnee;
			document.getElementById('dateReservation').value=dateRes;*/
			return false;
		}	
		else if(anneeSelect == annee && moisSelect == mois && jourSelect == jour && heure == 11 && minute > 30)
		{
		alert('Nous vous informons que notre formulaire de commande par internet est disponible jusqu\'à 11h30 le jour même,\n vous avez toutefois la possibilité de passer commande par téléphone au 0 810 811 708 jusqu\'à 12h00.');
			/*var tempJour = jour+1;
			dateRes = "0"+tempJour + "-" + tempMois + "-" + tempAnnee;
			document.getElementById('dateReservation').value=dateRes;*/
			return false;
		}
	return true;
	}
	

function lsjs_actualiseSelectDate(dateRes)
{
	//alert(dateRes);
	var jourSelect = dateRes.substring(0, 2);
	var moisSelect = dateRes.substring(3, 5);
	var anneeSelect = dateRes.substring(6, 10);
	
	var tempObjJourSelect=document.getElementById('jour');
	var tempObjMoisSelect=document.getElementById('mois');
	
	for (var i = 0; i < tempObjJourSelect.length; i++) {
		if (tempObjJourSelect.options[i].value==jourSelect) {
			tempObjJourSelect.options[i].selected=true;
		}
	}
		
	for (var i = 0; i < tempObjMoisSelect.length; i++) {
		if (tempObjMoisSelect.options[i].value==moisSelect) {
			tempObjMoisSelect.options[i].selected=true;
		}
	}
}



function verifierMenu(oForm)
{
	if (oForm.radioMenu[0].checked)
	{
		var i, n = 0 ;
		var oElement ;
	 
		for ( i = 0 ; i < oForm.elements.length ; i++ ) {
			oElement = oForm.elements[i] ;
			// tagName permet de connaître le nom de l'élément
			// Je ne m'intéresse qu'aux <input> de type checkbox
			// Les .toLowerCase( ) me permettent d'être insensible à la casse
			if ( oElement.tagName.toLowerCase( ) == "input" ) {
				if ( oElement.type.toLowerCase( ) == "checkbox" ) {
					// La propriété checked est à true si la checkbox est cochée
					if ( oElement.checked == true ) {
						n++ ;
						return true;
					}
				}
			}
		}
		alert("Veuillez selectionner un ou plusieurs ingrédients pour votre salade.");
		return false;
	}
	else
	{
		return true;
	}

}
