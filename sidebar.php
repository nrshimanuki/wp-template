<?php
/*
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		return;
	}
	<aside id="secondary" class="widget-area">
		<?php dynamic_sidebar( 'sidebar-1' ); ?>
	</aside><!-- #secondary -->
*/

	$post_type = get_post_type();
	if ($post_type == 'post') :
		$category = 'category';
		$url_front = home_url();
	else :
		$category = $post_type . '_category';
		$url_front = home_url() . '/' . $post_type;
	endif;
?>
		<aside class="sidebar widget-area">
			<div class="sidebar__inner widget widget_categories">
				<h3 class="sidebar__title widget_title">Categories</h3>
				<?php
					$args = array(
						'orderby' => 'id',
					);
					$terms = get_terms($category, $args);
					if(empty($terms->errors)) :
				?>
				<ul class="sidebar__list">
					<?php foreach($terms as $term) : ?>
					<li class="sidebar__item cat_item">
						<a href="<?php echo $url_front; ?>/<?php echo $term->slug; ?>/"><?php echo $term->name; ?></a>
					</li>
					<?php endforeach;?>
				</ul>
				<?php endif; ?>
			</div><!-- sidebar__inner -->
		</aside><!-- sidebar -->
