<div id="contents-green">

	<div id="road">
		<div id="etape1" class="blur">
			<span>1</span><div class="topcenter" style="margin-top: 8px;">ma formule</div>
		</div>
		<div id="etape2" class="blur"><span>2</span><div class="topcenter">mes ingrédients</div></div>
		<div id="etape3" class="blur"><span>3</span><div class="topcenter">mes suppléments</div></div>
		<div id="etape4" class="blur"><span>4</span><div class="topcenter">valider mon panier</div>
		</div><div id="etape5" class="blur"><span>5</span><div class="topcenter">enregistrer ma commande</div>
		</div><div id="etape6" class="actif blur"><span>6</span><div class="topcenter">retirer votre commande</div>
		</div>
	</div>

				
				<div id="mypanier">
					
					<span class="panier">Mon panier</span>	
					
					
					<div style="float: left;">
					<!-- BEGIN panier --> 					
						<div id="leftpanier" style="margin-bottom: 15px;">
							<h2 class="titreformulepanier blur">{panier.nomformule}</h2>															
						</div>							
						<div style="float: left; width: 160px; padding: 0 0 0 10px;">						
							<b style="font-size: 14px;">Quantité</b><br />
							<input class="ui-spinner-box" disabled type="text" value="{panier.quantite}" autocomplete="off" style="width: 40px;" name="qte"/>							
							<input class="price" type="text" disabled value="{panier.price}€" style="width: 50px; height: 20px;" name="price"/>
							<input type="hidden" name="pricebase" value="{panier.price}" class="pricebase">					
						</div>	
						<div style="clear: both; margin-top: 10px;"></div>									
					<!-- END panier --> 
					
					{codepromo}
					{codepromodescription}
					
					
					</div>
					
					
					
					<div style="float: right; width: 350px;padding-top: 0;margin-top: -30px; padding-right: 20px;">
							
							Mon paiement <br /> <br />
							
							Crédit &nbsp;&nbsp;<img src="styles/frontend/img/fraish_mini.png"/> <input class="credit" type="text" disabled value="{creditfraish}€" style="width: 70px; height: 20px;"/>
							<a href="paiementcredit.html" class="btnflecherose" style="margin-top: 25px;">Valider</a>

							<br /><br />Carte bancaire &nbsp;&nbsp;<img src="styles/frontend/img/cb.png"/>
							
							<form action="{sUrlPaiement}" method="post" id="PaymentRequest">
								
									<input type="hidden" name="version"             id="version"        value="{sVersion}" />
									<input type="hidden" name="TPE"                 id="TPE"            value="{sNumero}" />
									<input type="hidden" name="date"                id="date"           value="{sDate}" />
									<input type="hidden" name="montant"             id="montant"        value="{sMontant}" />
									<input type="hidden" name="reference"           id="reference"      value="{sReference}" />
									<input type="hidden" name="MAC"                 id="MAC"            value="{sMAC}" />
									<input type="hidden" name="url_retour"          id="url_retour"     value="{sUrlKO}" />
									<input type="hidden" name="url_retour_ok"       id="url_retour_ok"  value="{sUrlOK}" />
									<input type="hidden" name="url_retour_err"      id="url_retour_err" value="{sUrlKO}" />
									<input type="hidden" name="lgue"                id="lgue"           value="{sLangue}" />
									<input type="hidden" name="societe"             id="societe"        value="{sCodeSociete}" />
									<input type="hidden" name="texte-libre"         id="texte-libre"    value="{sTexteLibre}" />
									<input type="hidden" name="mail"                id="mail"           value="{sEmail}" />	
									
									
									<input type="submit" name="bouton" class="btnflecherose" style="margin-top: -30px;" id="bouton" value="Valider" />
								
								
								
								
								</form>

							<input type="hidden" name="fonction" value="commande">
								<input type="hidden" name="etape" value="7">
							
												
					</div>
					
					
					<div style="float: left;">
						<div id="leftpanier" style="margin-bottom: 15px;">																				
						</div>							
						<div style="float: left; width: 160px; padding: 20px 0 0 10px;">						
							<b style="font-size: 14px;">Total : &nbsp;&nbsp;&nbsp;<span style="color: #81b334; font-weight: bold; font-size: 18px;">{prixcommandetotal}€</span></b><br />							
						</div>	
					</div>
				
				<div style="clear: both"></div>	
				
				<br/><br/><br/><br/>
				</div>			
					
				

			

	
	
		<!--<a href="completercommande.html" class="btnflecheverte txtnoir" style="float: left; position: relative; bottom: 55px; left: 10px;">Compléter ma commande</a>-->
		
		<div style="clear: both"></div>	
		
	
</div>