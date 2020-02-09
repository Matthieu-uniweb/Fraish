document.write('<script type="text/javascript" src="/includes/plugins/jquery-171/jquery.js"></script>'); 

var ingredient = {

	modifier:function(id){
		$('.blocModif').each(function(index, element) {
            element.style.display='none';
		});
		$('#blocModif-'+id).css('display','table-row');
	},
	
	annuler:function(id){
		$('#blocModif-'+id).css('display','none');
	},
	
	confirmerSupression:function(Asupprimer){
		
		var reponse = confirm('Voulez-vous supprimer cet ingredient ?');
		
		if (reponse){
			document.forms['supression-'+Asupprimer].submit();
		}
		
	}
}