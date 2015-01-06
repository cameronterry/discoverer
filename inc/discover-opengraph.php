<?php
/**
 * Mini-library to retrieve the OpenGraph tags of a specific URL included in
 * "Link" Post Format types and containing a URL.
 *
 * Specifically, this library will retrieve the featured image as noted in the
 * OpenGraph tag, download it and set it as the feature image as a Post is
 * Published.
 *
 * Portions of this work are inspired and based on the excellent plugin Video
 * Thumbnails by Sutherland Boswell.
 * 
 * https://wordpress.org/plugins/video-thumbnails/
 */

class DiscovererOpenGraph {
	function __construct() {
		add_action( 'save_post', array( &$this, 'save_post' ), 100, 2 );
	}

	/**
	 * Takes a given URL and downloads it into the Uploads folder.
	 */
	public function download_url( $url = '' ) {
		$response = wp_remote_get( $url, array( 'sslverify' => false ) );

		if ( false === is_wp_error( $response ) ) {
			/** Grab the Content Type and the body (which is the image binary data). */
			$bits = wp_remote_retrieve_body( $response );
			$image_type = wp_remote_retrieve_header( $response, 'content-type' );

			/** Get the filename from the URL path. */
			$filename = basename( $url );

			/** Save the file to the upload folder. */
			$upload = wp_upload_bits( $filename, null, $bits );

			if ( false === $upload['error'] ) {
				return $upload;
			}
		}

		return null;
	}

	public function get_first_url( $content ) {
		$regexp = "/https?\:\/\/[^\" ]+/i";

		preg_match( $regexp, $content, $url );var_dump($content, $url);die();

		if ( false === empty( $url ) ) {
			return $url[0];
		}

		return false;
	}

	public function get_thumbnail( $post_id, $content = null ) {
		/** Grab the first available URL in the text. */
		$first_url = $this->get_first_url( $content );

		/** Then fetch the OpenGraph Data. */
		$opengraph_data = OpenGraph::fetch( $first_url );

		/** Make sure we have an image to actually work with. */
		if ( $opengraph_data->__isset( 'image' ) ) {
			$image_url = $opengraph_data->__get( 'image' );
			$upload_data = $this->download_url( $image_url );

			if ( false === empty( $upload_data ) ) {
				$wp_filetype = wp_check_filetype( basename( $upload_data['file'] ) );

				$attachment = array(
					'post_content' => '',
					'post_mime_type' => $wp_filetype['type'],
					'post_title' => $opengraph_data->__get( 'title' ),
					'post_status' => 'inherit'
				);

				$attach_id = wp_insert_attachment( $attachment, $upload_data['file'], $post_id );
				
				require_once( ABSPATH . 'wp-admin/includes/image.php' );
				$attach_data = wp_generate_attachment_metadata( $attach_id, $upload_data['file'] );
				wp_update_attachment_metadata( $attach_id, $attach_data );

				return $attach_id;
			}
		}

		return null;
	}

	public function save_post( $post_id, $post ) {
		/** Don't save thumbnails during an autosave or unpublished posts. */
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return null;
		}
var_dump(get_post_status( $post_id ));die();
		/** Make sure the Post is published and is the Link format. */
		if ( 'publish' !== get_post_status( $post_id ) && 'link' !== get_post_format( $post_id ) ) {
			return null;
		}

		/** Check to make sure we have a Post (it's helpful) and make sure it doesn't have a thumbnail. */
		if ( empty( $post ) || has_post_thumbnail( $post_id ) ) {
			return;
		}

		$attachment_id = $this->get_thumbnail( $post_id, $post->post_content );
		set_post_thumbnail( $post_id, $attachment_id );
	}
}

$discoverer_opengraph = new DiscovererOpenGraph();
