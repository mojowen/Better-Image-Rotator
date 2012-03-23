
jQuery(document).ready(function($) { 

	// The options and basics
	var $this = $('.better_image_rotator'),
		data = JSON.parse($this.attr('data'))
		$images = $('.better_rotator_item', $this).clone().hide(),
		size = $images.length-1,
		position = 0,
		show = parseInt(data.display),
		interval = data.speed,
		rotate = data.rotate;
		page = data.page,
		ready = true;

	// Setting up the environment
	$this.html('<div class="inside"></div>');
	var $inside = $('.inside',$this);
	if( page ) {
		$inside.after('<div class="after controls"></div>');
		$inside.before('<div class="before controls"></div>');
	}
	//Appending the first images we're going to show
	for (var i=position; i < show+position; i++) {
		$inside.append($images[i]).find('.better_rotator_item').fadeIn();
	};

	//The bindings
	$('.controls').live('click',function(e){
		if( $(this).hasClass('after') ) {
			slide(-1);
		} else {
			slide(1);
		}
	});
	if( typeof interval != 'undefined' && interval > 0 && rotate ) setInterval(function() { slide(-1) }, interval);

	function slide(dir) {
		if( ready ) {
			ready = false;
			if( dir > 0 ) {
				position = position + show + 1 > size ? -show : position + 1;
				$('.better_rotator_item:first',$this).fadeOut('fast',function(){
					$('.better_rotator_item:hidden').remove();
					$inside.append($images[position+show]).find('.better_rotator_item').fadeIn(function() { ready = true; });
				});
			} else {
				position = position - 1 < 0 ? size : position - 1;
				$('.better_rotator_item:last',$this).fadeOut('fast',function(){
					$('.better_rotator_item:hidden').remove();
					$inside.prepend($images[position]).find('.better_rotator_item').fadeIn(function() { ready = true; });
				});
			}
		}
	}

});
