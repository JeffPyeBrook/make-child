<?php
/**
 * @package Make
 */


add_filter( 'theme_mod_' . 'layout-post-featured-images' , 'theme_mod_product_page_force_featured_image', 10, 1 );

function theme_mod_product_page_force_featured_image( $value ) {
	if ( function_exists( 'on_gear_site' ) ) {
		if ( on_gear_site() ) {
			return 'thumbnail';
		}
	}

	if ( function_exists( 'on_transfer_site' ) ) {
		if ( on_transfer_site() ) {
			return 'none';
		}
	}

	return $value;
}

get_header();
global $post;
?>

<?php ttfmake_maybe_show_sidebar( 'left' ); ?>

<main id="site-main" class="site-main" role="main">
<?php if ( have_posts() ) : ?>

	<?php while ( have_posts() ) : the_post(); ?>
		<?php
		/**
		 * Allow for changing the template partial.
		 *
		 * @since 1.2.3.
		 *
		 * @param string     $type    The default template type to use.
		 * @param WP_Post    $post    The post object for the current post.
		 */
		$template_type = apply_filters( 'make_template_content_page', 'page', $post );
		get_template_part( 'partials/content', $template_type );
		?>
		<?php get_template_part( 'partials/content', 'comments' ); ?>
	<?php endwhile; ?>

<?php endif; ?>
</main>

<?php ttfmake_maybe_show_sidebar( 'right' ); ?>

<?php get_footer(); ?>
