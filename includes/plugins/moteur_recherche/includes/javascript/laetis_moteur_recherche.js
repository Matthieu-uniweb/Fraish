/**
*
* Une fonction qui catch les touches du clavier et n'accepte que les chiffres et *
* 
* @param
* @return
*/
function verifierSaisieChiffres (evenement)
	{
	key      = document.all?event.keyCode:evenement.which;
	cle      = String.fromCharCode(key);
	if (/[0-9*]/.test(cle)) 
		{
		return true;
		}
	return false;
	
	}

function quitter ()
    {
    window.location='../index.htm';
    }

function valider ()
    {
    // On vérifie d'abord si les valeurs entrées dans le formulaire sont correctes
    fin = true;
			
	if (f_config.format.value == "")
	    {
		alert("Vous devez entrer le format des fichiers à indexer.");
		document.f_config.format.focus();
		fin = false;
	    }
	/*
	if (f_config.repracine.value == "")
	    {
		alert("Vous devez entrer le répertoire racine.");
		document.f_config.repracine.focus();
		fin = false;
	    }
	*/
	if (f_config.poidstitle.value == "")
	    {
		alert("Vous devez entrer le poids pour les mots du titre.");
		document.f_config.poidstitle.focus();
		fin = false;
	    }
	
	if (f_config.poidsnom.value == "")
	    {
		alert("Vous devez entrer le poids pour le nom du fichier.");
		document.f_config.poidsnom.focus();
		fin = false;
	    }
	
	if (f_config.nbres.value == "")
	    {
		alert("Vous devez entrer le nombre de résultats affichés sur une page.");
		document.f_config.nbres.focus();
		fin = false;
	    }
	
	if (f_config.formeres.value == "")
	    {
		alert("Vous devez entrer la forme du résultat.");
		document.f_config.formeres.focus();
		fin = false;
	    }
	
	if (f_config.tablefichier.value == "")
	    {
		alert("Vous devez entrer le nom de la table contenant les informations sur les fichiers.");
		document.f_config.tablefichier.focus();
		fin = false;
	    }
	
	if (f_config.tablemotfichier.value == "")
	    {
		alert("Vous devez entrer le nom de la table contenant les informations sur les mots.");
		document.f_config.tablemotfichier.focus();
		fin = false;
	    }
	
	if (f_config.cheminBDD.value == "")
	    {
		alert("Vous devez entrer le chemin du fichier de connexion à la base de données.");
		document.f_config.cheminBDD.focus();
		fin = false;
	    }
	
	if (fin != "false")
	    {
	    window.document.forms.f_config.valider.value = '1';
	    window.document.forms.f_config.submit ();		
	    }
    }

function validerCron(selectedForm)
	{
	var erreur=false;
	if ( (selectedForm.minute.value>60 || selectedForm.minute.value=='')  && selectedForm.minute.value!='*' )
		{
		alert('erreur minutes');
		erreur=true;
		}
	if ( (selectedForm.heure.value>60 || selectedForm.heure.value=='') && selectedForm.heure.value!='*' )
		{
		alert('erreur heure');
		erreur=true;
		}
	if ( (selectedForm.jourSemaine.value>6 || selectedForm.jourSemaine.value=='') && selectedForm.jourSemaine.value!='*' )
		{
		alert('erreur jour semaine');
		erreur=true;
		}
	if ( (selectedForm.jourMois.value>31 || selectedForm.jourMois.value<1 || selectedForm.jourMois.value=='' )  && selectedForm.jourMois.value!='*' )
		{
		alert('erreur jour mois');
		erreur=true;
		}
	if ( (selectedForm.mois.value>12 || selectedForm.mois.value<1 || selectedForm.mois.value=='')  && selectedForm.mois.value!='*' )
		{
		alert('erreur mois');
		erreur=true;
		}
	
	if (!erreur)
		{
		selectedForm.submit();
		}
	}
	