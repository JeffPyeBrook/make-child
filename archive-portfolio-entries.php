 <?php
/**
 * @package Make
 */

get_header();
global $post;
$filters = new PortfolioFilterClass();
?>

<?php ttfmake_maybe_show_sidebar( 'left' ); ?>

<main id="site-main" class="site-main" role="main">
<?php if ( have_posts() ) : ?>

	<header class="section-header">
		<?php //get_template_part( 'partials/section', 'title' ); ?>
		<h1 class="section-title">
			<?php echo $filters->get_title(); ?>
		</h1>
		<?php get_template_part( 'partials/nav', 'paging' ); ?>
		<?php get_template_part( 'partials/section', 'description' ); ?>
	</header>

	<?php
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
		$tile = new PortfolioTile();
		echo $tile->lazy_portfolio_tile();
		?>
	<?php endwhile; ?>
	</div> <!--end product_grid_display group -->

	<?php get_template_part( 'partials/nav', 'paging' ); ?>

<?php else : ?>
	<?php get_template_part( 'partials/content', 'none' ); ?>
<?php endif; ?>
</main>

<?php ttfmake_maybe_show_sidebar( 'right' ); ?>

<?php get_footer(); ?>
