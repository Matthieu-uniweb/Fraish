// JavaScript Document

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

// Fonction d'affichage du div Article ajouté
function afficherConfirmationPanier(calque)
	{
	var hauteurPage = document.getElementById('page').offsetHeight+155;
	objMasque = document.getElementById('masquePanier');
	objMasque.style.height = hauteurPage+'px';
	afficherDiv('masquePanier');
	var sfEls = document.getElementById(calque);
	sfEls.style.display='block';
	}

function cacherDiv(div)
	{
	obj = document.getElementById(div);
	obj.style.display='none'; 
	}
	
function afficherDiv(div)
	{
	obj = document.getElementById(div);
	obj.style.display='block'; 
	}

function ajouterQuantite(ID_article)
	{
	q = findObj("article[" + ID_article + "][quantite]");
	q.value++;
	}

function retirerQuantite(ID_article)
	{
	q = findObj("article[" + ID_article + "][quantite]");
	if (q.value>0)
		{ q.value--; }
	}

/****************************************************************************/
/* FONCTIONS RELATIVES A LA PAGE ADRESSE DE LA BOUTIQUE 					*/
/****************************************************************************/

function dupliquerCoordonnees()
	{
	// Duplication des infos Facturation vers infos Livraison
	document.formulaireCommander.nomLivraison.value=document.formulaireCommander.nomFacturation.value;
	document.formulaireCommander.prenomLivraison.value=document.formulaireCommander.prenomFacturation.value;
	document.formulaireCommander.adresseLivraison.value=document.formulaireCommander.adresseFacturation.value;
	document.formulaireCommander.adresseLivraison2.value=document.formulaireCommander.adresseFacturation2.value;
	document.formulaireCommander.codePostalLivraison.value=document.formulaireCommander.codePostalFacturation.value;
	document.formulaireCommander.villeLivraison.value=document.formulaireCommander.villeFacturation.value;
	document.formulaireCommander.telLivraison.value=document.formulaireCommander.telFacturation.value;
	}

function affecterDonneesLivraison(ID_clientLivraison)
	{
	if (ID_clientLivraison!=0)
		{		
		document.formulaireCommander.nomLivraison.value=eval('document.formulaireCommander.nomLivraisonClient_'+ID_clientLivraison+'.value');
		document.formulaireCommander.prenomLivraison.value=eval('document.formulaireCommander.prenomLivraisonClient_'+ID_clientLivraison+'.value');
		document.formulaireCommander.adresseLivraison.value=eval('document.formulaireCommander.adresseLivraisonClient_'+ID_clientLivraison+'.value');
		document.formulaireCommander.adresseLivraison2.value=eval('document.formulaireCommander.adresseLivraison2Client_'+ID_clientLivraison+'.value');
		document.formulaireCommander.codePostalLivraison.value=eval('document.formulaireCommander.codePostalLivraisonClient_'+ID_clientLivraison+'.value');
		document.formulaireCommander.villeLivraison.value=eval('document.formulaireCommander.villeLivraisonClient_'+ID_clientLivraison+'.value');
		document.formulaireCommander.telLivraison.value=eval('document.formulaireCommander.telLivraisonClient_'+ID_clientLivraison+'.value');
		
		for (var i=0; i<document.formulaireCommander.ID_pays.length; i++) 
			{ 
			if (document.formulaireCommander.ID_pays.options[i].value == eval('document.formulaireCommander.ID_paysClient_'+ID_clientLivraison+'.value'))
					{ document.formulaireCommander.ID_pays.options.selectedIndex=i }   
			} // FIN for (var i=0; i<document.formulaireCommander.ID_pays.length; i++) 
		} // FIN if (ID_clientLivraison!=0)
	else
		{
		document.formulaireCommander.nomLivraison.value='';
		document.formulaireCommander.prenomLivraison.value='';
		document.formulaireCommander.adresseLivraison.value='';
		document.formulaireCommander.adresseLivraison2.value='';
		document.formulaireCommander.codePostalLivraison.value='';
		document.formulaireCommander.villeLivraison.value='';
		document.formulaireCommander.telLivraison.value='';
		document.formulaireCommander.messageLivraison.value='';
		document.formulaireCommander.message.value='';
		}
	} // FIN function affecterDonneesLivraison(ID_clientLivraison)

function supprimerAdresseLivraison()
	{
	if (window.confirm("Etes-vous sûr de vouloir supprimer cette adresse de livraison ?"))
		{
		window.location.href="scripts/suppr_adresse.php?ID_clientAdresse="+document.formulaireCommander.choixLivraison.options[document.formulaireCommander.choixLivraison.selectedIndex].value;
		}
	} // FIN function supprimerAdresseLivraison()

function demanderCodes(langue)
	{
	window.open('/boutique/'+langue+'/popup/demander-codes.php','demandeCode','height=335,width=560,toolbar=no,resizable=yes,menubar=yes,scrollbars=yes,Status=yes'); 
	}

/****************************************************************************/
/* FIN FONCTIONS RELATIVES A LA PAGE ADRESSE DE LA BOUTIQUE 								*/
/****************************************************************************/

/****************************************************************************/
/* FONCTIONS RELATIVES A LA PAGE ADRESSE DE LA BOUTIQUE 										*/
/****************************************************************************/

function validerPromotion()
	{
	// Si code promo renseigné alors on l'enregistre
	if (document.forms[0].offreSpeciale.value!='')
		{
		window.self.location.href='scripts/ajout_promo.php?codePromo='+document.forms[0].offreSpeciale.value;
		}
	// Sinon message
	else
		{
		alert("Merci d'indiquer votre offre speciale.");
		} // FIN else
	} // FIN function validerPromotion()

	
function validerChequeCadeau()
	{
	if (verifierFormulaire(document.formReduction))
		{	document.formReduction.submit(); }	
	} // FIN function validerChequeCadeau()
	

function passerCommande()
	{
	if (document.forms['commander'].typePaiement[0].checked==true)
		{
		document.forms['commander'].action='/includes/paiement/call_request.php';
		document.forms['commander'].method='POST';
		document.forms['commander'].submit();
		}
	if (document.forms['commander'].typePaiement[1].checked==true)
		{
		window.self.location.href='paiement-cheque.php';
		}
	if (document.forms['commander'].typePaiement[2].checked==true)
		{
		window.self.location.href='paiement-virement.php';
		}
	if (document.forms['commander'].typePaiement[3].checked==true)
		{
		window.self.location.href='paiement-fax.php';
		}
	}

/****************************************************************************/
/* FONCTIONS RELATIVES AUX PAGES COMPTE CLIENT DE LA BOUTIQUE 							*/
/****************************************************************************/

