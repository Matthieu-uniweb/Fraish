document.write('<script type="text/javascript" src="/includes/plugins/jquery-171/jquery.js"></script>'); 

var menuJour = {

	afficher:function(aAfficher){
		
		var statut = $('.contenu.jour'+aAfficher);
		var statut = statut[0].style.display;
		
		$('.contenu').each(function() {
            this.style.display='none';
        });
		
		if(statut == 'none'){
			$('.contenu.jour'+aAfficher).each(function() {
				this.style.display='table-row';
			});
		}
	},
	
	selectDefaultStuff:function(tabIDs, indexJour){
		if(tabIDs == '')
			alert('pas d\'ingrédients par défaut');
		
		tabIDs = tabIDs.split(',');
		for(var i = 0; i<tabIDs.length; i++){
			$('#ingredient'+indexJour+'-'+tabIDs[i]).attr('checked','checked');
		}
		
	}
}

