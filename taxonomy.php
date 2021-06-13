<?php get_header(); ?>

	<?php if (have_posts()) : ?>
	<?php while (have_posts()) : the_post(); ?>

		<?php if (has_post_thumbnail()) : ?>
		<?php the_post_thumbnail(); ?>
		<?php endif; ?>

		<h2><?php the_title(); ?></h2>
		<?php echo get_the_date(); ?>
		<a href="<?php the_permalink(); ?>"><?php the_permalink(); ?></a>

	<?php endwhile; ?>
	<?php endif;?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
