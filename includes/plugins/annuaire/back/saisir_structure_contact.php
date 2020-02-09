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

switch ($_POST['fonction'])
	{
	case 'enregistrerStructureContact':
		$service = new Tannuaire_service($_POST['ID_service']);
		$contact = new Tannuaire_contact($_POST['ID_contact']);
		
		$contact->modifierAttributs($_POST,'contact_');
		$contact->enregistrer();
		
		if ($_POST['contact_defaut'])
			{ $service->lierContact($contact->ID, $_POST['contact_role'], 1); }
		else
			{ $service->lierContact($contact->ID, $_POST['contact_role'], 0); }
		
		$adresse = new Tannuaire_adresse($_POST['adresse_ID']);
		if($_POST['adresse_numeroVoie'] == '')
			{
			$_POST['adresse_numeroVoie'] = 0;
			}
		$adresse->modifierAttributs($_POST,'adresse_');
		$adresse->enregistrer();
		
		// On lie l'adresse pas defaut au contact
		$contact->lierAdresse($adresse->ID, 1);
		
		// Les communications
		for ($i=0; $i < 8; $i++)
			{
			// Si une communication existait et que l'utilisateur l'a effacée
			// Alors on la supprime
			if ( ($_POST['com'][$i]['numero'] == '') && ($_POST['com'][$i]['ID'] != '') )
				{
				$contact->supprimerUneCommunication($_POST['com'][$i]['ID']);
				}
		
			if ($_POST['com'][$i]['numero'] != '')
				{
				$com = new Tannuaire_communication($_POST['com'][$i]['ID']);
				$com->modifierAttributs($_POST['com'][$i]);
				$com->enregistrer();
				if($i == 0)
					{	$contact->lierCommunication($com->ID, 1);	}
				else
					{	$contact->lierCommunication($com->ID, 0);	}
				}
			}
		
		$_POST['ID_contact'] = $contact->ID;
		break;
		// FIN case 'enregistrerStructureContact':
	case 'enregistrerImage':
		$contact = new Tannuaire_contact($_POST['ID_contact']);
		$contact->enregistrerPhoto($_POST, $_FILES);
		break;
			
	} // FIN switch ($_POST['fonction'])

$contact = new Tannuaire_contact($_POST['ID_contact']);
$structure = new Tannuaire_structure($_POST['ID_structure']);
$service = new Tannuaire_service($_POST['ID_service']);
$adresse = new Tannuaire_adresse($contact->ID_adresseDefaut);

$commune = new Tannuaire_commune();
$communication = new Tannuaire_communication();
?>
<html><!-- InstanceBegin template="/Templates/annuaire_back_page.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../includes/styles/annuaire_back.css" rel="stylesheet" type="text/css">
<!-- InstanceBeginEditable name="doctitle" -->
<title>Outil de saisie et de gestion des annuaires pratiques</title>
<!-- InstanceEndEditable -->
<script src="../includes/javascript/annuaire_back.js" type="text/javascript" language="javascript"></script>
<!-- InstanceBeginEditable name="head" -->
<script src="../../../javascript/globals.js" type="text/javascript" language="javascript"></script>
<script src="../../../javascript/fonctions_formulaires.js" type="text/javascript" language="javascript"></script>
<script src="../includes/javascript/annuaire_pop.js" type="text/JavaScript" language="JavaScript"></script>
<script language="javascript">
function envoyerFormulaire(ID_contact, lien)
	{
	an_ouvrePopLayer();	
	document.forms[0].ID_contact.value=ID_contact;
	document.forms[0].action=lien;
	document.forms[0].target="idPopIframe";	
	document.forms[0].submit();
	}
</script>
<!-- InstanceEndEditable -->
</head>
<body>
<table width="767"  border="0" align="center" cellpadding="0" cellspacing="0">
 <tr>
  <td width="204"><img src="../images/back/mail_service.gif" width="204" height="25"></td>
  <td width="554" align="center" valign="middle" bgcolor="#A0A0A0" class="chapitre"><!-- InstanceBeginEditable name="titre" -->Administration des annuaires pratiques<!-- InstanceEndEditable --></td>
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
        <td align="left"><img src="../images/back/clients.gif" width="10" height="14" hspace="5" vspace="0"><a href="clients.php" class="menuHaut">Gestion des clients</a> </td>
       </tr>
      </table></td>
     <td width="64"><img src="../images/back/habi_01.gif" width="64" height="47"></td>
    </tr>
    <tr>
     <td><img src="../images/e.gif" width="141" height="1"></td>
     <td><img src="../images/back/habi_02.gif" width="64" height="1"></td>
    </tr>
    <tr>
     <td align="left" bgcolor="#DF6400" class="menuHaut"><img src="../images/e.gif" width="10" height="5">Vos structures</td>
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
        <td><img src="../images/back/puce.gif" width="9" height="7" align="absmiddle"><a href="ajouter_structure.php" class="menu">Ajouter une structure</a> </td>
       </tr>
       <tr>
        <td><img src="../images/back/puce.gif" width="9" height="7" align="absmiddle"><a href="modifier_structure.php" class="menu">Rechercher une structure</a> </td>
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
     <td><span class="menuHaut"><img src="../images/e.gif" width="10" height="17" align="absmiddle">Vos supports diffusion</span></td>
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
        <td><img src="../images/back/puce.gif" width="9" height="7" align="absmiddle"><a href="saisir_support.php" class="menu">Ajouter un support </a></td>
       </tr>
       <tr>
        <td><img src="../images/back/puce.gif" width="9" height="7" align="absmiddle"><a href="menu_support.php" class="menu">Les supports de diffusion </a></td>
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
     <td><span class="menuHaut"><img src="../images/e.gif" width="10" height="17" align="absmiddle">Votre annuaire</span></td>
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
        <td><img src="../images/back/puce.gif" width="9" height="7" align="absmiddle"><a href="annuaire.php" class="menu">Consulter l'annuaire</a></td>
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
     <td><span class="menuHaut"><img src="../images/e.gif" width="10" height="17" align="absmiddle">Outils avanc&eacute;s </span></td>
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
        <td><img src="../images/back/puce.gif" width="9" height="7" align="absmiddle"><a href="services_non_lies.php" class="menu">Services non liés</a></td>
       </tr>			 
       <tr>
        <td><img src="../images/back/puce.gif" width="9" height="7" align="absmiddle"><a href="nettoyer.php" class="menu">Nettoyer l'annuaire</a> </td>
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
   <!-- InstanceBeginEditable name="sousMenuGauche" --><!-- InstanceEndEditable -->
   <p>&nbsp;</p>
   <p><img src="../images/back/mail_service_colonne.gif" width="205" height="144"></p></td>
  <td width="562" valign="top"><!-- InstanceBeginEditable name="contenu" -->
   <form name="formulaire" method="post" action="">
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
         <td bgcolor="#D9DCEE" class="titre"><img src="../images/back/fleche_titre.gif" width="22" height="18" align="absmiddle">Gestion des contacts</td>
        </tr>
        <tr>
         <td background="../images/back/pointille_titre.gif"><img src="../images/e.gif" width="560" height="1"></td>
        </tr>
        <tr>
         <td><img src="../images/e.gif" width="560" height="20"></td>
        </tr>
        <tr>
         <td><table width="100%" border="0" cellpadding="0" align="center">
           <tr>
            <td><table width="100%"  border="0" cellpadding="0" cellspacing="0" bgcolor="#898DB0">
              <tr>
               <td valign="top"><table width="100%"  border="0" cellspacing="0" cellpadding="5">
                 <tr>
                  <td class="menuHaut">Civilité : </td>
                  <td class="menuHaut"><select name="contact_civilite" class="input100">
                    <option value="Monsieur" <? if ($contact->civilite == 'Monsieur') { echo "selected"; } ?>>Monsieur</option>
                    <option value="Madame" <? if ($contact->civilite == 'Madame') { echo "selected"; } ?>>Madame</option>
                    <option value="Mademoiselle" <? if ($contact->civilite == 'Mademoiselle') { echo "selected"; } ?>>Mademoiselle</option>
                   </select></td>
                 </tr>
                 <tr>
                  <td class="menuHaut">Nom :</td>
                  <td class="menuHaut"><input name="contact_nom" type="text" class="input200" value="<? echo $contact->nom; ?>" onBlur="this.value=this.value.toUpperCase();"></td>
                 </tr>
                 <tr>
                  <td nowrap class="menuHaut">Prénom :</td>
                  <td class="menuHaut"><input name="contact_prenom" type="text" class="input200" value="<? echo $contact->prenom; ?>"></td>
                 </tr>								 <tr valign="top">
								   <td><span class="menuHaut">Descr. :</span></td>
								   <td><span class="menuHaut">
								     <textarea name="contact_descriptif" rows="4" class="input200" id="contact_descriptif"><? echo $contact->descriptif; ?></textarea>
								   </span></td>
							      </tr>
								 <tr>
								 <?
							 	 if ($contact->ID)
									{	?>

								 	<td><a href="popup/popup_uploader_photo.php" target="idPopIframe" class="texte" onClick="envoyerFormulaire('<? echo $contact->ID; ?>',this.href);return false;">Photo</a></td>
									<td><? 
									$nomPhoto = $contact->nommerPhoto();
									if (file_exists($nomPhoto)) { ?><a href="javascript:;" onClick="window.open('preview.php?img=<? echo $nomPhoto; ?>', 'PREVIEW','width=420,height=420,location=no,toolbar=no,status=no,menubar=no,resizable=yes,linkbar=no,scrollbars=no');"><img name="preview_1" src="<? echo $nomPhoto; ?>" width="33" height="33" border="0" align="middle"></a><? } ?></td>
								 </tr>
								 <? } ?>
                </table></td>
               <td valign="top" nowrap><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                 <tr>
                  <td class="textecourant"><table width="100%"  border="0" cellpadding="5" cellspacing="0" class="textecourant">
                    <tr>
                     <td class="menuHaut">Structure :</td>
                     <td class="menuHaut"><? echo $structure->nom; ?></td>
                    </tr>
                    <tr>
                     <td class="menuHaut">Service :</td>
                     <td class="menuHaut"><? echo $service->nom; ?></td>
                    </tr>
                    <tr>
                     <td class="menuHaut">R&ocirc;le</td>
                     <td class="menuHaut"><input name="contact_role" type="text" class="input150" value="<? echo $service->getRole($contact->ID); ?>" onKeyPress="return verifierCaracteres();"></td>
                    </tr>
                    <tr valign="top">
                     <td nowrap class="menuHaut">Contact par défaut <br>
                       du service :</td>
                     <td class="menuHaut"><input type="checkbox" name="contact_defaut" <? if ($service->ID_contactDefaut == $contact->ID) { echo "checked"; } ?> value="1"></td>
                    </tr>
                   </table></td>
                 </tr>
                </table></td>
              </tr>
             </table></td>
           </tr>
          </table></td>
        </tr>
        <tr>
         <td><img src="../images/e.gif" width="560" height="20"></td>
        </tr>
        <tr>
         <td><table width="100%" border="0" cellpadding="0" align="center">
           <tr>
            <td><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#EEEEEE">
              <tr>
               <td><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                 <tr>
                  <td valign="top"><table width="100%"  border="0" cellspacing="0" cellpadding="5">
                    <tr>
                     <td height="20" bgcolor="#898DB0" class="menuHaut">Informations sur le contact</td>
                    </tr>
                    <tr>
                     <td><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                       <tr>
                        <td valign="top" class="texte">N&deg; : <br>
                         <input name="adresse_numeroVoie" type="text" class="input50" maxlength="5" value="<? echo $adresse->numeroVoie; ?>"  onKeyPress="return verifierSaisieChiffres();"></td>
                        <td width="30" nowrap class="texte">&nbsp;</td>
                        <td valign="top" class="texte">Voie : <br>
                         <input name="adresse_voie" type="text" class="input200" value="<? echo $adresse->voie; ?>"></td>
                        <td width="30" nowrap class="texte">&nbsp;</td>
                        <td valign="top" class="texte">Compl&eacute;ment : <br>
                         <textarea name="adresse_complement" class="inputTextearea"><? echo $adresse->complement; ?></textarea></td>
                        <td>&nbsp;</td>
                       </tr>
                      </table></td>
                    </tr>
                    <tr>
                     <td><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                       <tr class="texte">
                        <td class="texte">Commune :<br>
                         <select name="adresse_commune" class="input150" onChange="affecterDonneesInsee(options[this.selectedIndex].value, options[this.selectedIndex].text),''">
                          <?
												 $communes = $commune->listerCommunes();
												 for ($c=0; $c < count($communes); $c++)
													{ 
													$commune = new Tannuaire_commune($communes[$c]['ID']);
													?>
                          <option value="<? echo $commune->inseeCommune.','.$commune->codePostalDefaut; ?>" <? if ($commune->inseeCommune == $adresse->codeInsee) { echo 'selected'; } ?>><? echo $commune->nom; ?></option>
                          <? } ?>
													 <option value="99999,00000" <? if ($adresse->codeInsee == '99999') { echo 'selected'; } ?>>Hors Territoire</option>
													 <option value="0,0" <? if ($adresse->codeInsee == '0') { echo 'selected'; } ?>>Adresse Inconnue</option>
                           <option value="100000," <? if ($adresse->codeInsee == '100000') { echo 'selected'; } ?>>Adresse Inutile</option>
                         </select></td>
                        <td width="30" nowrap>&nbsp;</td>
                        <td nowrap class="texte">CP :<br>
                         <input name="adresse_codePostal" type="text" class="input50" value="<? echo $adresse->codePostal; ?>" maxlength="5"  onKeyPress="return verifierSaisieChiffres();">
                         <input name="adresse_codeInsee" type="hidden" value="<? echo $adresse->codeInsee; ?>">
                         <input name="adresse_ID" type="hidden" value="<? echo $adresse->ID; ?>">
                        </td>
                        <td width="30" nowrap>&nbsp;</td>
                        <td class="texte">Ville :<br>
                         <input name="adresse_ville" type="text" class="input150" value="<? echo $adresse->ville; ?>"></td>
                        <td width="30" nowrap>&nbsp;</td>
                        <td valign="top" nowrap class="texte">Compl&eacute;ment CP : <br>
                         <input name="adresse_complementVille" type="text" class="input50" value="<? echo $adresse->complementVille; ?>" maxlength="5"></td>
                        <td width="100">&nbsp;</td>
                       </tr>
                      </table></td>
                    </tr>
                    <tr>
                     <td><hr width="99%" color="#666666" size="1"></td>
                    </tr>
                    <tr>
                     <td><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                       <? 
										$j=0;
										$communications = $contact->listerCommunications();
										while ($j< count($communications))
											{
											if ($j%2 == '0')
												{ 
												$communication = new Tannuaire_communication($communications[$j]);
												?>
                       <tr class="texte">
                        <td><? echo $communication->genererSelect("com[$j][ID_communication]", $communication->listerTypeCommunication(), 'ID', 'type', $communication->ID_communication, 'input150'); ?>
                         <input name="com[<? echo $j; ?>][numero]" type="text" class="input100" value="<? echo $communication->numero; ?>">
                         <input name="com[<? echo $j; ?>][ID]" type="hidden" value="<? echo $communication->ID; ?>">
                        </td>
                        <? $j++;
												}
											else
												{ 
												$communication = new Tannuaire_communication($communications[$j]);
												?>
                        <td><? echo $communication->genererSelect("com[$j][ID_communication]", $communication->listerTypeCommunication(), 'ID', 'type', $communication->ID_communication, 'input150');?>
                         <input name="com[<? echo $j; ?>][numero]" type="text" class="input100" value="<? echo $communication->numero; ?>">
                         <input name="com[<? echo $j; ?>][ID]" type="hidden" value="<? echo $communication->ID; ?>">
                        </td>
                       </tr>
                       <? $j++;
							 		}
								} // FIN while ($j< count($communications))

							for ($a=count($communications); $a < 8; $a++)
								{
								if ($a%2 == '0')
									{ ?>
                       <tr class="texte">
                        <td><? echo $communication->genererSelect("com[$a][ID_communication]", $communication->listerTypeCommunication(), 'ID', 'type', $a+1, 'input150'); ?>
                         <input name="com[<? echo $a; ?>][numero]" type="text" class="input100"></td>
                        <? $j++;
									}
								else
									{ ?>
                        <td><? echo $communication->genererSelect("com[$a][ID_communication]", $communication->listerTypeCommunication(), 'ID', 'type', $a+1, 'input150');?>
                         <input name="com[<? echo $a; ?>][numero]" type="text" class="input100"></td>
                       </tr>
                       <?
							 		} // FIN else
								}	// FIN for ($a=count($communications); $a < 8; $a++) ?>
                      </table></td>
                    </tr>
                   </table></td>
                 </tr>
                </table></td>
              </tr>
             </table></td>
           </tr>
          </table></td>
        </tr>
        <tr>
         <td><img src="../images/e.gif" width="1" height="10"></td>
        </tr>
        <tr>
         <td align="right"><input type="submit" name="Enregistrer" value="enregistrer" class="bouton"></td>
        </tr>
        <tr>
         <td><img src="../images/e.gif" width="1" height="20"></td>
        </tr>
        <tr>
         <td align="right"><a href="javascript:;" onClick="allerASaisie(); return false;" class="textecourant">Revenir à la saisie de la structure</a></td>
        </tr>
        <tr>
         <td><img src="../images/e.gif" width="1" height="10"></td>
        </tr>
       </table></td>
     </tr>
    </table>
	 <div id="popLayer" style="position:absolute; left:640px; top:-500px; width:404px; height:216px; z-index:1; visibility: hidden; overflow:visible;" class="popStyle">
    <table width="100%" height="214"  border="0" cellpadding="0" cellspacing="0">
     <tr>
      <td valign="middle" class="texte"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
         <td><a href="javascript:;" onMouseDown="MM_dragLayer('popLayer','',0,0,0,0,true,false,-1,-1,-1,-1,false,false,0,'',false,'')"><img src="../images/back/pop_poignee.gif" width="14" height="14" border="0"></a></td>
         <td align="right"><a href="javascript:;" onClick="an_closePop();"><img src="../images/back/pop_fermer.gif" width="45" height="14" hspace="1" border="0"></a></td>
        </tr>
       </table></td>
     </tr>
     <tr>
      <td align="center" valign="top"><iframe scrolling="yes" frameborder="0" name="idPopIframe" id="idPopIframe" src="" style="position:relative; left:0px; top:0px; width:400px; height:200px; z-index:1; overflow:hidden;"></iframe></td>
     </tr>
    </table>
   </div>
    <input type="hidden" name="ID_contact" value="<? echo $_POST['ID_contact']; ?>">
    <input type="hidden" name="ID_structure" value="<? echo $_POST['ID_structure']; ?>">
    <input type="hidden" name="ID_service" value="<? echo $_POST['ID_service']; ?>">
		<input type="hidden" name="fonction" value="enregistrerStructureContact">
   </form>
   <form name="formAction" method="post" action="">
    <input type="hidden" name="ID_contact" value="<? echo $_POST['ID_contact']; ?>">
    <input type="hidden" name="ID_structure" value="<? echo $_POST['ID_structure']; ?>">
    <input type="hidden" name="ID_service" value="<? echo $_POST['ID_service']; ?>">	 
   </form>
			<table width="100%" border="0" cellpadding="0" cellspacing="0"> 
					<tr> 
							<td><img src="../../images/e.gif" width="1" height="15"></td> 
					</tr> 
			</table> 			
   <!-- InstanceEndEditable --></td>
 </tr>
</table>
</td>
</tr>
</table><!-- #BeginLibraryItem "/includes/plugins/annuaire/back/modeles/annuaire_back_pied.lbi" --><table width="767" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td width="9"><img src="../images/back/coin_bas_gch.gif" width="9" height="25"></td>
		<td width="749" align="center" bgcolor="#E5E5E5" class="pied">Une cr&eacute;ation
			La&euml;tis Multim&eacute;dia
			- Novembre 2004 - <a href="http://www.laetis.fr" target="_blank" class="pied">www.laetis.fr</a>  -
		<a href="mailto:contact@laetis.fr" class="pied">contact@laetis.fr</a> - 05.65.74.70.97 <br>		</td>
		<td width="9"><img src="../images/back/coin_bas_dt.gif" width="9" height="25"></td>
	</tr>
</table><!-- #EndLibraryItem --></body>
<!-- InstanceEnd --></html>
