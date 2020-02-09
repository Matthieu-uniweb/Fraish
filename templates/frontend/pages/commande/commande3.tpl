<script type="text/javascript">
	$(document).ready( function () {
		
		$("form").submit(function () {	
			
			var test = true;		
			
			$('input.supmul').each(function() {				
			
				if ($(this).val()>0) 				
				{
					var nomsup = $(this).parent().parent().parent().prev().find("span").text();
					
					var vartest = $(this).parent().parent().parent().next().find("input[type=radio]").is(":checked");					
					if(!vartest)					
					{
						alert ("Veuillez choisir la taille de votre supplément "+nomsup);
						test = false;
					}						
				}						
			});
			
			return test;
		});	
		
	}); 
</script>



<div id="contents-green">

	<div id="road">
		<div id="etape1" class="blur"><span>1</span><div class="topcenter" style="margin-top: 8px;">ma formule</div></div>
		<div id="etape2" class="blur"><span>2</span><div class="topcenter">mes ingrédients</div></div>
		<div id="etape3" class="actif blur"><span>3</span><div class="topcenter">mes suppléments</div></div>
		<div id="etape4" class="blur"><span>4</span><div class="topcenter">valider mon panier</div></div>
		<div id="etape5" class="blur"><span>5</span><div class="topcenter">enregistrer ma commande</div>
		</div><div id="etape6" class="blur"><span>6</span><div class="topcenter">retirer votre commande</div></div>
	</div>

	<form name="formulaire" method="post"  enctype="multipart/form-data">

		<button type="submit" class="btnflecherose" style="float: right;">
			Valider
		</button>
		<h1 class="blur">{nomformule}</h1>

		<div style="border-top: 1px solid #007028; padding-top: 10px;">

			<div class="surcolonne">

				<h2 class="titrefamsc">Envie d'un supplément ?</h2>
				
					
					<div style="padding: 0 20px; color: #ffffff;">
					
					<table>
					<!-- BEGIN ssfamilles -->
					
							<script type="text/javascript">		
							$(document).ready(function() {
								<!-- BEGIN supplementmulti --> 	
									$( "#radioset{ssfamilles.supplementmulti.idsup}" ).buttonset();
								<!-- END supplementmulti -->
								});
							</script>
							
							<tr>
								<td colspan="4"><h2 class="blur" style="color: #ffffff;font-size: 22px;">{ssfamilles.intitule} :</h2></td>
							</tr>
							
							<!-- BEGIN supplement --> 		
																
								
								<tr>
									<td width=200><span style="float: left;">{ssfamilles.supplement.libelle}</span></td>
									<td>
										<div class="ui-spinner" style="float: left;">
										  <input class="ui-spinner-box spinthat" type="text" value="0" autocomplete="off" style="width: 80px;" id="spin" name="sup[{ssfamilles.supplement.mycount}][{ssfamilles.supplement.idsup}][qte]"/>
										</div>
									</td>
									<td><span style="float: left;">{ssfamilles.supplement.libellePrix}</span></td>
									<td></td>
								</tr>
								
											
						<!-- END supplement --> 
						
						<!-- BEGIN supplementmulti --> 						
								
								<tr>
									<td><span style="float: left; cursor: help;" {ssfamilles.supplementmulti.tooltip}>{ssfamilles.supplementmulti.libelle}</span></td>
									<td>
										<div class="ui-spinner" style="float: left;">
										  <input class="ui-spinner-box spinthat supmul" type="text" value="0" autocomplete="off" style="width: 80px;" id="spin" name="sup[{ssfamilles.supplementmulti.mycount}][{ssfamilles.supplementmulti.idsup}][qte]"/>
										</div>
									</td>
									<td>
										<div id="radioset{ssfamilles.supplementmulti.idsup}" style="float: left; margin: 0 0 0 20px;">
											
											<!-- BEGIN each -->
											<input type="radio" class="nrad" id="radio{ssfamilles.supplementmulti.each.count}{ssfamilles.supplementmulti.idsup}" name="sup[{ssfamilles.supplementmulti.mycount}][{ssfamilles.supplementmulti.idsup}][taille]" value="{ssfamilles.supplementmulti.each.taille}" /><label for="radio{ssfamilles.supplementmulti.each.count}{ssfamilles.supplementmulti.idsup}">{ssfamilles.supplementmulti.each.libellePrix}</label>
											<!-- END each --> 
																					
										</div>
									</td>
									<td></td>
								</tr>
								
											
						<!-- END supplementmulti --> 
						
								<tr>
									<td colspan="4"></td>
								</tr>	
										
					<!-- END ssfamilles --> 
					
					</table>				

				</div>
				
			<input type="hidden" name="fonction" value="commande">
			<input type="hidden" name="etape" value="4">
			<input type="hidden" name="size" value="{size}">
			<input type="hidden" name="nomFormule" value="{nomformule}">
			<input type="hidden" name="idFormule" value="{idformule}">
		</div>

		<div style="clear: both"></div>
		<a href="commanderetour.html" class="btnflecheroseleft">Retour</a>
	</form>
</div>