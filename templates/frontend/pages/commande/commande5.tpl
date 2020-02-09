<div id="contents-green">

	<div id="road">
		<div id="etape1" class="blur">
			<span>1</span><div class="topcenter" style="margin-top: 8px;">ma formule</div>
		</div>
		<div id="etape2" class="blur"><span>2</span><div class="topcenter">mes ingrédients</div></div>
		<div id="etape3" class="blur"><span>3</span><div class="topcenter">mes suppléments</div></div>
		<div id="etape4" class="blur"><span>4</span><div class="topcenter">valider mon panier</div>
		</div><div id="etape5" class="actif blur"><span>5</span><div class="topcenter">enregistrer ma commande</div>
		</div><div id="etape6" class="blur"><span>6</span><div class="topcenter">retirer votre commande</div>
		</div>
	</div>

	<form name="formulaire" method="post"  enctype="multipart/form-data">

		
					
				
					
				<div id="mypanier">
					
					<span class="panier">Mon panier</span>	
					
					
					{message}
					
					
					<!-- BEGIN panier --> 						
														
						
					
					<div id="leftpanier">
						<h2 class="titreformulepanier blur">{panier.nomformule}</h2>
						<div class="detailpanier">					
							{panier.txtDetailsFormule}	
							<br/><br/> Taille du menu : {panier.size}							
							<br/><br/>{panier.txtDetailsFormuleSup}
							<br/><br/><br/>
							<a class="btVert" href="supprimerpanier-elem_{panier.mycount}.html">Supprimer</a>							
						</div>											
					</div>			
					
					
					<div id="rightpanier">						
						
						
						<div style="float: left; width: 160px; padding: 40px 0 0 10px;">						
							<b style="font-size: 14px;">Quantité</b><br />
							<input class="ui-spinner-box" disabled type="text" value="{panier.quantite}" autocomplete="off" style="width: 40px;" id="spin" name="qte"/>							
							<input class="price" type="text" disabled value="{panier.price}€" style="width: 50px; height: 20px;" name="price"/>
							<input type="hidden" name="pricebase" value="{panier.price}" class="pricebase">					
						</div>
						
						<div style="float: right; width: 360px;padding-top: 10px;">
							<b style="font-size: 14px;">Commentaire</b><br /><br />
							<span style="font-style: italic">{panier.commentaire}</span>							
						</div>
						
						<div style="clear: both"></div>		
						
						
					</div>		
					<div style="clear: both"></div>
			
				<!-- END panier --> 
				
				</div>			
							
				<a href="completercommande.html" class="btnflecheverte txtnoir" style="float: left; position: relative; bottom: 55px; left: 370px;">Compléter ma commande</a>
					
					
				<p style="color: #000000; margin: -140px 0 0 670px; display: block; width: 250px;position: absolute;">Saisissez votre code promo, puis cliquez sur "Retirer votre commande" pour valider.	</p>
					
				<input class="codepromo pink" type="text" value="je dispose d'un code promo !" name="codepromo" onFocus="this.value=''"/>	
					
				<button type="submit" class="btnflecherose txtnoir" style="float: right; position: relative; bottom: 55px; right: -140px;">Retirer votre commande</button>
			
				

			<input type="hidden" name="fonction" value="commande">
			<input type="hidden" name="etape" value="6">

	</form>

		<div style="clear: both"></div>	
		
	
</div>