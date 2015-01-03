<?php get_header(); ?>

	<?php if ( have_posts() ) : ?>
		<div class="section">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content' ); ?>
			<?php endwhile; ?>
			<div class="clear-fix"></div>
		</div>
	<?php else : ?>

		<?php get_template_part( 'content', 'none' ); ?>

	<?php endif; ?>

<?php get_footer(); ?>