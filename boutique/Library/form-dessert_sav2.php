<?php
$dessertFavori = explode('|',$favori->dessert);
$dessertFavori = $dessertFavori[0];?>
    <p><?php 
    //Lister les desserts du jour
	if(substr($ID_pointDeVente,0,3)=='LIV')
		{
		$yaourt = $platJour->getMenuJour($dateReservation,$ptLivraison->ID_pointDeVente,'desserts');
		$yaourt2 = $platJour->getMenuJour($dateReservation,$ptLivraison->ID_pointDeVente,'desserts2');
		}
	else
		{
    	$yaourt = $platJour->getMenuJour($dateReservation,$ID_pointDeVente,'desserts');
		$yaourt2 = $platJour->getMenuJour($dateReservation,$ID_pointDeVente,'desserts2');
		}
	if(!$yaourt)
		{
		$yaourt = "biscuits sablés framboise";
		}
	if(!$yaourt2)
		{
		$yaourt2 = "biscuits sablés banane confiture de lait";
		}
	//$yaourt = "Framboise ou Banane";
	print_r( $platJour->getMenuJour($dateReservation,$ptLivraison->ID_pointDeVente,'desserts'));
	
		if(!$modeSupplement) 
			{?>
			<p><input name="radioDessert" type="radio" value="Cake carotte et noix" <?php if ($dessertFavori=='Cake carotte et noix' || !$dessertFavori) { echo 'checked="checked"'; } ?> />&nbsp;Cake carotte et noix</p>
            <p><input name="radioDessert" type="radio" value="Fruits a croquer" <?php if ($dessertFavori=='Fruits a croquer') { echo 'checked="checked"'; } ?> />&nbsp;Fruits &agrave; croquer</p>
            <p><input name="radioDessert" type="radio" value="Yaourt <?php echo $yaourt;?>" <?php if (/*'Yaourt'*/'Yaourt '.$yaourt==$dessertFavori) { echo 'checked="checked"'; } ?> />&nbsp;Yaourt <?php 
			if($yaourt)
				{
				echo " (".$yaourt.")";
				}?></p>
			<p><input name="radioDessert" type="radio" value="Yaourt <?php echo $yaourt2;?>" <?php /*if ('Yaourt'==$dessertFavori) { echo 'checked="checked"'; }*/ 
			if('Yaourt '.$yaourt2==$dessertFavori)
				{
				echo 'checked="checked"';
				}?> />&nbsp;Yaourt <?php 
			if($yaourt2)
				{
				echo " (".$yaourt2.")";
				}?></p><?php
			}
		else
			{?>
            <table><?php
			$tabDesserts = array('Cake carotte et noix','Fruits a croquer','Yaourt');
			foreach($tabDesserts as $itemDessert)
				{
				$i++;?>
                <tr>
					<td><input type="hidden" name="sup[<?php echo $i;?>][nom]" value="<?php echo $itemDessert;?>" />
                    <input type="hidden" name="sup[<?php echo $i;?>][prix]" value="2.6" /</td>				
					<td style="width:170px;"><?php echo $itemDessert;?></td>
                	<td>quantit&eacute;&nbsp;<input type="text" name="sup[<?php echo $i;?>][qte]" value="0" class="inputQte"/></td><?php
				//$i++;?>
                </tr><?php
				}
				$i++;?>
            </table><?php
			}?></p>