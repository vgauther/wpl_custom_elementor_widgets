<?php
/**
 * Plugin Name: WPL Custom Elementor Widgets
 * Description: Custom Elementor widget for displaying WPL property titles.
 * Version: 1.0
 * Author: Nivo-Web
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

// Load Elementor
function register_wpl_custom_elementor_widgets( $widgets_manager ) {

    require_once( __DIR__ . '/widgets/wpl-property-title-widget.php' );
    require_once( __DIR__ . '/widgets/wpl-location-widget.php' );

    $widgets_manager->register( new \Elementor_WPL_Property_Title_Widget() );
    $widgets_manager->register( new \Elementor_WPL_Location_Widget() );

}
add_action( 'elementor/widgets/register', 'register_wpl_custom_elementor_widgets' );