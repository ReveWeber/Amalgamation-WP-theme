<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Amalgamation
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer front-footer" role="contentinfo">
		<div class="site-info">
			<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'amalgamation' ) ); ?>"><?php printf( esc_html__( 'Proudly powered by %s', 'amalgamation' ), 'WordPress' ); ?></a>
			<span class="sep"> | </span>
			<?php printf( esc_html__( 'Theme: %1$s by %2$s.', 'amalgamation' ), 'amalgamation', '<a href="http://rweber.net" rel="designer">Rebecca Weber</a>' ); ?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
<a class="skip-link screen-reader-text" href="#"><?php esc_html_e( 'Return to Top', 'amalgamation' ); ?></a>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
