<style>
	form label {
		color: #59595A;
	}

</style>

<div id="contents-white">

	<div style="float: left; width: 680px; padding: 0 30px 0 0; ">

		<h1 class="blur" style="font-size: 20px;">Réaprovisionner mon compte</h1>

		<br/>
		<br/>
		
		<h2 style="font-size: 16px;">Vous avez choisi de réapprovisionner votre compte d'un montant de {montant}€, par carte bleue.</h1>
			<br/>
			<h2 class="pink" style="font-size: 20px;">{bonus}</h1>
			<br/>
			
			<p>Cliquez sur <i class="pink">procéder au paiement</i> afin d'être redirigé vers le formulaire de paiement.</p>
		<br/>
		<br/>
		
		<img src="styles/frontend/img/logocmcicpaiement.gif"/>
		
		
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

			<input type="submit" name="bouton" class="btnflecherose" style="margin-top: -30px; width: 180px;" id="bouton" value="Procéder au paiement" />

		</form>

	</div>
	<div style="clear: both"></div>
</div>