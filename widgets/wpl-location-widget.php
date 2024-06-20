<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Elementor_WPL_Location_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'wpl_location';
    }

    public function get_title() {
        return __( 'WPL Location', 'wpl_custom_elementor_widgets' );
    }

    public function get_icon() {
        return 'eicon-map-pin';
    }

    public function get_categories() {
        return [ 'general' ];
    }

    protected function _register_controls() {

        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Content', 'wpl_custom_elementor_widgets' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'location_field',
            [
                'label' => __( 'Location Field', 'wpl_custom_elementor_widgets' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'location1_name' => __( 'Location 1 Name', 'wpl_custom_elementor_widgets' ),
                    'location2_name' => __( 'Location 2 Name', 'wpl_custom_elementor_widgets' ),
                    'location3_name' => __( 'Location 3 Name', 'wpl_custom_elementor_widgets' ),
                    'location4_name' => __( 'Location 4 Name', 'wpl_custom_elementor_widgets' ),
                    'location5_name' => __( 'Location 5 Name', 'wpl_custom_elementor_widgets' ),
                    'location6_name' => __( 'Location 6 Name', 'wpl_custom_elementor_widgets' ),
                    'location7_name' => __( 'Location 7 Name', 'wpl_custom_elementor_widgets' ),
                ],
                'default' => 'location1_name',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'style_section',
            [
                'label' => __( 'Style', 'wpl_custom_elementor_widgets' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __( 'Title Color', 'wpl_custom_elementor_widgets' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpl-location-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'typography',
                'label' => __( 'Typography', 'wpl_custom_elementor_widgets' ),
                'selector' => '{{WRAPPER}} .wpl-location-title',
            ]
        );

        $this->add_responsive_control(
            'text_align',
            [
                'label' => __( 'Text Alignment', 'wpl_custom_elementor_widgets' ),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'wpl_custom_elementor_widgets' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'wpl_custom_elementor_widgets' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'wpl_custom_elementor_widgets' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                    'justify' => [
                        'title' => __( 'Justify', 'wpl_custom_elementor_widgets' ),
                        'icon' => 'eicon-text-align-justify',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wpl-location-title' => 'text-align: {{VALUE}};',
                ],
                'default' => 'left',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $property_id = $this->extract_property_id_from_url();
        $location_field = $settings['location_field'];

        if ( $property_id !== null ) {
            echo '<div class="wpl-location-title">' . esc_html( $this->get_wpl_location_field( $property_id, $location_field ) ) . '</div>';
        } else {
            echo '<div class="wpl-location-title">' . __( 'No ID found', 'wpl_custom_elementor_widgets' ) . '</div>';
        }
    }

    private function extract_property_id_from_url() {
        // Get the current URL
        $current_url = ( isset( $_SERVER['HTTPS'] ) ? "https" : "http" ) . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        
        // Use a regular expression to find the first number after "properties/"
        preg_match( '/properties\/(\d+)/', $current_url, $matches );
        if ( isset( $matches[1] ) ) {
            return intval( $matches[1] );
        }
        return null; // Return null if no number is found
    }

    private function get_wpl_location_field( $property_id, $field_name ) {
        global $wpdb;
        $location_field = $wpdb->get_var( $wpdb->prepare(
            "SELECT $field_name FROM wp_wpl_properties WHERE id = %d", 
            intval( $property_id )
        ));
        return $location_field ? $location_field : __( 'No location found', 'wpl_custom_elementor_widgets' );
    }
}
