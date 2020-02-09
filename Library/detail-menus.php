<?php
//include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/includes/classes/paquetage.inc.php';
//$formule = new Tbq_formule();
$listeFormules = Tbq_formule::lister();
?>
<?php /*?><img src="/images/site/tit-formules.jpg" /><?php */?>
<div class="ajusteur"></div>
<h3 id="menuboard">Pour commander en ligne, cliquez sur le menu de votre choix</h3>
<img src="/images/menus/legende-gobelets.jpg" alt="Tailles des menus"/>
<div class="ajusteur"></div>
<p>&nbsp;&nbsp;&nbsp;&nbsp;Le pain est compris dans chaque formule.</p>
<p>&nbsp;&nbsp;&nbsp;&nbsp;Vous pouvez ajouter des suppl&eacute;ments dans chaque formule.</p>
<p>&nbsp;&nbsp;&nbsp;&nbsp;Les boissons = jus de fruit, smoothies, dairy smoothies.</p>
<?php 
$visuMenuJour = new Tbq_menuJour();
echo $visuMenuJour->getDescriptifMenusJour();?>
<div class="ajusteur"></div>
<?php
if($listeFormules)
	{
	$i=0;
	foreach($listeFormules as $laformule)
		{
		if($i==4)
			{?>
            <div class="ajusteur"></div><?php
			}
		if(!$_SESSION['favori'])
			{?>
        	<a href="/boutique/fr/espace-client/reserver-ingredients.php?ID_formule=<?php echo $laformule->ID;?>" title="Formule <?php echo $laformule->nom;?>"><?php
			}
		else
			{?><a href="/boutique/fr/espace-client/menu-favori-ingredients.php?ID_formule=<?php echo $laformule->ID;?>" title="Formule <?php echo $laformule->nom;?>"><?php
            }?>
            <img src="/images/menus/<?php echo $laformule->visuel;?>" /></a>
		<?php
		$i++;
		}
		unset($_SESSION['favori']);
	}?>
<p>&nbsp;</p>