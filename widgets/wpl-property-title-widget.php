<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Elementor_WPL_Property_Title_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'wpl_property_title';
    }

    public function get_title() {
        return __( 'WPL Property Title', 'wpl_custom_elementor_widgets' );
    }

    public function get_icon() {
        return 'eicon-post-title';
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
                    '{{WRAPPER}} .wpl-property-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'typography',
                'label' => __( 'Typography', 'wpl_custom_elementor_widgets' ),
                'selector' => '{{WRAPPER}} .wpl-property-title',
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
                    '{{WRAPPER}} .wpl-property-title' => 'text-align: {{VALUE}};',
                ],
                'default' => 'left',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $property_id = $this->extract_property_id_from_url();
        
        if ( $property_id !== null ) {
            echo '<div class="wpl-property-title">' . esc_html( $this->get_wpl_property_title( $property_id ) ) . '</div>';
        } else {
            echo '<div class="wpl-property-title">' . __( 'No ID found', 'wpl_custom_elementor_widgets' ) . '</div>';
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

    private function get_wpl_property_title( $property_id ) {
        global $wpdb;
        $property_title = $wpdb->get_var( $wpdb->prepare(
            "SELECT field_312 FROM wp_wpl_properties WHERE id = %d", 
            intval( $property_id )
        ));
        return $property_title ? $property_title : __( 'No title found', 'wpl_custom_elementor_widgets' );
    }
}
