<?php
/**
 * The static front page template file.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Amalgamation
 */

get_header( 'front' ); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main front-page-panel-wrapper" role="main">

            <div class="front-page-pair">
            <div id="front-page-panel-1" class="front-page-panel">
            <?php 
                $my_query = new WP_Query( array ( 'pagename' => 'about',) );
                while ( $my_query->have_posts() ) : $my_query->the_post();
                    get_template_part( 'template-parts/content', 'front' );
                endwhile; 
            ?>
            </div>
            
            <div id="front-page-panel-2" class="front-page-panel">
            <?php 
                $my_query = new WP_Query( array ( 'pagename' => 'about',) );
                while ( $my_query->have_posts() ) : $my_query->the_post();
                    get_template_part( 'template-parts/content', 'front' );
                endwhile; 
            ?>            
            </div>
                </div>
            
            <div class="front-page-pair">
            <div id="front-page-panel-3" class="front-page-panel">
            <?php 
                $my_query = new WP_Query( array ( 'pagename' => 'tech',) );
                while ( $my_query->have_posts() ) : $my_query->the_post();
                    get_template_part( 'template-parts/content', 'front' );
                endwhile; 
            ?>            
            </div>

            <div id="front-page-panel-4" class="front-page-panel">
            <?php 
                $my_query = new WP_Query( array ( 'pagename' => 'craft',) );
                while ( $my_query->have_posts() ) : $my_query->the_post();
                    get_template_part( 'template-parts/content', 'front' );
                endwhile; 
            ?>            
            </div>
            </div>
            
		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer( 'front' ); ?>
