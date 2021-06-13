<?php get_header(); ?>

	<?php while(have_posts()) : the_post(); ?>
		<h2><?php the_title(); ?></h2>
		<?php the_content(); ?>
		<?php get_template_part( 'templates/content', 'page' ); ?>
	<?php endwhile; ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
