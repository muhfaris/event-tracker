<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://github.com/muhfaris
 * @since      1.0.0
 *
 * @package    Facebook_Pixel
 * @subpackage Facebook_Pixel/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">
    <?php
        $this->options = get_option( 'pixel-options' );
        settings_errors();
    ?>
    <h2><?php echo esc_html(get_admin_page_title()); ?></h2>
    <form method="post" name="fbpixel_options" action="options.php">
        <!-- load jQuery from CDN -->
        <?php settings_fields('pixel-group')?>
        <?php do_settings_sections('pixel-setting')?>
        <?php submit_button(); ?>

    </form>

</div>
