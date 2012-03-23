
jQuery(document).ready(function($) { 

	// The options and basics
	var $this = $('.better_image_rotator'),
		data = JSON.parse($this.attr('data'))
		$images = $('.better_rotator_item', $this).clone().hide(),
		size = $images.length-1,
		position = 0,
		show = data.display,
		interval = data.speed,
		rotate = data.rotate == 'on',
		page = data.page == 'on';

	// Setting up the environment
	$this.html('<div class="inside"></div>');
	var $inside = $('.inside',$this);
	if( page ) {
		$inside.after('<div class="after controls"></div>');
		$inside.before('<div class="before controls"></div>');
	}
	//Appending the first images we're going to show
	for (var i=position; i < show+position; i++) {
		$inside.append($images[i]).find('img').show();
	};

	//The bindings
	$('.controls').click(function(){
		if( $(this).hasClass('after') ) {
			slide(-1);
		} else {
			slide(+1);
		}
	});
	if( typeof interval != 'undefined' && interval > 0 && rotate ) {
		setInterval(function() { slide(-1) }, interval);
	}
	function slide(dir) {
		$('img:hidden').remove();
		if( dir > 0 ) {
			position = position + size + 1 > size ? -size : position + 1;
			$('img:first',$this).fadeOut('fast',function(){
				$(this).remove();
				$inside.append($images[position+size]).find('img').fadeIn();
			});
		} else {
			position = position - 1 < 0 ? size : position - 1;
			$('img:last',$this).fadeOut('fast',function(){
				$(this).remove(); 
				$inside.prepend($images[position]).find('img').fadeIn();
			});
			
		}
	}

});
