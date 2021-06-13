<?php
	get_header();
	$current_page_data = sanitize_post($GLOBALS['wp_the_query']->get_queried_object());
	$post_type = get_query_var('post_type');
	$query_object = get_queried_object();
	if (!empty($query_object->slug)) :
		$term_slug = $query_object->slug;
	endif;
	if (!empty($query_object->name)) :
		$term_name = $query_object->name;
	endif;
?>

	<?php
		$paged = get_query_var('paged') ? get_query_var('paged') : 1 ;
		$args = array(
			'post_type' => $post_type,
			'post_status' => 'publish',
			'posts_per_page' => 3,
			'paged' => $paged
		);
		$the_query = new WP_Query($args);
		if ($the_query->have_posts()) :
	?>
	<?php while ($the_query->have_posts()) : $the_query->the_post(); ?>

		<h2><?php the_title(); ?></h2>
		<a href="<?php the_permalink(); ?>"><?php the_permalink(); ?></a>

	<?php endwhile; wp_reset_postdata(); ?>
	<?php endif;?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
