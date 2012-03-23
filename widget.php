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
	$i = 0;
	foreach( $instance['images'] as $o ):
		echo '<li>';
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