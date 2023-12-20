<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://github.com/jakerb/Appuccino-for-WordPress
 * @since      1.0.0
 *
 * @package    Appuccino
 * @subpackage Appuccino/admin/partials
 */

	$admin = new Appuccino_Admin('appuccino', '1.0.0');

	$api_url = rtrim(home_url(), '/');
	$manifest_file = @json_decode(file_get_contents(implode('', array($api_url,'/wp-json/appuccino/v1/manifest.json'))));


	$admin->enqueue_styles();
	$admin->enqueue_scripts();

	$api_endpoint = implode('', array($api_url, '/wp-json/appuccino/v1/'));
	$api_endpoint_parsed = parse_url($api_endpoint);
	$is_localhost = $api_endpoint_parsed['host'] == 'localhost' || $api_endpoint_parsed['host'] == '127.0.0.1';

?>

<div class="wrap">
	<h1 class="wp-heading-inline">Appuccino for Wordpress</h1>
	<?php if(!is_array($manifest_file)) { ?>
	<p><strong>Oh no!</strong> I cannot load the manifest file this could be because you need to re-save your permalinks settings or because your site has been configured incorrectly. In order for your app to work, the manifest file is required.</p>
	<?php } ?>
	<?php if($is_localhost) { ?>
	<p><strong>Internet Access</strong> Ensure that this Wordpress site is accessible over the internet, a localhost version will not be able to communicate with Appuccino</p>
	<?php } ?>
	<div class="card">
		<h2 class="title">Project URL</h2>
		<p>Copy the following URL and paste it into the <em>Project URL</em> field when creating an app in the Appuccino dashboard.</p>
		<input value="<?php echo $api_endpoint; ?>" type="text" readonly class="regular-text ltr" style="width:100%">
		<p class="description"><small>If you have just installed Appuccino for Wordpress please save your permalinks before continuing.</small></p>
	</div>
	<div class="card">
		<h2 class="title">Project Manifest</h2>
		<p>Your project manifest contains all of the files that are included within your app.</p>
		<table class="wp-list-table widefat fixed striped">
		    <thead>
		        <tr>
		            <th>Filename</th>
		            <th>Checksum</th>
		        </tr>
		    </thead>
		    <tbody>
		    	<?php foreach($manifest_file as $item) { ?>
		        <tr>
		            <td>
		            	<a target="_blank" href="<?php echo $api_url; ?>/wp-json/appuccino/v1/file.json?file=<?php echo $item->file; ?>"><?php echo $item->file; ?></a>
		            </td>
		            <td><?php echo $item->md5; ?></td>
		        </tr>
		        <?php } ?>
		    </tbody>
		</table>
	</div>
</div>