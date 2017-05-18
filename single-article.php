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

		<?php while ( have_posts() ) : the_post(); ?>
			<?php
			/**
			 * Allow for changing the template partial.
			 *
			 * @since 1.2.3.
			 *
			 * @param string  $type The default template type to use.
			 * @param WP_Post $post The post object for the current post.
			 */
			$template_type = apply_filters( 'make_template_content_single', 'single', $post );

			function use_sku_builder_template_content( $content ) {
				remove_filter( 'the_content', 'use_sku_builder_template_content', 1 );
				$post_object = get_page_by_title( 'sku-builder-template' );
				// If the page doesn't already exist, then create it
				if ( null == $post_object ) {

					// Set the page ID so that we know the page was created successfully
					$post_id = wp_insert_post(
						array(
							'comment_status' => 'closed',
							'ping_status'    => 'closed',
							'post_author'    => 0,
							'post_name'      => 'sku-builder-template',
							'post_title'     => 'sku-builder-template',
							'post_status'    => 'draft',
							'post_type'      => 'page'
						)
					);
				} else {
					$content = $post_object->post_content;
				}

				return $content;
			}

			add_filter( 'the_content', 'use_sku_builder_template_content', 1, 0 );
			get_template_part( 'partials/content', $template_type );
			?>
			<?php get_template_part( 'partials/nav', 'post' ); ?>
			<?php get_template_part( 'partials/content', 'comments' ); ?>
		<?php endwhile; ?>

	<?php endif; ?>
</main>

<?php ttfmake_maybe_show_sidebar( 'right' ); ?>

<?php get_footer(); ?>
