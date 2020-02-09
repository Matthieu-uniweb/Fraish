<?
$classes_supplementaires=array("/includes/plugins/annuaire/includes/classes");
require_once 'DB.php';
include_once(rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/T_LAETIS_site_class.php');
include_once(rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/Tcontact_contact_class.php');
include_once(rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/Tcontact_criteres_specifiques_class.php');
include_once(rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/plugins/formulaires/includes/classes/Tformulaire_class.php');

$_POST['ID_support'] = '1';

$objet = new Tannuaire_support_recherche($_POST['ID_support']);
$tab = $objet->genererSupportEntier();

$categorieEnCours = '';

$_POST['options']="unePage,trierParCategorie,afficherImage,avecContact,avecAdresseDuContact,afficherComInterne,sansAdresseGenerique";
if ($_POST['options'])
	{
	$tabOptions = explode(',', $_POST['options']);
	}

$_POST['inseeCommune']=$_GET['inseeCommune'];
$communes = new Tcommune();
$commune = $communes->getCommune($_POST['inseeCommune']);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Support de diffusion complet par commune</title>
<link href="../includes/styles/annuaire_front.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../../../javascript/globals.js"></script>
<script language="javascript" src="../includes/javascript/annuaire_front.js"></script>
<script language="JavaScript" src="../includes/javascript/annuaire_fonctions_moteur_recherche.js"></script>
<script language="JavaScript" src="../../../javascript/iframe.js"></script>
<style type="text/css">
<!--
.Style2 {color: #330066}
-->
</style>
</head>

<body>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td align="left" class="annuaireTitre">&nbsp;
		  <center>
		    <b>Les structures de la commune : <? echo $commune['nom'].' ('.$commune['codePostalDefaut'].') <br>'; ?></b>
    </center><br></td>
	</tr>
</table>
<?
for ($t=0; $t<count($tab); $t++)
	{
	if ($tab[$t]['nbFille'] != 0)
		{ ?>
		<br>
		<table width="100%"  border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td align="left" class="etudiantsTrame"><img src="../images/e.gif" width="5" height="20" align="absmiddle"> &nbsp;<b><? echo $tab[$t]['libelle'].'<br>'; ?></b></td>
			</tr>
		</table>
<br>
		<? } 
	else
		{		
		$_POST['ID_categorie_consulte']=$tab[$t]['ID'];
		$listeStructures = $objet->rechercherCategorie($_POST);
		
		for ($i=0; $i<count($listeStructures); $i++)
			{
			$tabStruct[] = $listeStructures[$i]['ID_structure'];
			}
		?>
<!-- #BeginLibraryItem "/includes/plugins/annuaire/front/modeles/annuaire_front2.lbi" -->
		<?
$categorieEnCours = '';

if ($options)
	{
	$tabOptions = explode(',', $options);
	}

$affichageComInterne = (in_array('afficherComInterne', $tabOptions)) ? 1:0;

if (! (count($listeStructures) == 0))
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

						if (!$categorieEnCours)
							{ $categorieEnCours=0; }
						$categorie = new Tannuaire_categorie($categorieEnCours);
						$autresCategories = $categorie->getCategoriesAutres($service->ID);

						if (count($autresCategories))
							{
							$texteCatAutre = '';
							for ($c=0; $c<count($autresCategories); $c++)
								{
								$IDautre = $autresCategories[$c]['ID_categorie'];
								if ( ($IDautre == '280') || ($IDautre == '281') || ($IDautre == '282') || ($IDautre == '283') || ($IDautre == '284') )
									{
									$cate = new Tannuaire_categorie($IDautre);
									$texteCatAutre .= $cate->libelle.', ';
									}
								}
							$texteCatAutre = substr($texteCatAutre, 0, strlen($texteCatAutre)-2);
							if ($texteCatAutre) { echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="annuaireLien">('.$texteCatAutre.')</span>'; }
							}
						?></td>
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
													echo $communication->afficherCommunication('textecourant', $affichageComInterne)."<br>";
													}
												}
											else
												{
												echo $communication->afficherCommunication('textecourant', $affichageComInterne)."<br>";
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
	} // FIN if (! (count($listeStructures) == 0))
?>
    <!-- #EndLibraryItem -->
		<?
		} // Fin else
	} // FIN for ($i=0; $i<count($tab); $i++)
	
$_POST['commune'] = $_POST['inseeCommune'];
$objet = new Tannuaire_structure();
$listeStruct= $objet->rechercherStructureCriteres($_POST);
$categorieEnCours=0;

$listeStructures = array();
for ($i=0; $i<count($listeStruct); $i++)
	{
	if (! in_array($listeStruct[$i]['ID_structure'], $tabStruct) )
		{
		$listeStructures[] = $listeStruct[$i];
		}
	}

if (count($listeStructures))
	{
	?>
	<hr width="99%" size="1" color="#000099"><br>
		<table width="100%"  border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td align="left" class="etudiantsTrame"><img src="../images/e.gif" width="5" height="20" align="absmiddle"> &nbsp;<b>Structures qui n'ont pas été affectées à une catégorie</b></td>
			</tr>
		</table>
		<br><?
	}
?>
<!-- #BeginLibraryItem "/includes/plugins/annuaire/front/modeles/annuaire_front2.lbi" -->
		<?
$categorieEnCours = '';

if ($options)
	{
	$tabOptions = explode(',', $options);
	}

$affichageComInterne = (in_array('afficherComInterne', $tabOptions)) ? 1:0;

if (! (count($listeStructures) == 0))
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

						if (!$categorieEnCours)
							{ $categorieEnCours=0; }
						$categorie = new Tannuaire_categorie($categorieEnCours);
						$autresCategories = $categorie->getCategoriesAutres($service->ID);

						if (count($autresCategories))
							{
							$texteCatAutre = '';
							for ($c=0; $c<count($autresCategories); $c++)
								{
								$IDautre = $autresCategories[$c]['ID_categorie'];
								if ( ($IDautre == '280') || ($IDautre == '281') || ($IDautre == '282') || ($IDautre == '283') || ($IDautre == '284') )
									{
									$cate = new Tannuaire_categorie($IDautre);
									$texteCatAutre .= $cate->libelle.', ';
									}
								}
							$texteCatAutre = substr($texteCatAutre, 0, strlen($texteCatAutre)-2);
							if ($texteCatAutre) { echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="annuaireLien">('.$texteCatAutre.')</span>'; }
							}
						?></td>
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
													echo $communication->afficherCommunication('textecourant', $affichageComInterne)."<br>";
													}
												}
											else
												{
												echo $communication->afficherCommunication('textecourant', $affichageComInterne)."<br>";
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
	} // FIN if (! (count($listeStructures) == 0))
?>
    <!-- #EndLibraryItem -->
</body>
</html>