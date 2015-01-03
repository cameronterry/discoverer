<?php
/**
 * Discoverer functions.
 *
 * @package Discoverer
 */

define( 'DISCOVERER_VERSION', '1.0.0' );

if ( false === isset( $content_width ) ) {
	$content_width = 650;
}

/** Include additional files. */
$template_path = get_template_directory();

require_once( "$template_path/inc/class.opengraph.php" );
require_once( "$template_path/inc/discover-opengraph.php" );
require_once( "$template_path/inc/jetpack.php" );
require_once( "$template_path/inc/template-tags.php" );

function discoverer_lato_fonts_url() {
	return '//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=latin,latin-ext';
}

function discoverer_setup_theme() {
	/** Add editor style so the back-end looks like the front. */
	add_editor_style( array( 'assets/css/editor-style.css', discoverer_lato_fonts_url() ) );

	/** Load the appropriate languages folder. */
	load_theme_textdomain( 'discoverer', get_template_directory() . '/languages' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );

	/** Render out the HTML5 versions. */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	/** Add the post formats which are relevant to Discoverer. */
	add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'link' ) );

	set_post_thumbnail_size( '300', '169', true );
}

add_action( 'after_setup_theme', 'discoverer_setup_theme' );

function discoverer_enqueue_scripts() {
	wp_enqueue_style( 'discoverer-lato', discoverer_lato_fonts_url() );
	wp_enqueue_style( 'discoverer-css', get_stylesheet_uri(), array( 'discoverer-lato' ), DISCOVERER_VERSION );
}

add_action( 'wp_enqueue_scripts', 'discoverer_enqueue_scripts' );