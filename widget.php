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