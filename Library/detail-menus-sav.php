<?php
$menu = new Tbq_menu();
$listeMenus = $menu->lister();
?>
<style>
table tr td, table tr th {
text-align:center;
min-width:75px!important;
font-size:14px!important;
}
table tr th {
font-weight:bold;
}
a.btReserver {
float:left;
background-color:#FF6633;
width:80px;
height:25px;
padding-top:4px!important;
padding-left:0px!important;
color:#fff!important;
font-size:12px!important;
}
a.btReserver:hover {
font-weight:bold;
}
</style>
<table cellpadding="0" cellspacing="0">
    <tr style="background-color:#FF6633; color:#FFFFFF; height:25px;">
        <th style="border-left:solid 1px #FF6633;">Salade</td>
        <th>Soupe</td>
        <th>Boisson</td>
        <th>Dessert</td>
        <th>Pain</td>
        <th style="border-right:solid 1px #FF6633;">Eau</td>
        <th style="background-color:#fff; color:#000;">GRAND</td>
        <th style="background-color:#fff; color:#000;">MOYEN</td>
        <th style="background-color:#fff; color:#000;">PETIT</td>
        <th style="background-color:#fff; color:#000;">&nbsp;</td>
    </tr>
<?php
	if($listeMenus)
		{
		$i=0;
		foreach($listeMenus as $menu)
			{?>
            <tr <?php if($i%2){?>style="background-color:#FFCC66;"<?php }?>>
            	<td style="border-left:solid 1px #FF6633;"><?php if($menu->salade){?><img src="/images/icones/salades.gif" alt="Salade"/><?php }?></td>
                <td><?php if($menu->soupe){?><img src="/images/icones/soupe.gif" alt="Soupe"/><?php }?></td>
                <td><?php if($menu->boisson){?><img src="/images/icones/boisson.gif" alt="Boisson"/><?php }?></td>
                <td><?php if($menu->dessert){?><img src="/images/icones/dessert.gif" alt="Dessert" height="40"/><?php }?></td>
                <td><?php if($menu->pain){?><img src="/images/icones/pain.gif" alt="Boisson"/><?php }?></td>
                <td style="border-right:solid 1px #FF6633;"><?php if($menu->eau){?><img src="/images/icones/eau.gif" alt="Eau"/><?php }?></td>
                <td><strong><?php echo $menu->getPrixGrand();?> &euro;</strong></td>
                <td><strong><?php echo $menu->getPrixMoyen();?> &euro;</strong></td>
                <td align="center"><strong><?php echo $menu->getPrixPetit(); if($menu->getPrixPetit()>0){?> &euro;<?php }?></strong></td>
                <td><?php
                if(!$_SESSION['favori'])
					{?>
					<a href="/boutique/fr/espace-client/reserver-ingredients.php?ID_menu=<?php echo $menu->ID;?>" class="btReserver">&gt;R&eacute;server</a><?php
                    }
				else
					{?>
                    <a href="/boutique/fr/espace-client/menu-favori-ingredients.php?ID_menu=<?php echo $menu->ID;?>" class="btReserver">&gt;Choisir</a><?php
					}?></td>
            </tr>
            <?php
			$i++;
			}
			unset($_SESSION['favori']); 
		}?>
        <tr>
        	<td colspan="6" style="border-top:solid 1px #FF6633;"></td>
            <td></td>
        </tr>
</table>