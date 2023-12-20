<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://myappuccino.com/
 * @since      1.0.0
 *
 * @package    Appuccino
 * @subpackage Appuccino/admin/partials
 */

 $templates = glob(APPUCCINO_PLUGIN_BASE_PATH . '/view/templates/*.php');
 $appuccino_metab_key = 'appuccino_meta_box_body_template_value';

 $selected = isset( $values[$appuccino_metab_key] ) ? $values[$appuccino_metab_key] : '';

?>
<select name="<?php echo $appuccino_metab_key; ?>">
  <?php 
  	foreach($templates as $template_uri) { 
  		$template_path = 'templates/' . str_replace('.php', '.html', basename($template_uri));
  		$is_selected = is_array($selected) ? ($selected[0] == $template_path ? true : false) : false; 
  	?>
  <option 
  	<?php echo $is_selected ? 'selected' : '' ?> 
  	value="<?php echo $template_path; ?>">
  		<?php echo basename($template_uri); ?>	
	</option>
  <?php } ?>
</select>

<p>Templates are used to render the content of this page, you can manage custom templates in the <code><?php echo APPUCCINO_TEMPLATE_RESOURCE_DIR; ?></code> folder of this plugin.</p>
