function guideMenuCategorie(numero)
	{
	objetDossier = MM_findObj('dossier'+numero.toString());
	objetDiv = MM_findObj('div'+numero.toString());
	chaine = objetDossier.className.substr(objetDossier.className.length-10,10)
	switch(chaine)
		{
			case 'FermeeOver' :
			case 'Fermee':
				valeurTemp = (objetDossier.className.substr(0,objetDossier.className.length-10)+'Ouverte');
				objetDossier.className = valeurTemp;
				objetDiv.className = 'divVisible';
				break;
			case 'uverteOver' :
			case 'uverte':
				valeurTemp = (objetDossier.className.substr(0,objetDossier.className.length-11)+'Fermee');
				objetDossier.className = valeurTemp;
				objetDiv.className = 'divInvisible';
				break;
		}
	}

function mouseOverMenu(objet)
	{
	objet.className = objet.className+'Over';
	}
	
function mouseOuTportail_menu(objet)
	{
	if(objet.className.substr(objet.className.length-4,4)=='Over')
		{
			objet.className = objet.className.substr(0,objet.className.length-4);			
		}
	}

var categorieSelectionne = null;
var ancienContenu = '';
function guideSelectionner(objet,ID,couleur)
	{
	if(categorieSelectionne != null)
		{
		categorieSelectionne.style.backgroundColor = '';
		categorieSelectionne.innerHTML = ancienContenu;
		//alert(categorieSelectionne.outerHTML);
		}
	if(document.forms[0].ID_categorie_consulte.value != ID.toString());
		{
		document.forms[0].ID_categorie_consulte.value = ID;
		ancienContenu = objet.innerHTML;
		objet.style.backgroundColor = couleur;
		objet.innerHTML = '<table cellpadding="0" cellspacing="0" border="0" wifth="100%"><tr><td width="100%" class="categorie">' + ancienContenu + '<td><td><a href="javascript:;" onClick="voirCategorie(); return false;" class="divOeilVoir">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;voir</a>&nbsp;&nbsp;&nbsp;</td></tr></table>';
		categorieSelectionne = objet;
		}
	}	

var action = '';
function toutDevelopper()
	{
	switch(action)
		{
		case '':
		case 'on':
			ancien = 'divInvisible';
			ancienneImage = 'rubriqueGuideFermee';
			nouveau = 'divVisible';
			nouvelleImage = 'rubriqueGuideOuverte';
			action = 'off';
			break;
		case 'off':
			ancien = 'divVisible';
			ancienneImage = 'rubriqueGuideOuverte';
			nouveau = 'divInvisible';
			nouvelleImage = 'rubriqueGuideFermee';
			action = 'on';
			break;
		}

	var listeDiv = document.getElementsByTagName("div");
	for (n=0; n<listeDiv.length; n++) 
		{
		if (listeDiv[n].className == ancien)
			{
			listeDiv[n].className = nouveau;
			}
		else if (listeDiv[n].className == ancienneImage)
			{
			listeDiv[n].className = nouvelleImage;
			}
		}
	}
	
function localiserGuide(idGuide)
	{
	MM_openBrWindow('../../../../../cartographie/pop_carto.php?IDservice='+idGuide,'carto','width=770,height=540');
	}
	
function annuaireFrontAffichePopup(support,categorie)
	{
	win = window.open("" , 'resultats', 'width=500,height=650,toolbar=0,menubar=no,scrollbars=yes,status=yes');
	
	//si les params sont pas saisis, le formulaire de la page et ses hidden de départ est utilisé par défaut
	if (support)
	{
	document.formulaire.ID_support.value = support;
	}
	if (categorie)
	{
	document.formulaire.ID_categorie_consulte.value = categorie;
	}
	document.formulaire.target = win.name;
	document.formulaire.submit();
	}
