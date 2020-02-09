<div id="pain">
      <h2>+ 1 pain <span style="font-size:12px;">(selon disponibilit&eacute;s)</span></h2>
      <table border="0">
        <tr>
          <td><p>
              <input type="radio" name="radioPain" id="Céréales" value="Cereales" checked="checked" <?php if ( ($favori->pain=='Cereales') || (!$favori->pain) ) { echo 'checked="checked"'; } ?> />
              C&eacute;r&eacute;ales</p></td>
          
          <td><p>
              <input type="radio" name="radioPain" id="Noix" value="Noix" <?php if ($favori->pain=='Noix') { echo 'checked="checked"'; } ?> />
              Noix</p></td>
        
          <td><p>
              <input type="radio" name="radioPain" id="Figues" value="Figues" <?php if ($favori->pain=='Figues') { echo 'checked="checked"'; } ?> />
              Figues</p></td>
          </tr>
        <tr>
          
          <td><p>
              <input type="radio" name="radioPain" id="Lardons" value="Lardons" <?php if ($favori->pain=='Lardons') { echo 'checked="checked"'; } ?> />
              Lardons</p></td>
       
          <td><p>
              <input type="radio" name="radioPain" id="Raisins/Noisettes" value="Raisins/Noisettes" <?php if ($favori->pain=='Raisins/Noisettes') { echo 'checked="checked"'; } ?> />
              Raisins/Noisettes</p></td>
          
          <td><p>
              <input type="radio" name="radioPain" id="Fromage" value="Fromage" <?php if ($favori->pain=='Fromage') { echo 'checked="checked"'; } ?> />
              Fromage</p></td>
        </tr>
      </table>
      <p>&nbsp;</p>
    </div>