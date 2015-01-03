<?php get_header(); ?>

	<?php if ( have_posts() ) : ?>
		<div class="article">
			<?php while ( have_posts() ) : the_post(); ?>
				<div <?php post_class( 'content' ); ?>>
					<h1><?php the_title(); ?></h1>
					<?php if ( ( 'link' === get_post_format() || false === get_post_format() ) && has_post_thumbnail() ) : ?>
						<p><?php the_post_thumbnail( 'large' ); ?></p>
					<?php endif; ?>
					<?php the_content(); ?>
					<?php the_sharing_icons(); ?>
				</div>
				<div class="comments">
					<?php if ( comments_open() || '0' != get_comments_number() ) : ?>
						<?php comments_template(); ?>
					<?php endif; ?>
				</div>
			<?php endwhile; ?>
			<div class="clear-fix"></div>
		</div>
	<?php else : ?>

		<?php get_template_part( 'content', 'none' ); ?>

	<?php endif; ?>

<?php get_footer(); ?>