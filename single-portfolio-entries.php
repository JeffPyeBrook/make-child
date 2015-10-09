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


function sgp_meta_tags( $post_id  ) {

	$sg_design_id = sg_get_product_design_id( $post_id );
	if ( $sg_design_id ) {
		$sg_design = sg_get_design_by_id( $sg_design_id );
	} else {
		$sg_design = false;
	}


	$sg_article_id = sg_get_product_article_id( $post_id );
	if ( $sg_design_id ) {
		$sg_article = new SG_Article( $sg_article_id );
	} else {
		$sg_article = false;
	}

	$facebook_app_id = '';
	$facebook_admins = '';

	$giveaway_options = get_option( 'pbci_giveaway_options' );

	if ( is_array( $giveaway_options ) ) {
		extract( $giveaway_options ); // get's us $facebook_app_id
	}

	$thumbnail_id = get_post_thumbnail_id( $post_id );

	if ( $thumbnail_id ) {
		$image_attributes = wp_get_attachment_image_src( $thumbnail_id, array( 375, 375 ) );
		$image_link       = $image_attributes[0];
	} else {
		$image_link = '';
		$image_attributes[0] = ''; // url
		$image_attributes[1] = 0; // width
		$image_attributes[2] = 0; // height
		$image_attributes[3] = false; // no image
	}

//	error_log( __FUNCTION__ . ' image is ' . $image_link );
//
	if ( empty( $width ) ) {
		$image_width = $image_attributes[1];
	}

	if ( empty( $height ) ) {
		$image_height = $image_attributes[2];
	}

	if ( strpos( $image_link, 'missing' ) !== false ) {
		$image_link = '';
	}

	$title = get_the_title( $post_id );
	$title = $title . '  #rhinestone #bling, We made this!';
	$permalink = get_the_permalink( $post_id );

	$post = get_post( $post_id );
	$description = $post->post_content;

	if ( empty( $description ) ) {
		if ( $sg_design ) {
			$description = $sg_design->get_design_text();
		}
	}

	if ( ! empty( $description ) ) {
		$description = strip_tags( $description );
		$description = str_replace( "\n", " ", $description );
		$description = str_replace( '&nbsp;', ' ', $description );
		$description = sgc_compress_html( $description );
		if ( strlen( $description ) > 199 ) {
			$description = substr( $description, 0, 196 ) . '...';
		}
	}

	if ( empty( $image_link ) ) {
		$twitter_card_type = 'summary';
	} else {
		$twitter_card_type = 'photo';
	}

	?>


	<meta property="twitter:card" content="<?php echo $twitter_card_type; ?>">
	<?php if ( ! empty( $image_link )  ) { ?>
		<meta property="twitter:image:width" content="<?php echo $image_width; ?>">
		<meta property="twitter:image:height" content="<?php echo $image_height; ?>">
	<?php } ?>

	<meta property="twitter:site" content="@SparkleGear">
	<meta property="twitter:creator" content="@SparkleGear">
	<meta property="twitter:url" content="<?php echo $permalink;?>"/>
	<meta property="twitter:title" content="<?php echo $title; ?>"/>
	<meta property="twitter:description" content="<?php echo strip_tags( $description ); ?>"/>

	<?php if ( ! empty( $image_link ) ) { ?>
		<meta property="twitter:image" content="<?php echo $image_link; ?>"/>
	<?php } ?>


	<?php if ( ! empty( $image_link ) ) { ?>
		<meta name="thumbnail" content="<?php echo $image_link; ?>"/>
	<?php } ?>

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

		if ( $design_id ) {
			$sg_design = sg_get_design_by_id( $design_id );
			$design_text = $sg_design->get_design_text();
		} else {
			$sg_design = false;
			$design_text = '';
		}

		if ( $prodid ) {
			$normal_price = bling_product_normal_price($prodid);
		} else {
			$normal_price = '';
		}

		//sgp_meta_tags( $blingid );

		sgp_portfolio_image( $blingid );
		?>

		<div class="portfolio-item-single hentry"  itemscope itemtype="http://schema.org/Product">

			<h3 itemprop="name"><?php echo get_the_title( $prodid );?></h3>
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

								if ( !empty( $design_text ) ) {
									?>
									<div class="design-description">
										<div class="title"><?php echo bling_get_design_name_link( $blingid, 'About The Design' );?></div>
										<?php echo $design_text;?>

										<div class="byline">
											<?php echo $sg_design->get_byline();?>
										</div>
									</div>
								<?php
								}
								?>

								<?php if ( $article_id ) { ?>
									<div class="variation-description">
										<div class="title">About the  <?php echo bling_variation_name_link( $blingid );?></div>
										<?php bling_show_variation_text( $blingid ); ?>
									</div>
								<?php } ?>

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
