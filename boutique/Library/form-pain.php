<div id="pain" style="padding-left:45px;">
      <h2 style="padding-left:70px;">+ 1 pain <span style="font-size:12px;"></span></h2>
      
      <table border="0">
    <tr>  
<?php
$pains = Tbq_famille::listerIngredients(3, 'ordreWeb', '', 1);


//check if id is correct. if not, then try to find the ID with sql request
$idpainFav = Tbq_ingredient::checkIdForFavoris($favori->pain);

for ($i=0; $i<count($pains); $i++){
?>  
	<td style="padding-right:10px"><p>
  	<input type="radio" name="radioPain" id="<?php echo $pains[$i]['libelle']; ?>" value="<?php echo $pains[$i]['ID']; ?>" <?php if ($idpainFav==$pains[$i]['ID']) { echo 'checked="checked"'; } ?> />
  	<?php echo $pains[$i]['libelle']; ?></p></td>
<?php
	if (($i+1)%3 == 0)
		echo '</tr><tr>';
}
?>
	</tr>
</table>

</div>
  
  


