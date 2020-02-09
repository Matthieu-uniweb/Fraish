<!--
var emailfilter=/^\w+[\+\.\w-]*@([\w-]+\.)*\w+[\w-]*\.([a-z]{2,4}|\d+)$/i

function verifierMail(e)
	{
	var returnval=emailfilter.test(e.value)
	if (returnval==false)
		{
		alert("Veuillez saisir un email valide.")
		e.select()
		}
	return returnval
	} // FIN function verifierMail(e)


function lsjs_verifierFormulaire(formobj, element1, element2)
	{
	var fieldalias="mot de passe";
	var min = 5;
	var oblig = formobj.elements['obligatoire'].value;
	var champsRequis = oblig.split('|');

	var alertMsg = "Veuillez renseigner les champs suivants:\n";	
	var l_Msg = alertMsg.length;
	
	for (var i=0; i < champsRequis.length; i++)
	{		
		champObligatoire = champsRequis[i].split('-');
		var obj = formobj.elements[champObligatoire[0]];
		if (obj)
		{
			switch(obj.type)
			{
			case "select-one":
				if (obj.selectedIndex == -1 || obj.options[obj.selectedIndex].text == ""){
					alertMsg += " - " + champObligatoire[1] + "\n";
				}
				break;
			case "select-multiple":
				if (obj.selectedIndex == -1){
					alertMsg += " - " + champObligatoire[1] + "\n";
				}
				break;
			case "password":
			case "text":
			case "textarea":
				if (obj.value == "" || obj.value == null){
					alertMsg += " - " + champObligatoire[1] + "\n";
				}
				break;
			default:
			}
			if (obj.type == undefined){
				var blnchecked = false;
				for (var j = 0; j < obj.length; j++){
					if (obj[j].checked){
						blnchecked = true;
					}
				}
				if (!blnchecked){
					alertMsg += " - " + champObligatoire[1] + "\n";
				}
			}
		}
	}
	var StrLen = element1.value.length;
	var checkFinal = 0;
   if (element1.value=='')
   {
    alert("Veuillez entrer votre "+fieldalias+" dans le premier champ!");
	checkFinal = 0;
   }
   else if (element2.value=='')
   {
    alert("Veuillez confirmer votre "+fieldalias+" dans le second champ!");
	checkFinal = 0;
   }
   else if (element1.value!=element2.value)
   {
    alert("Les deux "+fieldalias+" ne concordent pas");
	checkFinal = 0;
   }
   else if (StrLen < min )
   {
	   alert("Votre mot de passe doit être de 5 caractères minimum!");
	   checkFinal = 0;
	   }
	   else
	   {
		checkFinal = 1; 
	   }	

	if (alertMsg.length == l_Msg && checkFinal == 1)
		{
		// Si tous les champs sont ok, alors on vérifie le champs email s'il existe
		//var email = formobj.elements['email'].value;
		if (formobj.elements['email'] != undefined)
			{ return verifierMail(formobj.elements['email']); }
		else if (formobj.elements['emailFacturation'] != undefined)
			{ return verifierMail(formobj.elements['emailFacturation']); }
		else
			{
				return true;
			}
		} // FIN if (alertMsg.length == l_Msg)
	else{
		alert(alertMsg);
		return false;
	}
} // FIN function verifierFormulaire(formobj)

function lsjs_verifierFormulaire2(formobj)
	{
	var oblig = formobj.elements['obligatoire'].value;
	var champsRequis = oblig.split('|');

	var alertMsg = "Veuillez renseigner les champs suivants:\n";	
	var l_Msg = alertMsg.length;
	var alerteOptions = false;
	
	for (var i=0; i < champsRequis.length; i++)
	{
		champObligatoire = champsRequis[i].split('-');

		var obj = formobj.elements[champObligatoire[0]];
		if (obj)
		{
			switch(obj.type)
			{
			case "select-one":
				if (obj.selectedIndex == -1 || obj.options[obj.selectedIndex].text == ""){
					
					alertMsg += " - " + champObligatoire[1] + "\n";
					obj.style.border = 'solid 1px #FF0000';
					obj.focus();
				}
				break;
			case "select-multiple":
				if (obj.selectedIndex == -1){
					alertMsg += " - " + champObligatoire[1] + "\n";
				}
				break;
			case "password":
			case "text":
			case "textarea":
				if (obj.value == "" || obj.value == null){
					alertMsg += " - " + champObligatoire[1] + "\n";
				}
				break;
			default:
			}
			if (obj.type == undefined){
				var blnchecked = false;
				
				for (var j = 0; j < obj.length; j++){
					if (obj[j].checked){
						blnchecked = true;
					}
					else
					{
					//gestion des options de formule
					if(obj[j].name=='menuOU')
						{
						alerteOptions = true;
						}
					}
				}
				if (!blnchecked){
					alertMsg += " - " + champObligatoire[1] + "\n";
				}
				
			}
		}
	} 

	if (alertMsg.length == l_Msg)
		{
		// Si tous les champs sont ok, alors on vérifie le champs email s'il existe
		//var email = formobj.elements['email'].value;
		if (formobj.elements['email'] != undefined)
			{ return verifierMail(formobj.elements['email']); }
		else if (formobj.elements['emailFacturation'] != undefined)
			{ return verifierMail(formobj.elements['emailFacturation']); }
		else
			{ return true; }
		} // FIN if (alertMsg.length == l_Msg)
	else{
		
		if(alerteOptions)
			  {
			  tabOptions = document.getElementsByName('menuOU');	
			  //alert(tabOptions.type);
			  for(i=0;i<tabOptions.length;i++)
				  {
				  //alert(tabOptions[i].value);
				  document.getElementById('menuOption'+tabOptions[i].value).style.color = '#FF0000';
				  }
			  }
		alert(alertMsg);
		return false;
	}
} // FIN function verifierFormulaire(formobj)

/*var fieldalias="mot de passe";

function verify(element1, element2, min)
 {
  var StrLen = element1.value.length;
   if (element1.value=='')
   {
    alert("Veuillez entrer votre "+fieldalias+" dans le premier champ!");
	return false;
   }
   else if (element2.value=='')
   {
    alert("Veuillez confirmer votre "+fieldalias+" dans le second champ!");
	return false;
   }
   else if (element1.value!=element2.value)
   {
    alert("Les deux "+fieldalias+" ne condordent pas");
	return false;
   }
   else if (StrLen < min )
   {
	   alert("Votre mot de passe doit être de 5 caractères minimum!");
	   return false;
	   }
	   else
	   {
	   }
}
*/
////////////////////////////////
// VERIFICATION DE CARACTERES //
////////////////////////////////

	function verifierMasqueSaisie (objet,format)
		{
		masque = null;
		masque = new Mask(format, "string");
		masque.attach(objet);
		// Reformatage
		if (objet.value != '')
	  {
			objet.value = masque.format(objet.value);
			}		
		//return true;
		} // FIN function verifierMasqueSaisie (objet,format)


function chiffres(event) {
	// Compatibilité IE / Firefox
	if(!event&&window.event) {
		event=window.event;
	}
	// IE
	if(event.keyCode < 48 || event.keyCode > 57) {
		event.returnValue = false;
		event.cancelBubble = true;
	}
	// DOM
	if(event.which < 48 || event.which > 57) {
		event.preventDefault();
		event.stopPropagation();
	}
} // FIN function chiffres(event)
-->


