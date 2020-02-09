<?
$classes_supplementaires=array("/includes/plugins/annuaire/includes/classes");
require_once 'DB.php';
include_once(rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/T_LAETIS_site_class.php');
include_once(rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/Tcontact_contact_class.php');
include_once(rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/Tcontact_criteres_specifiques_class.php');
include_once(rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/plugins/formulaires/includes/classes/Tformulaire_class.php');

if ( ($_POST['motCle']) && ($_POST['rubrique'] == 'toutes') )
	{ $_POST['ID_categorie_consulte'] = ''; }

$commune = new Tcommune();
$listeInseeCommune = '';

// Si on vient du moteur annuaire
if (! $_POST['inseeCommune'])
	{
	for ($i=0; $i<count($_POST['ID_canton']); $i++)
		{	
		if ($_POST['ID_canton'][$i] == '99999')
			{ $listeInseeCommune .= '99999,'; }
		else
			{
			$communes = $commune->listerCommunesDuCanton($_POST['ID_canton'][$i]);
			for ($j=0; $j<count($communes); $j++)
				{	$listeInseeCommune .= $communes[$j]['inseeCommune'].','; }
			} // FIN else
		} // FIN for ($i=0; $i<count($_POST['ID_canton']); $i++)
	$_POST['inseeCommune'] = substr($listeInseeCommune,0,strlen($listeInseeCommune)-1);
	} // FIN if (! $_POST['inseeCommune'])

$objet = new Tannuaire_support_recherche($_POST['ID_support']);
$listeStructures = $objet->rechercherCategorie($_POST);
$criteres = $objet->genererCriteresRecherche($_POST);

$numeroPage = $objet->getNumeroPage();
$nombreTotalPage = $objet->getNombreTotalPage();
$nombreReponses = $objet->getNombreReponses();

$options = '';
if ($_POST['options'])
	{ $options = $_POST['options'].','; }
$options .= 'trierParCategorie,avecContact';
$tabOptions=array();
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../includes/styles/annuaire_front.css" rel="stylesheet" type="text/css">
<link href="../../../../includes/styles/page.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../../../javascript/globals.js"></script>
<script language="javascript" src="../includes/javascript/annuaire_front.js"></script>
<script language="JavaScript" src="../includes/javascript/annuaire_fonctions_moteur_recherche.js"></script>
<title>Moteurs annuaires</title>
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-color:#F4F3F3;
}
body.scrollbar {
	SCROLLBAR-FACE-COLOR: #F6AC00; 
	SCROLLBAR-HIGHLIGHT-COLOR: #FFE37A; 
	SCROLLBAR-ARROW-COLOR: #9F3F3F; 
	}
</style>
</head>
<body bgcolor="#FFFFFF" class="scrollbar" onLoad="window.self.focus();"> 
<form name="formRecherche" method="post" action="<? echo $_SERVER['PHP_SELF']; ?>"> 
  <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0"> 
    <tr> 
      <td height="1" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0"> 
          <tr> 
            <td><a name="haut"></a> 
              <table width="100%"  border="0" cellspacing="0" cellpadding="0"> 
                <tr> 
                  <td bgcolor="#9F3F3F"><img src="../images/e.gif" width="12" height="66"></td> 
                  <td width="99%" valign="top"><table width="100%"  border="0" cellspacing="0" cellpadding="0"> 
                      <tr> 
                        <td><table width="100%"  border="0" cellspacing="0" cellpadding="0"> 
                            <tr> 
                              <td valign="top"><img src="../images/front/annuaire_resultats.gif" width="27" height="35" hspace="3" vspace="2"></td> 
                              <td><img src="../images/e.gif" width="3" height="1"></td> 
                              <td width="99%" valign="top" class="annuaireResultatsSousTitre"><img src="../../images/e.gif" width="1" height="5"><br> 
                                <span class="annuaireResultatsTitre"><? echo $objet->libelle; ?></span><br> 
                                <img src="../images/front/fleche.gif" width="13" height="11" align="absmiddle">&nbsp;<? if ($criteres['nomCategorie']) { echo $criteres['nomCategorie']; } else { echo 'Annuaire Pratique'; }?></td> 
                            </tr> 
                          </table></td> 
                      </tr> 
                      <tr> 
                        <td background="../images/front/pointille_horizontal.gif" style="background-repeat: repeat-x;"><img src="../../images/e.gif" width="1" height="1"></td> 
                      </tr> 
                      <tr> 
                        <td align="center"><img src="../../../../images/separateur.gif" width="8" height="9" vspace="8"></td> 
                      </tr> 
                    </table></td> 
                </tr> 
              </table></td> 
          </tr> 
      </table></td> 
    </tr> 
    <tr> 
      <td height="1" valign="top"><table width="100%"  border="0" cellspacing="0" cellpadding="6"> 
          <tr> 
            <td><!-- #BeginLibraryItem "/includes/plugins/annuaire/front/modeles/annuaire_front_criteres.lbi" -->
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
            <table width="100%"  border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td bgcolor="#F6AC00"><img src="../images/e.gif" width="6" height="1"></td>
                <td width="99%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="99%" nowrap class="textecourant">&nbsp;&nbsp; <b><? echo $objet->nombreReponses; ?> résultat(s)</b> trouvé(s)
                        sur <? echo $objet->nombreTotalPage; ?> page(s)</td>
                    </tr>
                    <tr>
                      <td width="100%" class="textecourant"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr>
                            <td valign="top" nowrap class="textecourant"><b>&nbsp;&nbsp; Vos
                                crit&egrave;res : &nbsp;</b></td>
                            <td width="99%" valign="top" class="textecourant"><? echo $criteres['votreRecherche']; ?></td>
                          </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td width="100%" class="textecourant"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="99%" class="textecourant">&nbsp;</td>
                            <?
				if($objet->numeroPage != 1)
					{
					?>
                            <td valign="top" nowrap class="textecourant">&nbsp;&nbsp;<a href="javascript:;" class="guideResultats" onClick="pagePrecedente();return false;"><img src="../images/front/precedent.gif" width="11" height="11" border="0"  align="absmiddle"></a>&nbsp;&nbsp;</td>
                            <?
					}
					?>
                            <td align="center" valign="top" nowrap class="textecourant">Page(s)
                              :
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
                            <td valign="top" nowrap class="textecourant">&nbsp;&nbsp;<a href="javascript:;" class="guideResultats" onClick="pageSuivante();return false;"><img src="../images/front/suivant.gif" width="11" height="11" border="0"  align="absmiddle"></a>&nbsp;</td>
                            <?
				}
				?>
                          </tr>
                      </table></td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td width="100%" colspan="2" background="../images/front/pointille_horizontal.gif" style="background-repeat: repeat-x;"><img src="../images/e.gif" width="1" height="1"></td>
              </tr>
            </table>
            <table width="100%"  border="0" cellspacing="0" cellpadding="6">
              <tr>
                <td><img src="../images/e.gif" width="1" height="10"></td>
              </tr>
            </table>
            <?
	} // FIN if (! in_array('unePage', $tabOptions) )
?>
            <!-- #EndLibraryItem --><!-- #BeginLibraryItem "/includes/plugins/annuaire/front/modeles/annuaire_front.lbi" -->
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
            <table width="100%"  border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="left" class="categorieResultats"><img src="../images/e.gif" width="5" height="1"><img src="../images/front/puce_categorie.gif" width="15" height="20" align="absmiddle"> &nbsp;<? echo $categorie->libelle; ?></td>
              </tr>
            </table>
            <br>
            <?
		} // FIN if (in_array('trierParCategorie', $tabOptions))
		?>
            <table width="100%" cellpadding="0" cellspacing="0">
              <tr>
                <td align="center" class="guideResultatsPasDeResultat"><br>
                    <b>Votre recherche n'a retourné aucun résultat</b><br>
                    <br></td>
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
            <table width="100%"  border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="left" class="categorieResultats"><img src="../images/e.gif" width="5" height="1"><img src="../images/front/puce_categorie.gif" width="15" height="20" align="absmiddle"> &nbsp;<? echo $categorie->libelle; ?></td>
              </tr>
            </table>
            <br>
            <?
		$categorieEnCours = $categorie->ID;
		}
	}
?>
            <table width="100%" cellpadding="0" cellspacing="0">
              <tr>
                <td><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="99%" valign="top"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td width="15" valign="top" nowrap><img src="../images/front/puce.gif" width="4" height="4" hspace="5" vspace="7"></td>
                                  <td width="99%" class="structureResultats"><?
						if ($structure->nom != "") { echo $structure->nom; } 
						if ( ($service->nom != "") && ($service->nom != "Accueil / Standard") )
							{
							echo '&nbsp; - &nbsp;'.$service->nom;
							}
						?>
                                  </td>
                                </tr>
                            </table></td>
                          </tr>
                          <tr>
                            <td><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td><img src="../images/e.gif" width="15" height="1"></td>
                                  <td width="99%"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                                      <?
						if ( ($structure->descriptif != '') && (! in_array('sansDescriptif', $tabOptions)) )
							{ 
							?>
                                      <tr>
                                        <td class="descriptifResultats"><? echo nl2br($structure->descriptif); ?></td>
                                      </tr>
                                      <? } // FIN if ( ($structure->descriptif != '') && (! in_array('sansDescriptif', $tabOptions)) )
	
						if ( ($service->descriptif) && (! in_array('sansDescriptif', $tabOptions)) )
							{
							?>
                                      <tr>
                                        <td class="descriptifResultats"><? echo nl2br($service->descriptif); ?> </td>
                                      </tr>
                                      <?
								} // FIN if ( ($service->descriptif) && (! in_array('sansDescriptif', $tabOptions)) )
							?>
                                      <tr>
                                        <td><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                              <td width="99%"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                                                  <?
									$adresses = $service->listerAdresses();
									for($j=0; $j < sizeof($adresses); $j++)
										{
										?>
                                                  <tr>
                                                    <td class="adresseResultats"><?
									$adresse = new Tannuaire_adresse($adresses[$j]);
									echo $adresse->afficherAdresse();
									?>
                                                    </td>
                                                  </tr>
                                                  <?	} // FIN for($j=0; $j < sizeof($adresses); $j++)

									if (in_array('uniquementTelephone', $tabOptions))
										{ $uniquementTelephone = 1; }
								
									$communications = $service->listerCommunications();
									if (sizeof($communications)>0)
										{ 
									?>
                                                  <tr>
                                                    <td class="adresseResultats"><?
										for($k=0; $k < sizeof($communications); $k++)
											{
											$communication = new Tannuaire_communication($communications[$k]['ID_communication']);
							
											if ($uniquementTelephone)
												{
												if ( ($communication->ID_communication=='3') || ($communication->ID_communication=='5') || ($communication->ID_communication=='6') )
													{
													echo $communication->afficherCommunication('textecourant', $affichageComInterne);
													}
												}
											else
												{
												echo $communication->afficherCommunication('textecourant', $affichageComInterne);
												}
											}
										?>
                                                    </td>
                                                  </tr>
                                                  <?
									} // FIN if(sizeof($communications)>0)	
									?>
                                              </table></td>
                                            </tr>
                                        </table></td>
                                      </tr>
                                      <tr>
                                        <td><img src="../images/e.gif" width="1" height="5"></td>
                                      </tr>
                                      <?
						if (in_array('avecContact', $tabOptions)) 
							{
							$contacts = $service->listerContacts();
							if (sizeof($contacts)>0)
							{
							?>
                                      <tr>
                                        <td><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                                            <?
								for($l=0; $l < sizeof($contacts); $l++)
									{
										?>
                                            <tr>
                                              <td valign="top"><img src="../images/front/carre_vert.gif" width="3" height="3" hspace="4" vspace="7"></td>
                                              <td width="99%"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                                                  <tr>
                                                    <td class="contactResultats">
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
                                                    <td class="contactResultats"><?
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
                                                    <td class="contactResultats"><?
										for($k=0; $k < sizeof($communicationsContact); $k++)
											{
											$communication = new Tannuaire_communication($communicationsContact[$k]);											
																		
											if ($uniquementTelephone)
												{
												if ( ($communication->ID_communication=='3') || ($communication->ID_communication=='5') || ($communication->ID_communication=='6') )
													{
													echo $communication->afficherCommunication('textecourant', $affichageComInterne);
													}
												}
											else
												{
												echo $communication->afficherCommunication('textecourant', $affichageComInterne);
												}
											} // FIN for($k=0; $k < sizeof($communicationsContact); $k++)
										?>
                                                    </td>
                                                  </tr>
                                                  <? } // FIN if(sizeof($communicationsContact)>0) ?>
                                                  <tr>
                                                    <td class="contactResultats"><img src="../images/e.gif" width="1" height="5"></td>
                                                  </tr>
                                              </table></td>
                                            </tr>
                                            <? } // FIN for($l=0; $l < sizeof($contacts); $l++) ?>
                                        </table></td>
                                      </tr>
                                      <?	
								} // FIN if(sizeof($contacts)>0)
							} // FIN if (in_array('avecContact', $tabOptions))							
							?>
                                  </table></td>
                                </tr>
                            </table></td>
                          </tr>
                      </table></td>
                      <?
	 if (in_array('afficherImage', $tabOptions))
		{
		$nomPhoto = $service->nommerPhoto();
		if (file_exists($nomPhoto))
			{
			?>
                      <td><img src="../images/e.gif" width="10" height="1"></td>
                      <td valign="top"><img src="<? echo $nomPhoto; ?>" border="0" title="<? echo $structure->nom.' - '.$service->nom; ?>"></td>
                      <?
			} // FIN if (file_exists($nomPhoto))
		} // FIN  if (in_array('afficherImage', $tabOptions))		
	?>
                      <td><img src="../images/e.gif" width="15" height="1"></td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td><img src="../images/e.gif" width="1" height="15"></td>
              </tr>
            </table>
            <?
		} // FIN for ($i=0; $i<count($listeStructures); $i++)
	} // FIN else
?>
            <table width="100%"  border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><img src="../images/e.gif" width="1" height="15"></td>
              </tr>
            </table>
            <!-- #EndLibraryItem --><!-- #BeginLibraryItem "/includes/plugins/annuaire/front/modeles/annuaire_front_criteres.lbi" -->
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
            <table width="100%"  border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td bgcolor="#F6AC00"><img src="../images/e.gif" width="6" height="1"></td>
                <td width="99%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="99%" nowrap class="textecourant">&nbsp;&nbsp; <b><? echo $objet->nombreReponses; ?> résultat(s)</b> trouvé(s)
                        sur <? echo $objet->nombreTotalPage; ?> page(s)</td>
                    </tr>
                    <tr>
                      <td width="100%" class="textecourant"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr>
                            <td valign="top" nowrap class="textecourant"><b>&nbsp;&nbsp; Vos
                                crit&egrave;res : &nbsp;</b></td>
                            <td width="99%" valign="top" class="textecourant"><? echo $criteres['votreRecherche']; ?></td>
                          </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td width="100%" class="textecourant"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="99%" class="textecourant">&nbsp;</td>
                            <?
				if($objet->numeroPage != 1)
					{
					?>
                            <td valign="top" nowrap class="textecourant">&nbsp;&nbsp;<a href="javascript:;" class="guideResultats" onClick="pagePrecedente();return false;"><img src="../images/front/precedent.gif" width="11" height="11" border="0"  align="absmiddle"></a>&nbsp;&nbsp;</td>
                            <?
					}
					?>
                            <td align="center" valign="top" nowrap class="textecourant">Page(s)
                              :
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
                            <td valign="top" nowrap class="textecourant">&nbsp;&nbsp;<a href="javascript:;" class="guideResultats" onClick="pageSuivante();return false;"><img src="../images/front/suivant.gif" width="11" height="11" border="0"  align="absmiddle"></a>&nbsp;</td>
                            <?
				}
				?>
                          </tr>
                      </table></td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td width="100%" colspan="2" background="../images/front/pointille_horizontal.gif" style="background-repeat: repeat-x;"><img src="../images/e.gif" width="1" height="1"></td>
              </tr>
            </table>
            <table width="100%"  border="0" cellspacing="0" cellpadding="6">
              <tr>
                <td><img src="../images/e.gif" width="1" height="10"></td>
              </tr>
            </table>
            <?
	} // FIN if (! in_array('unePage', $tabOptions) )
?>
            <!-- #EndLibraryItem --></td> 
          </tr> 
      </table></td> 
    </tr>
		<tr>
			<td height="1" valign="top"><table width="100%"  border="0" cellspacing="0" cellpadding="6">
          <tr> 
            <td align="right"><a href="#haut"><img src="../images/front/haut.gif" border="0"></a>&nbsp;&nbsp;<a href="javascript:;" onClick="printAll();return false;"><img src="../images/front/imprimer.gif" width="17" height="12" border="0"></a></td> 
          </tr> 
			</table></td>
		</tr>
    <tr> 
      <td valign="bottom"><!-- Bas de Page --> 
        <table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" bgcolor="#F7EED2"> 
          <tr> 
            <td width="100%" class="pointille_horizontal_gris"><img src="../images/e.gif" width="1" height="1"></td> 
          </tr> 
          <tr> 
            <td class="degrade_horizontal_gris"><img src="../images/e.gif" width="1" height="3"></td> 
          </tr> 
          <tr> 
            <td width="100%"><table width="100%"  border="0" cellspacing="0" cellpadding="0"> 
                <tr> 
                  <td width="30"><img src="../images/e.gif" width="20" height="1"></td> 
                  <td width="100%" class="bas_page"> <b>Le pays du Haut Rouergue
                      en Aveyron</b><br> 
                    18 bis Av. Marcel Lautard - BP14 - 12500 Espalion<br> 
                    T&eacute;l.: 05 65 51 69 88 - Fax.: 05 65 44 09 65 - <a href="mailto:contact@haut-rouergue.com" class="lien_bas_page">contact@haut-rouergue.com</a></td> 
                </tr> 
              </table></td> 
          </tr> 
        </table> 
        <!-- Fin Bas de Page --></td> 
    </tr> 
  </table> 
  <input type="hidden" name="numeroPage" value="<? echo $numeroPage; ?>"> 
  <input type="hidden" name="nombreTotalPage" value="<? echo $nombreTotalPage; ?>"> 
  <input type="hidden" name="nombreReponses" value="<? echo $nombreReponses; ?>"> 
  <input type="hidden" name="fonction" value=""> 
  <input type="hidden" name="ID_categorie_consulte" value="<? echo $_POST['ID_categorie_consulte']; ?>"> 
  <input type="hidden" name="ID_support" value="<? echo $_POST['ID_support']; ?>"> 
  <input type="hidden" name="inseeCommune" value="<? echo $_POST['inseeCommune']; ?>"> 
		<input type="hidden" name="ID_canton" value="<? echo $_POST['ID_canton']; ?>"> 
  <input type="hidden" name="motCle" value="<? echo $_POST['motCle']; ?>"> 
  <input type="hidden" name="options" value="<? echo $_POST['options']; ?>"> 
</form> 
</body>
</html>
