<h2>WP2D</h2>

<form action="options.php" method="post">

<?php
settings_fields('wp2d_plugin_options');
do_settings_sections('wp2d_plugin');
?>

<input name="submit" class="button button-primary" type="submit" value=" <?php echo __('Save') ?> ">

</form>
