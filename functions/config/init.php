<?php
/* Base settings
======================================*/

/**
 * 【管理画面】更新の無効化
 */
if (UPDATE_DISABLED) {
	// 管理者以外に対して実行
	if (!current_user_can('administrator')) {
		// すべての自動更新を無効化
		add_filter('automatic_updater_disabled', '__return_true');
		// 本体バージョンの更新非通知
		add_filter('pre_site_transient_update_core', '__return_null');
		// プラグインの更新非通知
		add_filter('pre_site_transient_update_plugins', '__return_null');
		// テーマファイルの更新非通知
		add_filter( 'pre_site_transient_update_themes', '__return_null');
	}
}



/**
 * wp_head内の不要な項目の削除
 */
if (REMOVE_WP_HEAD_ITEMS) {
	remove_action('wp_head', 'feed_links', 2);
	remove_action('wp_head', 'feed_links_extra', 3);
	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'wlwmanifest_link');
	remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');
	remove_action('wp_head', 'wp_generator');
	remove_action('wp_head', 'rel_canonical');
	remove_action('wp_head', 'index_rel_link');
	remove_action('wp_head', 'parent_post_rel_link', 10, 0);
	remove_action('wp_head', 'start_post_rel_link', 10, 0);
	remove_action('wp_head', 'wp_shortlink_wp_head');
	remove_action('wp_head', 'print_emoji_detection_script', 7);
	remove_action('wp_head', 'wp_oembed_add_discovery_links');
	remove_action('wp_head', 'rest_output_link_wp_head');
	remove_action('wp_head', 'wp_oembed_add_host_js');
	remove_action('wp_print_styles', 'print_emoji_styles');
}



/**
 * WordPress標準で読み込むjQueryの削除
 */
function delete_wp_jquery() {
	if(!is_admin())
		wp_deregister_script('jquery');
}
if (DELETE_WP_JQUERY)
	add_action('wp_enqueue_scripts', 'delete_wp_jquery');



/**
 * css, js
 */
function _s_scripts() {
	wp_enqueue_style('_s-style', get_stylesheet_uri(), array(), false);
	wp_enqueue_script('_s-ajaxzip3', get_template_directory_uri() . '/assets/js/ajaxzip3.js', array(), false, true);
	wp_enqueue_script('_s-script', get_template_directory_uri() . '/assets/js/script.js', array(), false, true);
}
add_action('wp_enqueue_scripts', '_s_scripts');



/**
 * title-tag
 */
add_theme_support( 'title-tag' );

function custom_title_separator($sep) {
	$sep = '|';
	return $sep;
}
add_filter('document_title_separator', 'custom_title_separator');



/**
 * 記事公開時にタイトルに日付を付与する
 */
// function add_date_to_title() {
// 	if (!empty($_POST['publish']) && $_POST['post_type'] == 'calendar') {
// 		$args = $_POST;
// 		$post_title = $_POST['post_title'] . '__' . date('Ymd');
// 		$args['post_title'] = $post_title;
// 		wp_update_post($args);
// 	}
// 	add_action('save_post', 'update_post');
// }
// add_action( 'new_to_publish', 'add_date_to_title' );
// add_action( 'pending_to_publish', 'add_date_to_title' );
// add_action( 'draft_to_publish', 'add_date_to_title' );
// add_action( 'auto-draft_to_publish', 'add_date_to_title' );
// add_action( 'future_to_publish', 'add_date_to_title' );
// add_action( 'private_to_publish', 'add_date_to_title' );



/**
 * description,keywords
 */
remove_filter('term_description','wpautop');
add_action('admin_menu', 'add_custom_fields');
add_action('save_post', 'save_custom_fields');

// カスタムフィールドを表示
function add_custom_fields() {
	add_meta_box('my_sectionid', 'ページの説明（160文字以内）', 'my_custom_fields', 'post');
	add_meta_box('my_sectionid', 'ページの説明（160文字以内）', 'my_custom_fields', 'page');
	add_meta_box('my_sectionid', 'ページの説明（160文字以内）', 'my_custom_fields', 'sample');
}
function my_custom_fields() {
	global $post;
	$keywords = get_post_meta($post->ID,'keywords',true);
	$description = get_post_meta($post->ID,'description',true);
	echo '<p>キーワード（半角カンマ区切り）<br>';
	echo '<input type="text" name="keywords" value="'.esc_html($keywords).'" size="60"></p>';
	echo '<p>ページの説明（description）160文字以内<br>';
	echo '<input type="text" style="width: 100%;height: 40px;" name="description" value="'.esc_html($description).'" maxlength="160"></p>';
}

// カスタムフィールドの値を保存
function save_custom_fields( $post_id ) {
	if (!empty($_POST['keywords'])){
		update_post_meta($post_id, 'keywords', $_POST['keywords'] );
	} else {
		delete_post_meta($post_id, 'keywords');
	}
	if (!empty($_POST['description'])){
		update_post_meta($post_id, 'description', $_POST['description'] );
	} else {
		delete_post_meta($post_id, 'description');
	}
}

// 表示
function meta_description() {
	$custom = get_post_custom();
	$description = '';
	$keywords = '';

	if (!empty( $custom['keywords'][0])) {
		$keywords = $custom['keywords'][0];
	}
	if (!empty( $custom['description'][0])) {
		$description = $custom['description'][0];
	}
	if (is_home()) {// トップページ
		echo '<meta name="keywords" content="'.$keywords.'">' . "\n";
		echo '<meta name="description" content="'.get_bloginfo('description').'">' . "\n";
	} elseif (is_single()) {// 記事ページ
		echo '<meta name="keywords" content="'.$keywords.'">' . "\n";
		echo '<meta name="description" content="'.$description.'">' . "\n";
	} elseif (is_page()) {// 固定ページ
		echo '<meta name="keywords" content="'.$keywords.'">' . "\n";
		echo '<meta name="description" content="'.$description.'">' . "\n";
	} elseif (is_archive()) {// 記事ページ
		echo '<meta name="keywords" content="'.$keywords.'">' . "\n";
		echo '<meta name="description" content="'.$description.'">' . "\n";
	} elseif (is_category()) {// カテゴリーページ
		echo '<meta name="description" content="'.single_cat_title().'の記事一覧">' . "\n";
	} elseif (is_tag()) {// タグページ
		echo '<meta name="robots" content="noindex, follow">' . "\n";
		echo '<meta name="description" content="'.single_tag_title("", true).'の記事一覧">' . "\n";
	} elseif (is_404()) {// 404ページ
		echo '<meta name="robots" content="noindex, follow">' . "\n";
		echo '<title>404:お探しのページが見つかりませんでした</title>' . "\n";
	} else {// その他ページ
		echo '<meta name="robots" content="noindex, follow">' . "\n";
	};
}
