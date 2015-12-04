<?php
/**
 * Template part for displaying results in search pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Amalgamation
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

		<?php if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php amalgamation_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-summary">
        <?php if ( has_post_thumbnail() ) : ?>
            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                <?php the_post_thumbnail( 'proportional-thumbnail', array( 'class' => 'alignleft' ) ); ?>
            </a>
        <?php endif; ?>
        <?php the_excerpt(); ?>
	</div><!-- .entry-summary -->
    
    <div class="more-link">
        <?php the_title( sprintf( '<a href="%s" rel="bookmark">More ', esc_url( get_permalink() ) ), '</a>' ); ?>
    </div>
</article><!-- #post-## -->

