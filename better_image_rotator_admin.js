jQuery(document).ready( function($) {
	$( "#sortable" ).sortable({ items: "li:not(:last)" });
	$( "#sortable" ).disableSelection();

	$('#sortable li a.delete').live('click', function(e) { e.preventDefault(); 
		if( $(this).parents('ul').find('li:not(:last)').length == 1 ) {
			$(this).parent('li').find('input[type=text]').val('');
			$(this).parent('li').find('.preview').remove();
		} else {
			$(this).parent('li').remove(); 
		}
	});

	$('#sortable li a.add').live('click', function(e) { 
		e.preventDefault(); 
		var elem = $(this).parents('ul').find('li:first').clone();
		$('input[type=text]',elem).val('');
		$('.preview',elem).remove();
		$(elem).insertBefore( $(this).parents('li') );
	});
	$('input[type=checkbox].show_rotate').live('click',function() { 
		var $this = $(this);
		if( $this.is(':checked') ) $this.parents('form').find('.rotate_speed').show();
		else $this.parents('form').find('.rotate_speed').hide();
	});

});