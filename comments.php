<div id="comments" class="comments-area">
	<h2 class="comments-title">Discussion</h2>
	<?php if ( have_comments() ) : ?>
		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
			<nav id="comment-nav-above" class="comment-navigation" role="navigation">
				<h1 class="screen-reader-text"><?php _e( 'Comment navigation', 'intergalactic' ); ?></h1>
				<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'intergalactic' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'intergalactic' ) ); ?></div>
			</nav>
		<?php endif; ?>

		<ol class="comment-list">
			<?php
				wp_list_comments( array(
					'avatar_size' => 50,
					'callback' => 'discoverer_the_comment',
					'short_ping' => true,
					'style' => 'ol'
				) );
			?>
		</ol>
	<?php endif; ?>

	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="no-comments"><?php _e( 'Comments are closed.', 'intergalactic' ); ?></p>
	<?php endif; ?>

	<?php comment_form( array(
		'comment_field' => '<div class="comment-form-comment"><textarea id="comment" name="comment" cols="45" placeholder="Join the discussion..." rows="8" aria-required="true"></textarea></div>'
	) ); ?>

</div>
