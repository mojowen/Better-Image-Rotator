<?php
add_action('widgets_init', create_function('', 'return register_widget("better_image_rotator");'));

class better_image_rotator extends WP_Widget
{
  function better_image_rotator()
  {
    $widget_ops = array('description' => __('A widget for rotating images and stuff'));
    $this->WP_Widget('better_image_rotator', __('Better Image Rotator Widget'), $widget_ops);
  }

  function form($instance)
  {
	$default = array( 'images'=>array(), 'display' => 4, 'speed' => 5000, 'rotate' => true, 'page' => true );

	$instance = !isset($instance['images']) ? $default : $instance;
	if( count($instance['images']) < 1 ) {
		array_push($instance['images'], array( 'img'=>'','url'=>'') );
	}

	$rotate = isset($instance['rotate']) ? $instance['rotate'] : true;
	$speed = isset($instance['speed']) ? $instance['speed'] : 500;
	$display = isset($instance['display']) ? $instance['display'] : 4;
	$page = isset($instance['page']) ? $instance['page'] : true;
	?>
	<h3>Options</h3>
	<p><label for="<?php echo $this->get_field_id('rotate'); ?>"> <?php echo __('Images should rotate?') ?>
		 <input id="<?php echo $this->get_field_id('rotate'); ?>" name="<?php echo $this->get_field_name('rotate'); ?>" type="checkbox" <?php if( $rotate ) echo 'checked="checked"';?>>
	</label></p>
	<p><label for="<?php echo $this->get_field_id('speed'); ?>" <?php if( !$rotate ) echo 'style="display: none;" ' ?>> <?php echo __('Rotation speed') ?>
		<input id="<?php echo $this->get_field_id('speed'); ?>" name="<?php echo $this->get_field_name('speed'); ?>" type="text" value="<?php echo $speed;?>">
	</label></p>
	<label for="<?php echo $this->get_field_id('display'); ?>"> <?php echo __('How many images to display') ?>
		<input id="<?php echo $this->get_field_id('display'); ?>" name="<?php echo $this->get_field_name('display'); ?>" type="text" value="<?php echo $display;?>">
	</label></p>
	<p><label for="<?php echo $this->get_field_id('page'); ?>"> <?php echo __('Should you be able to click to scroll through the images?') ?>
		 <input id="<?php echo $this->get_field_id('page'); ?>" name="<?php echo $this->get_field_name('page'); ?>" type="checkbox" <?php if( $page ) echo 'checked="checked"';?>>
	</label></p>
	<?php
	echo '<h3>Images</h3><ul id="sortable">';
	$i = 1;
	foreach( $instance['images'] as $o ):
		echo '<li>';
		echo '<h2 style="display:inline;">&#8616;</h2> <input value="'.$o['img'].'" class="upload_image" type="text" name="my_theme_options[social_icons]['.$i.'][img]" value="" /><input class="upload_image_button" type="button" value="Upload Image" />';
		echo ' Link URL: <input type="text" class="small-text" name="my_theme_options[social_icons]['.$i.'][url]" value="'.$o['url'].'">';

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


    return $instance;
  }

  function widget($args, $instance)
  {
	extract($args);
	
	echo $before_widget; 
	// Before the widget ?>

	<?php // Output $after_widget
		echo $after_widget;
  }
}

?>