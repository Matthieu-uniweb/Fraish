
<script type="text/javascript">
		
		$("form[name='inscription]'").submit(function () {			
			alert ("yes");
			if($('input[name=nomid]').val()=='')
			{
				alert ("Veuillez saisir votre nom");
				return false;
			}	
			if($('input[name=prenomid]').val()=='')
			{
				alert ("Veuillez saisir votre prénom");
				return false;
			}
			if($('input[name=cpid]').val()=='')
			{
				alert ("Veuillez saisir votre code postal");
				return false;
			}
			if($('input[name=villeid]').val()=='')
			{
				alert ("Veuillez saisir votre ville");
				return false;
			}
			if($('input[name=telid]').val()=='')
			{
				alert ("Veuillez saisir votre numéro de téléphone");
				return false;
			}				
			if($('input[name=naissanceid]').val()=='')
			{
				alert ("Veuillez saisir votre date de naissance");
				return false;
			}
			if($('input[name=emailid]').val()=='')
			{
				alert ("Veuillez saisir votre adresse email");
				return false;
			}
			if($('input[name=mdpid]').val()=='')
			{
				alert ("Veuillez saisir votre mot de passe");
				return false;
			}
			if($('input[name=mdpid]').val()!=$('input[name=mdpconfid]').val())
			{
				alert ("Les mots de passe ne concordent pas!");
				return false;
			}
			
			
			return true;
		});			
	
</script>




<div id="contents-green" class="globalbox" style="color: #ffffff;">
	
	<div id="boxleft">
		<h2 class="blur">Déjà Client</h2>
		<br /><br />
		<form name="formulaire" method="post"  enctype="multipart/form-data">	
	
			<div class="clearfix">
				<label for="xlInput">Adresse e-mail</label>
				<div class="input">
					<input class="large" id="xlInput" name="emaillogin" size="30" type="text" />
				</div>
			 </div><!-- /clearfix -->
			 
			 <div class="clearfix">
				<label for="xlInput">Mot de passe</label>
				<div class="input">
					<input class="large" id="xlInput" name="passlogin" size="30" type="password" />
				</div>
			 </div><!-- /clearfix -->	
	
	
			<button type="submit" class="btnfleche">
				Me connecter
			</button>
			
			<input type="hidden" name="fonction" value="traiterLogin">

		</form>
		
		<br /><br /><br /><br /><br />
		<form name="formulaire" method="post"  enctype="multipart/form-data">	
		
		Mot de passe oublié ?<br /><br />
		
			<div class="clearfix">
				<label for="xlInput">Adresse e-mail</label>
				<div class="input">
					<input class="large" id="xlInput" name="emailoubli" size="30" type="text" />
				</div>
			 </div><!-- /clearfix -->	
	
			<button type="submit" class="btnfleche">
				Me renvoyer mon mot de passe
			</button>
			
			<input type="hidden" name="fonction" value="traiterMdp">

		</form>
		



	</div>
	<div id="boxright">
		<h2 class="blur">Nouveau Client</h2>
		<br /><br />
		Remplissez le formulaire ci-dessous pour créer votre compte
		<br /><br />
		Informations personnelles
		<br /><br />
		<form name="inscription" method="post"  enctype="multipart/form-data">	
			
		<div class="clearfix">
			<label for="xlInput">Nom</label>
			<div class="input">
				<input class="large" id="xlInput" name="nomid" size="30" type="text" />
			</div>
		</div><!-- /clearfix --> 
		<div class="clearfix">
			<label for="xlInput">Prénom</label>
			<div class="input">
				<input class="large" id="xlInput" name="prenomid" size="30" type="text" />
			</div>
		</div><!-- /clearfix -->
		<div class="clearfix">
			<label for="xlInput">Adresse</label>
			<div class="input">
				<input class="large" id="xlInput" name="adresseid" size="30" type="text" />
			</div>
		</div><!-- /clearfix -->		
		<div class="clearfix">
			<label for="xlInput">Code postal</label>
			<div class="input">
				<input class="large" id="xlInput" name="cpid" size="30" type="text" />
			</div>
		</div><!-- /clearfix -->
		<div class="clearfix">
			<label for="xlInput">Ville</label>
			<div class="input">
				<input class="large" id="xlInput" name="villeid" size="30" type="text" />
			</div>
		</div><!-- /clearfix -->
		<div class="clearfix">
			<label for="xlInput">Téléphone</label>
			<div class="input">
				<input class="large" id="xlInput" name="telid" size="30" type="text" />
			</div>
		</div><!-- /clearfix -->
		<div class="clearfix">
			<label for="xlInput">Date de naissance (format 00-00-00000)</label>
			<div class="input">
				<input class="large" id="xlInput" name="naissanceid" size="30" type="text" />
			</div>
		</div><!-- /clearfix -->
		<div class="clearfix" style="clear: left;">
			<label for="mediumSelect">Newsletter</label>		
			<div class="input">
				<select class="large" name="newsletterid" id="mediumSelect">
					<option value="1">Oui, je souhaite être informé des nouveautés et promotions de la boutique Fraish.</option>
					<option value="0">Non</option>					
				</select>
			</div>
		</div><!-- /clearfix -->
		
		
		<br />
		Vos identifiants<br /><br />
		<div class="clearfix">
			<label for="xlInput">Adresse e-mail</label>
			<div class="input">
				<input class="large" id="xlInput" name="emailid" size="30" type="text" />
			</div>
		</div><!-- /clearfix -->
		<div class="clearfix">
			<label for="xlInput">Mot de passe</label>
			<div class="input">
				<input class="large" id="xlInput" name="mdpid" size="30" type="password" />
			</div>
		</div><!-- /clearfix -->
		<div class="clearfix">
			<label for="xlInput">Mot de passe (confirmation)</label>
			<div class="input">
				<input class="large" id="xlInput" name="mdpconfid" size="30" type="password" />
			</div>
		</div><!-- /clearfix -->
			
		<br />
		
		
		
		<br />
		<button type="submit" class="btnfleche">
			Créer mon compte
		</button>
			
		<input type="hidden" name="fonction" value="traiternouveauclient">

		</form>
		
	</div>
	
	<div style="clear: both;"></div>
		
</div>
