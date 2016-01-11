<?php
/**
 * The static front page template file.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Amalgamation
 */

if ( 'posts' == get_option( 'show_on_front' ) ) {
    include( get_home_template() ); 
} else {
get_header( 'front' ); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main front-page-panel-wrapper" role="main">

            <!-- functions below are defined in /inc/customizer.php -->
            <div class="front-page-pair">
                <div id="front-page-panel-1" class="front-page-panel">
                    <?php if (get_theme_mod('fp_panel_1') == 'post') {
                        Amalgamation_Front_Panel_Post( intval( get_theme_mod( 'panel_1_post' ) ) );
                    } elseif (get_theme_mod('fp_panel_1') == 'page') {
                        Amalgamation_Front_Panel_Page( intval( get_theme_mod( 'panel_1_page' ) ) );
                    } else { 
                        Amalgamation_Front_Panel_Latest();
                    } ?>
                </div>

                <div id="front-page-panel-2" class="front-page-panel">
                    <?php if (get_theme_mod('fp_panel_2') == 'post') {
                        Amalgamation_Front_Panel_Post( intval( get_theme_mod( 'panel_2_post' ) ) );
                    } elseif (get_theme_mod('fp_panel_2') == 'page') {
                        Amalgamation_Front_Panel_Page( intval( get_theme_mod( 'panel_2_page' ) ) );
                    } else { 
                        Amalgamation_Front_Panel_Latest();
                    } ?>
                </div>
            </div>
            
            <div class="front-page-pair">
                <div id="front-page-panel-3" class="front-page-panel">
                    <?php if (get_theme_mod('fp_panel_3') == 'post') {
                        Amalgamation_Front_Panel_Post( intval( get_theme_mod( 'panel_3_post' ) ) );
                    } elseif (get_theme_mod('fp_panel_3') == 'page') {
                        Amalgamation_Front_Panel_Page( intval( get_theme_mod( 'panel_3_page' ) ) );
                    } else { 
                        Amalgamation_Front_Panel_Latest();
                    } ?>
                </div>

                <div id="front-page-panel-4" class="front-page-panel">
                    <?php if (get_theme_mod('fp_panel_4') == 'post') {
                        Amalgamation_Front_Panel_Post( intval( get_theme_mod( 'panel_4_post' ) ) );
                    } elseif (get_theme_mod('fp_panel_4') == 'page') {
                        Amalgamation_Front_Panel_Page( intval( get_theme_mod( 'panel_4_page' ) ) );
                    } else { 
                        Amalgamation_Front_Panel_Latest();
                    } ?>
                </div>
            </div>
            
		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer( 'front' ); } // end else statement ?>
