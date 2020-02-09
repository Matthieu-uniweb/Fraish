
<style>
	form label {
		color: #59595A;
	}

</style>


<div id="contents-white">

	<div style="float: left; width: 600px; padding: 0 30px 0 0; ">


		 <h1 class="blur" style="font-size: 20px;">Editer mon compte</h1>	
		 
		 
		 {message}
		
<br/><br/>
		<form name="inscription" method="post"  enctype="multipart/form-data">

			<div class="clearfix">
				<label for="xlInput">Nom</label>
				<div class="input">
					<input class="large" id="xlInput" name="nomid" size="30" type="text" value="{nom}"/>
				</div>
			</div><!-- /clearfix -->
			<div class="clearfix">
				<label for="xlInput">Prénom</label>
				<div class="input">
					<input class="large" id="xlInput" name="prenomid" size="30" type="text" value="{prenom}"/>
				</div>
			</div><!-- /clearfix -->
			<div class="clearfix">
				<label for="xlInput">Adresse</label>
				<div class="input">
					<input class="large" id="xlInput" name="adresseid" size="30" type="text" value="{adresse}"/>
				</div>
			</div><!-- /clearfix -->
			<div class="clearfix">
				<label for="xlInput">Code postal</label>
				<div class="input">
					<input class="large" id="xlInput" name="cpid" size="30" type="text" value="{cp}"/>
				</div>
			</div><!-- /clearfix -->
			<div class="clearfix">
				<label for="xlInput">Ville</label>
				<div class="input">
					<input class="large" id="xlInput" name="villeid" size="30" type="text" value="{ville}"/>
				</div>
			</div><!-- /clearfix -->
			<div class="clearfix">
				<label for="xlInput">Téléphone</label>
				<div class="input">
					<input class="large" id="xlInput" name="telid" size="30" type="text" value="{tel}"/>
				</div>
			</div><!-- /clearfix -->
			<div class="clearfix" style="clear: left;">
				<label for="mediumSelect">Newsletter</label>
				<div class="input">
					<select class="large" name="newsletterid" id="mediumSelect">
						<option value="1" {selectnl2} >Oui, je souhaite être informé des nouveautés et promotions de la boutique Fraish.</option>
						<option value="0" {selectnl1} >Non</option>
					</select>
				</div>
			</div><!-- /clearfix -->

			<div class="clearfix">
				<label for="xlInput">Adresse e-mail</label>
				<div class="input">
					<input class="large" id="xlInput" name="emailid" size="30" type="text" value="{mail}"/>
				</div>
			</div><!-- /clearfix -->
			<div class="clearfix">
				<label for="xlInput">Mot de passe</label>
				<div class="input">
					<input class="large" id="xlInput" name="mdpid" size="30" type="password" value=""/>
				</div>
			</div><!-- /clearfix -->
			<div class="clearfix">
				<label for="xlInput">Mot de passe (confirmation)</label>
				<div class="input">
					<input class="large" id="xlInput" name="mdpconfid" size="30" type="password" value=""/>
				</div>
			</div><!-- /clearfix -->

			<br />

			<br />
			<button type="submit" class="btnfleche txtnoir" style="float: left;margin: 0 0 0 265px;">
				Enregistrer
			</button>

			<input type="hidden" name="fonction" value="editercompte">
			<input type="hidden" name="edited" value="1">
		</form>

	</div>
	<div style="clear: both"></div>
</div>