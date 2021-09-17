<?php
/*
Plugin Name:	WP2D
Plugin URI:		https://progr.interplanety.org/en/wordpress-plugin-wp2d/
Version:		1.0.0
Author:			Nikita Akimov
Author URI:		https://progr.interplanety.org/en/
License:		GPL-3.0-or-later
Description:	Autopost publishing posts to the Discord server
*/

//	not run directly
if(!defined('ABSPATH')) {
	exit;
}

$plugin_prefix = 'wp2d_';

function pn() {
	// get plugin name
	$plugin_data = get_plugin_data(__FILE__);
	return $plugin_data['Name'];
}
function pnl() {
	// plugin name lowercase
	return mb_strtolower(pn());
}


// ---------- settings menu

function wp2d_add_options_page() {
	// function to render the options page
	add_options_page(
		pn(),						// page title text
		pn(),						// menu item text
		'manage_options',			// user rights
		'wp2d/wp2d-options.php'		// file to render the options view page
	);
}

add_action('admin_menu', 'wp2d_add_options_page');


// ---------- page

function wp2d_register_settings() {
	// function to register plugin options
    // whole wp2d settings
	register_setting(
		pnl().'_plugin_options',	// option group
		pnl().'_plugin_options'		// option name
	);
	// discord api section in settings
    add_settings_section(
		'discord_api',				// id
		'Discord API Settings',		// title
		pnl().'_section_text',		// function name for render section title
		pnl().'_plugin'				// page id for do_settings_section
	);
	// options fields
	// webhook
    add_settings_field(
		pnl().'_webhook_url',		// id
		'Webhook URL',				// field title
		pnl().'_webhook_url',		// function name for rendering this option
		pnl().'_plugin',			// menu page id
		'discord_api'				// section id
	);
}
// function for render section title
function wp2d_section_text() {
	echo 'Discord webhook settings:';
}
// functions for current option render
function wp2d_webhook_url() {
    $options = get_option(pnl().'_plugin_options');
    echo '<input id="' . pnl().'_webhook_url" name="'.pnl().'_plugin_options['.pnl().'_webhook_url]" type="text"
		value="' . esc_attr($options[pnl().'_webhook_url']) . '">';
}

add_action('admin_init', 'wp2d_register_settings');


// ---------- "settings" link for plugin on plugins page

function wp2d_settings_link($links) {
    return array_merge(
		array(
			'settings' => '<a href="options-general.php?page=wp2d/wp2d-options.php">' . __('Settings') . '</a>'
		),
		$links
	);
}

add_filter('plugin_action_links_' . plugin_basename( __FILE__ ), 'wp2d_settings_link');


// ---------- adding metabox with option to posts

function wp2d_meta_box() {
    // $wp2d_options = get_option(pnl().'_plugin_options');
    add_meta_box(
		pnl().'_metabox',	// id
		pn(),				// title
		pnl().'_metabox',	// function name for rendering this metabox
		$types,
		'normal',
		'high'
	);
}

// functions for current metabox render
function wp2d_metabox($post) {
	// security hidden field
	wp_nonce_field(plugin_basename(__FILE__), pnl().'_meta_nonce');
	// wp2d_do_autopost checkbox
	$do_autopost = get_post_meta(
						$post->ID,
						pnl().'_do_autopost',
						true
					);
	?>
	
	<label for=" <?php echo pnl().'_do_autopost'; ?> ">
		<input type="checkbox" name=" <?php echo pnl().'_do_autopost'; ?> " id=" <?php echo pnl().'_do_autopost'; ?> "
			<?php ($do_autopost == 'yes' ? echo 'checked="checked"' : ''); ?>
			>
			<?php _e('Hide &#8220;Yandex.Share&#8221; icons', 'easy-yandex-share'); ?>
	</label>

	<?php
}
add_action('add_meta_boxes', 'wp2d_meta_box');



?>
