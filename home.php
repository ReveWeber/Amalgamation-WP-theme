<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Amalgamation
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

				<header>
					<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
				</header>

			<?php 
            $length_setting = '';
            if ( get_theme_mod( 'archive_length_setting' ) == 'excerpt' ) {
                $length_setting = 'excerpt';
            }
            /* Start the Loop */ 
            while ( have_posts() ) : the_post(); ?>

				<?php
					get_template_part( 'template-parts/content', $length_setting );
				?>

			<?php endwhile; ?>

			<?php the_posts_navigation(); ?>

		<?php else : ?>

			<?php get_template_part( 'template-parts/content', 'none' ); ?>

		<?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
