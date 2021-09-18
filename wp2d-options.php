<h2>WP2D</h2>

<form action="options.php" method="post">

<?php
settings_fields(
    'wp2d_plugin_options'   // option group from register_settigns
);
do_settings_sections(
    'wp2d_plugin'       // page id
);
?>
    <input name="submit" class="button button-primary" type="submit" value=" <?php echo __('Save') ?> ">
</form>
<p>
<hr>
<h3> How to get Discord channel webhook URL</h3>
<h4> 1. This is your channed and you have the admin privelegies</h4>
<p>

