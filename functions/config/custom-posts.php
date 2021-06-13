<?php

/**
 * 投稿をカスタマイズ
 */
// function post_has_archive($args, $post_type) {
// if ('post' == $post_type) {
// 		$args['rewrite'] = true;
// 		$args['has_archive'] = 'news';
// 	}
// 	return $args;
// }
// add_filter('register_post_type_args', 'post_has_archive', 10, 2);

function change_post_menulabel() {
	global $menu;
	global $submenu;
	$name = 'お知らせ';
	$menu[5][0] = $name;
	$submenu['edit.php'][5][0] = $name.'一覧';
	$submenu['edit.php'][10][0] = '新しい'.$name;
}
function change_post_objectlabel() {
	global $wp_post_types;
	$name = 'お知らせ';
	$labels = &$wp_post_types['post']->labels;
	$labels->name = $name;
	$labels->singular_name = $name;
	$labels->add_new = _x('追加', $name);
	$labels->add_new_item = $name.'の新規追加';
	$labels->edit_item = $name.'の編集';
	$labels->new_item = '新規'.$name;
	$labels->view_item = $name.'を表示';
	$labels->search_items = $name.'を検索';
	$labels->not_found = $name.'が見つかりませんでした';
	$labels->not_found_in_trash = 'ゴミ箱に'.$name.'は見つかりませんでした';
}
function custom_rewrite_basic() {
	add_rewrite_rule('news/page/?([0-9]{1,})/?$', 'index.php?category_name=news&paged=$matches[1]', 'top');
	add_rewrite_rule('news/(.+?)/page/?([0-9]{1,})/?$', 'index.php?category_name=$matches[1]&paged=$matches[2]', 'top');
}
if (CHANGE_POST_LABEL) {
	add_action( 'init', 'change_post_objectlabel' );
	add_action( 'admin_menu', 'change_post_menulabel' );
	add_action('init', 'custom_rewrite_basic');
}



/**
 * cptui
 */
function cptui_register_my_cpts() {
	/**
	 * Post Type: Sample.
	 */
	$labels = [
		"name" => __( "Sample", "custom-post-type-ui" ),
		"singular_name" => __( "Sample", "custom-post-type-ui" ),
	];
	$args = [
		"label" => __( "Sample", "custom-post-type-ui" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => true,
		"rewrite" => [ "slug" => "sample", "with_front" => true ],
		"query_var" => true,
		"menu_position" => 5,
		"supports" => [ "title", "editor", "thumbnail", "custom-fields" ],
		"taxonomies" => [ "sample_category" ],
		"show_in_graphql" => false,
	];
	register_post_type( "sample", $args );
}
add_action( 'init', 'cptui_register_my_cpts' );


function cptui_register_my_taxes() {
	/**
	 * Taxonomy: Sample categories.
	 */
	$labels = [
		"name" => __( "Sample categories", "custom-post-type-ui" ),
		"singular_name" => __( "Sample category", "custom-post-type-ui" ),
	];
	$args = [
		"label" => __( "Sample categories", "custom-post-type-ui" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => true,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => [ 'slug' => 'sample_category', 'with_front' => true,  'hierarchical' => true, ],
		"show_admin_column" => true,
		"show_in_rest" => true,
		"rest_base" => "sample_category",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"show_in_quick_edit" => true,
		"show_in_graphql" => false,
	];
	register_taxonomy( "sample_category", [ "sample" ], $args );
}
add_action( 'init', 'cptui_register_my_taxes' );
