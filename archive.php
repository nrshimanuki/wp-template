<?php get_header(); ?>

	<?php if (have_posts()) : ?>
	<?php while (have_posts()) : the_post(); ?>

		<?php if (has_post_thumbnail()) : ?>
		<?php the_post_thumbnail(); ?>
		<?php endif; ?>

		<h2><?php the_title(); ?></h2>
		<?php echo get_the_date(); ?>
		<a href="<?php the_permalink(); ?>"><?php the_permalink(); ?></a>



		<?php
			echo paginate_links(array(
				'base' => get_pagenum_link(1) . '%_%',
				'format' => '?paged=%#%',
				// 'format' => 'page/%#%/',
				// 'format' => '&paged=%#%',
				'total' => $wp_query->max_num_pages,
				// 'total' => $the_query->max_num_pages,
				'current' => max(1, get_query_var('paged')),
				// 'current' => max(1, $paged),
				'mid_size' => 2,
				'prev_text' => '前の一覧',
				'next_text' => '次の一覧',
				'type' => 'list',
				// 'before_page_number' => '<span class="screen-reader-text">' . 'screen-reader-text' . ' </span>'
			));
		?>

		<?php the_posts_navigation(); ?>


	<?php endwhile; ?>
	<?php endif;?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
