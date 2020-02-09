
var option = {

	modifier:function(id){
		$('.blocModifOption').each(function(index, element) {
            element.style.display='none';
		});
		$('#blocModifOption-'+id).css('display','table-row');
	}
	
}