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

$structure = new Tannuaire_structure($_POST['ID_structure']);

switch ($_POST['fonction'])
	{	
	case 'saisirStructure':
		$_POST['structure_ID_typ_classement'] = $_POST[$_POST['classement']];

		// On enregistre la structure		
		$structure->modifierAttributs($_POST,'structure_');
		$structure->enregistrer();
		
		if (! $_POST['ID_structure'])
			{ $_POST['ID_structure'] = $structure->ID; }
		
		// On enregistre le(s) service(s)
		if ($_POST['service'])
			{
			while(list ($ID_service) = each ($_POST['service'])) 
				{
				$service = new Tannuaire_service($ID_service);
				$service->modifierAttributs($_POST['service'][$ID_service]);
				$service->enregistrer();
				
				// On lie le service à la structure
				if ($_POST['service'][$ID_service]['defaut'])
					{ $structure->lierService($service->ID, 1); }
				else
					{ $structure->lierService($service->ID, 0); }
				
				// On lie l'adresse au service
				// Si il s'agit du service par défaut, ou si la case 'Dupliquer l'adresse' n'est pas cochée 
				// (cela signifie que c'est une adresse différente de l'adresse du service par défaut)
				if ( ($_POST['service'][$ID_service]['defaut']) || ($_POST['adresse'][$ID_service]['checkParDefaut'] != '1') )
					{
					/*if (($_POST['adresse'][$ID_service]['checkParDefaut'] != '1'))
						{ $service->supprimerAdresses(); } */
		
					$adresse = new Tannuaire_adresse($_POST['adresse'][$ID_service]['ID']);
					if($_POST['adresse'][$ID_service]['numeroVoie'] == '')
						{
						$_POST['adresse'][$ID_service]['numeroVoie'] = 0;
						}
					$adresse->modifierAttributs($_POST['adresse'][$ID_service]);
					$adresse->enregistrer();
			
					// On lie l'adresse pas defaut au service
					$service->delierAdresses();
					$service->lierAdresse($adresse->ID, 1);
					}
			
				// On lie les communications
				for ($k=0; $k<8; $k++)
					{
					// Si une communication existait et que l'utilisateur l'a effacée
					// Alors on la supprime
					if ( ($_POST['com'][$ID_service][$k]['numero'] == '') && ($_POST['com'][$ID_service][$k]['ID'] != '') )
						{
						$service->supprimerUneCommunication($_POST['com'][$ID_service][$k]['ID']);
						}
			
					if ($_POST['com'][$ID_service][$k]['numero'] != '')
						{
						$com = new Tannuaire_communication($_POST['com'][$ID_service][$k]['ID']);
						$com->modifierAttributs($_POST['com'][$ID_service][$k]);
						$com->enregistrer();
						if ($k == 0)
							{ $service->lierCommunication($com->ID, 1);	}
						else
							{	$service->lierCommunication($com->ID, 0);	}
						}
					} // FIN for ($k=0; $k<=5; $k++)
				} // FIN while(list ($ID_service) = each ($_POST['service'])) 
			} // FIN if ($_POST['service'])
		break;

	case 'ajouterService':
		// Nouveau service
		$service = new Tannuaire_service();
		// Nom du service donné par défaut
		$_POST['nom'] = "Accueil / Standard";
		$service->modifierAttributs($_POST);
		$service->enregistrer();
		// Si la structure n'a pas encore de service par défaut
		if (! $structure->ID_serviceDefaut)
			{	$structure->lierService($service->ID, 1); }
		else
			{	
			$structure->lierService($service->ID, 0); 
			$serviceDefaut = new Tannuaire_service($structure->ID_serviceDefaut);
			$service->lierAdresse($serviceDefaut->ID_adresseDefaut, 1);
			}
		$_POST['ID_service'] = $service->ID;
		break;
	case 'allerAPage':
		$_POST['page'] = $_POST['page'];
		break;
	case 'dupliquerServiceAdresse':
		$structure->dupliquerServiceAdresse($_POST['ID_service']);
		break;
	case 'dupliquerServiceCommunication':
		$structure->dupliquerServiceCommunication();
		break;
	case 'dupliquerServiceContact':
		$structure->dupliquerServiceContact();
		break;
	case 'supprimerContact':
		$service = new Tannuaire_service($_POST['ID_service']);
		$service->supprimerUnContact($_POST['ID_contact']);
		break;
	case 'supprimerService':
		$service = new Tannuaire_service($_POST['ID_service']);
		$service->supprimer();
		break;
	case 'changerVisibilite':
		$categorie = new Tannuaire_categorie($_POST['ID_categorie']);
		$categorie->modifierVisibilite($_POST['ID_service']);
		break;
	case 'enregistrerImage':
		$service = new Tannuaire_service($_POST['ID_service']);
		$service->enregistrerPhoto($_POST, $_FILES);
		break;		
	case 'supprimerStructure':
		$structure->supprimer();
		header("Location:index.php");
		break;
	} // FIN switch ($_POST['fonction'])

$objet = new Tannuaire_structure_recherche($_POST['ID_structure']);
$objet->nombreReponseParPage = 3;
$listeServices = $objet->listerServices($_POST);

$commune = new Tcommune();
$communication = new Tannuaire_communication();
$serviceDefaut = new Tannuaire_service($objet->ID_serviceDefaut);

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
<script src="../includes/javascript/annuaire_fonctions_moteur_recherche.js" type="text/javascript" language="javascript"></script>
<script src="../../../javascript/fonctions_formulaires.js" type="text/javascript" language="javascript"></script>
<script src="../../../javascript/globals.js" type="text/javascript" language="javascript"></script>
<script src="../includes/javascript/annuaire_pop.js" type="text/JavaScript" language="JavaScript"></script>
<script language="javascript">
function envoyerFormulaire(ID_service, lien)
	{
	an_ouvrePopLayer();
	document.formAction.ID_service.value=ID_service;
	document.formAction.target="idPopIframe";
	document.formAction.action=lien;
	document.formAction.submit();
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
      <td><table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF"> 
        <tr> 
         <td bgcolor="#D9DCEE" class="titre"><img src="../images/back/fleche_titre.gif" width="22" height="18" align="absmiddle">Gestion
          des structures</td> 
        </tr> 
        <tr> 
         <td background="../images/back/pointille_titre.gif"><img src="../images/e.gif" width="560" height="1"></td> 
        </tr> 
        <tr> 
         <td><img src="../images/e.gif" width="1" height="20"></td> 
        </tr> 
        <tr> 
         <td><table width="100%" border="0" cellpadding="0" align="center"> 
           <tr> 
            <td><table width="100%"  border="0" cellpadding="0" cellspacing="0" bgcolor="#898DB0"> 
              <tr> 
               <td valign="top"><table width="100%"  border="0" cellspacing="0" cellpadding="5"> 
                 <tr> 
                  <td class="menuHaut">Nom :</td> 
                  <td><input name="structure_nom" type="text" class="input200" value="<? if ($objet->nom) { echo $objet->nom; } else { echo stripslashes($_POST['libelle']); } ?>"></td> 
                 </tr> 
                 <tr> 
                  <td valign="top" nowrap class="menuHaut">Descriptif :</td> 
                  <td><textarea name="structure_descriptif" rows="3" class="inputTextearea"><? echo $objet->descriptif; ?></textarea></td> 
                 </tr> 
                </table></td> 
               <td valign="top" nowrap><table width="100%"  border="0" cellspacing="0" cellpadding="0"> 
                 <tr> 
                  <td><table width="100%"  border="0" cellpadding="5" cellspacing="0"> 
                    <tr> 
                     <td nowrap class="menuHaut">Type de structure :</td> 
                     <td><select name="structure_ID_typ_structure" class="input150" onChange="affecterTypStructure(options[this.selectedIndex].value);"> 
                       <? 
											$typStructures = $objet->listerTypeStructure(); 
											for ($t=0; $t < count($typStructures); $t++)
												{ 
												if ($typStructures[$t]['ID'] == $objet->ID_typ_structure)
													{ $selected = "selected"; }
												else
													{ $selected = ""; }
												?> 
                       <option value="<? echo $typStructures[$t]['ID']; ?>" <? echo $selected; ?>><? echo $typStructures[$t]['type']; ?></option> 
                       <? } ?> 
                      </select></td> 
                     <td class="menuHaut">Effectif total :</td> 
                     <td><input name="structure_effectifTotal" type="text" class="input50" value="<? echo $objet->effectifTotal; ?>" onKeyPress="return verifierSaisieChiffres();"></td> 
                    </tr> 
                    <tr> 
                     <td class="menuHaut">Forme juridique :</td> 
                     <td><input name="structure_formeJuridique" type="text" class="input150" value="<? echo $objet->formeJuridique; ?>" onKeyPress="return verifierCaracteres();"></td> 
                     <td nowrap class="menuHaut">Année de création :</td> 
                     <td><input name="structure_anneeCreation" type="text" class="input50" value="<? echo $objet->anneeCreation; ?>" maxlength="4" onKeyPress="return verifierSaisieChiffres();"></td> 
                    </tr> 
                    <tr> 
                     <td class="menuHaut">SIRET : </td> 
                     <td><input name="structure_siret" type="text" class="input100" value="<? echo $objet->siret; ?>" onKeyPress="return verifierCaracteres();"></td> 
                     <td class="menuHaut">ID : </td> 
                     <td class="menuHaut"><? echo $objet->ID; ?></td> 
                    </tr> 
                   </table></td> 
                 </tr> 
                </table></td> 
              </tr> 
              <tr> 
               <td colspan="2"><div id="divNaf" style="visibility:hidden; display:none; z-index: 15;"> 
                 <table width="100%"  border="0" cellspacing="0" cellpadding="2"> 
                  <tr> 
                   <td class="menuHaut" width="100"><input type="radio" id="classNaf2" value="classNaf" name="classement"> 
                    Code NAF : </td> 
                   <td class="menuHaut"><? echo $objet->genererSelect('classNaf', $objet->listerCodesNaf(), 'ID', 'type', $objet->ID_typ_classement, 'input500');?></td> 
                  </tr> 
                 </table> 
                </div> 
                <div id="divAssoc" style="visibility:hidden; display:none; z-index: 15;"> 
                 <table width="100%"  border="0" cellspacing="0" cellpadding="2"> 
                  <tr> 
                   <td class="menuHaut" width="150"><input type="radio" id="classAssoc2" value="classAssoc" name="classement"> 
                    Code Assoc - Adm. : </td> 
                   <td class="menuHaut"><? echo $objet->genererSelect('classAssoc', $objet->listerCodesAssociations(), 'ID', 'type', $objet->ID_typ_classement, 'input500');?></td> 
                  </tr> 
                 </table> 
                </div></td> 
              </tr> 
             </table></td> 
           </tr> 
          </table> 
          <script language="javascript">
affecterTypStructure(document.forms[0].structure_ID_typ_structure.options[document.forms[0].structure_ID_typ_structure.selectedIndex].value);
					</script> </td> 
        </tr> 
        <tr> 
         <td width="95%" align="center"><table width="95%" border="0" cellspacing="0" cellpadding="0"> 
           <tr> 
            <td><input type="submit" name="Enregistrer" value="Enregistrer" class="bouton"></td> 
            <td align="right"><a href="javascript:;" onClick="if (confirm('Etes-vous sûr de vouloir supprimer cette structure ? \nAttention ceci supprimera également toutes les services, contacts, adresses et communications de cette structure !!')) { supprimerStructure();return false; }" class="textecourant"><img src="../images/back/supprimer.gif" border="0" alt="Supprimer cette structure"></a> <a href="javascript:;" class="textecourant" onClick="ajouterService('<? echo $_POST['ID_structure']; ?>');return false;"><img src="../images/back/ajouter.gif" border="0" alt="Ajouter un service"></a> 
             <?
					 if ($nombreReponses > 1)
						{ ?> 
             <a href="javascript:;" onClick="if (confirm('Etes-vous sûr de vouloir dupliquer l\'adresse du service par d&eacute;faut &agrave; tous les autres services ?')) { dupliquer('Adresse','');return false; }" class="textecourant"><img src="../images/back/copier.gif" border="0" alt="Dupliquer l'adresse du service par d&eacute;faut &agrave; tous les autres services"></a> <a href="javascript:;" onClick="if (confirm('Etes-vous sûr de vouloir dupliquer les communications du service par d&eacute;faut &agrave; tous les autres services ?')) { dupliquer('Communication','');return false; }" class="textecourant"><img src="../images/back/copier.gif" border="0" alt="Dupliquer les communications du service par d&eacute;faut &agrave; tous les autres services"></a> <a href="javascript:;" onClick="if (confirm('Etes-vous sûr de vouloir dupliquer les contacts du service par d&eacute;faut &agrave; tous les autres services ?')) { dupliquer('Contact','');return false; }" class="textecourant"><img src="../images/back/copier.gif" border="0" alt="Dupliquer les contacts du service par d&eacute;faut &agrave; tous les autres services"></a> 
             <? } ?> </td> 
           </tr> 
          </table></td> 
        </tr> 
        <tr> 
         <td><hr width="95%" align="center" size="1" color="#898DB0"></td> 
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
        <tr> 
         <td><?
					for ($i=0; $i<count($listeServices); $i++)
						{
						$service = new Tannuaire_service($listeServices[$i]['ID']);
						$adresse = new Tannuaire_adresse($service->ID_adresseDefaut);
						$communications = $service->listerCommunications();
					
						if ( ($service->ID == $_POST['ID_service']) || (! $service->nom) )
							{ $style = "visibility:visible; display:block; z-index: 5;"; }
						else if ($objet->getServiceDefaut($service->ID))
							{ $style = "visibility:visible; display:block; z-index: 5;"; }							
						else
							{ $style = "visibility:hidden; display:none; z-index: 5;"; }
					?> 
          <table width="100%" border="0" cellpadding="0" align="center"> 
           <tr> 
            <td><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#EEEEEE"> 
              <tr> 
               <td><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#898DB0"> 
                 <tr> 
                  <td class="menuHaut" height="20" width="99%">&nbsp;<a href="javascript:;" onClick="afficheService('service<? echo $service->ID; ?>');return false;" class="menuHaut"> 
                   <? 
									 if ($service->nom) { echo $service->nom.' ('.$service->ID.')'; } /*else { echo "Veuillez indiquer un nom pour ce service"; }*/ ?> 
                   </a></td> 
                  <td width="100" nowrap><a href="javascript:;" class="textecourant" onClick="if (confirm('Etes-vous sûr de vouloir supprimer ce service ?')) { supprimerService('<? echo $service->ID; ?>');return false; }">Supprimer</a></td> 
                  <td align="right" class="menuHaut" nowrap>Par défaut
                   <input type="radio" name="service[<? echo $service->ID; ?>][defaut]" <? if ($objet->getServiceDefaut($service->ID)) { echo "checked"; } ?> value="1"> 
&nbsp;&nbsp;</td>
                 </tr> 
                </table></td> 
              </tr> 
              <tr> 
               <td><div id="service<? echo $service->ID; ?>" style="<? echo $style; ?>"> 
                 <table width="100%"  border="0" cellspacing="0" cellpadding="0"> 
                  <tr> 
                   <td valign="top"><table width="100%"  border="0" cellspacing="5" cellpadding="0"> 
                     <tr> 
                      <td><table width="100%" border="0" cellspacing="0" cellpadding="0"> 
                        <tr> 
                         <td class="texte">Nom : </td> 
                         <td><input name="service[<? echo $service->ID; ?>][nom]" type="text" class="input200" value="<? echo $service->nom; ?>"></td> 
                        </tr> 
                        <tr> 
                         <td class="texte">Descriptif : </td> 
                         <td><textarea name="service[<? echo $service->ID; ?>][descriptif]" class="inputTextearea"><? echo $service->descriptif; ?></textarea></td> 
                        </tr> 
                       </table></td> 
                     </tr> 
                     <tr> 
                      <td bgcolor="#898DB0"><img src="../images/e.gif" width="99%" height="1"></td> 
                     </tr> 
                     <? 
										 $class = 'input';
										 $disabled = '';
											 if (! $objet->getServiceDefaut($service->ID))
												{ 
												if ($serviceDefaut->ID_adresseDefaut == $service->ID_adresseDefaut) 
													{	
													$class = 'inputGrise'; 
													$disabled = ' disabled';
													}
											?> 
                     <tr> 
                      <td class="texte"><input type="checkbox" name="adresse[<? echo $service->ID; ?>][checkParDefaut]" value="1" <? if ($serviceDefaut->ID_adresseDefaut == $service->ID_adresseDefaut) { echo 'checked'; } ?> onClick="modifierAdresseDefaut(this, '<? echo $service->ID; ?>');"> 
                       Même adresse que le service par défaut </td> 
                     </tr> 
                     <? } ?> 
                     <tr> 
                      <td><table width="100%"  border="0" cellspacing="0" cellpadding="0"> 
                        <tr> 
                         <td valign="top" class="texte">N&deg; : <br> 
                          <input name="adresse[<? echo $service->ID; ?>][numeroVoie]" type="text" class="<? echo $class; ?>50" maxlength="5" value="<? echo $adresse->numeroVoie; ?>" onKeyPress="return verifierSaisieChiffres();" <? echo $disabled; ?>></td> 
                         <td width="10" nowrap>&nbsp;</td> 
                         <td valign="top" class="texte">Voie : <br> 
                          <input name="adresse[<? echo $service->ID; ?>][voie]" type="text" class="<? echo $class; ?>200" value="<? echo $adresse->voie; ?>" <? echo $disabled; ?>> 
                          (ex: avenue des Rosiers)</td> 
                         <td width="10" nowrap>&nbsp;</td> 
                         <td valign="top" class="texte">Compl&eacute;ment : <br> 
                          <textarea name="adresse[<? echo $service->ID; ?>][complement]" class="<? echo $class; ?>textearea" <? echo $disabled; ?>><? echo $adresse->complement; ?></textarea></td> 
                         <td width="99%" class="texte">&nbsp;</td> 
                        </tr> 
                       </table></td> 
                     </tr> 
                     <tr> 
                      <td><table width="100%"  border="0" cellspacing="0" cellpadding="0"> 
                        <tr> 
                         <td class="texte">Commune :<br> 
                          <select name="adresse[<? echo $service->ID; ?>][commune]" class="<? echo $class; ?>150" onChange="affecterDonneesInsee(options[this.selectedIndex].value, options[this.selectedIndex].text, '<? echo $service->ID; ?>')" <? echo $disabled; ?>> 
                           <?
													 $communes = $commune->listerCommunes();
													 for ($c=0; $c < count($communes); $c++)
														{ 
														$commune = new Tannuaire_commune($communes[$c]['ID']);
														?> 
                           <option value="<? echo $commune->inseeCommune.','.$commune->codePostalDefaut; ?>" <? if ($commune->inseeCommune == $adresse->codeInsee) { echo 'selected'; } ?>><? echo $commune->nom; ?></option> 
                           <? } ?> 
                           <option value="99999,00000" <? if ($adresse->codeInsee == '99999') { echo 'selected'; } ?>>Hors
                           Territoire</option> 
                           <option value="0,0" <? if ($adresse->codeInsee == '0') { echo 'selected'; } ?>>Adresse
                           Inconnue</option> 
                           <option value="100000," <? if ($adresse->codeInsee == '100000') { echo 'selected'; } ?>>Adresse
                           Inutile</option> 
                          </select></td> 
                         <td width="10" nowrap>&nbsp;</td> 
                         <td nowrap class="texte">CP :<br> 
                          <input name="adresse[<? echo $service->ID; ?>][codePostal]" type="text" class="<? echo $class; ?>50" value="<? echo $adresse->codePostal; ?>" maxlength="5" onKeyPress="return verifierSaisieChiffres();" <? echo $disabled; ?>> 
                          <input name="adresse[<? echo $service->ID; ?>][codeInsee]" type="hidden" value="<? echo $adresse->codeInsee; ?>" <? echo $disabled; ?>> 
                          <input name="adresse[<? echo $service->ID; ?>][ID]" type="hidden" value="<? echo $adresse->ID; ?>" <? echo $disabled; ?>> </td> 
                         <td width="10" nowrap>&nbsp;</td> 
                         <td class="texte">Ville :<br> 
                          <input name="adresse[<? echo $service->ID; ?>][ville]" type="text" class="<? echo $class; ?>100" value="<? echo $adresse->ville; ?>" <? echo $disabled; ?>></td> 
                         <td width="10" nowrap>&nbsp;</td> 
                         <td valign="top" nowrap class="texte">Compl&eacute;ment
                          CP : <br> 
                          <input name="adresse[<? echo $service->ID; ?>][complementVille]" type="text" class="<? echo $class; ?>50" value="<? echo $adresse->complementVille; ?>" maxlength="10" <? echo $disabled; ?>></td> 
                         <td width="99%">&nbsp;</td> 
                        </tr> 
                       </table></td> 
                     </tr> 
                     <tr> 
                      <td><table width="100%"  border="0" cellspacing="0" cellpadding="0"> 
                        <tr> 
                         <td valign="top" class="texte">Coordonnées X :
                          <input name="adresse[<? echo $service->ID; ?>][x]" type="text" class="<? echo $class; ?>100" maxlength="10" value="<? echo $adresse->x; ?>" onKeyPress="return verifierSaisieChiffres();" <? echo $disabled; ?>></td> 
                         <td width="10" nowrap>&nbsp;</td> 
                         <td valign="top" class="texte">Coordonnées Y :
                          <input name="adresse[<? echo $service->ID; ?>][y]" type="text" class="<? echo $class; ?>100" maxlength="10" value="<? echo $adresse->y; ?>" onKeyPress="return verifierSaisieChiffres();" <? echo $disabled; ?>></td> 
                         <td width="10" nowrap>&nbsp;</td> 
                         <td class="texte">&nbsp;</td> 
                        </tr> 
                       </table></td> 
                     </tr> 
                     <tr> 
                      <td bgcolor="#898DB0"><img src="../images/e.gif" width="99%" height="1"></td> 
                     </tr> 
                     <tr> 
                      <td><table width="100%"  border="0" cellspacing="0" cellpadding="0"> 
                        <? 
							$j=0;
							while ($j< count($communications))
								{
								if ($j%2 == '0')
									{ 
									$communication = new Tannuaire_communication($communications[$j]['ID_communication']);									
									?> 
                        <tr> 
                         <td><? echo $communication->genererSelect("com[$service->ID][$j][ID_communication]", $communication->listerTypeCommunication(), 'ID', 'type', $communication->ID_communication, 'input150'); ?> 
                          <input name="com[<? echo $service->ID; ?>][<? echo $j; ?>][numero]" type="text" class="input100" value="<? echo $communication->numero; ?>"> 
                          <input name="com[<? echo $service->ID; ?>][<? echo $j; ?>][ID]" type="hidden" value="<? echo $communication->ID; ?>"></td> 
                         <? $j++;
									}
								else
									{ 
									$communication = new Tannuaire_communication($communications[$j]['ID_communication']);
									?> 
                         <td><? echo $communication->genererSelect("com[$service->ID][$j][ID_communication]", $communication->listerTypeCommunication(), 'ID', 'type', $communication->ID_communication, 'input150');?> 
                          <input name="com[<? echo $service->ID; ?>][<? echo $j; ?>][numero]" type="text" class="input100" value="<? echo $communication->numero; ?>"> 
                          <input name="com[<? echo $service->ID; ?>][<? echo $j; ?>][ID]" type="hidden" value="<? echo $communication->ID; ?>"></td> 
                        </tr> 
                        <? $j++;
							 		}
								} // FIN while ($j< count($communications))

							for ($a=count($communications); $a < 8; $a++)
								{
								if ($a%2 == '0')
									{ ?> 
                        <tr> 
                         <td><? echo $communication->genererSelect("com[$service->ID][$a][ID_communication]", $communication->listerTypeCommunication(), 'ID', 'type', $a+1, 'input150'); ?> 
                          <input name="com[<? echo $service->ID; ?>][<? echo $a; ?>][numero]" type="text" class="input100"></td> 
                         <? $j++;
									}
								else
									{ ?> 
                         <td><? echo $communication->genererSelect("com[$service->ID][$a][ID_communication]", $communication->listerTypeCommunication(), 'ID', 'type', $a+1, 'input150');?> 
                          <input name="com[<? echo $service->ID; ?>][<? echo $a; ?>][numero]" type="text" class="input100"></td> 
                        </tr> 
                        <?
							 		} // FIN else
								}	// FIN for ($a=count($communications); $a < 8; $a++) ?> 
                       </table></td> 
                     </tr> 
                    </table></td> 
                   <?
																			$contacts = $service->listerContacts();
																			?> 
                   <td width="200" valign="top" bgcolor="#D9DCEE" class="textecourant"><table width="100%" border="0" cellspacing="0" cellpadding="0"> 
                     <tr> 
                      <td><table width="100%"  border="0" cellspacing="0" cellpadding="5"> 
                        <tr> 
                         <td class="texte"><b> 
                          <? if (!count($contacts)) { echo "Aucun contact"; } else { echo count($contacts)." contact(s) existant(s)"; } ?> 
                          </b></td> 
                        </tr> 
                        <tr> 
                         <td><table width="100%" border="0" cellspacing="5" cellpadding="0"> 
																										<?									 
																										for ($k=0; $k<count($contacts); $k++)
																											{
																											$numContact = $k+1;
																											$contact = new Tannuaire_contact($contacts[$k]['ID_contact']); 
																											$contactCom = new Tannuaire_communication($contact->ID_communicationDefaut);
																											?> 
                           <tr class="texte"> 
                            <td class="texte" width="99%"><? echo $numContact.' - '.$contact->afficherContact(); ?></td> 
                            <td nowrap>&raquo; <a href="javascript:;" onClick="saisirContact('<? echo $service->ID; ?>', '<? echo $contact->ID; ?>');return false;" class="textecourant">Détails</a><br>&raquo; <a href="javascript:;" onClick="supprimerContact('<? echo $service->ID; ?>', '<? echo $contact->ID; ?>');return false;" class="textecourant">Supprimer</a></td> 
                           </tr> 
                           <?	} ?> 
                          </table></td> 
                        </tr> 
                        <tr> 
                         <td align="right" nowrap class="texte">&raquo; <a href="javascript:;" onClick="saisirContact('<? echo $service->ID; ?>', '');return false;" class="textecourant">Ajouter
                           un contact</a>&nbsp;&nbsp;
																									<? if (count($contacts) > 1) 
																										{ ?>
																											<br>
                         &raquo; <a href="javascript:;" onClick="modifierOrdreContact('<? echo $service->ID; ?>');return false;" class="textecourant">Modifier l'ordre des contacts</a>&nbsp;&nbsp;
																									<? } ?>
																									</td> 
                        </tr> 
                       </table></td> 
                     </tr> 
                     <tr> 
                      <td bgcolor="#898DB0"><img src="../images/e.gif" width="99%" height="1"></td> 
                     </tr> 
                     <tr> 
                      <td><table width="100%"  border="0" cellspacing="0" cellpadding="5"> 
                        <tr> 
                         <td class="menuHaut">Supports</td> 
                        </tr> 
                        <?
											 $cpt=0;
											 if ($service->ID)
												{
												$support = new Tannuaire_support();
												$supports = $support->listerSupport();
												
												for ($s=0; $s<count($supports); $s++)
													{							
													$support = new Tannuaire_support($supports[$s]['ID']);
													$html = $support->genererHtmlListe($service->ID);
													
													if ($html)
														{
														$cpt++;
													?> 
                        <tr> 
                         <td class="texte"><b><? echo $supports[$s]['libelle']; ?></b></td> 
                        </tr> 
                        <tr> 
                         <td class="texte"><? echo $html; ?></td> 
                        </tr> 
                        <? 
													} // FIN if ($html)
												} // IN for ($s=0; $s<count($supports); $s++)
											 if ($cpt == '0')
											{ ?> 
                        <tr> 
                         <td class="texte">Aucun support sélectionné</td> 
                        </tr> 
                        <? } 
												 } // FIN if ($service->ID)
												 ?> 
                        <tr> 
                         <td align="right" class="texte">&raquo; <a href="javascript:;" onClick="gererSupports('<? echo $service->ID; ?>');return false;" class="textecourant">G&eacute;rer
                           les supports</a>&nbsp;&nbsp;</td> 
                        </tr> 
                       </table></td> 
                     </tr> 
                     <tr> 
                      <td bgcolor="#898DB0"><img src="../images/e.gif" width="99%" height="1"></td> 
                     </tr> 
                     <tr> 
                      <td><table width="100%"  border="0" cellspacing="0" cellpadding="5"> 
                        <tr> 
                         <td class="menuHaut">Photo</td> 
                        </tr> 
                        <?
												$nomPhoto = $service->nommerPhoto();
												if (file_exists($nomPhoto))
													{	?> 
                        <tr> 
                         <td><a href="javascript:;" onClick="window.open('preview.php?img=<? echo $nomPhoto; ?>', 'PREVIEW','width=420,height=420,location=no,toolbar=no,status=no,menubar=no,resizable=yes,linkbar=no,scrollbars=no');"><img name="preview_1" src="<? echo $nomPhoto; ?>" width="33" height="33" border="0" align="middle"></a></td> 
                        </tr> 
                        <? } 
											 else
												 	{ ?> 
                        <tr> 
                         <td class="texte">Aucune photo sélectionnée</td> 
                        </tr> 
                        <? } ?>
                        <tr> 
                         <td align="right" class="texte">&raquo; <a href="popup/popup_uploader_photo.php" target="idPopIframe" class="textecourant" onClick="envoyerFormulaire('<? echo $service->ID; ?>',this.href); return false;">Photo</a>&nbsp;&nbsp;</td> 
                        </tr> 
                       </table></td> 
                     </tr> 
                     <tr> 
                      <td bgcolor="#898DB0"><img src="../images/e.gif" width="99%" height="1"></td> 
                     </tr> 
                    </table></td> 
                  </tr> 
                 </table> 
                </div></td> 
              </tr> 
             </table></td> 
           </tr> 
          </table> 
          <? } ?> </td> 
        </tr> 
        <tr> 
         <td><img src="../images/e.gif" width="1" height="10"></td> 
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
        <tr> 
         <td width="95%" align="center"><table width="95%%"  border="0" cellspacing="0" cellpadding="0"> 
           <tr> 
            <td><input type="submit" name="Enregistrer" value="Enregistrer" class="bouton"></td> 
            <td align="right"><a href="javascript:;" class="textecourant" onClick="ajouterService('<? echo $_POST['ID_structure']; ?>');return false;"><img src="../images/back/ajouter.gif" border="0" alt="Ajouter un service"></a></td> 
           </tr> 
          </table></td> 
        </tr> 
        <tr> 
         <td><hr width="95%" align="center" size="1" color="#898DB0"></td> 
        </tr> 
        <tr> 
         <td width="95%" align="right" class="textecourant"><a href="index.php" class="textecourant">Revenir
           au menu</a></td> 
        </tr> 
        <tr> 
         <td><img src="../images/e.gif" width="1" height="20"></td> 
        </tr> 
       </table></td> 
     </tr> 
    </table> 
    <input type="hidden" name="ID_categorie"> 
    <input type="hidden" name="structure_ID_typ_classement"> 
    <input type="hidden" name="fonction" value="saisirStructure"> 
    <input type="hidden" name="numeroPage" value="<? echo $numeroPage; ?>"> 
    <input type="hidden" name="nombreTotalPage" value="<? echo $nombreTotalPage; ?>"> 
    <input type="hidden" name="nombreReponses" value="<? echo $nombreReponses; ?>"> 
    <input type="hidden" name="options" value="<? echo $_POST['options']; ?>"> 
    <input type="hidden" name="ID_structure" value="<? echo $_POST['ID_structure']; ?>"> 
   </form> 
   <form name="formAction" method="post" action=""> 
    <input type="hidden" name="numeroPage" value="<? echo $numeroPage; ?>"> 
    <input type="hidden" name="nombreTotalPage" value="<? echo $nombreTotalPage; ?>"> 
    <input type="hidden" name="nombreReponses" value="<? echo $nombreReponses; ?>"> 
    <input type="hidden" name="options" value="<? echo $_POST['options']; ?>"> 
    <input type="hidden" name="fonction"> 
    <input type="hidden" name="ID_service"> 
    <input type="hidden" name="ID_contact"> 
    <input type="hidden" name="ID_categorie"> 
    <input type="hidden" name="ID_structure" value="<? echo $_POST['ID_structure']; ?>"> 
    <input type="hidden" name="page" value="<? echo $_POST['page']; ?>"> 
   </form> 
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
