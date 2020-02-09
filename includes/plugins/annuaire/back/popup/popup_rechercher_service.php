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

$_POST['options'] = 'unePage';

$objet = new Tannuaire_support_recherche($_POST['ID_support_consulte']);
$categorie = new Tannuaire_categorie($_POST['ID_categorie_consulte']);

if ($_POST['fonction'] == 'delierCategorieService')
	{
	$categorie->delierServiceCategories($_POST['ID_service']);
	}

$listeStructures = $objet->rechercherCategorie($_POST);

$numeroPage = $objet->getNumeroPage();
$nombreTotalPage = $objet->getNombreTotalPage();
$nombreReponses = $objet->getNombreReponses();

$options = '';
if ($_POST['options'])
	{ $options = $_POST['options'].','; }
$options .= 'delierService,modifierStructure,avecContact,unePage';
$tabOptions=array();
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../includes/styles/annuaire_back.css" rel="stylesheet" type="text/css">
<title>Outil de saisie et de gestion des annuaires pratiques</title>
<script src="../../includes/javascript/annuaire_back.js" type="text/javascript" language="javascript"></script>
<script language="javascript">
function supprimerLienCategorieService(ID_categorie_consulte, ID_service)
	{
	if ( (ID_categorie_consulte) && (ID_service) )
		{
		document.forms[0].ID_categorie_consulte.value = ID_categorie_consulte;
		document.forms[0].ID_service.value = ID_service;
		document.forms[0].fonction.value = 'delierCategorieService';
		document.forms[0].submit();
		}
	}
	
function saisirStructure(ID_structure, ID_service)
	{
	if ( (ID_structure) && (ID_service) )
		{		
		document.forms[0].ID_structure.value = ID_structure;
		document.forms[0].ID_service.value = ID_service;
		document.forms[0].target = '_parent';
		document.forms[0].action = '../saisir_structure.php';
		document.forms[0].submit();
		window.parent.an_closePop();
		}	
	}
</script>
</head>
<body>
<form name="formulaire" method="post" action="">
<table width="350" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td class="texte"><b>Support : <? echo $objet->libelle; ?> <br>Catégorie : <? echo $categorie->libelle; ?></b></td>
	</tr>
</table>
<br>
<table width="350" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td align="center" class="texte"><!-- #BeginLibraryItem "/includes/plugins/annuaire/back/modeles/annuaire_back.lbi" -->
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
     <td align="left" class="categorieResultats"><img src="../../images/e.gif" width="5" height="1"><img src="../../images/back/puce_categorie.gif" width="15" height="20" align="absmiddle"> &nbsp;<? echo $categorie->libelle; ?></td>
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
       <a href="../modifier_structure.php" class="texte">Cliquez ici pour effectuer
       une nouvelle recherche</a><br>
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
     <td align="left" class="categorieResultats"><img src="../../images/e.gif" width="5" height="1"><img src="../../images/back/puce_categorie.gif" width="15" height="20" align="absmiddle"> &nbsp;<? echo $categorie->libelle; ?></td>
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
        <td width="10" bgcolor="#0D4B91"><img src="../../images/e.gif" width="1" height="1"></td>
        <td width="99%" class="menuHaut"><strong>&nbsp;&nbsp;
           <?
												if ($structure->nom != "") { echo $structure->nom; } 
												if ($service->nom != "") { echo '&nbsp; - &nbsp;'.$service->nom;	}
												?>
        </strong></td>
        <td align="right" valign="top"><img src="../../images/back/tranche.gif" width="10" height="14"></td>
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
         <td bordercolor="#FAFDFE" bgcolor="#898DB0"><img src="../images/e.gif" width="1" height="1"></td>
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
         <td bordercolor="#FAFDFE" bgcolor="#898DB0"><img src="../images/e.gif" width="1" height="1"></td>
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
         <td bordercolor="#FAFDFE" bgcolor="#898DB0"><img src="../images/e.gif" width="1" height="1"></td>
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
         <td bordercolor="#FAFDFE" bgcolor="#898DB0"><img src="../images/e.gif" width="1" height="1"></td>
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
                <td valign="top"><img src="../../images/back/carre_vert.gif" width="3" height="3" hspace="4" vspace="7"></td>
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
                   <td class="texte"><img src="../../images/e.gif" width="1" height="5"></td>
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
         <td bordercolor="#FAFDFE" bgcolor="#898DB0"><img src="../images/e.gif" width="1" height="1"></td>
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
         <td bordercolor="#FAFDFE" bgcolor="#898DB0"><img src="../images/e.gif" width="1" height="1"></td>
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
         <td bordercolor="#FAFDFE" bgcolor="#898DB0"><img src="../images/e.gif" width="1" height="1"></td>
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
     <td><img src="../../images/e.gif" width="1" height="15"></td>
    </tr>
   </table>
		<!-- #EndLibraryItem --></td>
	</tr>
</table>
	<input type="hidden" name="numeroPage" value="<? echo $numeroPage; ?>"> 
	<input type="hidden" name="nombreTotalPage" value="<? echo $nombreTotalPage; ?>"> 
	<input type="hidden" name="nombreReponses" value="<? echo $nombreReponses; ?>"> 
	<input type="hidden" name="ID_categorie_consulte">
	<input type="hidden" name="ID_structure">	
	<input type="hidden" name="ID_service">
	<input type="hidden" name="fonction">
</form>
</body>
</html>