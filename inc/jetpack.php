<?php

	function discoverer_loop_start() {
        remove_filter( 'the_content', 'sharing_display', 19 );
        remove_filter( 'the_excerpt', 'sharing_display', 19 );
        
        if ( class_exists( 'Jetpack_Likes' ) ) {
            remove_filter( 'the_content', array( Jetpack_Likes::init(), 'post_likes' ), 30, 1 );
        }
    }

    add_action( 'loop_start', 'discoverer_loop_start' );