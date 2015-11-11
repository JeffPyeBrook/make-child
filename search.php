<?php
/**
 * @package Make
 */
global $wp_query;
get_header();
global $post;
$filters = new PortfolioFilterClass();
?>

<?php ttfmake_maybe_show_sidebar( 'left' ); ?>

<main id="site-main" class="site-main" role="main">
<?php if ( have_posts() ) : ?>

	<?php //sg_order_search_results(); ?>

	<header class="section-header">
		<?php get_template_part( 'partials/section', 'title' ); ?>
	</header>

	<?php
	//$filters->isotope_design_theme_links( true );
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
//		$template_type =  apply_filters( 'make_template_content_search', 'search', $post );
//		get_template_part( 'partials/content', $template_type );
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

<?php
function sg_order_search_results() {
	global $wp_query;

	$results = array();

	$search_term = get_query_var( 's' );
	$search_term = sg_cleanup_string( $search_term );

	foreach ( $wp_query->posts as $index => $post ) {
		$post_id = $post->ID;

		if ( isset( $results[$post_id] ) ) {
			// post already in results
			continue;
		}

		$title = sg_cleanup_string( $post->post_title );

		$words = explode( ' ', $title );

		if ( in_array( $search_term, $words ) ) {
			$results[$post_id] = $post;
			unset( $wp_query->posts[$index] );
			continue;
		}

		if ( in_array( $search_term . 's', $words ) ) {
			$results[$post_id] = $post;
			unset( $wp_query->posts[$index] );
			continue;
		}
	}

	$results = array_merge( array_values( $results ), $wp_query->posts );

	//usort($results, 'sg_cmp_search_result_posts');

	$wp_query->posts = $results;
}

function sg_cleanup_string( $string ) {
	$string = strtolower( $string );
	$string = trim( preg_replace( "/[^0-9a-z]+/i", " ", $string ) );
	$string = trim( preg_replace('/\s+/', ' ', $string ) );
	return $string;
}

function sg_cmp_search_result_posts($a, $b) {

	if ($a->post_type == $b->post_type ) {
		return strcasecmp ( $a->post_title, $b->post_title );
	}

	if ( $a->post_type == SG_Design::POST_TYPE ) {
		$a_order = 1;
	} elseif ( $a->post_type == SG_Portfolio_Item::POST_TYPE ) {
		$a_order = 10;
	} elseif ( $a->post_type == SG_Mockup::POST_TYPE ) {
		$a_order = 100;
	} else {
		$a_order = 1000;
	}

	if ( $b->post_type == SG_Design::POST_TYPE ) {
		$b_order = 1;
	} elseif ( $b->post_type == SG_Portfolio_Item::POST_TYPE ) {
		$b_order = 10;
	} elseif ( $b->post_type == SG_Mockup::POST_TYPE ) {
		$b_order = 100;
	} else {
		$b_order = 1000;
	}

	return ($a_order < $b_order) ? -1 : 1;
}
