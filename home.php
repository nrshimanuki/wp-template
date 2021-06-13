<?php get_header(); ?>

	<?php
		$paged = get_query_var('paged') ? get_query_var('paged') : 1 ;
		$args = array(
			'post_type' => 'post',
			'post_status' => 'publish',
			'posts_per_page' => 3,
			'paged' => $paged
		);
		$the_query = new WP_Query($args);
		if ($the_query->have_posts()) :
	?>
	<?php while ($the_query->have_posts()) : $the_query->the_post(); ?>

			<?php if (has_post_thumbnail()) : ?>
			<?php the_post_thumbnail(); ?>
			<?php endif; ?>

			<?php echo get_the_date(); ?>
			<h2><?php the_title(); ?></h2>
			<a href="<?php the_permalink(); ?>"><?php the_permalink(); ?></a>

	<?php endwhile; wp_reset_postdata(); ?>
	<?php endif;?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
