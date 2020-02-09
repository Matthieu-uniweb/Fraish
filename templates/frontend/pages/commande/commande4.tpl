<div id="contents-green">

	<div id="road">
		<div id="etape1" class="blur">
			<span>1</span><div class="topcenter" style="margin-top: 8px;">ma formule</div>
		</div>
		<div id="etape2" class="blur"><span>2</span><div class="topcenter">mes ingrédients</div></div>
		<div id="etape3" class="blur"><span>3</span><div class="topcenter">mes suppléments</div></div>
		<div id="etape4" class="actif blur"><span>4</span><div class="topcenter">valider mon panier</div>
		</div><div id="etape5" class="blur"><span>5</span><div class="topcenter">enregistrer ma commande</div>
		</div><div id="etape6" class="blur"><span>6</span><div class="topcenter">retirer votre commande</div>
		</div>
	</div>

	<form name="formulaire" method="post"  enctype="multipart/form-data">

		
					
				<div id="mypanier">
					
					<div id="leftpanier">
						<h2 class="titreformulepanier blur">{nomformule}</h2>
						<div class="detailpanier">					
							{txtDetailsFormule}	
							<br/><br/> Taille du menu : {size}							
							<br/><br/>{txtDetailsFormuleSup}
							<br/><br/><br/>
							<a class="btVert" href="supprimerpanier-elem_panier.html">Supprimer</a>							
						</div>											
					</div>			
					
					
					<div id="rightpanier">						
						
						
						<div style="float: left; width: 160px; padding: 95px 0 0 10px;">						
							<b style="font-size: 14px;">Quantité</b><br />
							<input class="ui-spinner-box spinthat" type="text" value="1" autocomplete="off" style="width: 40px;" id="spin" name="qte"/>							
							<input class="price" type="text" disabled value="{price}€" style="width: 50px; height: 20px;" name="price"/>
							<input type="hidden" name="pricebase" value="{price}" class="pricebase">					
						</div>
						
						<div style="float: right; width: 360px;padding-top: 10px;">
							<b style="font-size: 14px;">Commentaire</b><br /><br />
							<textarea name="commentaire" style="width: 350px; height: 150px;" class="com"></textarea><br /><br /><br />
						</div>
						
						<div style="clear: both"></div>		
						
						
					</div>		
					<div style="clear: both"></div>							
					
					
					<button type="submit" class="btnflecherose txtnoir" style="float: right; position: relative; bottom: 45px; right: 20px;">
							Ajouter à ma commande
					</button>
							
				</div>
					
			

			<input type="hidden" name="fonction" value="commande">
			<input type="hidden" name="etape" value="5">
			
			
	</form>

		<div style="clear: both"></div>
		
		<a href="commanderetour.html" class="btnflecheroseleft">Retour</a>
	
</div>