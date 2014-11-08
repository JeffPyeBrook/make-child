<?php
/**
 * @package Make
 */

get_header();
global $post;
?>

<?php ttfmake_maybe_show_sidebar( 'left' ); ?>


	<?php if ( have_posts() ) : ?>

	<header class="section-header">
		<?php get_template_part( 'partials/section', 'title' ); ?>
		<?php get_template_part( 'partials/section', 'description' ); ?>
		<main id="site-main" class="site-main" role="main">

			<style>
				#tipRow {
					margin: 0 0 10px 0;
					border: 1px solid #c7dbee;

				}

				#tipRow,#tipTop {
					width: 98%;
					float: left;
				}

				#tipTop {
					height: 10px;
				}

				#tipRow,#tipTop {
					width: 100%;
					float: left;
				}

				#tip {
				}

				#tipRowHalf,#tipTopHalf,#tip {
					width: 48%;
					float: left;
					padding: 5px;
				}

				div.tip-img {
					display:inline-block;
				}

				div.tip-text {
					display:inline-block;
				}

				span.tip-title {
					font-weight: bold;
					font-size: 1.1rem;
					font-size: 1.1em;
				}

				span.tip-title:after {
					content: '\A';
					white-space: pre;
				}

				#tip img {
					width: 100px;
					margin: 15px 20px;
					float: left;
					padding-bottom: 30px;
				}

				.tipsWrapper {
					width: 100%;
				}

				.tipsWrapper span {
					font-style: italic;
				}

				.tipstitle {
					font-weight: bold;
				}

			</style>

			<div id="content" role="main">
				<h6>Apparel and Accessory Information</h6>
				<hr>
				<div class="tipsWrapper">
					<span class="tipstitle">What size shirt do you need?</span>
					<span class=""tip-text">
				From your wardrobe, find a t-shirt that fits you well. Measure on a
				flat surface with the front of the garment facing up. Measure as
				shown below. </span>
					<div id="tipRow">
						<div id="tip" class="tipL">
							<div class="tip-img">
								<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/tshirt_bodywidth.png">
							</div>
							<div class="tip-text">
								<span class="tip-title">Body Width</span>
								<span class="tip-text">The body width is measured approximately 2 inches below the
									armhole across the garment from edge to edge. Double this
									measurement and compare to the size charts below.</span>
							</div>
						</div>
						<div id="tip" class="tipR">
							<div class="tip-img">
								<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/tshirt_bodylength.png">
							</div>
							<div class="tip-text">
								<span class="tip-title">Body Length</span>
								<span class="tip-text">The body length is measured in a straight line from the highest
									point of the shoulder at the join of the collar to the bottom
									opening.</span>
							</div>
						</div>
					</div>
				</div>
				<br>
			</div>

	</header>

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
		$template_type = apply_filters( 'make_template_content_archive', 'archive', $post );
		get_template_part( 'partials/content', $template_type );
		?>
	<?php endwhile; ?>

	<?php get_template_part( 'partials/nav', 'paging' ); ?>

<?php else : ?>
	<?php get_template_part( 'partials/content', 'none' ); ?>
<?php endif; ?>
</main>

<?php ttfmake_maybe_show_sidebar( 'right' ); ?>

<?php get_footer(); ?>
