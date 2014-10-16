<?php

function sgp_portfolio_image( $item_id, $width = false, $height = false, $title= '', $caption = '', $extra_attributes = '' ) {

	if ( empty( $width ) && empty( $height ) ) {
		$size = 'large';
	} elseif ( empty( $height ) ) {
		$size = 'height';
	} else {
		$size = array( $width, $height );
	}

	$thumbnail_id = get_post_thumbnail_id( $item_id );

	$image_large_attributes = wp_get_attachment_image_src( $thumbnail_id, 'large' );
	$image_large = $image_large_attributes[0];

	$image_thumb_attributes = wp_get_attachment_image_src( $thumbnail_id, 'medium-single-product' );
	$image_thumb = $image_thumb_attributes[0];

	if ( empty( $width ) ) {
		$width = $image_thumb_attributes[1];
	}

	if ( empty( $height ) ) {
		$height = $image_thumb_attributes[2];
	}

	?>
	<div class="portfolio-image">
	<a href="<?php echo $image_large;?>" title="<?php echo get_the_title($item_id);?>" class="prettyLink" rel="prettyPhoto[<?php echo $item_id;?>]">
		<img width="<?php echo $width;?>" height="<?php echo $height;?>" src="<?php echo $image_thumb;?>" alt="<?php echo get_the_title($item_id);?>">
	</a>
	</div>
<?php

}


/**
 * @package Make
 */
/* create a filter to force the product thumbnail to show next to the text */
function portfolio_force_featured_image( $default, $option ) {
	if ( 'layout-post-featured-images' == $option ) {
		$default = 'none';
	}

	return $default;
}

add_filter( 'make_sanitize_choice', 'portfolio_force_featured_image', 10 ,2 );


add_filter( 'theme_mod_' . 'layout-post-post-author-location' , 'portfolio_layout_post_author_location' );

function portfolio_layout_post_author_location( ) {
	return 'post-footer';
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
		$template_type = apply_filters( 'make_template_content_single', 'single', $post );
		get_template_part( 'partials/content', $template_type );
		?>
		<?php get_template_part( 'partials/nav', 'post' ); ?>


		<?php
		$blingid              = get_the_ID();
		$prodid               = get_product_id_from_post_id( $blingid );
		$thelink              = get_portfolio_url();
		$post_image_url       = '';//bling_image( wpsc_the_product_id(), 400, 400 );
		$portfolio_item_title = get_the_title( $blingid );

		$article_id = sg_get_product_article_id( $blingid );
		$design_id  = sg_get_product_design_id( $blingid );

		if ( $prodid ) {
			$normal_price = bling_product_normal_price($prodid);
		} else {
			$normal_price = '';
		}

		sgp_portfolio_image( $blingid );
		?>

		<div class="portfolio-item-single hentry"  itemscope itemtype="http://schema.org/Product">

			<div class="portfolio_item_cell">

				<div class="design_description">
					<?php //bling_show_design_text( $design_id ); ?>
				</div>

				<div class="portfolio_grid_display group">

					<div style="clear: both; text-align: center;" class="group">
						<div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
							<meta itemprop="price" content="<?php echo $normal_price;?>">
						</div>

						<div itemprop="brand" itemscope itemtype="http://schema.org/Organization">
							<meta itemprop="logo" content="http://www.sparkle-gear.com/wp-content/themes/bling/images/logo.png">
							<meta itemprop="name" content="<?php echo stripslashes( get_bloginfo( 'name') ) ;?>">
						</div>
						<?php

						if ( $article_id ) {
							$sg_article = new SG_Article( $article_id );
							$button_text = 'Customize Yours Now ';
							$more_info_product_id = $prodid;
						} else {
							$button_text = 'Create your own custom item now!';
							$more_info_product_id = bling_custom_design_request_product_id();
						}

						//bling_more_info_button( $more_info_product_id, $button_text );
						?>

						<div class="portfolio-text">

							<div class="descriptions" itemprop="description">
								<div class="narrative">
									<?php //echo bling_get_design_description( $id ); ?>
									<?php the_content(); ?>
								</div>
								<?php
								$design_text = bling_get_design_info_text( $blingid );
								if ( !empty( $design_text ) ) {
									?>
									<div class="design-description">
										<div class="title"><?php echo bling_get_design_name_link( $blingid, 'About The Design' );?></div>
										<?php echo $design_text;?>
									</div>
								<?php
								}
								?>

								<div class="variation-description">
									<div class="title">About the  <?php echo bling_variation_name_link( $blingid );?></div>
									<?php bling_show_variation_text( $blingid ); ?>
								</div>

							</div>
						</div>

						<?php
						bling_more_info_button( $more_info_product_id, $button_text );
						?>

					</div>
					<!--entry-content-->
				</div>
				<!-- product_grid_display group  -->
			</div>
			<!-- portfolio_item_cell -->
		</div> <!-- portfolio-item-single -->


		<?php get_template_part( 'partials/content', 'comments' ); ?>
	<?php endwhile; ?>

<?php endif; ?>
</main>

<?php ttfmake_maybe_show_sidebar( 'right' ); ?>

<?php get_footer(); ?>
