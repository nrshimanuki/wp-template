<?php get_header(); ?>

	<?php while(have_posts()) : the_post(); ?>

		<h2><?php the_title(); ?></h2>
		<?php the_content(); ?>



		<div class="post_pager">
			<ul class="page_navi">
				<?php if (get_previous_post(false)) :?>
				<li class="post_navi_item -prev"><?php previous_post_link('%link', 'Prev', false); ?></li>
				<?php else : ?>
				<li class="post_navi_item -prev"></li>
				<?php endif; ?>

				<?php if (get_next_post(false)) :?>
				<li class="post_navi_item -next"><?php next_post_link('%link', 'Next', false); ?></li>
				<?php else : ?>
				<li class="post_navi_item -next"></li>
				<?php endif; ?>

				<li class="post_navi_back"><a href="#">Back</a></li>
			</ul>
		</div>

		<?php
			the_post_navigation(
				array(
					'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Previous:', 'wp-template' ) . '</span> <span class="nav-title">%title</span>',
					'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next:', 'wp-template' ) . '</span> <span class="nav-title">%title</span>',
				)
			);
		?>


	<?php endwhile; ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
