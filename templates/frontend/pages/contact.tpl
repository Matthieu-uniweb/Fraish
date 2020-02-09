<script type="text/javascript">
	var RecaptchaOptions = {
		theme : 'clean',
		lang : 'fr'

	};
</script>

<style>
	form label {
		color: #59595A;
	}
	table {
		width: auto;
		background-color: #ffffff;
	}

</style>

<div id="contents-white">
	<div id="fruits33">

		<div style="float: right;">
			<iframe width="425" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.fr/maps?f=q&amp;source=s_q&amp;hl=fr&amp;geocode=&amp;q=Fraish,+Lab%C3%A8ge&amp;aq=0&amp;oq=fraish+labege&amp;sll=46.22475,2.0517&amp;sspn=32.303511,95.756836&amp;t=m&amp;ie=UTF8&amp;hq=Fraish,&amp;hnear=Lab%C3%A8ge,+Haute-Garonne,+Midi-Pyr%C3%A9n%C3%A9es&amp;ll=43.550891,1.508064&amp;spn=0.008258,0.023378&amp;z=14&amp;iwloc=A&amp;cid=9920039359728142703&amp;output=embed"></iframe>
			<br />
			<small><a style="color: #000000;" href="https://maps.google.fr/maps?f=q&amp;source=embed&amp;hl=fr&amp;geocode=&amp;q=Fraish,+Lab%C3%A8ge&amp;aq=0&amp;oq=fraish+labege&amp;sll=46.22475,2.0517&amp;sspn=32.303511,95.756836&amp;t=m&amp;ie=UTF8&amp;hq=Fraish,&amp;hnear=Lab%C3%A8ge,+Haute-Garonne,+Midi-Pyr%C3%A9n%C3%A9es&amp;ll=43.550891,1.508064&amp;spn=0.008258,0.023378&amp;z=14&amp;iwloc=A&amp;cid=9920039359728142703" style="color:#0000FF;text-align:left">Agrandir le plan</a></small>
		</div>

		<h1 class="blur" style="font-size: 20px;">Nous contacter </h1>
		<br />

		<b>FRAISH</b> - Centre Commercial LABEGE2 - 31670 LABEGE

		<br />
		Tel : 05.61.73.17.88
		<br />
		<br />
		<br />

		<form name="formulaire" method="post" enctype="multipart/form-data">
			<fieldset>
				<legend>
					<span style="margin-left: 20px; color: #59595A;">Laissez vos coordonnées</span>
				</legend>
				<br />
				<br />
				<br />

				<div class="clearfix">
					<label for="xlInput">Nom*</label>
					<div class="input">
						<input class="xlarge" id="xlInput" name="nom" size="30" type="text" />
					</div>
				</div><!-- /clearfix -->

				<div class="clearfix">
					<label for="xlInput">Prénom *</label>
					<div class="input">
						<input class="xlarge" id="xlInput" name="prenom" size="30" type="text" />
					</div>
				</div><!-- /clearfix -->

				<div class="clearfix">
					<label for="xlInput">E-mail *</label>
					<div class="input">
						<input class="xlarge" id="xlInput" name="email" size="30" type="text" />
					</div>
				</div><!-- /clearfix -->

				<div class="clearfix">
					<label for="xlInput">N° de téléphone</label>
					<div class="input">
						<input class="xlarge" id="xlInput" name="tel" size="30" type="text" />
					</div>
				</div><!-- /clearfix -->

				<div class="clearfix">
					<label for="xlInput">Sujet</label>
					<div class="input">
						<input class="xlarge" id="xlInput" name="sujet" size="30" type="text" />
					</div>
				</div><!-- /clearfix -->

				<div style="margin: 0 0 15px 147px;">
					{recaptcha}
				</div>

				<div class="clearfix">
					<label for="textarea">Votre message</label>
					<div class="input">
						<textarea class="xxlarge" id="textarea" name="message"></textarea>

 <span class="help-block"> </span>
					</div>
				</div><!-- /clearfix -->

				<br />
				<br />

				<button type="submit" class="btn primary" style="margin-left: 150px;">
					Envoyer mon message
				</button>

				<input type="hidden" name="fonction" value="traiterContact">
			</fieldset>
		</form>
		<br />

	</div>
</div>