
<script language="javascript">
function annulerCommande()
	{
		
	if 	(document.forms['enCours'].ID_typ_paiement.value!=5)
	{
		alert("Annulation impossible, seules les commandes réglés avec votre compte fraish peuvent être annulées.");
		return 0;
	}
	else
	{
		var ok = confirm("Etes vous sur de vouloir annuler cette commande ?");
		if(ok==1)
			{
			//document.forms['enCours'].ID_commande.value = ID_commande;
			document.forms['enCours'].submit();
			}
		}
	}	
	
</script>


<div id="contents-white">

	
	
	
	<div style="float: left; width: 410px; padding: 0 30px 0 0; ">
	    
	    <span class="panier">Mon compte</span> 
	    
	    <table>
	        <tr>
	            <td class="lefttabcompte">Nom :</td>
	            <td class="righttabcompte">{nom}</td>
	        </tr>
	        <tr>
                <td class="lefttabcompte">Prénom :</td>
                <td class="righttabcompte">{prenom}</td>
            </tr>
            <tr>
                <td class="lefttabcompte">Adresse :</td>
                <td class="righttabcompte">{adresse}</td>
            </tr>
            <tr>
                <td class="lefttabcompte">Code postal :</td>
                <td class="righttabcompte">{cp}</td>
            </tr>
            <tr>
                <td class="lefttabcompte">Ville :</td>
                <td class="righttabcompte">{ville}</td>
            </tr>
            <tr>
                <td class="lefttabcompte">Téléphone :</td>
                <td class="righttabcompte">{tel}</td>
            </tr>
            <tr>
                <td class="lefttabcompte">E-mail :</td>
                <td class="righttabcompte">{mail}</td>
            </tr>
            <tr>
                <td></td>
                <td><a class="btVert" href="editercompte.html" style="margin-top: 10px;">Modifier mon compte</a></td>
            </tr>
	    </table>
	    
	    <hr class="hrcompte"/>
	    
	    
	     Pour toute annulation après 11h15, merci de nous téléphoner au 05.61.73.17.88.<br/><br/>
	   
	   
	    <span class="entete" style="margin-left: 20px;">Mes commandes en cours</span>	 <br/><br/>
	    
	   
	    	    
	    <table>
	    	<!-- BEGIN commandesencours -->    	
		        <tr>
		            <td class="lefttabcompte" width="100" style="vertical-align: top;">{commandesencours.date} :</td>
		            <td class="righttabcompte">{commandesencours.plat}
		            	
		            	<form name="enCours" id="enCours" enctype="multipart/form-data" method="post" onsubmit="return annulerCommande()" style="display:inline;">    		
				    		<input name="ID_client" type="hidden" value="{commandesencours.ID_client}" />
				    		<input name="ID_commande" type="hidden" value="{commandesencours.ID_commande}" />
				    		<input name="ID_typ_paiement" type="hidden" value="{commandesencours.ID_typ_paiement}" />
				    		<input type="hidden" name="fonction" value="compte">
				    		<input type="submit" name="submit" value="Annuler cette commande" class="boutonAbandonnee" style="margin-top: 5px;padding-left: 10px; padding-right: 10px;"/>
						</form> 
		            	
		            	</td>		           
		        </tr>		        
			<!-- END commandesencours --> 
	     </table>
	    <br/><br/>   
	   <span class="entete" style="margin-left: 20px;">Mes dernières commandes</span>	 <br/><br/>   
	    	    
	    <table>
	    	<!-- BEGIN commandes -->    	
		        <tr>
		            <td class="lefttabcompte" width="100" style="vertical-align: top;">{commandes.date} :</td>
		            <td class="righttabcompte">{commandes.plat}</td>		           
		        </tr>	      
			<!-- END commandes --> 
	     </table>
	     
	</div>
	<div style="float: left; width: 440px; padding: 0;">
	    Crédit &nbsp;&nbsp;<img src="styles/frontend/img/fraish_mini.png"/> <input class="credit" type="text" disabled value="{creditfraish}€" style="width: 70px; height: 20px; margin-left: 10px;"/>
	    <br /> 
	    <br /> FRAISH vous a réservé un espace personnel ou vous pouvez créditer votre compte et l'utiliser comme votre porte-monnaie !! 
	    <br /> Pour 25€ crédités, FRAISH vous offre 2€, pour 50€ crédités, FRAISH vous offre 5€ et pour 100€ ou plus, FRAISH vous offre 12€ !	    
	    <br /> Choisissez votre mode de rechargement, complétez le formulaire et validez.
	    <br /> Rendez-vous dans votre point de vente avec votre règlement, votre premier menu vous attend.
	    <br /> 24 heures après, votre compte sera crédité et accessible sur votre profil FRAISH.
	    <br /> Pour les commandes suivantes, cliquez sur "je paie avec mon crédit FRAISH".
	 <br />  <br /> 
	<span class="entete">Réaprovisionner mon compte</span> <a href="detailscompte.html">(historique)</a>
	<br /> <br /> 
	
	

	<table>	 
        <tr>            
            <td><b>Par chèque</b></td>
            <td></td>
        </tr>
        
        <form name="formulaire" method="post"  enctype="multipart/form-data">
        
        <tr>            
            <td style="text-align: right; width: 120px;">Numéro* :</td>
            <td><input name="numero" class="credit" type="text" value="" style="width: 150px; height: 20px; margin-left: 10px;"/></td>
        </tr>
        
        <tr>            
            <td style="text-align: right;">Somme* :</td>
            <td><input name="somme" class="credit" type="text" value="" style="width: 150px; height: 20px; margin-left: 10px;"/> €</td>
        </tr>
        
        <tr>            
            <td style="text-align: right;"></td>
            <td><button type="submit" class="btnflecherose txtnoir" style="float: right; margin-right: 130px;">Valider</button></td>
        </tr>
        
        <input type="hidden" name="fonction" value="reapprocheque">
        
       </form>
        
        <tr>            
            <td></td>
            <td></td>
        </tr>    
    
        <tr>            
            <td><b>Par titre restaurant</b></td>
            <td></td>
        </tr>
        <form name="formulaire" method="post"  enctype="multipart/form-data">
        <tr>            
            <td style="text-align: right;">Nombre* :</td>
            <td><input name="nombre" class="credit" type="text" value="" style="width: 150px; height: 20px; margin-left: 10px;"/></td>
        </tr>
        
        <tr>            
            <td style="text-align: right;">Somme à l'unité* :</td>
            <td><input name="somme" class="credit" type="text" value="" style="width: 150px; height: 20px; margin-left: 10px;"/> €</td>
        </tr>
        <tr>            
            <td style="text-align: right;"></td>
            <td><button type="submit" class="btnflecherose txtnoir" style="float: right; margin-right: 130px;">Valider</button></td>
        </tr>
        <input type="hidden" name="fonction" value="reapproticketresto">
        
       </form>

         <tr>            
            <td><b>Par Carte bleue </b> (validation immédiate)</td>
            <td></td>
        </tr>
        <form name="formulaire" method="post"  enctype="multipart/form-data">
        
        <tr>            
            <td style="text-align: right;">Somme* :</td>
            <td><input name="somme" class="credit" type="text" value="" style="width: 150px; height: 20px; margin-left: 10px;"/> €</td>
        </tr>
        
        
        <tr>            
            <td></td>
            <td style="text-align: right; padding-right: 135px;">
            	<img src="styles/frontend/img/cb.png" style="margin-bottom: 7px;"/>
            	
            	<button type="submit" class="btnflecherose txtnoir" style="float: right;">Valider</button></td>
        </tr>
        <input type="hidden" name="fonction" value="reapprocb">
        
       </form>

    </table>
	
	
	</div>
	
	
		<div style="clear: both"></div>	
		
	
</div>