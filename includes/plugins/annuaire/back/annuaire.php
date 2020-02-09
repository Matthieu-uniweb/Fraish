<?
header("Expires: 0"); 
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache");
header("Cache-Control: post-check=0,pre-check=0");
header("Cache-Control: max-age=0");
header("Pragma: no-cache");

$classes_supplementaires=array("/includes/plugins/annuaire/includes/classes");
require_once 'DB.php';
include_once(rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/T_LAETIS_site_class.php');
include_once(rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/Tcontact_contact_class.php');
include_once(rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/Tcontact_criteres_specifiques_class.php');
include_once(rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/plugins/formulaires/includes/classes/Tformulaire_class.php');
session_start();

if ($_POST['ID_contact'] && !$_POST['recherche'])
	{
	$annuaireContact = new Tannuaire_contact();
	$conta = $annuaireContact->getContactInformations($_POST['ID_contact'], $_POST['ID_typ_contact']);
	$_POST['recherche'] = $conta['nom'];
	}

if (! $_POST['recherche']) { $_POST['recherche'] = "a"; }
$contact = $service = $structure = 0;

// Recherche de Contacts
if ( ($_POST['ID_typ_contact'] == '1') || ($_POST['ID_typ_contact'] == '') )
	{
	$objet = new Tannuaire_contact_recherche();
	$listeContacts = $objet->rechercherContact($_POST);
	$contact = 1;
	}
// Recherche de Services
else if ($_POST['ID_typ_contact'] == '2')
	{
	$objet = new Tannuaire_service_recherche();
	$listeServices = $objet->rechercherService($_POST);
	$service = 1;
	}
// Recherche de Structures
else if ($_POST['ID_typ_contact'] == '3')
	{
	$objet = new Tannuaire_structure_recherche();
	$listeStructures = $objet->rechercherStructureLettre($_POST);
	$structure = 1;
	}

$numeroPage = $objet->getNumeroPage();
$nombreTotalPage = $objet->getNombreTotalPage();
$nombreReponses = $objet->getNombreReponses();

$options = '';
if ($_POST['options'])
	{ $options = $_POST['options'].','; }
$tabOptions=array();
?>
<html>
<!-- InstanceBegin template="/Templates/annuaire_back_page.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../includes/styles/annuaire_back.css" rel="stylesheet" type="text/css">
<!-- InstanceBeginEditable name="doctitle" -->
<title>Outil de saisie et de gestion des annuaires pratiques</title>
<!-- InstanceEndEditable -->
<script src="../includes/javascript/annuaire_back.js" type="text/javascript" language="javascript"></script>
<!-- InstanceBeginEditable name="head" -->
<script language="javascript">
function allerAPage(numeroPage)
	{
	document.formContenu.numeroPage.value = numeroPage;
	document.formContenu.fonction.value="allerPage";
	document.formContenu.submit();	
	}

function pagePrecedente()
	{
	document.formContenu.fonction.value="pagePrecedente";
	document.formContenu.submit();	
	}

function pageSuivante()
	{
	document.formContenu.fonction.value="pageSuivante";
	document.formContenu.submit();
	}

function contact(ID_contact, ID_typ_contact)
	{	
	document.formContenu.ID_contact.value = ID_contact;
	document.formContenu.ID_typ_contact.value = ID_typ_contact;	
	document.formContenu.numeroPage.value = '1';
	document.formContenu.submit();
	}

function rechercher(requete)
	{
	document.formContenu.recherche.value = requete;
	document.formContenu.numeroPage.value = '1';
	document.formContenu.submit();
	}
</script>
<!-- InstanceEndEditable -->
</head>
<body> 
<table width="767"  border="0" align="center" cellpadding="0" cellspacing="0"> 
 <tr> 
  <td width="204"><img src="../images/back/mail_service.gif" width="204" height="25"></td> 
  <td width="554" align="center" valign="middle" bgcolor="#A0A0A0" class="chapitre"><!-- InstanceBeginEditable name="titre" -->Administration
    des annuaires pratiques<!-- InstanceEndEditable --></td> 
  <td width="9" align="right" valign="top" bgcolor="#A0A0A0"><img src="../images/back/coin_haut.gif" width="9" height="25"></td> 
 </tr> 
</table> 
<table width="767" align="center" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF"> 
 <tr> 
  <td><img src="../images/e.gif" width="767" height="2"></td> 
 </tr> 
</table> 
<table align="center" width="767" border="0" cellspacing="0" cellpadding="0"> 
 <tr> 
  <td width="205" valign="top"><table width="205" border="0" cellspacing="0" cellpadding="0"> 
    <tr> 
     <td width="141" bgcolor="#DF6400"><table width="141" border="0" cellspacing="0" cellpadding="0"> 
       <tr> 
        <td align="left"><img src="../images/back/accueil.gif" width="11" height="13" hspace="5" vspace="0"><a href="index.php" class="menuHaut">Accueil</a></td> 
       </tr> 
       <tr> 
        <td align="left"><img src="../images/back/clients.gif" width="10" height="14" hspace="5" vspace="0"><a href="clients.php" class="menuHaut">Gestion
          des clients</a> </td> 
       </tr> 
      </table></td> 
     <td width="64"><img src="../images/back/habi_01.gif" width="64" height="47"></td> 
    </tr> 
    <tr> 
     <td><img src="../images/e.gif" width="141" height="1"></td> 
     <td><img src="../images/back/habi_02.gif" width="64" height="1"></td> 
    </tr> 
    <tr> 
     <td align="left" bgcolor="#DF6400" class="menuHaut"><img src="../images/e.gif" width="10" height="5">Vos
      structures</td> 
     <td><img src="../images/back/habi_03.gif" width="64" height="17"></td> 
    </tr> 
   </table> 
   <table width="141" border="0" cellspacing="0" cellpadding="0"> 
    <tr> 
     <td><img src="../images/e.gif" width="141" height="1"></td> 
    </tr> 
   </table> 
   <table width="141" border="0" cellpadding="1" cellspacing="0" bgcolor="#000000"> 
    <tr> 
     <td><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#EEEEEE"> 
       <tr> 
        <td><img src="../images/back/puce.gif" width="9" height="7" align="absmiddle"><a href="ajouter_structure.php" class="menu">Ajouter
          une structure</a> </td> 
       </tr> 
       <tr> 
        <td><img src="../images/back/puce.gif" width="9" height="7" align="absmiddle"><a href="modifier_structure.php" class="menu">Rechercher
          une structure</a> </td> 
       </tr> 
      </table></td> 
    </tr> 
   </table> 
   <table width="141" border="0" cellspacing="0" cellpadding="0"> 
    <tr> 
     <td><img src="../images/e.gif" width="141" height="3"></td> 
    </tr> 
   </table> 
   <table width="141" border="0" cellpadding="0" cellspacing="0" bgcolor="#898DB0"> 
    <tr> 
     <td><span class="menuHaut"><img src="../images/e.gif" width="10" height="17" align="absmiddle">Vos
       supports diffusion</span></td> 
    </tr> 
   </table> 
   <table width="141" border="0" cellspacing="0" cellpadding="0"> 
    <tr> 
     <td><img src="../images/e.gif" width="141" height="1"></td> 
    </tr> 
   </table> 
   <table width="141" border="0" cellpadding="1" cellspacing="0" bgcolor="#000000"> 
    <tr> 
     <td><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#EEEEEE"> 
       <tr> 
        <td><img src="../images/back/puce.gif" width="9" height="7" align="absmiddle"><a href="saisir_support.php" class="menu">Ajouter
          un support </a></td> 
       </tr> 
       <tr> 
        <td><img src="../images/back/puce.gif" width="9" height="7" align="absmiddle"><a href="menu_support.php" class="menu">Les
          supports de diffusion </a></td> 
       </tr> 
      </table></td> 
    </tr> 
   </table> 
   <table width="141" border="0" cellspacing="0" cellpadding="0"> 
    <tr> 
     <td><img src="../images/e.gif" width="141" height="3"></td> 
    </tr> 
   </table> 
   <table width="141" border="0" cellpadding="0" cellspacing="0" bgcolor="#D8853D"> 
    <tr> 
     <td><span class="menuHaut"><img src="../images/e.gif" width="10" height="17" align="absmiddle">Votre
       annuaire</span></td> 
    </tr> 
   </table> 
   <table width="141" border="0" cellspacing="0" cellpadding="0"> 
    <tr> 
     <td><img src="../images/e.gif" width="141" height="1"></td> 
    </tr> 
   </table> 
   <table width="141" border="0" cellpadding="1" cellspacing="0" bgcolor="#000000"> 
    <tr> 
     <td><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#EEEEEE"> 
       <tr> 
        <td><img src="../images/back/puce.gif" width="9" height="7" align="absmiddle"><a href="annuaire.php" class="menu">Consulter
          l'annuaire</a></td> 
       </tr> 
       <tr> 
        <td><img src="../images/back/puce.gif" width="9" height="7" align="absmiddle"><a href="statistiques.php" class="menu">Statistiques</a> </td> 
       </tr> 
      </table></td> 
    </tr> 
   </table> 
   <table width="141" border="0" cellspacing="0" cellpadding="0"> 
    <tr> 
     <td><img src="../images/e.gif" width="141" height="3"></td> 
    </tr> 
   </table> 
   <table width="141" border="0" cellpadding="0" cellspacing="0" bgcolor="#8FB089"> 
    <tr> 
     <td><span class="menuHaut"><img src="../images/e.gif" width="10" height="17" align="absmiddle">Outils
       avanc&eacute;s </span></td> 
    </tr> 
   </table> 
   <table width="141" border="0" cellspacing="0" cellpadding="0"> 
    <tr> 
     <td><img src="../images/e.gif" width="141" height="1"></td> 
    </tr> 
   </table> 
   <table width="141" border="0" cellpadding="1" cellspacing="0" bgcolor="#000000"> 
    <tr> 
     <td><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#EEEEEE"> 
       <tr> 
        <td><img src="../images/back/puce.gif" width="9" height="7" align="absmiddle"><a href="exporter.php" class="menu">Exportation</a></td> 
       </tr> 
       <tr> 
        <td><img src="../images/back/puce.gif" width="9" height="7" align="absmiddle"><a href="services_non_lies.php" class="menu">Services
          non liés</a></td> 
       </tr> 
       <tr> 
        <td><img src="../images/back/puce.gif" width="9" height="7" align="absmiddle"><a href="nettoyer.php" class="menu">Nettoyer
          l'annuaire</a> </td> 
       </tr> 
      </table></td> 
    </tr> 
   </table> 
   <table width="141" border="0" cellspacing="0" cellpadding="0"> 
    <tr> 
     <td><img src="../images/e.gif" width="141" height="6"></td> 
    </tr> 
   </table> 
   <table width="141" border="0" cellpadding="0" cellspacing="0" bgcolor="#898DB0"> 
    <tr> 
     <td width="126"><table width="100%"  border="0" cellspacing="0" cellpadding="0"> 
       <tr> 
        <td><img src="../images/back/info.gif" width="21" height="17" hspace="5" vspace="1" align="absmiddle"><a href="infos.php" class="menuHaut">Informations</a></td> 
       </tr> 
       <tr> 
        <td><img src="../images/back/deconnexion.gif" width="21" height="17" hspace="5" vspace="1" align="absmiddle"><a href="index.php" class="menuHaut">D&eacute;connexion</a></td> 
       </tr> 
      </table></td> 
     <td width="15"><img src="../images/back/habi_04.gif" width="15" height="43"></td> 
    </tr> 
   </table> 
   <!-- InstanceBeginEditable name="sousMenuGauche" --> 
   <table width="141" border="0" cellspacing="0" cellpadding="0"> 
    <tr> 
     <td><img src="../images/e.gif" width="141" height="25"></td> 
    </tr> 
   </table> 
   <table width="141" border="0" cellpadding="0" cellspacing="0" bgcolor="#D8853D"> 
    <tr> 
     <td><span class="menuHaut"><img src="../images/e.gif" width="10" height="17" align="absmiddle">Votre
       annuaire</span></td> 
    </tr> 
   </table> 
   <table width="141" border="0" cellspacing="0" cellpadding="0"> 
    <tr> 
     <td><img src="../images/e.gif" width="141" height="1"></td> 
    </tr> 
   </table> 
   <table width="141" border="0" cellpadding="1" cellspacing="0" bgcolor="#000000"> 
    <tr> 
     <td><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#EEEEEE"> 
       <tr> 
        <td><img src="../images/back/puce.gif" width="9" height="7" align="absmiddle"><a href="javascript:;" onClick="contact('', '1');return false;" title="Visualiser les informations sur les contacts de l'annuaire" class="menu">Les
          contacts</a></td> 
       </tr> 
       <tr> 
        <td><img src="../images/back/puce.gif" width="9" height="7" align="absmiddle"><a href="javascript:;" onClick="contact('', '2');return false;" title="Visualiser les informations sur les services" class="menu">Les
          services</a> </td> 
       </tr> 
       <tr> 
        <td><img src="../images/back/puce.gif" width="9" height="7" align="absmiddle"><a href="javascript:;" onClick="contact('', '3');return false;" title="Visualiser les informations sur les structures" class="menu">Les
          structures</a></td> 
       </tr> 
       <tr> 
        <td><img src="../images/e.gif" width="1" height="5"></td> 
       </tr> 
       <tr> 
        <form name="formRecherche" method="post" action="<? echo $_SERVER['PHP_SELF']; ?>"> 
         <td><table width="100%"  border="0" cellspacing="0" cellpadding="0"> 
           <tr> 
            <td nowrap class="texte" align="center"><b>Rechercher un contact
              : </b><br> 
             <input type="text" name="recherche" class="input100" value=""> 
&nbsp;<a href="javascript:;" onClick="document.formRecherche.submit();return false;" class="menu">OK</a></td> 
           </tr> 
          </table></td> 
        </form> 
       </tr> 
      </table></td> 
    </tr> 
   </table> 
   <table width="141" border="0" cellspacing="0" cellpadding="0"> 
    <tr> 
     <td><img src="../images/e.gif" width="141" height="3"></td> 
    </tr> 
   </table> 
   <!-- InstanceEndEditable --> 
   <p>&nbsp;</p> 
   <p><img src="../images/back/mail_service_colonne.gif" width="205" height="144"></p></td> 
  <td width="562" valign="top"><!-- InstanceBeginEditable name="contenu" --> 
   <table width="562" border="0" cellspacing="0" cellpadding="0"> 
    <tr> 
     <td background="../images/back/pointille_contenu.gif"><img src="../images/e.gif" width="1" height="1"></td> 
    </tr> 
    <tr> 
     <td><img src="../images/e.gif" width="562" height="3"></td> 
    </tr> 
   </table> 
   <table width="562" border="0" cellpadding="1" cellspacing="0" bgcolor="#D4D4D4"> 
    <tr> 
     <td><table width="100%"  border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF"> 
       <tr> 
        <td bgcolor="#D9DCEE" class="titre"><img src="../images/back/fleche_titre.gif" width="22" height="18" align="absmiddle">Annuaire</td> 
       </tr> 
       <tr> 
        <td background="../images/back/pointille_titre.gif"><img src="../images/e.gif" width="560" height="1"></td> 
       </tr> 
       <tr> 
        <td><img src="../images/e.gif" width="560" height="20"></td> 
       </tr> 
       <tr> 
        <td><table width="100%"  border="0" cellspacing="0" cellpadding="0"> 
          <form name="formContenu" method="post" action="<? echo $_SERVER['PHP_SELF']; ?>"> 
           <tr> 
            <td align="left"><table width="100%" cellpadding="0" cellspacing="0"> 
              <tr class="en_tete_contenu"> 
               <td><table width="100%" border="0" cellpadding="0" cellspacing="0"> 
                 <tr> 
                  <td align="left" width="4.5%">&nbsp;</td> 
                  <?
										for ($i="a"; ($i<="z") && ($i!="aa"); $i++)
											{ 
											if (strtolower(substr($_POST['recherche'], 0, 1))==$i) 
												{ $class = " class='alphabet_selectionne'"; }
											else 
												{ $class = " class='alphabet'"; } ?> 
                  <td id="alph_<? echo $i; ?>" align="center" <? echo $class; ?> width="3.5%" height="25" onMouseOver="changeAlphabet(this, 'over')" onMouseOut="changeAlphabet(this, 'out')" onClick="rechercher('<? echo $i; ?>');">&nbsp;<img src="../images/back/lettres/lettre_<? echo $i; ?>.gif" border="0">&nbsp;</td> 
                  <? } ?> 
                  <td align="right" width="4.5%">&nbsp;</td> 
                 </tr> 
                </table></td> 
              </tr> 
              <tr class="ligne_contenu"> 
               <td><br> 
                <table width="100%" cellpadding="0" cellspacing="0"> 
                 <? 
									if (count($listeContacts)+count($listeServices)+count($listeStructures) == 0)
										{ ?> 
                 <tr> 
                  <td align="center" bordercolor="#BC829A" class="texte"><b>Votre
                    recherche n'a retourné aucun résultat</b></td> 
                 </tr> 
                 <?
										}
									else
									{
									?> 
                 <tr> 
                  <td align="center"><!-- #BeginLibraryItem "/includes/plugins/annuaire/back/modeles/annuaire_back_criteres2.lbi" --> 
                   <?
if ($options)
	{
	$tabOptions = explode(',', $options);
	}

if (! in_array('unePage', $tabOptions) )
	{
	if ($objet->numeroPage == '')
		{
		$objet->numeroPage = 1;
		}
?> 
                   <table width="95%" border="0" cellspacing="5" cellpadding="0"> 
                    <tr> 
                     <td width="99%" nowrap class="textecourant"><b><? echo $objet->nombreReponses; ?> résultat(s)</b> trouvé(s)
                      sur <? echo $objet->nombreTotalPage; ?> page(s)</td> 
                     <?
	if($objet->numeroPage != 1)
		{
		?> 
                     <td nowrap class="textecourant">&nbsp;&nbsp;<a href="javascript:;" class="lienContact" onClick="pagePrecedente();return false;"><img src="../images/back/precedent.gif" width="11" height="11" border="0"  align="absmiddle"></a>&nbsp;&nbsp;</td> 
                     <?
		}
		?> 
                     <td align="center" nowrap class="textecourant">Page(s) :
                      <?
	for ($i=1; $i <= $objet->nombreTotalPage; $i++)
		{
		if ($i == $objet->numeroPage)
			{
			echo '<b>'.$i.'</b>';
			}
		else
			{
			?> 
                      <a href="javascript:;" class="textecourant" onClick="allerAPage('<? echo $i; ?>');return false;"><? echo $i; ?></a> 
                      <?
			}
		if($i != $objet->nombreTotalPage)
			{
			echo ' - ';
			}
		}
	?> </td> 
                     <?
if($objet->numeroPage < $objet->nombreTotalPage)
	{
	?> 
                     <td nowrap class="textecourant">&nbsp;&nbsp;<a href="javascript:;" class="lienContact" onClick="pageSuivante();return false;"><img src="../images/back/suivant.gif" width="11" height="11" border="0"  align="absmiddle"></a>&nbsp;</td> 
                     <?
	}
	?> 
                    </tr> 
                   </table> 
                   <table width="95%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF"> 
                    <tr> 
                     <td><img src="../images/e.gif" width="1" height="15"></td> 
                    </tr> 
                   </table> 
                   <?
	} // FIN if (! in_array('unePage', $tabOptions) )
?> 
                  <!-- #EndLibraryItem --></td> 
                 </tr> 
                 <tr> 
                  <td><img src="../images/e.gif" width="560" height="10"></td> 
                 </tr> 
                 <?
									if ($contact)
										{ ?> 
                 <tr> 
                  <td><!-- #BeginLibraryItem "/includes/plugins/annuaire/back/modeles/annuaire_back_contacts.lbi" --> 
                   <?
for ($i=0; $i<count($listeContacts); $i++)
			{
			?> 
                   <table width="100%" cellpadding="0" cellspacing="0"> 
                    <tr> 
                     <td align="center" bordercolor="#FFFFFF"><table width="95%" border="0" cellpadding="0" cellspacing="0" bgcolor="#898DB0"> 
                       <tr> 
                        <td width="10" bgcolor="#384089"><img src="../images/e.gif" width="13" height="10"></td> 
                        <td width="99%" class="menuHaut">&nbsp;&nbsp; 
                         <?
			if ($listeContacts[$i]->nom != "") { echo $listeContacts[$i]->afficherContact(); }			
			?> </td> 
                        <td width="10" bgcolor="#384089"><img src="../images/e.gif" width="13" height="10"></td> 
                       </tr> 
                      </table> 
                      <table width="95%" border="1" cellpadding="0" cellspacing="0" bordercolor="#898DB0"> 
                       <?			
			$adresses = $listeContacts[$i]->listerAdresses();
			for($j=0; $j < sizeof($adresses); $j++)
				{
				$adresse = new Tannuaire_adresse($adresses[$j]);
				if($adresse->ville != '')
					{
					?> 
                       <tr> 
                        <td bordercolor="#FAFDFE"><table width="100%"  border="0" cellspacing="3" cellpadding="0"> 
                          <tr> 
                           <td class="texte"><strong>Adresse : </strong><span class="texte"> 
                            <?	echo $adresse->afficherAdresse(); ?> 
                            </span></td> 
                          </tr> 
                         </table></td> 
                       </tr> 
                       <tr> 
                        <td bordercolor="#FAFDFE" bgcolor="#898DB0"><img src="../images/e.gif" width="1" height="1"></td> 
                       </tr> 
                       <?
					} // FIN if($adresse->ville != '')
				} // FIN for($j=0; $j < sizeof($adresses); $j++)

			$communications = $listeContacts[$i]->listerCommunications();
			if (sizeof($communications) > 0)
				{
				?> 
                       <tr> 
                        <td bordercolor="#FAFDFE"><table width="100%"  border="0" cellspacing="3" cellpadding="0"> 
                          <tr> 
                           <td class="texte"><?
				$communications = $listeContacts[$i]->listerCommunications();
				for($k=0; $k < sizeof($communications); $k++)
					{
					$communication = new Tannuaire_communication($communications[$k]);
					echo $communication->afficherCommunication('textecourant');
					}
				?> </td> 
                          </tr> 
                         </table></td> 
                       </tr> 
                       <?
				} // FIN if(sizeof($communications)>0)

			$structuresServices = $listeContacts[$i]->listerStructuresServices();
			if (sizeof($structuresServices) > 0)
			{
			?> 
                       <tr> 
                        <td bordercolor="#FAFDFE"><table width="100%"  border="0" cellspacing="3" cellpadding="0"> 
                          <tr> 
                           <td class="texte"><?
			for ($l=0; $l < sizeof($structuresServices); $l++)
				{ 
				?> 
                            <b><? echo $structuresServices[$l]['nom_structure']; ?></b><br> 
                            Service : <? echo $structuresServices[$l]['nom_service']; ?><br> 
                            <?
				}
			?> </td> 
                          </tr> 
                         </table></td> 
                       </tr> 
                       <?
			} // FIN if(sizeof($contacts)>0)

			switch ($option)
				{
				case 'lier':
					?> 
                       <tr> 
                        <td bordercolor="#FAFDFE"><table width="100%" border="0" cellspacing="0" cellpadding="0"> 
                          <tr> 
                           <td align="right"><a href="javascript:;" class="textecourant" onClick="lierContactAnnuaire('<? echo $_POST['ID_user_courant']; ?>', '<? echo $listeContacts[$i]->ID; ?>'); return false;" title="Ce contact de l'annuaire correspond à l'utilisateur">Lier</a>&nbsp;&nbsp;</td> 
                          </tr> 
                         </table></td> 
                       </tr> 
                       <?
					break;
				
				default:
					break;
				}
			?> 
                      </table> 
                      <br></td> 
                    </tr> 
                   </table> 
                   <?
			} // FIN for ($i=0; $i<count($listeContacts); $i++)
?> 
                   <!-- #EndLibraryItem --></td> 
                 </tr> 
                 <? }
									else if ($service)
										{ ?> 
                 <tr> 
                  <td><!-- #BeginLibraryItem "/includes/plugins/annuaire/back/modeles/annuaire_back_services.lbi" --> 
                   <?
for ($i=0; $i<count($listeServices); $i++)
			{
			?> 
                   <table width="100%" cellpadding="0" cellspacing="0"> 
                    <tr> 
                     <td align="center" bordercolor="#FFFFFF"><table width="95%"  border="0" cellpadding="0" cellspacing="0" bgcolor="#D8853D"> 
                       <tr> 
                        <td width="10" bgcolor="#DF6400"><img src="../images/e.gif" width="13" height="10"></td> 
                        <td width="99%" class="menuHaut">&nbsp;&nbsp; 
                         <?
			if ($listeServices[$i]->nom != "") { echo $listeServices[$i]->nom; } 
			?> </td> 
                        <td width="10" bgcolor="#DF6400"><img src="../images/e.gif" width="13" height="10"></td> 
                       </tr> 
                      </table> 
                      <table width="95%" border="1" cellpadding="0" cellspacing="0" bordercolor="#DF6400"> 
                       <?			
			if ($listeServices[$i]->descriptif != '')
				{ 
			?> 
                       <tr> 
                        <td bordercolor="#FFF2FC"><table width="100%" border="0" cellspacing="3" cellpadding="0"> 
                          <tr> 
                           <td class="texte"><? echo $listeServices[$i]->descriptif; ?></td> 
                          </tr> 
                         </table></td> 
                       </tr> 
                       <?
			 	} // FIN if($listeServices[$i]->descriptif != '')
			
			$structure = new Tannuaire_structure_recherche($listeServices[$i]->getStructure());
			if ($structure->nom)
				{
				?> 
                       <tr> 
                        <td bordercolor="#FFF2FC"><table width="100%" border="0" cellspacing="3" cellpadding="0"> 
                          <tr> 
                           <td class="texte"><b>Structure : </b> 
                            <?	echo $structure->nom; ?></td> 
                          </tr> 
                         </table></td> 
                       </tr> 
                       <?
			 	} // FIN if($listeServices[$i]->descriptif != '')
			
			$adresses = $listeServices[$i]->listerAdresses();
			for($j=0; $j < sizeof($adresses); $j++)
			{
			$adresse = new Tannuaire_adresse($adresses[$j]);
			if ($adresse->ville != '')
				{ 
				?> 
                       <tr> 
                        <td bordercolor="#FFF2FC"><table width="100%"  border="0" cellspacing="3" cellpadding="0"> 
                          <tr> 
                           <td class="texte"><strong>Adresse : </strong><span class="texte"> 
                            <?	echo $adresse->afficherAdresse(); ?> 
                            </span></td> 
                          </tr> 
                         </table></td> 
                       </tr> 
                       <?
				} // FIN if($adresse->ville != '')
			} // FIN for($j=0; $j < sizeof($adresses); $j++)
			$communications = $listeServices[$i]->listerCommunications();
			if (sizeof($communications)>0)
				{ 
			?> 
                       <tr> 
                        <td bordercolor="#FFF2FC"><table width="100%"  border="0" cellspacing="3" cellpadding="0"> 
                          <tr> 
                           <td class="texte"><?
					$communications = $listeServices[$i]->listerCommunications();
					for($k=0; $k < sizeof($communications); $k++)
						{
						$communication = new Tannuaire_communication($communications[$k]['ID_communication']);
						echo $communication->afficherCommunication('textecourant');
						}					
					?> </td> 
                          </tr> 
                         </table></td> 
                       </tr> 
                       <?
				} // FIN if(sizeof($communications)>0)
			$contacts = $listeServices[$i]->listerContacts();
			if (sizeof($contacts)>0)
			{
			?> 
                       <tr> 
                        <td bordercolor="#FFF2FC"><table width="100%"  border="0" cellspacing="3" cellpadding="0"> 
                          <tr> 
                           <td class="texte"><?
					for($l=0; $l < sizeof($contacts); $l++)
						{
						$contactDuService = new Tannuaire_contact($contacts[$l]['ID_contact']);
						echo $contactDuService->afficherContact()."<br>";
						}
					?> </td> 
                          </tr> 
                         </table></td> 
                       </tr> 
                       <?
				} // FIN if(sizeof($contacts)>0)
			?> 
                      </table> 
                      <br></td> 
                    </tr> 
                   </table> 
                   <?
			} // FIN for ($i=0; $i<count($listeServices); $i++)
?> 
                   <!-- #EndLibraryItem --></td> 
                 </tr> 
                 <? }
									else if ($structure)
										{ ?> 
                 <tr> 
                  <td><!-- #BeginLibraryItem "/includes/plugins/annuaire/back/modeles/annuaire_back_structures.lbi" --> 
                   <?
for ($i=0; $i<count($listeStructures); $i++)
			{
			$structure = new Tannuaire_structure_recherche($listeStructures[$i]->ID);
			?> 
                   <table width="100%" cellpadding="0" cellspacing="0"> 
                    <tr> 
                     <td align="center" bordercolor="#FFFFFF"><table width="95%"  border="0" cellpadding="0" cellspacing="0" bgcolor="#8FB089"> 
                       <tr> 
                        <td width="10" bgcolor="#006600"><img src="../images/e.gif" width="13" height="10"></td> 
                        <td width="99%" class="menuHaut">&nbsp;&nbsp; 
                         <?	if ($structure->nom != "") { echo $structure->nom; } ?> </td> 
                        <td width="10" bgcolor="#006600"><img src="../images/e.gif" width="13" height="10"></td> 
                       </tr> 
                      </table> 
                      <table width="95%" border="1" cellpadding="0" cellspacing="0" bordercolor="#006600"> 
                       <tr> 
                        <td bordercolor="#FFF2FC"><table width="100%"  border="0" cellspacing="3" cellpadding="0"> 
                          <tr> 
                           <td class="texte"><strong>Informations : </strong><br> 
                            <span class="texte"> 
                            <?			
			if ($structure->formeJuridique)
				{
				?> 
                            Forme juridique : <? echo $structure->formeJuridique; ?><br> 
                            <?
				}
			if ($structure->anneeCreation)
				{
				?> 
                            Année de création : <? echo $structure->anneeCreation; ?><br> 
                            <?
				}
			if ($structure->ID_typ_classement)
				{
				$classement = $structure->getTypeClassement($structure->ID_typ_classement);
				if ($classement['type_asso'])
					{ ?> 
                            Classement Association : <? echo $classement['type_asso']; ?><br> 
                            <? }
				else if ($classement['type_naf'])
					{ ?> 
                            Classement Naf : <? echo $classement['type_naf']; ?><br> 
                            <? }
				else
					{ ?> 
                            Classement : <? echo $structure->ID_typ_classement; ?><br> 
                            <? }
				}
			if ($structure->siret)
				{
				?> 
                            Numéro Siret : <? echo $structure->siret; ?><br> 
                            <?
				}
			if ($structure->ID_typ_structure)
				{
				?> 
                            Type de structure : <? echo $structure->getTypeStructure($structure->ID_typ_structure); ?><br> 
                            <?
				}
			if ($structure->effectifTotal)
				{
				?> 
                            Effectif : <? echo $structure->effectifTotal; ?><br> 
                            <?
				}
			?> 
                            </span></td> 
                          </tr> 
                         </table></td> 
                       </tr> 
                       <?
			
			if ($structure->descriptif)
			{
			?> 
                       <tr> 
                        <td bordercolor="#FFF2FC" bgcolor="#BC829A"><img src="../images/e.gif" width="1" height="1"></td> 
                       </tr> 
                       <tr> 
                        <td bordercolor="#FFF2FC"><table width="100%"  border="0" cellspacing="3" cellpadding="0"> 
                          <tr> 
                           <td class="texte"><? echo $structure->descriptif; ?> </td> 
                          </tr> 
                         </table></td> 
                       </tr> 
                       <?
			}
			?> 
                      </table> 
                      <br></td> 
                    </tr> 
                   </table> 
                   <?
			} // FIN for ($i=0; $i<count($listeStructures); $i++)
?> 
                   <!-- #EndLibraryItem --></td> 
                 </tr> 
                 <? }
										?> 
                 <tr> 
                  <td><img src="../images/e.gif" width="560" height="10"></td> 
                 </tr> 
                 <tr> 
                  <td align="center"><!-- #BeginLibraryItem "/includes/plugins/annuaire/back/modeles/annuaire_back_criteres2.lbi" --> 
                   <?
if ($options)
	{
	$tabOptions = explode(',', $options);
	}

if (! in_array('unePage', $tabOptions) )
	{
	if ($objet->numeroPage == '')
		{
		$objet->numeroPage = 1;
		}
?> 
                   <table width="95%" border="0" cellspacing="5" cellpadding="0"> 
                    <tr> 
                     <td width="99%" nowrap class="textecourant"><b><? echo $objet->nombreReponses; ?> résultat(s)</b> trouvé(s)
                      sur <? echo $objet->nombreTotalPage; ?> page(s)</td> 
                     <?
	if($objet->numeroPage != 1)
		{
		?> 
                     <td nowrap class="textecourant">&nbsp;&nbsp;<a href="javascript:;" class="lienContact" onClick="pagePrecedente();return false;"><img src="../images/back/precedent.gif" width="11" height="11" border="0"  align="absmiddle"></a>&nbsp;&nbsp;</td> 
                     <?
		}
		?> 
                     <td align="center" nowrap class="textecourant">Page(s) :
                      <?
	for ($i=1; $i <= $objet->nombreTotalPage; $i++)
		{
		if ($i == $objet->numeroPage)
			{
			echo '<b>'.$i.'</b>';
			}
		else
			{
			?> 
                      <a href="javascript:;" class="textecourant" onClick="allerAPage('<? echo $i; ?>');return false;"><? echo $i; ?></a> 
                      <?
			}
		if($i != $objet->nombreTotalPage)
			{
			echo ' - ';
			}
		}
	?> </td> 
                     <?
if($objet->numeroPage < $objet->nombreTotalPage)
	{
	?> 
                     <td nowrap class="textecourant">&nbsp;&nbsp;<a href="javascript:;" class="lienContact" onClick="pageSuivante();return false;"><img src="../images/back/suivant.gif" width="11" height="11" border="0"  align="absmiddle"></a>&nbsp;</td> 
                     <?
	}
	?> 
                    </tr> 
                   </table> 
                   <table width="95%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF"> 
                    <tr> 
                     <td><img src="../images/e.gif" width="1" height="15"></td> 
                    </tr> 
                   </table> 
                   <?
	} // FIN if (! in_array('unePage', $tabOptions) )
?> 
                  <!-- #EndLibraryItem --></td> 
                 </tr> 
                 <?
										} // FIN else ?> 
                </table></td> 
              </tr> 
             </table></td> 
           </tr> 
           <input type="hidden" name="numeroPage" value="<? echo $numeroPage; ?>"> 
           <input type="hidden" name="nombreTotalPage" value="<? echo $nombreTotalPage; ?>"> 
           <input type="hidden" name="nombreReponses" value="<? echo $nombreReponses; ?>"> 
           <input type="hidden" name="ID_contact" value="<? echo $_POST['ID_contact']; ?>"> 
           <input type="hidden" name="ID_typ_contact" value="<? echo $_POST['ID_typ_contact']; ?>"> 
           <input type="hidden" name="recherche" value="<? echo $_POST['recherche']; ?>"> 
           <input type="hidden" name="fonction" value=""> 
          </form> 
         </table></td> 
       </tr> 
       <tr> 
        <td bgcolor="#FFFFFF"><img src="../images/e.gif" width="1" height="10"></td> 
       </tr> 
      </table></td> 
    </tr> 
   </table> 
   <table width="95%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF"> 
    <tr> 
     <td><img src="../../images/e.gif" width="1" height="15"></td> 
    </tr> 
   </table> 
   <!-- InstanceEndEditable --></td> 
 </tr> 
</table> 
</td> 
</tr> 
</table> 
<!-- #BeginLibraryItem "/includes/plugins/annuaire/back/modeles/annuaire_back_pied.lbi" --> 
<table width="767" border="0" align="center" cellpadding="0" cellspacing="0"> 
 <tr> 
  <td width="9"><img src="../images/back/coin_bas_gch.gif" width="9" height="25"></td> 
  <td width="749" align="center" bgcolor="#E5E5E5" class="pied">Une cr&eacute;ation
   La&euml;tis Multim&eacute;dia - Novembre 2004 - <a href="http://www.laetis.fr" target="_blank" class="pied">www.laetis.fr</a> - <a href="mailto:contact@laetis.fr" class="pied">contact@laetis.fr</a> -
   05.65.74.70.97 <br> </td> 
  <td width="9"><img src="../images/back/coin_bas_dt.gif" width="9" height="25"></td> 
 </tr> 
</table> 
<!-- #EndLibraryItem --> 
</body>
<!-- InstanceEnd -->
</html>
