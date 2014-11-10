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
		global $wp_query;
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

				$start = microtime( true );
				$tile = new PortfolioTile();
				$end = microtime( true );
				$elapsed = round( ($end - $start) * 1000, 0 );
				//error_log( basename( __FILE__  ). ' @ ' . __LINE__  . ' new PortfolioTile took ' . $elapsed );

				$start = microtime( true );
				echo $tile->lazy_portfolio_tile();
				$end = microtime( true );
				$elapsed = round( ($end - $start) * 1000, 0 );
				//error_log( basename( __FILE__  ). ' @ ' . __LINE__  . ' lazy_portfolio_tile ' . $elapsed );

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
