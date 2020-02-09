<?

if (empty($cheminFichier))
	{
	$cheminFichier=".";
	}

if (empty($fichierIndex))
	{
	$fichierIndex="index.php";
	}
if($PHP_AUTH_USER != "")
	{
	$administrateur = true;
	$cheminFichier;
	
	}

// les liens 

$laetisAideLiens[0][lien]="index.php";
$laetisAideLiens[0][titre]="Moteur de recherche";
$laetisAideLiens[0][niveau]=0;
$laetisAideLiens[1][lien]="laetis_recherche_utilisation.php";
$laetisAideLiens[1][titre]="Utilisation";
$laetisAideLiens[1][niveau]=0;
$laetisAideLiens[2][lien]="laetis_recherche_configuration.php";
$laetisAideLiens[2][titre]="Configuration";
$laetisAideLiens[2][niveau]=1;
$laetisAideLiens[3][lien]="laetis_recherche_statistiques.php";
$laetisAideLiens[3][titre]="Statistiques";
$laetisAideLiens[3][niveau]=1;

?>
<link href="includes/styles/lien.css" rel="stylesheet" type="text/css">
<table width='100%' border='0' cellpadding='0' cellspacing='0' dwcopytype='CopyTableRow'>
                    <tr> 
                      <td width='5%' height='21' align='center'><img src='images/carre_aide.gif' width='14' height='15'></td>
                      <td height='21' colspan='2' align='left' valign='middle'>&nbsp;&nbsp;<a href="javascript:;"'<? echo $fichierIndex; ?>' class='lien'><strong>Sommaire</strong></a></td>
                    </tr>
					<form name="laetis_formulaireAide" action="" method="post">
				  <input type="hidden" name="cheminFichier" value="<? echo $cheminFichier; ?>">
				  <input type="hidden" name="fichierIndex" value="<? echo $fichierIndex; ?>">
				  <?
					for ($i=0;$i<sizeof($laetisAideLiens);$i++)
						{
						if ($i==0)
							{
							?>		<tr> 
						  <td width='5%' height='21' align='center'><img src='<? echo $cheminFichier; ?>/images/carre_aide.gif' width='14' height='15'></td>
						  <td height='21' colspan='2' align='left' valign='middle'>&nbsp;&nbsp;<input type="button"  
						  	onClick="this.form.action='<? echo $cheminFichier; echo "/"; echo $laetisAideLiens[$i][lien]; ?>;this.form.submit(); " 
							class="bouton_lien" value="<? echo $laetisAideLiens[$i][titre]; ?>" /></td>
						</tr>
						<?
							}
							else
							{
							// on affiche le menu suivant si appel depuis l'admin ou non
							if ($laetisAideLiens[$i][niveau] && $cheminFichier==".")
								{
								$affichable=false;
								}
								else
								{
								$affichable=true;
								}
								
							if ($affichable)
								{
						?>
				
						 <tr> 
                      <td height='21' align='center'>&nbsp;</td>
                      <td height='21' align='center' valign='middle'><img src='<? echo $cheminFichier; ?>/images/carre_aide.gif' width='14' height='15'></td>
                      <td><input type="button"  
						  	onClick="this.form.action='<?  echo $cheminFichier; echo "/"; echo $laetisAideLiens[$i][lien]; ?>';this.form.submit();" 
							class="bouton_lien" value="<?  echo $laetisAideLiens[$i][titre]; ?>" /></td>
                    </tr>
						<?		
						}
							}
						}
						
         			?>
               </form>
                  </table>
				  