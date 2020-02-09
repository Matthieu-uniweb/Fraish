
<style>
	form label {
		color: #59595A;
	}

</style>


<div id="contents-white">

	<div style="float: left; width: 600px; padding: 0 30px 0 0; ">


		 <h1 class="blur" style="font-size: 20px;">Historique des approvisionnements</h1>	
		 
		 
		 {message}
		
<br/><br/>
		
		<b>Total des approvisionnements :</b> {sommeappro}&euro;<br /><br />
		<ul>
		<!-- BEGIN appros -->
		
			<li>Approvisionnement de {appros.montant} &euro; par {appros.label} le {appros.date} </li>
						
		<!-- END appros -->
		</ul>
		
		

	</div>
	<div style="clear: both"></div>
</div>