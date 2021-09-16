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

function wp2d_add_options_page() {
	// function to render the options page
	add_options_page(pn(), pn(), 'manage_options', 'wp2d/wp2d-options.php');
}
add_action('admin_menu', 'wp2d_add_options_page');


function wp2d_register_settings() {
	// function to register plugin options
    register_setting(mb_strtolower(pn()).'_plugin_options', mb_strtolower(pn()).'_plugin_options');
    
	// webhook section
    add_settings_section('discord_api', 'Discord API Settings', 'wp2d_section_text', mb_strtolower(pn()).'_plugin');

    add_settings_field(
		mb_strtolower(pn()).'_webhook_url',
		'Discord Webhook URL',
		mb_strtolower(pn()).'_webhook_url',
		mb_strtolower(pn()).'_plugin',
		'discord_api'
	);
}

function wp2d_section_text() {
	echo '<p>Here you can set all the options for using the API</p>';
}
function wp2d_webhook_url() {
    $options = get_option(mb_strtolower(pn()).'_plugin_options');
    echo '<input id="' . mb_strtolower(pn()).'_webhook_url" name="'.mb_strtolower(pn()).'_plugin_options[webhook_url]" type="text"
		value="' . esc_attr($options['webhook_url']) . '" />';
}

add_action('admin_init', 'wp2d_register_settings');



?>
