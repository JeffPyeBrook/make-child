 <?php
/**
 * @package Make
 */

get_header();
global $post;
?>

<?php ttfmake_maybe_show_sidebar( 'left' ); ?>

<main id="site-main" class="site-main" role="main">
<?php if ( have_posts() ) : ?>

	<header class="section-header">
		<?php //get_template_part( 'partials/section', 'title' ); ?>
		<h1 class="section-title">
			Rhinestone Designs
		<?php get_template_part( 'partials/section', 'description' ); ?>
	</header>

	<?php //isotope_design_theme_links( );	?>
	<?php
		//$gallery = new DesignGallery( 'design_gallery' );
		//$gallery->isotope_design_theme_links( true );
		$filters = new PortfolioFilterClass();
		$filters->isotope_design_theme_links( true );
	?>

	<div class="product_grid_display group">
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
		//$template_type = apply_filters( 'make_template_content_archive', 'archive', $post );
		//get_template_part( 'partials/content', $template_type );
		//echo $gallery->lazy_portfolio_tile( get_the_ID() );
		$tile = new PortfolioTile();
		echo $tile->lazy_portfolio_tile();

		?>
	<?php endwhile; ?>
</div>
	<?php get_template_part( 'partials/nav', 'paging' ); ?>

<?php else : ?>
	<?php get_template_part( 'partials/content', 'none' ); ?>
<?php endif; ?>
</main>

<?php ttfmake_maybe_show_sidebar( 'right' ); ?>

<?php get_footer(); ?>
