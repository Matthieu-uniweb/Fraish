<?
header("Expires: 0"); 
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache");
header("Cache-Control: post-check=0,pre-check=0");
header("Cache-Control: max-age=0");
header("Pragma: no-cache");

include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/classes.inc.php';
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/includes/classes/paquetage.inc.php';

T_LAETIS_site::initialiserSession();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<title>Mon espace d'administration e-boutique</title>
<meta name="description" content="Espace d'administration de votre boutique" />
<meta name="keywords" content="espace, administration, boutique" />
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />
<link rel="icon" type="image/x-icon" href="/favicon.ico" />
<style type="text/css">
body {
	font-family:Arial, Helvetica, sans-serif;
	font-size:10px;
	padding:0px;
	margin:0px;
}
h2 {
	font-size:16px;
}
h3 {
	font-size:12px;
}
h4 {
	font-size:11px;
	font-weight:bold;
	margin:0;
	padding:0;
	padding:2px 0px;
}
.barre {
	text-decoration: line-through;
}
</style>
</head>
<body>
<?php 
/*<h2><?php echo "Commandes FRAISH'Menu du ".T_LAETIS_site::dateEnFrancais($_GET['dateSeuleInsertion']); ?></h2>
*/
?>
<?php 
$cpt=0;
$_GET['ordre']="ASC";
$commande = new Tbq_commande();
$commandes = $commande->listerTousesCommandes($_GET);

$ingredients = $commande->ingredientsAdmin;

foreach($commandes as $detailCommande)
	{	
	$client = new Tbq_client($detailCommande['ID_client']);
$ID_client[] = $detailCommande['ID_client'];
	$jus[] = $detailCommande['boissonStat'];
	$nom[] = $client->nomFacturation; 
	$prenom[] = $client->prenomFacturation;     
	$numCommande[] = $detailCommande['ID_commande_fraish']; 
	$taille[] = $detailCommande['taille'];           
	$pain[] = $detailCommande['pain']; 
	//$ingredient[] = $detailCommande['plat']." <b>".$detailCommande['vinaigrette']."</b>";
	$plat[] = str_replace('<br>Selon disponibilit�s: ', '', $detailCommande['plat']);
	//$plat[] = $detailCommande['plat'];	
	
	$vinaigretteok = explode(':',  $detailCommande['vinaigrette']);
	$vinaigrette[] = $vinaigretteok[0];	
	
	$statut[] = $detailCommande['statut'];
	$boisson[] = $detailCommande['boisson'];
	$boissonStat[] = $detailCommande['boissonStat'];
	$commentaire[] = $detailCommande['commentaire'];
	$dessert[] = $detailCommande['dessert'];
	$soupe[] = $detailCommande['soupe'];
	$prix[] = $detailCommande['prix'];
	$paiement[] = $detailCommande['ID_typ_paiement'];
	$ptLivraison = new Tbq_pointLivraison($detailCommande['ID_pointLivraison']);
	$livraison[] = $ptLivraison->nom; 
	$supplements[] = $detailCommande['supplement'];
	$eau[] = $detailCommande['eau'];
	$nb_dans_panier[] = $detailCommande['nb_dans_panier'];
	$code_promo[] = $detailCommande['code_promo'];
	
	$idsPlat = explode('|',substr($detailCommande['IDsPlat'],0,-1));
	}
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <?php
for ($i=0; $i<count($nom); $i++)
	{ 
	$aLaLigne=0;
	if ( ($cpt!=0) && ($cpt%4==0) )
		{ $aLaLigne=1; }

	if ( ($i!=0) && ($i%4==0) )
		{		
		if ($aLaLigne==1)
			{
			echo '</tr><tr';
			echo ' style="page-break-after: always;"';
			echo '><td colspan="4">&nbsp;</td></tr><tr>';
			}
		else
			{
			echo '</tr><tr><td colspan="4">&nbsp;</td></tr><tr>';
			}
		
		}
	?>
    <td width="25%" valign="top" height="400" style="border: 1px dashed #000000; padding: 20px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td valign="top"><img src="../images/logo.jpg" alt="Fraish" width="84" height="38" /></td>
        </tr>
        <tr>
          <td valign="top"><h3><?php echo $nom[$i]; ?> <?php echo $prenom[$i]; ?></h3></td>
        </tr>
        <tr>
          <td valign="top">N&deg; Com. <?php echo $numCommande[$i]; ?></td>
        </tr>
        <tr>
          <td valign="top" <?php if ($nb_dans_panier[$i]>1) echo 'style="color: #ff0000; font-weight: bold; font-size: 12px;"'?>> Quantit&eacute; : x<?php echo $nb_dans_panier[$i]; ?></td>
        </tr>
        
        <?php if ($code_promo[$i]!="")echo "<tr><td valign=\"top\" style=\"color: #ff0000; font-weight: bold; font-size: 11px;\"> Code promo : $code_promo[$i] </td></tr>";?>        
        
        <tr>
          <td valign="top"><h4><?php echo $taille[$i]; ?></h4></td>
        </tr>
        
        <?php 
		//AFficher soupe
		if ($soupe[$i]!=', , ,' && $soupe[$i]!='') { ?>
        <tr>
        	<td>
            <h4>Soupe</h4>
            </td>
        </tr>
        <tr>
          <td valign="top"><?php echo $soupe[$i]; ?></td>
        </tr>
        <?php 
		} //FIN afficher soupe
			
		if($plat[$i])//IF afficher salade
			{?>
            <tr>
              <td valign="top"><h4>Salade</h4></td>
            </tr>
            <tr>
              <td valign="top"><h4><?php echo $vinaigrette[$i]; ?></h4></td>
            </tr>
            <?php 
          $tabPlat = explode(', ', $plat[$i]); 

		 //boucle for pour lister les ingredients dans l'ordre voulu dans l'amdin 
		 $tabPlat2 = array();
		 
		/* foreach($commande->ingredientsAdmin as $iAdmin)
		 	{
			if(in_array($iAdmin,$tabPlat))
				{
				$tabPlat2[] = $iAdmin;
				}
			}*/
		foreach($commande->getIdsParOrdreAdmin() as $iAdmin)
		{
		if(in_array($iAdmin,$idsPlat))
			{
			$tabPlat2[] = $iAdmin;
			}
		}
		
          //for ($j=0; $j<count($tabPlat2); $j++)
		  //for ($j=0; $j<count($tabPlat); $j++)
		  foreach($tabPlat as $libPlat)
                {
			//$Tbq_ingredient = new Tbq_ingredient();
			//$Tbq_ingredient->initialiser($tabPlat2[$j]);
		?>
            <tr>
              <td valign="top"><?php /*echo $Tbq_ingredient->libelle;*/ echo $libPlat;?></td>
            </tr>
        <?php 
                } // FIN for ($j=0; $j<count($tabPlat); $j++)
            }//FIN if salade
	  
	  	if($dessert[$i])
			{?>
            <tr>
            	<td valign="top"><h4>Dessert</h4><?php echo $dessert[$i];?></td></tr>
            <?php
			}?>
        <tr>
          <td valign="top"><h4>Pain: <?php echo $pain[$i]; ?></h4></td>
        </tr>
        <?php
		if($eau[$i])
			{?>
			<tr>
	            <td valign="top">
                <h4>Eau : <?php echo $eau[$i]; ?></h4>
                </td>
			</tr><?php
			}

		if($boisson[$i]!='')
			{?>
        <tr>
          <td valign="top"><h4>
              <?php 
	/*if ( ($boissonStat[$i]=='MY JUICE') || ($boissonStat[$i]=='MY SMOOTHIE') || ($boissonStat[$i]=='MY DAIRY') )
	{ echo str_replace('- 3 ingr�dients au choix -', '', $boisson[$i]); }*/
	if($boissonStat[$i]=='MY')
		{
		echo ' MY, '.str_replace('- 3 ingr�dients au choix -', '', $boisson[$i]);
		}
	elseif(/*$jus[$i]!=''*/$boisson[$i])
		{ /*echo 'Jus: '.$jus[$i];*/ echo $boisson[$i]; }
		
	if($boisson[$i]=='DailyJuice')
		{
		echo 'DailyJuice';
		}?>
          </h4></td>
        </tr><?php
			}
			
		if($supplements[$i])
			{?>
            <tr>
                <td valign="top"><h4>Suppl&eacute;ment(s)</h4></td>
            </tr>
			<tr>
            	<td><?php echo $supplements[$i];?></td>
			</tr><?php
			}?>
        <tr>
          <td valign="top"><?php 
		  if ($commentaire[$i]) { 
		  	echo "Commentaire: ";?>
            <span style='background-color:#FFCCFF;'><?php echo $commentaire[$i];?></span><?php
			} ?></td>
        </tr>
        <tr>
        	<td valign="top">
            <br /><?php
			echo $prix[$i].' &euro;';?><br /><?php
			$client = new Tbq_client($ID_client[$i]);
			if($paiement[$i]==1 && $client->soldeCompte>=0)//IF paiement CB
				{?>
               	<font style="color:#090; font-weight:bold;">PAY&Eacute; CB</font>
				<?php
				}//FIN IF paiement CB
			if($paiement[$i]==1 && $client->soldeCompte<0)
				{?>
               	<font style="color:#090; font-weight:bold;">PAY&Eacute; CB</font><br />
                <font style="color:#FF0000; font-weight:bold;">Solde compte <?php echo $client->soldeCompte;?>&euro;</font>
				<?php
				}
			
			if($paiement[$i]==5 && $client->soldeCompte>=0)//IF paiement compte
				{?>
                <font style="color:#090; font-weight:bold;">PAY&Eacute;<br />Compte Fraish</font><?php
				}//FIN IF paiement compte
			if($paiement[$i]==5 && $client->soldeCompte<0)//IF paiement compte
				{?>
                <font style="color:#ff0000; font-weight:bold; font-size: 12px;">PAIEMENT D&Ucirc; : <? echo $client->soldeCompte ?>&euro;<br />Recharge compte</font><?php
				}//FIN IF paiement compte
			unset($client);?>
            <p><?php
			if($livraison[$i])
				{?>
            	Livraison : <?php echo $livraison[$i];?><?php
				}?>
                </p>
            </td>
        </tr>       
    </table></td>
    <?php 
	$cpt++;
	} // FIN for ($i=0; $i<count($nom); $i++) 

?>
  </tr>
</table>
</body>
</html>
