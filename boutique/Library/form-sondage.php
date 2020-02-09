<?php
$listeQuestions = Tbq_sondage::listerQuestionsActives();
if($listeQuestions)
	{?>
    <div id="sondage" style="background-color:#FCC;">
    <p><strong>Sondage :</strong></p>
    <?php
	foreach($listeQuestions as $sondage)
		{?>
        <input type="hidden" name="tabSondages[]" value="<?php echo $sondage->ID;?>" />
        <p><em>*&nbsp;<?php echo $sondage->question;?></em></p>
        <p>
        <input type="radio" name="reponse[<?php echo $sondage->ID;?>]" value="reponse1" />&nbsp;<?php echo $sondage->reponse1;?><br />
        <input type="radio" name="reponse[<?php echo $sondage->ID;?>]" value="reponse2" />&nbsp;<?php echo $sondage->reponse2;
		
		if($sondage->reponse3)//Une troisième réponse est facultative
			{?><br />
        	<input type="radio" name="reponse[<?php echo $sondage->ID;?>]" value="reponse3" />&nbsp;<?php echo $sondage->reponse3;?></p><?php
			}
		}?>
      </div><?php
	}
?>