<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Divine WP' );
define( 'CHILD_THEME_URL', 'http://www.wpstuffs.com/' );
define( 'CHILD_THEME_VERSION', '1.0.0' );

//* Enqueue Lato Google font
add_action( 'wp_enqueue_scripts', 'genesis_sample_google_fonts' );
function genesis_sample_google_fonts() {
	wp_enqueue_style( 'google-font-lato', '//fonts.googleapis.com/css?family=Dancing+Script:700|EB+Garamond', array(), CHILD_THEME_VERSION );
}

$content_width = 740;

//* Add HTML5 markup structure
add_theme_support( 'html5' );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Add support for custom background
add_theme_support( 'custom-background' );

//* Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );

/** Remove default sidebar */
remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );
remove_action( 'genesis_sidebar_alt', 'genesis_do_sidebar_alt' );

/** Remove secondary sidebar */
unregister_sidebar( 'sidebar' );
unregister_sidebar( 'sidebar-alt' );

/** Support for various Image sizes */
add_image_size( 'portfolio', 420, 300, TRUE );

//* Add post navigation (requires HTML5 theme support)
add_action( 'genesis_entry_footer', 'genesis_prev_next_post_nav', 3 );

/** Add support for post formats */
add_theme_support( 'post-formats', array(
	'aside',
	'audio',
	'gallery',
	'image',
	'quote',
	'status',
	'video'
) );

//* Unregister Layout setting
genesis_unregister_layout( 'content-sidebar' ); 
genesis_unregister_layout( 'sidebar-content' ); 
genesis_unregister_layout( 'content-sidebar-sidebar' ); 
genesis_unregister_layout( 'sidebar-sidebar-content' );
genesis_unregister_layout( 'sidebar-content-sidebar' );

/** To remove post info, entry title and post meta based on post format */
add_action( 'genesis_before_entry', 'divine_read_remove_elements', 3 );

function divine_read_remove_elements() {
		
	if ( 'aside' == get_post_format() || 'quote' == get_post_format() || 'status' == get_post_format() || 'link' == get_post_format()) {
			//* Remove the entry title (requires HTML5 theme support)
			remove_action( 'genesis_entry_header', 'genesis_do_post_title' );						
			//* Remove the entry meta in the entry footer (requires HTML5 theme support)
			remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
			//* Customize the entry meta in the entry header (requires HTML5 theme support)
			add_filter( 'genesis_post_info', 'sp_post_info_filter' );
		}

else if ( 'gallery' == get_post_format() || 'audio' == get_post_format() || 'video' == get_post_format() || 'image' == get_post_format()) {
			//* Remove the entry meta in the entry footer (requires HTML5 theme support)
			remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
			//* Add entry title (requires HTML5 theme support)
			add_action( 'genesis_entry_header', 'genesis_do_post_title' );
			//* Customize the entry meta in the entry header (requires HTML5 theme support)
			add_filter( 'genesis_post_info', 'sp_post_info_filter' );						
		}
		
else if ( 'post' == get_post_type() ){
			//* Add entry title (requires HTML5 theme support)
			add_action( 'genesis_entry_header', 'genesis_do_post_title' );						
			//* Add entry meta in the entry footer (requires HTML5 theme support)
			add_action( 'genesis_entry_footer', 'genesis_post_meta' );
			//* Add entry meta in the entry header (requires HTML5 theme support)
			add_action( 'genesis_entry_header', 'genesis_post_info', 12 );
			//* Customize the entry meta in the entry header (requires HTML5 theme support)
			add_filter( 'genesis_post_info', 'sp1_post_info_filter' );						
		}
}

//* Customize the entry meta in the entry header (requires HTML5 theme support)
function sp_post_info_filter($post_info) {
	$post_info = '<span class="special-entry-meta-header"><a href="'.get_permalink().'">[post_date]</a></span>[post_edit]';
	return $post_info;
}

//* Customize the entry meta in the entry header (requires HTML5 theme support)
function sp1_post_info_filter($post_info) {
	$post_info = '[post_date] by [post_author_posts_link] [post_comments] [post_edit]';
	return $post_info;
}

/** Create portfolio custom post type */
add_action( 'init', 'divine_portfolio_post_type' );
function divine_portfolio_post_type() {
    register_post_type( 'portfolio',
        array(
            'labels' => array(
                'name' => __( 'Portfolio', 'divine' ),
                'singular_name' => __( 'Portfolio', 'divine' ),
            ),          
            'has_archive' => true,
            'hierarchical' => true,
            'menu_icon' => get_stylesheet_directory_uri() . '/images/icons/portfolio.png',
            'public' => true,
            'rewrite' => array( 'slug' => 'portfolio' ),
            'taxonomies' => array( 'portfolio-type' ),
            'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'page-attributes', 'genesis-seo' ),
        )
    );
}
 
/* Register Portfolio Taxonomy */
add_action( 'init', 'create_portfolio_tax' );
function create_portfolio_tax() {
    register_taxonomy(
        'portfolio-type',
        'portfolio',
        array(
            'label' => __( 'Portfolio Category' ),
            'hierarchical' => true
        )
    );
}

/** Change the number of portfolio items to be displayed (props Bill Erickson) */
add_action( 'pre_get_posts', 'divine_portfolio_items' );
function divine_portfolio_items( $query ) {

	if( $query->is_main_query() && !is_admin() && is_post_type_archive( 'portfolio' ) ) {
		$query->set( 'posts_per_page', '6' );
	}
}

/** Responsive Mobile menu **/
function gst_primarymenu_script() {
  	
	wp_register_script( 'primary-menu', get_stylesheet_directory_uri() . '/js/primarymenu.js', array('jquery'), '1.0.0', false );
	wp_enqueue_script( 'primary-menu' );
	wp_enqueue_script( 'ga-fitvids',    CHILD_URL . '/js/jquery.fitvids.js', array( 'jquery' ), null, true );
 }
add_action('wp_enqueue_scripts', 'gst_primarymenu_script');


/** Customize breadcrumbs display */
add_filter( 'genesis_breadcrumb_args', 'divine_breadcrumb_args' );
function divine_breadcrumb_args( $args ) {
	$args['home'] = 'Home';
	$args['sep'] = ' ';
	$args['list_sep'] = ', '; // Genesis 1.5 and later
	$args['prefix'] = '<div class="breadcrumb"><div class="wrap">';
	$args['suffix'] = '</div></div>';
	$args['labels']['prefix'] = '<span class="home"></span>';
	return $args;
}

//* Customize the next page link
add_filter ( 'genesis_next_link_text' , 'sp_next_page_link' );
function sp_next_page_link ( $text ) {
	$nextlink = '<span class="next-page">Next Page</div>';
	return $nextlink;
}

//* Customize the previous page link
add_filter ( 'genesis_prev_link_text' , 'sp_previous_page_link' );
function sp_previous_page_link ( $text ) {
	$prevlink = '<span class="prev-page">Previous Page</span>';
	return $prevlink;
}

//* Add footer menu widget area
add_action( 'genesis_footer', 'widget_footer_menu', 5);
function widget_footer_menu() {
if ( is_active_sidebar( 'footer-menu' ) ) {
		echo '<div class="footer-menu"><div class="wrap">';
		dynamic_sidebar( 'footer-menu' );
		echo '</div></div><!-- end #footer-menu -->';
	} 
}

genesis_register_sidebar( array(
	'id'				=> 'footer-menu',
	'name'			=> __( 'Bottom Footer menu'),
	'description'	=> __( 'Place Menu in Footer'),
) );