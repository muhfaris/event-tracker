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

<?php
    // check user capabilities
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    function page_tabs( $current = 'first' ) {
        $tabs = array(
            'dashboard'   => __( 'Dashboard', 'dashboard' ),
            'settings'  => __( 'Setting', 'settings' ),
            'pixel-events'  => __( 'Pixel Events', 'pixel-events' )
        );

        echo '<h2>'. esc_html(get_admin_page_title()) . '</h2>';
        $html = '<h2 class="nav-tab-wrapper">';
        foreach( $tabs as $tab => $name ){
            $class = ( $tab == $current ) ? 'nav-tab-active' : '';
            $html .= '<a class="nav-tab ' . $class . '" href="?page=events-tracker-setting&tab=' . $tab . '">' . $name . '</a>';
        }
        $html .= '</h2>';
        echo $html;
    }
?>

<div class="wrap">
<?php
    // Code displayed before the tabs (outside)
    // Tabs
    $tab = ( ! empty( $_GET['tab'] ) ) ? esc_attr( $_GET['tab'] ) : 'dashboard';
    page_tabs( $tab );

    $this->options = get_option( 'mfa-pixel-options' );
?>
    <div class="tab-content">
        <?php switch($tab) :
          case 'settings':
        ?>
            <form method="post" name="fbpixel_options" action="options.php">
               <!-- load jQuery from CDN -->
               <?php settings_fields('pixel-group')?>
               <?php do_settings_sections('events-tracker-setting')?>
               <?php submit_button(); ?>
            </form>

        <?php
            break;
          case 'pixel-events':
            echo 'Tools';
            break;
          default:
            $html = '<blockquote style="font-size: 20px;line-height: initial;">';
            $html .= 'Do not hestitate to contact Me, if You want to contribute to this plugin, with suggestion / report issue etc.';
            $html .= 'We using github for development, You can find at <a href="https://github.com/muhfaris/events-tracker"> Events Tracker</a>.</blockquote>';
            $html .= '</hr>';
            $html .= '<h2>Donation</h2>';
            $html .= '<button style="padding:5px;margin:3px"><a href="https://paypal.me/farisafif">Paypal</a></button>';
            $html .= '<button style="padding:5px;margin:3px"><a href="https://saweria.co/donate/muhfaris">Sawerin (Indonesian)</a></button> ';
            $html .= '';
            echo $html;
            break;
            endswitch;
        ?>
    </div>


</div>
