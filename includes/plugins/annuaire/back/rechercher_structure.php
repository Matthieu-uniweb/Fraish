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

$objet = new Tannuaire_structure_recherche();

switch ($_POST['operation'])
	{
	case 'Ajouter':
		$_POST['motCle'] = $_POST['libelle'];
		// Recherche les mots clés dans la base pour éviter les doublons
		$listeStructures = $objet->rechercherStructureCriteres($_POST);
		$nombreReponses = sizeof($listeStructures);
		
		// Si pas de réponse, on continue dans la saisie de la nouvelle structure
		if ($nombreReponses == '0')
			{ ?>
<form name="formAction" method="post" action="saisir_structure.php">
 <input type="hidden" name="libelle" value="<? echo stripslashes($_POST['libelle']); ?>">
</form>
<script language="javascript">document.formAction.submit();</script>
<? }
		else
			{	$message = 1;	}
		break;
	case 'Rechercher':
		$listeStructures = $objet->rechercherStructureCriteres($_POST);
		break;
	}

$criteres = $objet->genererCriteresRecherche($_POST);

$numeroPage = $objet->getNumeroPage();
$nombreTotalPage = $objet->getNombreTotalPage();
$nombreReponses = $objet->getNombreReponses();

$options = '';
if ($_POST['options'])
	{ $options = $_POST['options'].','; }
$options .= 'modifierStructure,avecContact';
$tabOptions=array();
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
<script src="../includes/javascript/annuaire_fonctions_moteur_recherche.js" type="text/javascript" language="javascript"></script>
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
   <table width="562" border="0" cellspacing="0" cellpadding="0"> 
    <tr> 
     <td background="../images/back/pointille_contenu.gif"><img src="../images/e.gif" width="1" height="1"></td> 
    </tr> 
    <tr> 
     <td><img src="../images/e.gif" width="562" height="3"></td> 
    </tr> 
   </table> 
   <table width="562" border="0" align="center" cellpadding="1" cellspacing="0" bgcolor="#D4D4D4"> 
    <tr> 
     <td valign="top"><table width="100%"  border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF"> 
       <tr> 
        <td valign="top"><table width="100%"  border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF"> 
          <tr> 
           <td bgcolor="#D9DCEE" class="titre"><img src="../images/back/fleche_titre.gif" width="22" height="18" align="absmiddle">Résultats
            de votre recherche</td> 
          </tr> 
          <tr> 
           <td background="../images/back/pointille_titre.gif"><img src="../images/e.gif" width="560" height="1"></td> 
          </tr> 
          <tr> 
           <td><img src="../images/e.gif" width="560" height="20"></td> 
          </tr> 
          <tr> 
           <td><table width="100%" border="0" cellpadding="0" cellspacing="5" bordercolor="#000000" bgcolor="#898DB0"> 
             <tr> 
              <td class="menuHaut"><b> &nbsp;&nbsp;Les r&eacute;sultats de votre
                recherche</b></td> 
             </tr> 
            </table></td> 
          </tr> 
          <tr> 
           <td><img src="../images/e.gif" width="1" height="15"></td> 
          </tr> 
         </table></td> 
       </tr> 
       <tr> 
        <td valign="top"><table width="100%"  border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF"> 
          <tr> 
           <td align="center"><? 
								if ($message)
									{ ?> 
            <table width="562" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF"> 
             <tr> 
              <td width="99%"><span class="texte"><b><? echo $nombreReponses; ?> structures
                 et services existantes correspondent au nom de la structure
                 que vous souhaitez créer. Afin d'éviter les doublons, veuillez
                 vérifier que cette structure n'est pas déjà présente dans le
                 système Annuaire.<br> 
               <br> 
               Si elle est présente, vous pouvez la modifier en cliquant sur
               le lien 'Modifier' correspondant.<br> 
               Sinon cliquez sur le lien suivant : <a href="saisir_structure.php" class="textecourant">Continuer
               l'ajout de la structure</a> </b></span><br> 
               <br></td> 
             </tr> 
             <tr> 
              <td><img src="../images/e.gif" width="560" height="20"></td> 
             </tr> 
            </table> 
            <? } // if ($message) ?>            <!-- #BeginLibraryItem "/includes/plugins/annuaire/back/modeles/annuaire_back_criteres.lbi" -->
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
	?>
              </td>
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
            <table width="95%"  border="0" cellspacing="0" cellpadding="0">
             <tr>
              <td bgcolor="#898DB0"><img src="../images/e.gif" width="20" height="1"></td>
             </tr>
            </table>
            <table width="95%" border="0" cellpadding="0" cellspacing="0">
             <tr>
              <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                 <td valign="top" class="menuHaut"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                   <tr>
                    <td valign="top" nowrap bgcolor="#898DB0" class="menuHaut">&nbsp;&nbsp;Vos
                     crit&egrave;res : &nbsp;&nbsp;</td>
                   </tr>
                 </table></td>
                 <td valign="top" class="textecourant">&nbsp;&nbsp;</td>
                 <td width="99%" valign="top" class="textecourant"><? echo $criteres['votreRecherche']; ?></td>
                 <td valign="middle" nowrap><a href="modifier_structure.php" class="textecourant"><img src="../images/back/f_bleu.gif" width="16" height="12" hspace="2" border="0" align="absmiddle">Autre
                   recherche</a></td>
                </tr>
              </table></td>
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
            <!-- #EndLibraryItem --><!-- #BeginLibraryItem "/includes/plugins/annuaire/back/modeles/annuaire_back.lbi" -->
            <?
$categorieEnCours = '';

if ($options)
	{
	$tabOptions = explode(',', $options);
	}

$affichageComInterne = (in_array('afficherComInterne', $tabOptions)) ? 1:0;

if (count($listeStructures) == 0)
	{	
	if (in_array('trierParCategorie', $tabOptions))
		{
		$categorie = new Tannuaire_categorie($_POST['ID_categorie_consulte']);
		?>
            <table width="95%"  border="0" cellpadding="0" cellspacing="0" bgcolor="#898DB0">
             <tr>
              <td align="left" class="categorieResultats"><img src="../images/e.gif" width="5" height="1"><img src="../images/back/puce_categorie.gif" width="15" height="20" align="absmiddle"> &nbsp;<? echo $categorie->libelle; ?></td>
             </tr>
            </table>
            <br>
            <?
		} // FIN if (in_array('trierParCategorie', $tabOptions))
		?>
            <table width="95%" border="1" cellpadding="0" cellspacing="0" bordercolor="#0D4B91" bgcolor="#FAFDFE">
             <tr>
              <td align="center" bordercolor="#0D4B91" class="texte"><br>
                <br>
                <strong>Votre recherche n'a retourné aucun résultat</strong><br>
                <a href="modifier_structure.php" class="texte">Cliquez ici
                pour effectuer une nouvelle recherche</a><br>
         <br>
         <br>
              </td>
             </tr>
            </table>
            <?
}
else
{
for ($i=0; $i<count($listeStructures); $i++)
	{
	$structure = new Tannuaire_structure($listeStructures[$i]['ID_structure']);
	$service = new Tannuaire_service($listeStructures[$i]['ID_service']);

	if (in_array('trierParCategorie', $tabOptions))
		{
		if ($listeStructures[$i]['ID_categorie'] != $categorieEnCours)
			{
			$categorie = new Tannuaire_categorie($listeStructures[$i]['ID_categorie']);
			?>
            <table width="95%"  border="0" cellpadding="0" cellspacing="0" bgcolor="#898DB0">
             <tr>
              <td align="left" class="categorieResultats"><img src="../images/e.gif" width="5" height="1"><img src="../images/back/puce_categorie.gif" width="15" height="20" align="absmiddle"> &nbsp;<? echo $categorie->libelle; ?></td>
             </tr>
            </table>
            <br>
            <?
		$categorieEnCours = $categorie->ID;
		}
	}
?>
            <table width="95%" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
             <tr>
              <td align="center"><table width="100%"  border="0" cellpadding="0" cellspacing="0" bgcolor="#898DB0">
                <tr>
                 <td width="10" bgcolor="#0D4B91"><img src="../images/e.gif" width="1" height="1"></td>
                 <td width="99%" class="menuHaut"><strong>&nbsp;&nbsp;
                    <?
												if ($structure->nom != "") { echo $structure->nom; } 
												if ($service->nom != "") { echo '&nbsp; - &nbsp;'.$service->nom;	}
												?>
                 </strong></td>
                 <td align="right" valign="top"><img src="../images/back/tranche.gif" width="10" height="14"></td>
                </tr>
               </table>
                <table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#898DB0" bgcolor="#FFFFFF">
                 <?
				if ( ($structure->descriptif != '') && (! in_array('sansDescriptif', $tabOptions)) )
					{ 
					?>
                 <tr>
                  <td bordercolor="#FFF2FC"><table width="100%"  border="0" cellspacing="3" cellpadding="0">
                    <tr>
                     <td class="texte"><strong>Descriptif de la structure : </strong><? echo nl2br($structure->descriptif); ?></td>
                    </tr>
                  </table></td>
                 </tr>
                 <tr>
                  <td bordercolor="#FAFDFE" bgcolor="#898DB0"><img src="images/e.gif" width="1" height="1"></td>
                 </tr>
                 <? } // FIN if ( ($structure->descriptif != '') && (! in_array('sansDescriptif', $tabOptions)) )
	
						if ( ($service->descriptif) && (! in_array('sansDescriptif', $tabOptions)) )
							{
							?>
                 <tr>
                  <td bordercolor="#FFF2FC"><table width="100%"  border="0" cellspacing="3" cellpadding="0">
                    <tr>
                     <td class="texte"><strong>Descriptif du service : </strong><? echo nl2br($service->descriptif); ?></td>
                    </tr>
                  </table></td>
                 </tr>
                 <tr>
                  <td bordercolor="#FAFDFE" bgcolor="#898DB0"><img src="images/e.gif" width="1" height="1"></td>
                 </tr>
                 <?
			} // FIN if ( ($service->descriptif) && (! in_array('sansDescriptif', $tabOptions)) )

				$adresses = $service->listerAdresses();
				for($j=0; $j < sizeof($adresses); $j++)
					{
					$adresse = new Tannuaire_adresse($adresses[$j]);
					if ($adr = $adresse->afficherAdresse())
						{
					?>
                 <tr>
                  <td bordercolor="#FFF2FC"><table width="100%"  border="0" cellspacing="3" cellpadding="0">
                    <tr>
                     <td class="texte"><strong>Adresse : </strong>
                       <?
									echo $adr;
									?></td>
                    </tr>
                  </table></td>
                 </tr>
                 <?	
					} // FIN if ($adr = $adresse->afficherAdresse())
				} // FIN for($j=0; $j < sizeof($adresses); $j++)

									if (in_array('uniquementTelephone', $tabOptions))
										{ $uniquementTelephone = 1; }
								
									$communications = $service->listerCommunications();
									if (sizeof($communications)>0)
										{ 
									?>
                 <tr>
                  <td bordercolor="#FAFDFE" bgcolor="#898DB0"><img src="images/e.gif" width="1" height="1"></td>
                 </tr>
                 <tr>
                  <td bordercolor="#FFF2FC"><table width="100%"  border="0" cellspacing="3" cellpadding="0">
                    <tr>
                     <td class="texte"><strong>Communications : </strong><br>
                       <?
										for($k=0; $k < sizeof($communications); $k++)
											{
											$communication = new Tannuaire_communication($communications[$k]['ID_communication']);
							
											if ($uniquementTelephone)
												{
												if ( ($communication->ID_communication=='3') || ($communication->ID_communication=='5') || ($communication->ID_communication=='6') )
													{
													echo $communication->afficherCommunication('texte', $affichageComInterne);
													}
												}
											else
												{
												echo $communication->afficherCommunication('texte', $affichageComInterne);
												}
											}
										?></td>
                    </tr>
                  </table></td>
                 </tr>
                 <?
									} // FIN if(sizeof($communications)>0)	
						if (in_array('avecContact', $tabOptions)) 
							{
							$contacts = $service->listerContacts();
							if (sizeof($contacts)>0)
							{
							?>
                 <tr>
                  <td bordercolor="#FAFDFE" bgcolor="#898DB0"><img src="images/e.gif" width="1" height="1"></td>
                 </tr>
                 <tr>
                  <td bordercolor="#FFF2FC"><table width="100%"  border="0" cellspacing="3" cellpadding="0">
                    <tr>
                     <td class="texte"><strong>Contacts : </strong>
                       <table width="100%"  border="0" cellspacing="0" cellpadding="0">
                        <?
								for($l=0; $l < sizeof($contacts); $l++)
									{
										?>
                        <tr>
                         <td valign="top"><img src="../images/back/carre_vert.gif" width="3" height="3" hspace="4" vspace="7"></td>
                         <td width="99%"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                           <tr>
                            <td class="texte">
                             <?
									$contactDuService = new Tannuaire_contact($contacts[$l]['ID_contact']);
									echo $contactDuService->afficherContact();
									if ($contactDuService->descriptif)
										{ echo ', '.$contactDuService->descriptif; }
									if ($service->getRole($contacts[$l]['ID_contact']))
										{ echo ', '.$service->getRole($contacts[$l]['ID_contact']); }
									?>
                            </td>
                           </tr>
                           <?
									if (in_array('avecAdresseDuContact', $tabOptions)) 
										{
										?>
                           <tr>
                            <td class="texte"><?
									$adresseContact = new Tannuaire_adresse($contactDuService->ID_adresseDefaut);
									echo $adresseContact->afficherAdresse();
									?>
                            </td>
                           </tr>
                           <?
									 	}
									 if (in_array('uniquementTelephone', $tabOptions))

										{ $uniquementTelephone = 1; }
								
									$communicationsContact = $contactDuService->listerCommunications();
									if (sizeof($communicationsContact)>0)
										{ 
									?>
                           <tr>
                            <td class="texte"><?
										for($k=0; $k < sizeof($communicationsContact); $k++)
											{
											$communication = new Tannuaire_communication($communicationsContact[$k]);											
																		
											if ($uniquementTelephone)
												{
												if ( ($communication->ID_communication=='3') || ($communication->ID_communication=='5') || ($communication->ID_communication=='6') )
													{
													echo $communication->afficherCommunication('texte', $affichageComInterne);
													}
												}
											else
												{
												echo $communication->afficherCommunication('texte', $affichageComInterne);
												}
											} // FIN for($k=0; $k < sizeof($communicationsContact); $k++)
										?>
                            </td>
                           </tr>
                           <? } // FIN if(sizeof($communicationsContact)>0) ?>
                           <tr>
                            <td class="texte"><img src="../images/e.gif" width="1" height="5"></td>
                           </tr>
                         </table></td>
                        </tr>
                        <? } // FIN for($l=0; $l < sizeof($contacts); $l++) ?>
                      </table></td>
                    </tr>
                  </table></td>
                 </tr>
                 <?	
								} // FIN if(sizeof($contacts)>0)
							} // FIN if (in_array('avecContact', $tabOptions))							
							?>
                 <?
				 if (in_array('modifierStructure', $tabOptions))
					{
				 ?>
                 <tr>
                  <td bordercolor="#FAFDFE" bgcolor="#898DB0"><img src="images/e.gif" width="1" height="1"></td>
                 </tr>
                 <tr>
                  <td bordercolor="#FFF2FC"><table width="100%"  border="0" cellspacing="3" cellpadding="0">
                    <tr>
                     <td align="right">&raquo;&nbsp; <a href="javascript:;" onClick="saisirStructure('<? echo $structure->ID; ?>', '<? echo $service->ID; ?>');return false;" class="textecourant">Modifier</a>&nbsp;</td>
                    </tr>
                  </table></td>
                 </tr>
                 <? } // FIN if (in_array('modifierStructure', $tabOptions)) ?>
                 <?
				 if (in_array('lierStructure', $tabOptions))
					{
				 ?>
                 <tr>
                  <td bordercolor="#FAFDFE" bgcolor="#898DB0"><img src="images/e.gif" width="1" height="1"></td>
                 </tr>
                 <tr>
                  <td bordercolor="#FFF2FC"><table width="100%"  border="0" cellspacing="3" cellpadding="0">
                    <tr>
                     <td align="right" valign="middle" class="texte">&raquo;&nbsp;Lier
                       <input name="services[<? echo $service->ID; ?>]" type="checkbox" value="on" <? if ($categorie->getServiceLie($service->ID)) { echo "checked"; } ?>>
              &nbsp;</td>
                    </tr>
                  </table></td>
                 </tr>
                 <? } // FIN if (in_array('lierStructure', $tabOptions)) ?>
                 <?
				 if (in_array('delierService', $tabOptions))
					{
				 ?>
                 <tr>
                  <td bordercolor="#FAFDFE" bgcolor="#898DB0"><img src="images/e.gif" width="1" height="1"></td>
                 </tr>
                 <tr>
                  <td bordercolor="#FFF2FC"><table width="100%"  border="0" cellspacing="3" cellpadding="0">
                    <tr>
                     <td align="right" class="texte">&raquo;&nbsp; <a href="javascript:;" onClick="supprimerLienCategorieService('<? echo $categorie->ID; ?>', '<? echo $service->ID; ?>');return false;" class="textecourant">Délier</a>&nbsp;</td>
                    </tr>
                  </table></td>
                 </tr>
                 <? } // FIN if (in_array('delierService', $tabOptions)) ?>
               </table></td>
             </tr>
            </table>
            <br>
            <?
		} // FIN for ($i=0; $i<count($listeStructures); $i++)
	} // FIN else
?>
            <table width="95%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
             <tr>
              <td><img src="../images/e.gif" width="1" height="15"></td>
             </tr>
            </table>
            <!-- #EndLibraryItem --><!-- #BeginLibraryItem "/includes/plugins/annuaire/back/modeles/annuaire_back_criteres.lbi" -->
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
	?>
              </td>
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
            <table width="95%"  border="0" cellspacing="0" cellpadding="0">
             <tr>
              <td bgcolor="#898DB0"><img src="../images/e.gif" width="20" height="1"></td>
             </tr>
            </table>
            <table width="95%" border="0" cellpadding="0" cellspacing="0">
             <tr>
              <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                 <td valign="top" class="menuHaut"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                   <tr>
                    <td valign="top" nowrap bgcolor="#898DB0" class="menuHaut">&nbsp;&nbsp;Vos
                     crit&egrave;res : &nbsp;&nbsp;</td>
                   </tr>
                 </table></td>
                 <td valign="top" class="textecourant">&nbsp;&nbsp;</td>
                 <td width="99%" valign="top" class="textecourant"><? echo $criteres['votreRecherche']; ?></td>
                 <td valign="middle" nowrap><a href="modifier_structure.php" class="textecourant"><img src="../images/back/f_bleu.gif" width="16" height="12" hspace="2" border="0" align="absmiddle">Autre
                   recherche</a></td>
                </tr>
              </table></td>
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
         </table></td> 
       </tr> 
      </table></td> 
    </tr> 
   </table> 
   <table width="562" border="0" cellspacing="0" cellpadding="0"> 
    <tr> 
     <td><img src="../images/e.gif" width="1" height="20"></td> 
    </tr> 
   </table> 
   <form name="formulaire" method="post" action=""> 
    <input type="hidden" name="numeroPage" value="<? echo $numeroPage; ?>"> 
    <input type="hidden" name="nombreTotalPage" value="<? echo $nombreTotalPage; ?>"> 
    <input type="hidden" name="nombreReponses" value="<? echo $nombreReponses; ?>"> 
    <input type="hidden" name="ID_structure"> 
    <input type="hidden" name="ID_service"> 
    <input type="hidden" name="fonction"> 
    <input type="hidden" name="operation" value="<? echo $_POST['operation']; ?>"> 
    <input type="hidden" name="options" value="<? echo $_POST['options']; ?>"> 
    <input type="hidden" name="motCle" value="<? echo $_POST['motCle']; ?>"> 
    <input type="hidden" name="formeJuridique" value="<? echo $_POST['formeJuridique']; ?>"> 
    <input type="hidden" name="anneeCreation" value="<? echo $_POST['anneeCreation']; ?>"> 
    <input type="hidden" name="ID_typ_classement" value="<? echo $_POST['ID_typ_classement']; ?>"> 
    <input type="hidden" name="typAsso" value="<? echo $_POST['typAsso']; ?>"> 
    <input type="hidden" name="typNaf" value="<? echo $_POST['typNaf']; ?>"> 
    <input type="hidden" name="siret" value="<? echo $_POST['siret']; ?>"> 
    <input type="hidden" name="typStructure" value="<? echo $_POST['typStructure']; ?>"> 
    <input type="hidden" name="effectifTotal" value="<? echo $_POST['effectifTotal']; ?>"> 
    <input type="hidden" name="descriptif" value="<? echo $_POST['descriptif']; ?>"> 
    <input type="hidden" name="commune" value="<? echo $_POST['commune']; ?>"> 
   </form> 
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
