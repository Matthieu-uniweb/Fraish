/////////////////////////////////////////////////////////
// FONCTIONS D'AFFICHAGE DES SUPPORTS (ADMINISTRATION) //
/////////////////////////////////////////////////////////

function findObj(theObj, theDoc)
{
  var p, i, foundObj;
  
  if(!theDoc) theDoc = document;
  if( (p = theObj.indexOf("?")) > 0 && parent.frames.length)
  {
    theDoc = parent.frames[theObj.substring(p+1)].document;
    theObj = theObj.substring(0,p);
  }
  if(!(foundObj = theDoc[theObj]) && theDoc.all) foundObj = theDoc.all[theObj];
  for (i=0; !foundObj && i < theDoc.forms.length; i++) 
    foundObj = theDoc.forms[i][theObj];
  for(i=0; !foundObj && theDoc.layers && i < theDoc.layers.length; i++) 
    foundObj = findObj(theObj,theDoc.layers[i].document);
  if(!foundObj && document.getElementById) foundObj = document.getElementById(theObj);
  
  return foundObj;
}

function afficheTexteareaCategorieFille(numero)
	{
	objetDiv = findObj('categorieFille'+numero.toString());
	chaine = objetDiv.className;
	if (chaine == 'divInvisible')
		{ objetDiv.className = 'divVisible'; }
	else
		{ objetDiv.className = 'divInvisible'; }
	}

function afficheDescriptif(numero)
	{
	objetDiv = findObj('textearea'+numero.toString());
	chaine = objetDiv.className;
	if (chaine == 'divInvisible')
		{ objetDiv.className = 'divVisible'; }
	else
		{ objetDiv.className = 'divInvisible'; }
	}

function cocher(objet)
	{
	if (objet.checked == false)
		{ objet.checked = false; }
	else
		{	objet.checked = true; }
	}

var categorieSelectionne = null;
var ancienContenu = '';
function guideSelectionnerBack(objet,ID,ID_support,couleur,check)
	{
	checkbox = MM_findObj(check);
	temp = checkbox.checked;

	if(categorieSelectionne != null)
		{
		categorieSelectionne.style.backgroundColor = '';
		categorieSelectionne.innerHTML = ancienContenu; 
		}
	if(document.forms[0].ID_categorie_consulte.value != ID.toString());
		{
		checkbox = MM_findObj(check);
		checkbox.checked = temp;

		document.forms[0].ID_categorie_consulte.value = ID;
		ancienContenu = objet.innerHTML;
		objet.style.backgroundColor = couleur;
		objet.innerHTML = '<table cellpadding="0" cellspacing="0" border="0" width="100%"><tr><td width="80%" class="rubriqueGuideEtudiantsFinale">' + ancienContenu + '</td><td nowrap class="rubriqueGuideEtudiantsFinale"><a href="javascript:;" onClick="afficheDescriptif(' + ID_support + ID + ');return false;" class="divOeilVoir">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;descriptif</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr></table>';
		categorieSelectionne = objet;
		}
	}

function guideMenuCategorieBack(numero)
	{
	objetDossier = findObj('dossier'+numero.toString());
	objetDiv = findObj('div'+numero.toString());
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

function modifierAdresseDefaut(checkbox, numero)
	{
	if (checkbox.checked)
		{
		dupliquer('Adresse', numero);
		}
	else
		{ 
		objet = findObj('adresse['+numero.toString()+'][numeroVoie]');			
		objet.className = 'input'+objet.className.substr(10, objet.className.lenght);
		objet.disabled = false;
		objet = findObj('adresse['+numero.toString()+'][voie]');	
		objet.className = 'input'+objet.className.substr(10, objet.className.lenght);
		objet.disabled = false;
		objet = findObj('adresse['+numero.toString()+'][complement]');	
		objet.className = 'input'+objet.className.substr(10, objet.className.lenght);
		objet.disabled = false;
		objet = findObj('adresse['+numero.toString()+'][commune]');	
		objet.className = 'input'+objet.className.substr(10, objet.className.lenght);
		objet.disabled = false;
		objet = findObj('adresse['+numero.toString()+'][codePostal]');	
		objet.className = 'input'+objet.className.substr(10, objet.className.lenght);
		objet.disabled = false;
		objet = findObj('adresse['+numero.toString()+'][codeInsee]');	
		objet.disabled = false;		
		objet = findObj('adresse['+numero.toString()+'][ID]');
		objet.value = ''; // On vide l'ID
		objet.disabled = false;
		objet = findObj('adresse['+numero.toString()+'][ville]');	
		objet.className = 'input'+objet.className.substr(10, objet.className.lenght);
		objet.disabled = false;
		objet = findObj('adresse['+numero.toString()+'][complementVille]');	
		objet.className = 'input'+objet.className.substr(10, objet.className.lenght);
		objet.disabled = false;
		objet = findObj('adresse['+numero.toString()+'][x]');	
		objet.className = 'input'+objet.className.substr(10, objet.className.lenght);
		objet.disabled = false;		
		objet = findObj('adresse['+numero.toString()+'][y]');	
		objet.className = 'input'+objet.className.substr(10, objet.className.lenght);
		objet.disabled = false;	
		}
	}


function mouseOverMenuBack(objet)
	{
	objet.className = objet.className+'Over';
	}
	
function mouseOuTportail_menuBack(objet)
	{
	if(objet.className.substr(objet.className.length-4,4)=='Over')
		{
			objet.className = objet.className.substr(0,objet.className.length-4);			
		}
	}

/////////////////////////////////////////////////////////
// FONCTIONS D'AFFICHAGE DES SERVICES (ADMINISTRATION) //
/////////////////////////////////////////////////////////

function affecterDonneesInsee(chaineEntree1, chaineEntree2, nb)
  {
	if (!nb)
		{
		codeInseeEnCours = MM_findObj("adresse_codeInsee");
		codePostalEnCours = MM_findObj("adresse_codePostal");
		villeEnCours = MM_findObj("adresse_ville");
		}
	else
		{
		codeInseeEnCours = MM_findObj("adresse[" + nb + "][codeInsee]");
		codePostalEnCours = MM_findObj("adresse["+ nb +"][codePostal]");
		villeEnCours = MM_findObj("adresse["+ nb + "][ville]");
		}

  temp=chaineEntree1.split(",");
	codeInseeEnCours.value = temp[0];
	codePostalEnCours.value = temp[1];
	villeEnCours.value = chaineEntree2;
  }

function affecterTypStructure(ID_typ_structure)
	{
	// Autre
	if (ID_typ_structure == '4')
		{
		MM_findObj("divNaf").style.display='none'; 
		MM_findObj("divNaf").style.visibility='hidden';
		MM_findObj("divAssoc").style.display='none'; 
		MM_findObj("divAssoc").style.visibility='hidden';
		MM_findObj("classAssoc2").checked = false;
		MM_findObj("classNaf2").checked = false;
		}
	else
		{
		// Administration - Association
		if ((ID_typ_structure == '1') || (ID_typ_structure == '2'))
			{
			divAAfficher = MM_findObj("divAssoc");
			divACacher = MM_findObj("divNaf");
			caseACocher = MM_findObj("classAssoc2");
			caseADecocher = MM_findObj("classNaf2");
			}
		// Entreprise
		else if (ID_typ_structure == '3')
			{
			divAAfficher = MM_findObj("divNaf");
			divACacher = MM_findObj("divAssoc");
			caseACocher = MM_findObj("classNaf2");
			caseADecocher = MM_findObj("classAssoc2");
			}
		divACacher.style.display='none'; 
		divACacher.style.visibility='hidden';
		divAAfficher.style.display='block'; 
		divAAfficher.style.visibility='visible';
		caseACocher.checked = true;
		caseADecocher.checked = false;
		}
	}

function afficheService(service)
	{
	obj = document.getElementById(service);
	if (obj.style.visibility=='visible')
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

function changeAlphabet(lien,etat)
	{
	if (lien.className.lastIndexOf("_selectionne") == -1)
		{
		if (etat=='over')
			{
			lien.className = "alphabet_over";
			}
		if (etat=='out')
			{
			lien.className = "alphabet";
			}	
		}
	}

/////////////////////////////////////////////////////////////////////////////
// FONCTIONS D'ACTIONS SUR LES STRUCTURES ET LES SUPPORTS (ADMINISTRATION) //
/////////////////////////////////////////////////////////////////////////////

function ajouterCategorie()
	{
	document.forms[0].fonction.value = 'ajouterCategorieMere';
	document.forms[0].action = 'saisir_support.php';
	document.forms[0].submit();
	}
	
function ajouterCategorieFille(ID_categorie_a_modifier)
	{
	document.forms[0].ID_categorie_a_modifier.value = ID_categorie_a_modifier;
	document.forms[0].fonction.value = 'ajouterCategorieFille';
	document.forms[0].action = 'saisir_support.php';
	document.forms[0].submit();
	}

function ajouterService(ID_structure)
	{
	if (! ID_structure)
		{ 
		document.formulaire.submit();
		}
	document.formAction.fonction.value = 'ajouterService';
	document.formAction.action = 'saisir_structure.php';
	document.formAction.submit();	
	}

function allerAjouterCategorie()
	{
	document.forms[0].action = 'saisir_support_categorie.php';
	document.forms[0].submit();
	}

function allerASaisie()
	{
	document.formAction.action = 'saisir_structure.php';
	document.formAction.submit();
	}
	
function consulterSupport(ID_support_consulte)
	{
	document.forms[0].ID_support_consulte.value = ID_support_consulte;
	document.forms[0].action = 'consulter_support.php';
	document.forms[0].submit();
	}

function dupliquer(type, ID_service)
	{
	if (ID_service)
		{ document.formAction.ID_service.value = ID_service; }
	document.formAction.fonction.value = 'dupliquerService' + type;
	document.formAction.action = 'saisir_structure.php';
	document.formAction.submit();	
	}

function enregistrerCategorie(ID_categorie_a_modifier, ID_categorieMere)
	{
	document.forms[0].ID_categorie_a_modifier.value = ID_categorie_a_modifier;
	document.forms[0].ID_categorieMere.value = ID_categorieMere;
	document.forms[0].fonction.value = 'enregistrerCategorie';
	document.forms[0].action = 'saisir_support.php';
	document.forms[0].submit();
	}

function gererSupports(ID_service)
	{
	document.formAction.ID_service.value = ID_service;
	document.formAction.action = 'saisir_structure_support.php';
	document.formAction.submit();
	}

function lierServices(ID_categorie_a_modifier)
	{
	document.forms[0].ID_categorie_a_modifier.value = ID_categorie_a_modifier;
	document.forms[0].action = 'menu_categorie.php';
	document.forms[0].submit();
	}

function modifierOrdreContact(ID_service)
	{
	document.formAction.ID_service.value = ID_service;
	document.formAction.action = 'saisir_ordre_contact.php';
	document.formAction.submit();
	}
	
function saisirContact(ID_service, ID_contact)
	{
	if (! ID_service)
		{ 
		document.formulaire.submit();
		}
	document.formAction.ID_service.value = ID_service;
	document.formAction.ID_contact.value = ID_contact;
	document.formAction.action = 'saisir_structure_contact.php';
	document.formAction.submit();
	}

function saisirStructure(ID_structure, ID_service)
	{
	if ( (ID_structure) && (ID_service) )
		{
		document.forms[0].ID_structure.value = ID_structure;
		document.forms[0].ID_service.value = ID_service;
		document.forms[0].action = 'saisir_structure.php';
		document.forms[0].submit();
		}
	}

function support(ID_support_a_modifier)
	{
	document.forms[0].ID_support_a_modifier.value = ID_support_a_modifier;
	document.forms[0].action = 'saisir_support.php';
	document.forms[0].submit();
	}

function supprimerCategorieSupport(ID_categorie_a_modifier)
	{
	document.forms[0].ID_categorie_a_modifier.value = ID_categorie_a_modifier;
	document.forms[0].fonction.value = 'supprimerCategorieSupport';
	document.forms[0].action = 'saisir_support.php';
	document.forms[0].submit();
	}

function supprimerContact(ID_service, ID_contact)
	{
	document.formAction.fonction.value = 'supprimerContact';
	document.formAction.ID_contact.value = ID_contact;
	document.formAction.ID_service.value = ID_service;
	document.formAction.action = 'saisir_structure.php';
	document.formAction.submit();	
	}

function supprimerService(ID_service)
	{
	document.formAction.fonction.value = 'supprimerService';
	document.formAction.ID_service.value = ID_service;
	document.formAction.action = 'saisir_structure.php';
	document.formAction.submit();	
	}

function supprimerStructure()
	{
	document.formAction.fonction.value = 'supprimerStructure';
	document.formAction.action = 'saisir_structure.php';
	document.formAction.submit();
	}

function supprimerSupport(ID_support_a_modifier)
	{
	document.forms[0].fonction.value = 'supprimerSupport';
	document.forms[0].ID_support_a_modifier.value = ID_support_a_modifier;
	document.forms[0].action = 'menu_support.php';
	document.forms[0].submit();
	}

function toutDevelopper()
	{
	if (document.forms[0].ouvert.value == '0')
		{ document.forms[0].ouvert.value = '1' }
	else
		{ document.forms[0].ouvert.value = '0' }
	document.forms[0].action = 'saisir_structure_support.php';
	document.forms[0].submit();
	}
	
function fonctionVisible(ID_categorie, ID_service)
	{
	document.formAction.fonction.value = 'changerVisibilite';
	document.formAction.ID_service.value = ID_service;
	document.formAction.ID_categorie.value = ID_categorie;
	document.formAction.action = 'saisir_structure.php';
	document.formAction.submit();	
	}
/////////////////////////////////////////////////////////////////////////////////
// FIN FONCTIONS D'ACTIONS SUR LES STRUCTURES ET LES SUPPORTS (ADMINISTRATION) //
/////////////////////////////////////////////////////////////////////////////////