<?php
namespace Sintecelementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Background;



// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 *
 * Sintec elementor Team Member section widget.
 *
 * @since 1.0
 */
class Sintec_Features extends Widget_Base {

	public function get_name() {
		return 'sintec-features';
	}

	public function get_title() {
		return __( 'Features', 'sintec' );
	}

	public function get_icon() {
		return 'eicon-info-box';
	}

	public function get_categories() {
		return [ 'sintec-elements' ];
	}

	protected function _register_controls() {

		$repeater = new \Elementor\Repeater();
        
		// ----------------------------------------   Features content ------------------------------
		$this->start_controls_section(
			'features_block',
			[
				'label' => __( 'Features', 'sintec' ),
			]
		);
		$this->add_control(
            'features_content', [
                'label' => __( 'Create Features', 'sintec' ),
                'type'  => Controls_Manager::REPEATER,
                'title_field' => '{{{ label }}}',
                'fields' => [
                    [
                        'name'  => 'label',
                        'label' => __( 'Title', 'sintec' ),
                        'type'  => Controls_Manager::TEXT,
                        'label_block' => true,
                        'default' => __('Money back gurantee', 'sintec')
                    ],
	                [
		                'name'  => 'desc',
		                'label' => __( 'Description', 'sintec' ),
                        'type'  => Controls_Manager::TEXTAREA,
                        'default' => __('Shall open divide a one', 'sintec')
	                ],
                    [
		                'name'  => 'icon',
		                'label' => __( 'Icon', 'sintec' ),
		                'type'  => Controls_Manager::ICON,

	                ],
                    [
		                'name'  => 'title_url',
		                'label' => __( 'Title link', 'sintec' ),
		                'type'  => Controls_Manager::URL,
	                ],
                ],
            ]
		);

		$this->end_controls_section(); // End features content


        //------------------------------ Style Features ------------------------------
        $this->start_controls_section(
            'style_features', [
                'label' => __( 'Style Features', 'sintec' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'features_title_heading',
            [
                'label'     => __( 'Style Feature Title ', 'sintec' ),
                'type'      => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'color_featuretitle', [
                'label' => __( 'Title Color', 'sintec' ),
                'type'  => Controls_Manager::COLOR,
                'default' => '#2a2a2a',
                'selectors' => [
                    '{{WRAPPER}} .single-feature h3' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'feature_hover_title', [
                'label' => __( 'Title Hover Color', 'sintec' ),
                'type'  => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .single-feature .title:hover h3' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_hover_bg', [
                'label' => __( 'Feature Hover Border Color', 'sintec' ),
                'type'  => Controls_Manager::COLOR,
                'default' => '#eff2f3',
                'selectors' => [
                    '{{WRAPPER}} .single-feature:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
        

	}

	protected function render() {

    $settings = $this->get_settings();
    $features = $settings['features_content'];

    ?>
    <section class="feature-area section_gap_bottom_custom">
        <div class="container">
            <div class="row">
                <?php
                if( is_array( $features ) && count( $features ) > 0 ) {
	                foreach ( $features as $feature ) {
		                ?>
                        <div class="col-lg-3 col-md-6">
                            <div class="single-feature">

                                <?php

                                if( !empty( $feature['title_url']['url'] ) ) {
                                    echo '<a href="'. esc_url( $feature['title_url']['url'] ) .'" class="title">';

                                    if ( $feature['icon'] ) {
                                        echo '<i class="' . esc_attr( $feature['icon'] ) . '"></i>';
                                    }

                                    if ( ! empty( $feature['label'] ) ) {
                                        echo '<h3>' . esc_html( $feature['label'] ) . '</h3>';
                                    }
                                    echo '</a>';
                                }else{
                                    if ( $feature['icon'] ) {
                                        echo '<i class="' . esc_attr( $feature['icon'] ) . '"></i>';
                                    }

                                    if ( ! empty( $feature['label'] ) ) {
                                        echo '<h3>' . esc_html( $feature['label'] ) . '</h3>';
                                    }
                                }

                                // Description
                                if( !empty( $feature['desc'] ) ){
                                    echo '<p>'. esc_html( $feature['desc'] ) .'</p>';
                                }

                                ?>
                            </div>
                        </div>
		                <?php
	                }
                } ?>
            </div>
        </div>
    </section>
    <?php

    }
}
