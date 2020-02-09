// JavaScript Document
function supprimer(ID_gamme)
	{
	if (window.confirm("Voulez vous supprimer cette gamme ?"))
		{
		window.location.href="scripts/suppr_gamme.php?ID_gamme="+ID_gamme;
		}
	}
function supprimerPays(ID)
	{
		if (window.confirm("Voulez vous supprimer ce pays ?"))
		{
		window.location.href="scripts/suppr_pays.php?ID="+ID;
		}
	}
function supprimerCategorie(ID)
	{
		if (window.confirm("Voulez vous supprimer cette categorie ?"))
		{
		window.location.href="scripts/suppr_categorie.php?ID="+ID;
		}
	}
function supprimerCommande(ID_commande)
	{
	if (window.confirm("Voulez vous supprimer cette commande ?"))
		{
		window.location.href="scripts/suppr_commande.php?ID_commande=" + ID_commande ;
		}
	}
function supprimerPort(ID_port)
	{
	if (window.confirm("Voulez vous supprimer cette famille de ports ?"))
		{
		window.location.href="scripts/suppr_port.php?ID_port=" + ID_port;
		}
	}
function supprimerTarifLivraison(ID_tarifLivraison,ID_port)
	{
	if (window.confirm("Voulez vous supprimer ce tarif ?"))
		{
		window.location.href="scripts/suppr_tarifLivraison.php?ID_tarifLivraison=" + ID_tarifLivraison + "&ID_port=" + ID_port;
		}
	}

function choisirListe(choix)
	{
	for (i=0;i<document.formulaire.elements.length;i++)
		{
		if ( (document.formulaire.elements[i].type=="select-one") && (document.formulaire.elements[i].name!='choixStatut') )
			{
			//alert(document.formulaire.elements[i].options[document.formulaire.elements[i].selectedIndex].value);
			document.formulaire.elements[i].selectedIndex=choix;
			}
		}
	}

function afficherCalqueArticles(objet)
	{
	cacherCalqueArticles('calquePrix');
	cacherCalqueArticles('calqueStock');
	cacherCalqueArticles('calqueDecliner');
	cacherCalqueArticles('calqueReference');
	calque  = objet.options[objet.selectedIndex].value;
	objetCalque = document.getElementById(calque);
	objetCalque.style.display = 'inline';
	calqueBouton = 'boutonSubmit';
	objetBouton = document.getElementById(calqueBouton);
	objetBouton.style.display = 'inline';
	}
	
function cacherCalqueArticles(calque)
	{
	objetCalque = document.getElementById(calque);
	objetCalque.style.display = 'none';
	}
	
function lsjs_controleDates() 
	{
	dateDebut = document.getElementById('debut').value;
	dateFin = document.getElementById('fin').value;
	var date = new Date();
	var annee = date.getFullYear();
	if(dateDebut.length != 10 || dateFin.length != 10)
		{
		alert('Format incorrect\nFormat: jj-mm-aaaa\nEx: 01-01-2008');
		document.formulaire.debut.focus();
		return false;
		}
	
	if(dateDebut.substring(0, 2) < 01 || dateDebut.substring(0, 2) > 31)
		{
		alert('le jour de la date de début doit être compris entre 01 et 31.\nFormat: jj-mm-aaaa\nEx: 01-01-2008');
		document.formulaire.debut.focus();
		return false;
		}

	if(dateDebut.substring(3, 5) < 01 || dateDebut.substring(3, 5) > 12)
		{
		alert('le mois de la date de début doit être compris entre 01 et 12.\nFormat: jj-mm-aaaa\nEx: 01-01-2008');
		document.formulaire.debut.focus();
		return false;
		}	
	
	if(dateDebut.substring(6, 10) < 2008 || dateDebut.substring(6, 10) > annee)
		{
		alert('l\'année de la date de début doit être compris entre 2008 et '+annee+'.\nFormat: jj-mm-aaaa\nEx: 01-01-2008');
		document.formulaire.debut.focus();
		return false;
		}
	
	if(dateDebut.charAt(2) != '-' || dateDebut.charAt(5) != '-')
		{
		alert('le séparateur de la date de début doit être " - ".\nFormat: jj-mm-aaaa\nEx: 01-01-2008');
		document.formulaire.debut.focus();
		return false;
		}
					
	if(dateFin.substring(0, 2) < 01 || dateFin.substring(0, 2) > 31)
		{
		alert('le jour de la date de fin doit être compris entre 01 et 31.\nFormat: jj-mm-aaaa\nEx: 01-01-2008');
		document.formulaire.fin.focus();
		return false;
		}
						
	if(dateFin.substring(3, 5) < 01 || dateFin.substring(3, 5) > 12)
		{
		alert('le mois de la date de fin doit être compris entre 01 et 12.\nFormat: jj-mm-aaaa\nEx: 01-01-2008');
		document.formulaire.fin.focus();
		return false;
		}	
							
	if(dateFin.substring(6, 10) < 2008 || dateFin.substring(6, 10) > annee)
		{
		alert('l\'année de la date de fin doit être compris entre 2008 et '+annee+'.\nFormat: jj-mm-aaaa\nEx: 01-01-2008');
		document.formulaire.fin.focus();
		return false;
		}
								
	if(dateFin.charAt(2) != '-' || dateFin.charAt(5) != '-')
		{
		alert('le séparateur de la date de fin doit être " - ".\nFormat: jj-mm-aaaa\nEx: 01-01-2008');
		document.formulaire.fin.focus();
		return false;
		}
		
	if((dateDebut.substring(3, 5) == 04 || dateDebut.substring(3, 5) == 06 || dateDebut.substring(3, 5) == 09 || dateDebut.substring(3, 5) == 11) && dateDebut.substring(0, 2) > 30)	
		{
			alert('le jour: '+dateDebut+' de la date de début n\'existe pas, il doit être compris entre 01 et 30.\nFormat: jj-mm-aaaa\nEx: 01-01-2008');
			document.formulaire.debut.focus();
			return false;
		}
		
	if((dateFin.substring(3, 5) == 04 || dateFin.substring(3, 5) == 06 || dateFin.substring(3, 5) == 09 || dateFin.substring(3, 5) == 11) && dateFin.substring(0, 2) > 30)	
		{
			alert('le jour: '+dateFin+' de la date de fin n\'existe pas, il doit être compris entre 01 et 30.\nFormat: jj-mm-aaaa\nEx: 01-01-2008');
			document.formulaire.fin.focus();
			return false;
		}
		
	if(dateDebut.substring(3, 5) == 02 && dateDebut.substring(0, 2) > 29)	
		{
			alert('le jour: '+dateDebut+' de la date de début n\'existe pas, il doit être compris entre 01 et 29.\nFormat: jj-mm-aaaa\nEx: 01-01-2008');
			document.formulaire.debut.focus();
			return false;
		}
		
	if(dateFin.substring(3, 5) == 02 && dateFin.substring(0, 2) > 29)	
		{
			alert('le jour: '+dateFin+' de la date de fin n\'existe pas, il doit être compris entre 01 et 30.\nFormat: jj-mm-aaaa\nEx: 01-01-2008');
			document.formulaire.fin.focus();
			return false;
		}
		
	
									
	if(dateDebut.substring(6, 10) != dateFin.substring(6, 10))
		{
		if(dateDebut.substring(6, 10) > dateFin.substring(6, 10))
			{
			alert('l\'année de début est supérieure à l\'année de fin.\n'+dateDebut.substring(6, 10)+' > '+dateFin.substring(6, 10)+'.\nFormat: jj-mm-aaaa\nEx: 01-01-2008');
			document.formulaire.debut.focus();
			return false;
			}
		}		
	else
		{	
		if(dateDebut.substring(3, 5) == dateFin.substring(3, 5)) 
			{
			if(dateDebut.substring(0, 2) > dateFin.substring(0, 2)) 
				{
				alert('le jour de début est supérieure au jour de fin.\n'+dateDebut.substring(0, 2)+' > '+dateFin.substring(0, 2)+'.\nFormat: jj-mm-aaaa\nEx: 01-01-2008');
				document.formulaire.debut.focus();
				return false;
				}
			}
		else
			{
			if(dateDebut.substring(3, 5) > dateFin.substring(3, 5))
				{
				alert('le mois de début est supérieure au mois de fin.\n'+dateDebut.substring(3, 5)+' > '+dateFin.substring(3, 5)+'.\nFormat: jj-mm-aaaa\nEx: 01-01-2008');
				document.formulaire.debut.focus();
				return false;
				}
			}
		}
	return true;
	}
	
function lsjs_controleDates2() 
	{
	dateDebut = document.getElementById('debut').value;
	dateFin = document.getElementById('fin').value;
	var date = new Date();
	var annee = date.getFullYear();
	if(dateDebut.length != 7 || dateFin.length != 7)
		{
		alert('Format incorrect\nFormat: jj-mm-aaaa\nEx: 01-2011');
		document.formulaire.debut.focus();
		return false;
		}

	if(dateDebut.substring(0,2) < 01 || dateDebut.substring(0,2) > 12)
		{
		alert('le mois de la date de début doit être compris entre 01 et 12.\nFormat: mm-aaaa\nEx: 01-2011');
		document.formulaire.debut.focus();
		return false;
		}	
	
	if(dateDebut.substring(3,7) < 2008 || dateDebut.substring(3,7) > annee)
		{
		alert('l\'année de la date de début doit être compris entre 2008 et '+annee+'.\nFormat: mm-aaaa\nEx: 01-01-2008');
		document.formulaire.debut.focus();
		return false;
		}
	
	if(dateDebut.charAt(2) != '-')
		{
		alert('le séparateur de la date de début doit être " - ".\nFormat: mm-aaaa\nEx: 01-2011');
		document.formulaire.debut.focus();
		return false;
		}
											
	if(dateFin.substring(0,2) < 01 || dateFin.substring(0,2) > 12)
		{
		alert('le mois de la date de fin doit être compris entre 01 et 12.\nFormat: mm-aaaa\nEx: 01-2011');
		document.formulaire.fin.focus();
		return false;
		}	
							
	if(dateFin.substring(3,7) < 2008 || dateFin.substring(3,7) > annee)
		{
		alert('l\'année de la date de fin doit être compris entre 2008 et '+annee+'.\nFormat: mm-aaaa\nEx: 01-2011');
		document.formulaire.fin.focus();
		return false;
		}
								
	if(dateFin.charAt(2) != '-')
		{
		alert('le séparateur de la date de fin doit être " - ".\nFormat: mm-aaaa\nEx: 01-2008');
		document.formulaire.fin.focus();
		return false;
		}
									
	if(dateDebut.substring(3,7) != dateFin.substring(3,7))
		{
		if(dateDebut.substring(3,7) > dateFin.substring(3,7))
			{
			alert('l\'année de début est supérieure à l\'année de fin.\n'+dateDebut.substring(3,7)+' > '+dateFin.substring(3,7)+'.\nFormat: mm-aaaa\nEx: 01-2011');
			document.formulaire.debut.focus();
			return false;
			}
		}		
	else
		{	
		if(dateDebut.substring(0,2) > dateFin.substring(0,2))
			{
			alert('le mois de début est supérieure au mois de fin.\n'+dateDebut.substring(0,2)+' > '+dateFin.substring(3, 5)+'.\nFormat: jj-mm-aaaa\nEx: 01-2011');
			document.formulaire.debut.focus();
			return false;
			}
		}
	return true;
	}

function lsjs_moisDAvant()
	{
	var dateDebut = document.getElementById('debut').value;
	var dateFin = document.getElementById('fin').value;
	var mois = dateDebut.substring(3, 5);
	var annee = dateDebut.substring(6, 10);
	if(mois != 01 || annee != '2008')
		{
		var jourDeb = '01';
		if (mois == 01)
			{
			mois = 12;
			annee = annee - 1;
			jourFin = '31';
			}
		else
			{	
			mois = mois - 1;
			if (mois <= 9 && mois >= 1)
				{
				mois = '0'+mois;
				}
			if(mois == 01 || mois == 03 || mois == 05 || mois == 07 || mois == 08 || mois == 10)
				{
				var jourFin = '31';
				}
			else
				{
				if(mois == 02)
					{
					var jourFin = '29';
					}
				else
					{
					var jourFin = '30';
					}
				}
			}
			dateDebut = jourDeb+'-'+mois+'-'+annee;
			dateFin = jourFin+'-'+mois+'-'+annee;
			document.getElementById('debut').value = dateDebut;
			document.getElementById('fin').value = dateFin;
		}
	else
		{
		alert('date limite: 01-01-2008');
		return false;
		}	
	return true;
	}
