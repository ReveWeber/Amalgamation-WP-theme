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
		<div class="alignleft"><a href="<?php echo the_permalink(); ?>">
			<?php the_post_thumbnail( 'proportional-thumbnail' );?>
			</a></div>
        <?php the_excerpt(); ?>
	</div><!-- .entry-summary -->
    
    <div class="read-more-link">
        <a href="<?php echo the_permalink();?>" rel="bookmark">Read More</a>     </div>
</article><!-- #post-## -->

