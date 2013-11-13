<?php
/**
 * The custom portfolio post type archive template
 */
 
/** Force full width content layout */
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

/** Remove the post info function */
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );

/** Remove the post content */
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );

/** Remove the post image */
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );

/** Remove the post meta function */
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

add_action( 'genesis_before_content', 'divine_portfolio_title', 10 );
function divine_portfolio_title() {
	echo '<div class="portfolio-archive-header">';
	echo '<h1>My Portfolio</h1>';
  echo '<p>This is a sample Portfolio category, You can easily change this text.</p>';
	echo '</div>';
}
 
/** Add the featured image after post title */
add_action( 'genesis_entry_header', 'divine_portfolio_grid' );
function divine_portfolio_grid() {
	if ( $image = genesis_get_image( 'format=url&size=portfolio' ) ) {
		printf( '<a class="portfolio-featured-image" href="%s" rel="bookmark"><img src="%s" alt="%s" /></a>', get_permalink(), $image, the_title_attribute( 'echo=0' ) );
	}
}

genesis();