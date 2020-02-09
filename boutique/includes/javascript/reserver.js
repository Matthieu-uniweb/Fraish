function lsjs_afficherCalque(calque)
	{
	obj = document.getElementById(calque);

	if (obj.style.display=='block')
		{
		obj.style.display='none'; 
		obj.style.visibility='hidden'; 
		} 
	else
		{
		obj.style.display='block'; 
		obj.style.visibility='visible'; 
		} 
	}
	
function affichageMenuSoupes()
	{
	document.getElementById('tableauSoupes').style.visibility = "visible";
	document.getElementById('tableauSoupes').style.display= "block";
	/*document.getElementById('tableauSalades').style.visibility = "hidden";
	document.getElementById('tableauSalades').style.display = "none";
	document.getElementById('tableauSalades2').style.visibility = "hidden";
	document.getElementById('tableauSalades2').style.display = "none";
	document.getElementById('tableauSalades3').style.visibility = "hidden";
	document.getElementById('tableauSalades3').style.display = "none";	
	document.getElementById('choixMenuSmoothie1').style.visibility = "visible";
	document.getElementById('choixMenuSmoothie2').style.visibility = "visible";
	document.getElementById('choixMenuSmoothie3').style.visibility = "visible";*/
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
	/*document.getElementById('tableauSoupes').style.visibility = "hidden";
	document.getElementById('tableauSoupes').style.display= "none";
	document.getElementById('choixMenuSmoothie1').style.visibility = "visible";
	document.getElementById('choixMenuSmoothie2').style.visibility = "visible";
	document.getElementById('choixMenuSmoothie3').style.visibility = "visible";*/
	return true;
}
function affichageSmoothies()
{
	document.getElementById('tableauSmoothies').style.visibility = "visible";
	document.getElementById('tableauSmoothies').style.display = "block";
		
	document.getElementById('tableauJusDeFruits').style.visibility = "hidden";
	document.getElementById('tableauJusDeFruits').style.display= "none";
	
	//document.getElementById('tableauDairySmoothies').style.visibility = "hidden";
	//document.getElementById('tableauDairySmoothies').style.display= "none";
	
	/*document.getElementById('pain').style.visibility = "visible";
	document.getElementById('pied').style.visibility = "visible";*/
	return true;
}
function affichageDailyJuice()
	{
	document.getElementById('tableauSmoothies').style.visibility = "hidden";
	document.getElementById('tableauSmoothies').style.display = "none";
		
	document.getElementById('tableauJusDeFruits').style.visibility = "hidden";
	document.getElementById('tableauJusDeFruits').style.display= "none";
	}
function affichageDairySmoothies()
{
	document.getElementById('tableauDairySmoothies').style.visibility = "visible";
	document.getElementById('tableauDairySmoothies').style.display= "block";	
	document.getElementById('tableauSmoothies').style.visibility = "hidden";
	document.getElementById('tableauSmoothies').style.display = "none";
	document.getElementById('tableauJusDeFruits').style.visibility = "hidden";
	document.getElementById('tableauJusDeFruits').style.display= "none";
	/*document.getElementById('pain').style.visibility = "visible";
	document.getElementById('pied').style.visibility = "visible";*/
	return true;
}
function affichageJusDeFruits()
{
	document.getElementById('tableauJusDeFruits').style.visibility = "visible";
	document.getElementById('tableauJusDeFruits').style.display= "block";
	document.getElementById('tableauSmoothies').style.visibility = "hidden";
	document.getElementById('tableauSmoothies').style.display = "none";
	
	//document.getElementById('tableauDairySmoothies').style.visibility = "hidden";
	//document.getElementById('tableauDairySmoothies').style.display= "none";	
	/*document.getElementById('pain').style.visibility = "visible";
	document.getElementById('pied').style.visibility = "visible";*/
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
function afficherMyDairySmoothies()
	{
	document.getElementById('myingredientsDairySmoothies').style.display= "block";
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

function lsjs_controleDates(heureServeur, pointDeVente) 
	{

	var tempObjJourSelect=document.getElementById('jour');
	var tempObjMoisSelect=document.getElementById('mois');
	
	var jourSelect = document.getElementById('jour').value;
	
	var num_jour_lettre=Number (jourSelect) + Number (num_jour_global) -1;
	
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

	var weekend = document.getElementById("jourLettre").value;

	var jourSelect = tempJour;
	var moisSelect = tempMois;
	var anneeSelect = tempAnnee;
	
	/** BLOCAGE TEMPORAIRE DES RESA FILATIERS **/
	var lieu = document.getElementById('ID_pointDeVente').value;
	if(lieu==2)
		{
		alert("Le kiosque des Filatiers est actuellement fermé.\nNous ne pouvons pas enregistrer votre commande.\nMerci de votre compréhension.");
		return false;
		}
	/** FIN BLOCAGE TEMPORAIRE RESA FILATIERS **/
	
	/** CONTROLE EXCEPTIONNEL **/
	if(jourSelect==9 && moisSelect==4 && anneeSelect==2012 && pointDeVente==1)
		{
		alert("Le kiosque sera fermé le lundi 9 avril.");
		return false;
		}
	/** (FIN) CONTROLE EXCEPTIONNEL **/
	
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
				//alert('Nous vous informons que notre formulaire de commande par internet est disponible jusqu\'à 11h30 le jour même,\n vous avez toutefois la possibilité de passer commande par téléphone jusqu\'à 12h00.');
				alert("Votre commande est pour aujourd'hui, nous vous informons que la commande par Internet est disponible jusqu'à 11h35.\nVous avez toutefois la possibilité de commander par téléphone jusqu'à 12h.");
				document.forms[0].jour.style.border='solid 1px #FF0000';
			document.forms[0].jour.focus();
				/*var tempAnnee = annee+1;
		dateRes = tempJour + "-" + tempMois + "-" + tempAnnee;
		document.getElementById('dateReservation').value=dateRes;*/
				return false;
			}
		
		/*if(anneeSelect == annee && moisSelect == mois && num_jour_lettre == 06 || num_jour_lettre == 13 || num_jour_lettre == 20 || num_jour_lettre == 27 || num_jour_lettre == 34 || num_jour_lettre == 41 || num_jour_lettre== 07 || num_jour_lettre == 14 || num_jour_lettre == 21 || num_jour_lettre == 28 || num_jour_lettre == 35 || num_jour_lettre == 42 )*/
		if(weekend == 'Samedi' || weekend == 'Dimanche')
		{
			alert('Nous vous informons que notre formulaire de commande par internet n\'est pas disponible le samedi et le dimanche.\Veuillez choisir une autre date.');
			document.forms[0].jour.style.border='solid 1px #FF0000';
			document.forms[0].jour.focus();
			/*var tempJour = jour+1;
			dateRes = "0"+tempJour + "-" + tempMois + "-" + tempAnnee;
			document.getElementById('dateReservation').value=dateRes;*/
			return false;
		}	
		else if(anneeSelect == annee && moisSelect == mois && jourSelect == jour && heure >= 12)
		{
			alert("Votre commande est pour aujourd'hui, nous vous informons que la commande par Internet est disponible jusqu'à 11h35.\nVous avez toutefois la possibilité de commander par téléphone jusqu'à 12h.");
			/*var tempJour = jour+1;
			dateRes = "0"+tempJour + "-" + tempMois + "-" + tempAnnee;
			document.getElementById('dateReservation').value=dateRes;*/
			document.forms[0].jour.style.border='solid 1px #FF0000';
			document.forms[0].jour.focus();
			return false;
		}	
		else if(anneeSelect == annee && moisSelect == mois && jourSelect == jour && heure == 11 && minute > 35)
		{
		alert("Votre commande est pour aujourd'hui, nous vous informons que la commande par Internet est disponible jusqu'à 11h35.\nVous avez toutefois la possibilité de commander par téléphone jusqu'à 12h.");
			/*var tempJour = jour+1;
			dateRes = "0"+tempJour + "-" + tempMois + "-" + tempAnnee;
			document.getElementById('dateReservation').value=dateRes;*/
			document.forms[0].jour.style.border='solid 1px #FF0000';
			document.forms[0].jour.focus();
			return false;
		}
		if(pointDeVente=='')
			{
			alert('Veuillez indiquer le point de vente où vous retirerez votre menu.');
			document.forms[0].ID_pointDeVente.style.border='solid 1px #FF0000';
			document.forms[0].ID_pointDeVente.focus();
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
