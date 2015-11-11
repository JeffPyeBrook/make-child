<?php
/**
 * @package Make
 */

get_header();
?>

<?php ttfmake_maybe_show_sidebar( 'left' ); ?>

<main id="site-main" class="site-main" role="main">
	<article id="search" class="" page type-page status-publish hentry>
		<header class="section-header">
			<h1>Sparkle Search</h1>
		</header>

		<?php
		$uri = get_stylesheet_directory_uri() . '/search.html';
		if ( ! empty ( $_REQUEST['s'] ) ) {
			$uri .= '?s=' . esc_html( trim( $_REQUEST['s'] ) );
		}
		?>
		<iframe scrolling="no" height="1400px" width="100%;" src="<?php echo $uri;?>"></iframe>

	</article>
</main>

<?php ttfmake_maybe_show_sidebar( 'right' ); ?>


<?php get_footer(); ?>
