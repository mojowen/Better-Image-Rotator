<?php
add_action('widgets_init', 'init_better_widget_admin');
function init_better_widget_admin() {
	register_widget("better_image_rotator");
}

class better_image_rotator extends WP_Widget
{
  function better_image_rotator()
  {
    $widget_ops = array('description' => __('A widget for rotating images and stuff'));
    $this->WP_Widget('better_image_rotator', __('Better Image Rotator Widget'), $widget_ops);
  }

  function form($instance)
  {
	wp_enqueue_script( "better_img_rotator_admin",better_img_rotator_base.'better_image_rotator_admin.js',array("jquery"),1,true );

	$instance['images'] = !isset($instance['images']) ? array('') : $instance['images'];
	$instance['urls'] = !isset($instance['urls']) ? array('') : $instance['urls'];

	$instance['images'] = is_array($instance['images']) ? $instance['images'] : array('');
	$instance['urls'] = is_array($instance['urls']) ? $instance['urls'] : array('');
	$urls = isset($instance['urls']) ? $instance['urls'] : array();
	$rotate = isset($instance['rotate']) ? $instance['rotate'] : true;
	$speed = isset($instance['speed']) ? $instance['speed'] : 5000;
	$display = isset($instance['display']) ? $instance['display'] : 4;
	$height = isset($instance['height']) ? $instance['height'] : 80;
	$page = isset($instance['page']) ? $instance['page'] : true;

	?>
	<h3>Options</h3>
	<p><label for="<?php echo $this->get_field_id('rotate'); ?>"> <?php echo __('Images should rotate?') ?>
		 <input id="<?php echo $this->get_field_id('rotate'); ?>" name="<?php echo $this->get_field_name('rotate'); ?>" class="show_rotate" type="checkbox" <?php if( $rotate ) echo 'checked="checked"';?>>
	</label></p>
	<p><label class="rotate_speed" for="<?php echo $this->get_field_id('speed'); ?>" <?php if( !$rotate ) echo 'style="display: none;" ' ?>> <?php echo __('Rotation speed') ?>
		<input id="<?php echo $this->get_field_id('speed'); ?>" name="<?php echo $this->get_field_name('speed'); ?>" type="text" value="<?php echo $speed;?>">
	</label></p>
	<label for="<?php echo $this->get_field_id('display'); ?>"> <?php echo __('How many images to display') ?>
		<input id="<?php echo $this->get_field_id('display'); ?>" name="<?php echo $this->get_field_name('display'); ?>" type="text" value="<?php echo $display;?>">
	</label></p>
	<p><label for="<?php echo $this->get_field_id('page'); ?>"> <?php echo __('Should you be able to click to scroll through the images?') ?>
		 <input id="<?php echo $this->get_field_id('page'); ?>" name="<?php echo $this->get_field_name('page'); ?>" type="checkbox" <?php if( $page ) echo 'checked="checked"';?>>
	</label></p>
	<p><label for="<?php echo $this->get_field_id('height'); ?>"> <?php echo __('Height of the Images in the Slider') ?>
		 <input id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" type="text" value="<?php echo $height;?>">
	</label></p>
	<?php
	echo '<h3>Images</h3><ul id="sortable">';
	$i = 0;
	foreach( $instance['images'] as $o ):
		echo '<li>';
		$url = isset($urls[$i]) ? $urls[$i] : '';
		echo '<input value="'.$o.'" class="upload_image" id="'.$this->get_field_id('images').'[]" type="text" name="'.$this->get_field_name('images').'[]" value="'.$o.'" /><br />';
		echo ' Link URL: <input type="text" class="small-text" id="'.$this->get_field_id('urls').'[]" name="'.$this->get_field_name('urls').'[]" value="'.$url.'">';

		echo ' <a href="#" class="delete">x</a>';

		echo '</li>';
		$i++;
	endforeach;


	echo '<li><a href="#" class="add">Add New</a></li>';
	echo '</ul>';

  }

  function update($new_instance, $old_instance)
  {
	$instance = $old_instance;
	$instance['rotate'] = (bool)strip_tags($new_instance['rotate']);
	$instance['speed'] = strip_tags($new_instance['speed']);
	$instance['height'] = strip_tags($new_instance['height']);
	$instance['display'] = strip_tags($new_instance['display']);
	$instance['page'] = strip_tags($new_instance['page']);

	$instance['images'] = $new_instance['images'];
	$instance['urls'] = $new_instance['urls'];
	

    return $instance;
  }

  function widget($args, $instance)
  {
	wp_enqueue_script( 'BetterImageRotator', better_img_rotator_base.'better_image_rotator.js',array( 'jquery' ), '1.0', true );
	extract($args);
	$height = isset($instance['height']) ? esc_attr($instance['height']) : 80;
	$vars = array(
		'speed' => esc_attr($instance['speed']),
		'page' => esc_attr($instance['page']),
		'display' => esc_attr($instance['display']),
		'rotate' => esc_attr($instance['rotate'])
	);
	echo $before_widget; 
	// Before the widget ?>
		<style type="text/css">div.better_image_rotator {  height: <?php echo $height;?>px; float: none; clear: both; display: block; margin: 10px 0; }div.better_image_rotator a:hover img { border: 0; opacity: .5; }div.better_image_rotator a img { border: 0; cursor: pointer; }div.better_image_rotator .better_rotator_item {display: none;} div.better_image_rotator .inside { width: 90%; height: <?php echo $height;?>px; } div.better_image_rotator img.better_rotator_img { max-height: <?php echo $height;?>px; margin: 0 2%; }div.better_image_rotator .controls:hover { opacity: 1; }div.better_image_rotator .controls { width: 4%; max-width: 10px; margin-left: -4%; height: 80px; border: 2px solid #999; cursor: pointer; opacity: 0.3;}div.better_image_rotator div { float: left; clear: none; overflow: hidden; }div.better_image_rotator .after { margin: 0 -4% 0 0;}</style>
		<div class="better_image_rotator" data='<?php echo json_encode($vars);?>'>
			<?php 
				$i=0; 
				foreach( $instance['images'] as $img): 
					$linked = 'better_rotator_item';
			?>
					<?php if( isset($instance['urls'][$i]) && !empty($instance['urls'][$i]) ): ?>
						<a href="<?php echo esc_attr($instance['urls'][$i]);?>" target="_blank" class="better_rotator_item better_rotator_link">
						<?php $linked = ''; ?>
					<?php endif;?>

					<img src="<?php echo esc_attr($img); ?>" class="better_rotator_img <?php echo $linked; ?>"> 

					<?php if( isset($instance['urls'][$i]) && !empty($instance['urls'][$i]) ): ?>
						</a>
					<?php endif; ?>
			<?php 
				$i++;
				endforeach; 
			?>
		</div>
	<?php // Output $after_widget
	echo $after_widget;
  }
}

?>