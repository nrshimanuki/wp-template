<?php
/**
 * アイキャッチ機能を有効化
 */
if(USE_THUMBNAIL)
	add_theme_support('post-thumbnails');



/**
 * 固定ページに抜粋フィールド表示
 */
function page_excerpt() {
	add_post_type_support('page', 'excerpt');
}
// add_action('init', 'page_excerpt');



/**
 * contentの抜粋文字数
 */
function excerpt_length($length) {
	return 28;
}
add_filter('excerpt_length', 'excerpt_length');



/**
 * 特定の投稿タイプ以外は自動整形を無効化
 * お知らせだけは自動整形を有効化
 */
function disable_page_wpautop() {
	if ( (get_post_type() != 'news') ){
		remove_filter('the_content', 'wpautop'); // 記事
		remove_filter('the_excerpt', 'wpautop'); // 抜粋
		remove_filter('the_content', 'wptexturize');
	}
}
if (DISABLE_PAGE_WPAUTOP)
	add_action( 'wp', 'disable_page_wpautop' );



/**
 * 【管理画面】メタボックス削除
 */
function remove_post_support() {
	// remove_post_type_support('post','title'); // タイトル
	// remove_post_type_support('post','editor'); // 本文

	remove_post_type_support('post','revisions'); // リビジョン
	remove_post_type_support('post','trackbacks'); // トラックバック
	remove_post_type_support('post','author'); // 作成者
	remove_post_type_support('post','excerpt'); // 抜粋
	// remove_post_type_support('post','custom-fields'); // カスタムフィールド
	// remove_post_type_support('post','page-attributes'); // 表示順
	// remove_post_type_support('post','post-formats'); // 投稿フォーマット
	if (REMOVE_POST_CATEGORY)
		unregister_taxonomy_for_object_type('category', 'post'); // カテゴリ
	if (REMOVE_POST_TAGS)
		unregister_taxonomy_for_object_type('post_tag', 'post'); // タグ
	if (!USE_THUMBNAIL)
		remove_post_type_support('post','thumbnail'); // アイキャッチ画像
	if (REMOVE_COMMENT)
		remove_post_type_support('post','comments'); // コメント

	// remove_post_type_support('page','revisions'); // リビジョン
	// remove_post_type_support('page','trackbacks'); // トラックバック
	// remove_post_type_support('page','author'); // 作成者
	// remove_post_type_support('page','excerpt'); // 抜粋
	// remove_post_type_support('page','custom-fields'); // カスタムフィールド
	// remove_post_type_support('page','page-attributes'); // 表示順
	// remove_post_type_support('page','post-formats'); // 投稿フォーマット
	// if (!USE_THUMBNAIL)
		// remove_post_type_support('page','thumbnail'); // 固定ページアイキャッチ画像
	if (REMOVE_COMMENT)
		remove_post_type_support('page','comments'); // コメント
}
add_action('init','remove_post_support');



/**
 * shortcode [url] サイトのURLを出力
 */
add_shortcode('url', 'shortcode_url');
function shortcode_url() {
	return get_bloginfo('url');
}

/**
 * shortcode [template] テンプレート・ディレクトリのパスを出力
 */
add_shortcode('template', 'shortcode_tp');
function shortcode_tp() {
	return get_template_directory_uri();
}
