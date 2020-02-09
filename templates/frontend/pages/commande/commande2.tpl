<script type="text/javascript">
	$(document).ready( function () {
		$('label').mouseover(function() {
			var content = $(this).siblings('div.contentdetails').html();
			$('#details').html(content);
		});

		$('.max').change(function() {
		 	if ($('.max:checked').length > 10)
		 	{
		 		alert ("Nombre maximum de crudités atteint !")
		 		$(this).attr('checked', false);
		 	}
		});

		$('.max2').change(function() {
		 	if ($('.max2:checked').length > 2)
		 	{
		 		alert ("Nombre maximum de topping atteint !")
		 		$(this).attr('checked', false);
		 	}
		});



		$("form").submit(function () {

			if($('input[name=droitsalade]').val()=='1')
			{
				if($('.max3:checked').length<1){
					alert ("Veuillez choisir les ingrédients de votre salade");
					return false;
				}
				else if($('input[type=radio][name=sauce]:checked').length<1){
					alert ("Veuillez choisir la sauce de votre salade");
					return false;
				}
				/*else if($('input[type=radio][name=pains]:checked').length<1){
					alert ("Veuillez choisir votre type de pain");
					return false;
				}		*/
			 }

			/*if($('input[name=droitsoupe]').val()=='1')
			{
				if($('input[type=radio][name=soupe]:checked').length<1){
					alert ("Veuillez choisir votre soupe");
					return false;
				}

			}*/

			if($('input[name=droitpain]').val()=='1')
			{
				if($('input[type=radio][name=pains]:checked').length<1){
					alert ("Veuillez choisir votre type de pain");
					return false;
				}

			}

			if($('input[name=droitdessert]').val()=='1')
			{
				if($('input[type=radio][name=desserts]:checked').length<1){
					alert ("Veuillez choisir votre dessert");
					return false;
				}

			}

			if($('input[name=droitboisson]').val()=='1')
			{
				if($('input[type=radio][name=boissons]:checked').length<1){
					alert ("Veuillez choisir votre boisson");
					return false;
				}

			}

			if($('input[name=droiteau]').val()=='1')
			{
				if($('input[type=radio][name=eaux]:checked').length<1){
					alert ("Veuillez choisir votre eau");
					return false;
				}

			}

			return true;
		});

	});
</script>


	<div id="contents-green">

		<div id="road">
			<div id="etape1" class="blur"><span>1</span> <div class="topcenter" style="margin-top: 8px;">ma formule</div></div>
			<div id="etape2" class="actif blur"><span>2</span> <div class="topcenter">mes ingrédients</div></div>
			<div id="etape3" class="blur"><span>3</span> <div class="topcenter">mes suppléments</div></div>
			<div id="etape4" class="blur"><span>4</span> <div class="topcenter">valider mon panier</div></div>
			<div id="etape5" class="blur"><span>5</span> <div class="topcenter">enregistrer ma commande</div></div>
			<div id="etape6" class="blur"><span>6</span> <div class="topcenter">retirer votre commande</div></div>
		</div>



		<form name="formulaire" method="post"  enctype="multipart/form-data">

		<button type="submit" class="btnflecherose" style="float: right;">
				Valider
		</button>
		<h1 class="blur">{nomformule}</h1>

		<div style="border-top: 1px solid #007028; padding-top: 10px;">


			<div class="surcolonne">

				<h2 class="titrefamsc">Salades composées</h2>

				<div class="colonneIngredients">
					<h2 class="titrefam noMt">BASE</h2>

					<h2 class="titrefam">FECULENTS</h2>
					<ul class="inputs-list">
					<!-- BEGIN feculents -->
						<li>
							<label {feculents.classdisabled}>
							<input class="max3" type="checkbox" name="ingredient[]" value="{feculents.id}" {feculents.disabled} {feculents.checked}/>
							<span>{feculents.intitule}</span> </label>
						</li>
					<!-- END feculents -->
					</ul>
					<h2 class="titrefam">SALADES</h2>
					<ul class="inputs-list">
					<!-- BEGIN salades -->
						<li>
							<label {salades.classdisabled}>
							<input class="max3" type="checkbox" name="ingredient[]" value="{salades.id}" {salades.disabled} {salades.checked}/>
							<span>{salades.intitule}</span> </label>
						</li>
					<!-- END salades -->
					</ul>
					<hr />
					<h2 class="titrefam">COMPLEMENTS</h2>

					<h2 class="titrefam">CRUDITES</h2>
					<span class="greenlittle">(maximum 10 ingrédients)</span>
					<ul class="inputs-list">
					<!-- BEGIN crudites -->
						<li>
							<label {crudites.classdisabled}>
							<input class="max max3" type="checkbox" name="ingredient[]" value="{crudites.id}" {crudites.disabled} {crudites.checked}/>
							<span>{crudites.intitule}</span> </label>
						</li>
					<!-- END crudites -->
					</ul>

				</div>
				<div class="colonneIngredients" style="border: 0;">
					<h2 class="titrefam noMt">FROMAGES</h2>
					<ul class="inputs-list">
					<!-- BEGIN fromages -->
						<li>
							<label {fromages.classdisabled}>
							<input type="checkbox" name="ingredient[]" value="{fromages.id}" {fromages.disabled} {fromages.checked}/>
							<span>{fromages.intitule}</span> </label>
						</li>
					<!-- END fromages -->
					</ul>

					<h2 class="titrefam">VIANDES</h2>
					<ul class="inputs-list">
					<!-- BEGIN viandes -->
						<li>
							<label {viandes.classdisabled}>
							<input type="checkbox" name="ingredient[]" value="{viandes.id}" {viandes.disabled} {viandes.checked}/>
							<span>{viandes.intitule}</span> </label>
						</li>
					<!-- END viandes -->
					</ul>

					<h2 class="titrefam">POISSONS</h2>
					<ul class="inputs-list">
					<!-- BEGIN poissons -->
						<li>
							<label {poissons.classdisabled}>
							<input type="checkbox" name="ingredient[]" value="{poissons.id}" {poissons.disabled} {poissons.checked}/>
							<span>{poissons.intitule}</span> </label>
						</li>
					<!-- END poissons -->
					</ul>

					<hr />

					<h2 class="titrefam">TOPPING</h2>
					<span class="greenlittle">(maximum 2 ingrédients)</span>
					<ul class="inputs-list">
					<!-- BEGIN topping -->
						<li>
							<label {topping.classdisabled}>
							<input class="max2" type="checkbox" name="ingredient[]" value="{topping.id}" {topping.disabled} {topping.checked}/>
							<span>{topping.intitule}</span> </label>
						</li>
					<!-- END poissons -->
					</ul>

					<hr />

					<h2 class="titrefam">ASSAISONNEMENTS</h2>
					<h2 class="titrefam">SAUCES</h2>
					<ul class="inputs-list">
					<!-- BEGIN sauces -->
						<li>
							<label {sauces.classdisabled}>
							<input type="radio" name="sauce" value="{sauces.id}" {sauces.disabled} {sauces.checked}/>
							<span>{sauces.intitule}</span> </label>
							<div class="contentdetails" style="display: none;">{sauces.details}</div>
						</li>
					<!-- END sauces -->
					</ul>

				</div>
			</div>
			<div class="colonneIngredients" style="border-left: 1px solid #007028;">

				<h2 class="titrefamscleft">Soupes</h2>

				<h2 class="titrefam">RECETTES DU JOUR</h2>
				<ul class="inputs-list">
				<!-- BEGIN recettesdujour -->
					<li>
						<label {recettesdujour.classdisabled}>
						<input type="radio" name="soupe" value="{recettesdujour.id}" {recettesdujour.disabled} {recettesdujour.checked}/>
						<span>{recettesdujour.intitule}</span> </label>
						<div class="contentdetails" style="display: none;">{recettesdujour.details}</div>
					</li>
				<!-- END recettesdujour -->
				</ul>

				<h2 class="titrefam" style="color: #ffffff; font-size: 13px;">AGREMENTS</h2>
				<ul class="inputs-list">
				<!-- BEGIN agrements -->
					<li>
						<label {agrements.classdisabled}>
						<input type="checkbox" name="agrement[]" value="{agrements.id}" {agrements.disabled} {agrements.checked}/>
						<span>{agrements.intitule}</span> </label>
					</li>
				<!-- END agrements -->
				</ul>

				<hr />

				<h2 class="titrefamscleft">SALADES</h2>
				<h2 class="titrefam">RECETTES DU JOUR</h2>
				<ul class="inputs-list">
				<!-- BEGIN saladeRecettesdujour -->
					<li>
						<label {saladeRecettesdujour.classdisabled}>
						<input type="radio" name="saladeRecettesdujour" value="{saladeRecettesdujour.id}" {saladeRecettesdujour.disabled} {saladeRecettesdujour.checked}/>
						<span>{saladeRecettesdujour.intitule}</span> </label>
						<div class="contentdetails" style="display: none;">{saladeRecettesdujour.details}</div>
					</li>
				<!-- END saladeRecettesdujour -->
				</ul>

				<hr />

				<h2 class="titrefamscleft">PAINS</h2>
				<ul class="inputs-list">
				<!-- BEGIN pains -->
					<li>
						<label {pains.classdisabled}>
						<input type="radio" name="pains" value="{pains.id}" {pains.disabled} {pains.checked}/>
						<span>{pains.intitule}</span> </label>
					</li>
				<!-- END pains -->
				</ul>

				<hr />

				<h2 class="titrefamscleft">DESSERTS GOURMANDS</h2>
				<ul class="inputs-list">
				<!-- BEGIN desserts -->
					<li>
						<label {desserts.classdisabled}>
						<input type="radio" name="desserts" value="{desserts.id}" {desserts.disabled} {desserts.checked}/>
						<span>{desserts.intitule}</span> </label>
					</li>
				<!-- END desserts -->
				</ul>

			</div>
			<div class="colonneIngredients">
				<h2 class="titrefamscleft">BOISSONS</h2>

				<h2 class="titrefam">JUS DE FRUITS</h2>
				<ul class="inputs-list">
				<!-- BEGIN jusdefruits -->
					<li>
						<label {jusdefruits.classdisabled}>
						<input type="radio" name="boissons" value="{jusdefruits.id}" {jusdefruits.disabled} {jusdefruits.checked}/>
						<span>{jusdefruits.intitule}</span> </label>
						<div class="contentdetails" style="display: none;">{jusdefruits.details}</div>
					</li>
				<!-- END jusdefruits -->
				</ul>

				<h2 class="titrefam">Milk Shakes</h2>
				<ul class="inputs-list">
				<!-- BEGIN milkshakes -->
					<li>
						<label {milkshakes.classdisabled}>
						<input type="radio" name="boissons" value="{milkshakes.id}" {milkshakes.disabled} {milkshakes.checked}/>
						<span>{milkshakes.intitule}</span> </label>
						<div class="contentdetails" style="display: none;">{milkshakes.details}</div>
					</li>
				<!-- END milkshakes -->
				</ul>

				<h2 class="titrefam">SMOOTHIES</h2>
				<ul class="inputs-list">
				<!-- BEGIN smoothies -->
					<li>
						<label {smoothies.classdisabled}>
						<input type="radio" name="boissons" value="{smoothies.id}" {smoothies.disabled} {smoothies.checked}/>
						<span>{smoothies.intitule}</span> </label>
						<div class="contentdetails" style="display: none;">{smoothies.details}</div>
					</li>
				<!-- END smoothies -->
				</ul>

				<hr />

				<h2 class="titrefamscleft">EAUX</h2>
				<ul class="inputs-list">
				<!-- BEGIN eaux -->
					<li>
						<label {eaux.classdisabled}>
						<input type="radio" name="eaux" value="{eaux.id}" {eaux.disabled} {eaux.checked}/>
						<span>{eaux.intitule}</span> </label>
					</li>
				<!-- END eaux -->
				</ul>


			</div>



			<input type="hidden" name="fonction" value="commande">
			<input type="hidden" name="etape" value="3">
			<input type="hidden" name="size" value="{size}">
			<input type="hidden" name="nomFormule" value="{nomformule}">
			<input type="hidden" name="idFormule" value="{idformule}">
			<input type="hidden" name="choixingredients" value="1">

			<!-- droits menu, pour controle -->
			<input type="hidden" name="droitsalade" value="{droitsalade}">
			<input type="hidden" name="droitsoupe" value="{droitsoupe}">
			<input type="hidden" name="droitdessert" value="{droitdessert}">
			<input type="hidden" name="droitboisson" value="{droitboisson}">
			<input type="hidden" name="droiteau" value="{droiteau}">
			<input type="hidden" name="droitpain" value="{droitpain}">

		<div class="colonneinfosplus">
			<div class="cvertright">
				<h2>CONSEIL</h2>

				<h3>Composition idéale</h3>
				1 féculent <br />
				1 variété de salade <br />
				5 crudités <br />
				1 protéine <br />
				1 sauce <br />
				1 topping <br />
			</div>

			<div class="cvertright" id="details">

			</div>

		</div>

		</div>




		<div style="clear: both"></div>
		<a href="commanderetour.html" class="btnflecheroseleft">Retour</a>
	</form>
</div>