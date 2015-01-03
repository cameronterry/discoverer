<?php

	function discoverer_the_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		extract( $args, EXTR_SKIP );

		$tag = ( 'div' === $style ? 'div' : 'li' ); ?>
		<<?php echo( $tag ); ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?>>
			<?php if ( $args['avatar_size'] != 0 ) : ?>
				<?php echo( get_avatar( $comment, $args['avatar_size'] ) ); ?>
			<?php endif; ?>
			<div class="main">
				<p><span class="comment-author"><?php comment_author_link(); ?></span> wrote;</p>
				<?php comment_text(); ?>
				<div class="reply">
					<?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
				</div>
			</div>
		
	<?php }

	function the_blog_title() {
		printf( '<%1$s class="title"><a href="%2$s">%3$s</a></%1$s>', ( is_home() ? 'h1' : 'div' ), home_url(), get_bloginfo( 'name' ) );
	}

	function the_sharing_icons() {
		if ( function_exists( 'sharing_display' ) ) {
			sharing_display( '', true );
		}
	}