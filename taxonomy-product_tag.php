<?php
/**
 * @package Make
 */

///* create a filter to stop featured image from displaying on this page */
//function taxonomy_product_Tag_no_featured_image( $default, $option ) {
//	if ( 'layout-archive-featured-images' == $option ) {
//		$default = 'none';
//	}
//
//	return $default;
//}
//
//add_filter( 'make_sanitize_choice', 'taxonomy_product_tag_no_featured_image', 10 ,2 );


function thememod_taxonomy_product_force_featured_image( $value, $setting_id ) {
	if ( 'layout-archive-featured-images' == $setting_id ) {
		$value = 'none';
	}

	return $value;
}


add_filter( 'make_settings_thememod_current_value', 'thememod_taxonomy_product_force_featured_image', 10 ,2 );


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
