/**
*  Des fonction qui permettent de traiter les fonctions de base de verification des formulaires
*
* Le formulaire pour etre compatible doit avoir la structure suivante:
*	  <form name="formulaire" action="" method="post" 
*	  onSubmit="if (!envoyerFormulaire(this)){return false;}">
*	 pour un champ obligatoire:
*		<input name="pays" size="25" obligatoire="1" nomAffiche="Le nom qui apparaitra dans le message d'alert> 
*	pour un groupe de checkbox dont au moins une valeur doit etre selectionnée:
* 		<input type="checkbox" name="hiver" groupe="saison" value="oui" onClick="if (this.checked){this.form.groupeSaison.value=this.value;}else{this.form.groupeSaison.value='';}"> 
*    	<input name="groupePeche" type="hidden" value="" obligatoire="1" nomAffiche="Quel(s) type(s) de pêche pratiquez-vous ?">
*    </form>
*/

/**
*
* une fonction qui verifie si le champ mail du formulaire contient une valeur,
* si oui, verifie que cette valeur est au format mail
* si le mail est valide ou vide, on verifie qu'il y a eut un choix au moins de fait
* alors on verifie les champs obligatoires avec la fonction verifierFormulaire()
*
* @return bool
*/
function envoyerFormulaire (selectedForm)
 	{
	// le champ est-il vide ?
	if(selectedForm.email.value)
		{
		// il n'est pas vide, on verifie la validite du mail
		if (!verifierMail(selectedForm.email) )
			{
			return false;
			}
		}

		// on verifie les champs obligatoires
	if (verifierFormulaire (selectedForm))
				{
				return true;
				//selectedForm.submit();
				}
	
	return false;
 	}
	
	
function envoyerFormulaire2 (selectedForm)
 	{
		// on verifie les champs obligatoires
	if (verifierFormulaire (selectedForm))
				{
				return true;
				//selectedForm.submit();
				}
	
	return false;
 	}


/**
* une fonction qui verifie que dans le formulaire passé en arguments
* les champs ayant la propriété "obligatoire" soient renseignés
* Si le champ nomAffiche est renseigne, alors c'est lui qui sera affiché dans le message d'alerte
* Cette fonction doit etre appellée d'un onSubmit()
*
* @param form 
* @return bool
*/
function verifierFormulaire (selectedForm)
	{
	for (i=0;i<selectedForm.elements.length;i++)
		{
		if(selectedForm.elements[i].obligatoire && !selectedForm.elements[i].value.length)
			{
			if (selectedForm.elements[i].nomAffiche)
				{
				alert("Le champ "+selectedForm.elements[i].nomAffiche+" est obligatoire");
				}
				else
				{
				alert("Le champ "+selectedForm.elements[i].name+" est obligatoire");
				}
			// si le champ n'est pas caché, on lui donne le focus
			if (selectedForm.elements[i].type!="hidden")
				{
				selectedForm.elements[i].focus();
				}
			return false;
			}
		}
	return true;
	}
	
 function verifierMail(objet)
	{
	// doit avoir la forme: _@_.__ au moins
	if (!verifierStringMail(objet.value))
		{
		objet.select();
		objet.focus();
		return false;
		}
	return true;
	}
	
function verifierStringMail(value)
	{
	// doit avoir la forme: _@_.__ au moins
	if (value.indexOf('@')<1
				|| value.lastIndexOf('.')<(value.indexOf('@')+2)
					|| value.lastIndexOf('.')>(value.length-3)
						 
				)
		{
		alert("Le mail saisi n\'est pas valide");
		return false;
		}
	return true;
	}
	
function verifierCaracteresMails(evenement)
	{ 
	// tous les caracteres autorisés + le ';' dans le cas de champs pour emeils multiples séparés par des ';'
	key      = document.all?event.keyCode:evenement.which;
	cle      = String.fromCharCode(key);
	if (/[A-Za-z0-9\-_.;@]/.test(cle)) 
		{
		return true;
		}
	return false;
	}

function mettreAjourValeurDeGroupe (objet)
	{
	if (objet.checked)
		{
		eval("objet.form."+objet.groupe+".value=objet.value;");
		}
		else
		{
		eval("objet.form."+objet.groupe+".value='';");
		}
	}
	
/**
* Une fonction qui catch les touches du clavier et n'accepte que les chiffres
* 
* @param
* @return
*/
function verifierSaisieChiffres(evenement)
	{
	key      = document.all?event.keyCode:evenement.which;
	cle      = String.fromCharCode(key);
	if (/[0-9,.]/.test(cle)) 
		{
		return true;
		}
	return false;
	}
	
function verifierCaracteres(evenement)
	{ 
	key      = document.all?event.keyCode:evenement.which;
	cle      = String.fromCharCode(key);
	if (/[A-Za-z0-9\-_. '@éèçàùôîûâê]/.test(cle)) 
		{
		return true;
		}
	return false;
	}

function verifierCaracteresTelephone (evenement)
	{
	key      = document.all?event.keyCode:evenement.which;
	cle      = String.fromCharCode(key);
	if (/[0-9\()]/.test(cle)) 
		{
		return true;
		}
	return false;
	}
	