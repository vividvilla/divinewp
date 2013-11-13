<?php
/**
 * The custom portfolio post type archive template
 */

/** Force full width content layout */
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

add_action( 'genesis_after_header', 'gst_do_mobilenav', 20 );

/** Remove the post info function */
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );

/** Remove the post content */
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );

/** Remove the post image */
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );

add_action( 'genesis_before_content', 'divine_portfolio_title',10 );
function divine_portfolio_title() {
	echo '<div class="portfolio-archive-header">';
	echo '<h1>';
	echo single_cat_title( $category_id );
	echo '</h1>';
  echo '<p>';
	echo category_description( $category_id );
	echo '</p>';
	echo '</div>';
}

/** Add the featured image after post title */
add_action( 'genesis_entry_header', 'divine_portfolio_grid' );
function divine_portfolio_grid() {
	if ( has_post_thumbnail() ){
		echo '<a class="portfolio-featured-image" href="' . get_permalink() .'" title="' . the_title_attribute( 'echo=0' ) . '">';
		echo get_the_post_thumbnail($thumbnail->ID, 'portfolio' );
		echo '</a>';
	}
}

/** Remove the post meta function */
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

genesis();