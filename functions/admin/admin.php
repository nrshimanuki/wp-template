<?php
/**
 * 管理画面のスタイル
 */
function add_admin_style() {
	$admin_style = get_template_directory_uri() . '/functions/admin/css/admin.css';
	wp_enqueue_style('original_admin_style', $admin_style);
}
if (ADD_ADMIN_STYLE)
	add_action('admin_enqueue_scripts', 'add_admin_style');



/**
 * ファビコンの削除
 */
function remove_favicon() {
	exit;
}
if (REMOVE_FAVICON)
	add_action('do_faviconico', 'remove_favicon');



/**
 * フロントエンドで管理ツールバーの非表示化
 */
if (REMOVE_ADMIN_BAR)
	add_filter('show_admin_bar', '__return_false');



/**
 * remove_admin_bar_menus
 */
function remove_admin_bar_menus($wp_admin_bar) {
	// $wp_admin_bar->remove_menu('my-account'); // こんにちは、[ユーザー名]さん.
	// $wp_admin_bar->remove_menu('user-info'); // ユーザー / [ユーザー名].
	// $wp_admin_bar->remove_menu('edit-profile'); // ユーザー / プロフィールを編集.
	// $wp_admin_bar->remove_menu('logout'); // ユーザー / ログアウト.

	$wp_admin_bar->remove_menu('wp-logo'); // WordPressロゴ.
	$wp_admin_bar->remove_menu('about'); // WordPressロゴ / WordPressについて.
	$wp_admin_bar->remove_menu('wporg'); // WordPressロゴ / WordPress.org.
	$wp_admin_bar->remove_menu('documentation'); // WordPressロゴ / ドキュメンテーション.
	$wp_admin_bar->remove_menu('support-forums'); // WordPressロゴ / サポート.
	$wp_admin_bar->remove_menu('feedback'); // WordPressロゴ / フィードバック.

	// $wp_admin_bar->remove_menu('site-name'); // サイト名.
	// $wp_admin_bar->remove_menu('view-site'); // サイト名 / サイトを表示.

	// $wp_admin_bar->remove_menu('updates'); // 更新.
	if (REMOVE_COMMENT)
		$wp_admin_bar->remove_menu('comments'); // コメント.

	// $wp_admin_bar->remove_menu('new-content'); // 新規投稿.
	// $wp_admin_bar->remove_menu('new-post'); // 新規投稿 / 投稿.
	// $wp_admin_bar->remove_menu('new-media'); // 新規投稿 / メディア.
	// $wp_admin_bar->remove_menu('new-page'); // 新規投稿 / 固定.
	$wp_admin_bar->remove_menu('new-user'); // 新規投稿 / ユーザー.

	// $wp_admin_bar->remove_menu('menu-toggle'); // メニュー.
}
add_action('admin_bar_menu', 'remove_admin_bar_menus', 999);

//	プラグイン（例）
// function remove_admin_bar_menus_plugins($wp_admin_bar) {
// 	$wp_admin_bar->remove_menu('new-mw-wp-form'); // 新規投稿 / MW WP Form.
// 	$wp_admin_bar->remove_menu('wpseo-menu'); // Yoast SEO.
// 	$wp_admin_bar->remove_menu('all-in-one-seo-pack'); // All in One SEO Pack.
// 	$wp_admin_bar->remove_menu('show_template_file_name_on_top'); // Show Current Template.
// }
// add_action('admin_bar_menu', 'remove_admin_bar_menus_plugins', 100000);
// add_filter('aioseo_show_in_admin_bar', '__return_false'); // All in One SEO Pack.



/**
 * 【管理画面】ダッシュボードの不要な項目削除
 */
function remove_dashboard_widgets() {
	global $wp_meta_boxes;
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_site_health']); // サイトヘルスステータス
	// unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']); // 現在の状況(概要)
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']); // アクティビティ
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']); // クイックドラフト(クイック投稿)
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']); // WordPressブログ
	// unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']); // 被リンク
	// unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']); // プラグイン
	// unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']); // 最近の下書き
	// unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']); // フォーラム
	// unset($wp_meta_boxes['dashboard']['normal']['core']['jetpack_summary_widget']); // jetpack
	if (REMOVE_COMMENT)
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']); // 最近のコメント
}
add_action('wp_dashboard_setup', 'remove_dashboard_widgets' );
remove_action('welcome_panel', 'wp_welcome_panel'); //ようこそ



/**
 * 【管理画面】メディアの位置移動
 */
function customize_menus(){
	global $menu;
	$menu[57] = $menu[4]; // セパレータ
	$menu[58] = $menu[10]; // メディア
	unset($menu[10]);
}
add_action('admin_menu', 'customize_menus');



/**
 * remove_menus
 */
function remove_menus() {
	if (!current_user_can('administrator')) {
	// 管理者以外の場合
	}

	if ( current_user_can( 'administrator' ) ) {
	// 管理者の場合
	} elseif ( current_user_can( 'editor' ) ) {
	// 編集者の場合
	} elseif ( current_user_can( 'author' ) ) {
	// 投稿者の場合
	} elseif ( current_user_can( 'contributor' ) ) {
	// 寄稿者の場合
	} elseif ( current_user_can( 'subscriber' ) ) {
	// 購読者の場合
	}

	// --- ダッシュボード ---
	// remove_menu_page( 'index.php' ); // ダッシュボード
	// remove_submenu_page( 'index.php', 'index.php' ); // ダッシュボード / ホーム.
	// remove_submenu_page( 'index.php', 'update-core.php' ); // ダッシュボード / 更新.

	// --- 投稿 ---
	// remove_menu_page( 'edit.php' ); // 投稿
	// remove_submenu_page( 'edit.php', 'edit.php' ); // 投稿 / 投稿一覧.
	// remove_submenu_page( 'edit.php', 'post-new.php' ); // 投稿 / 新規追加.
	if (REMOVE_POST_CATEGORY)
		remove_submenu_page( 'edit.php', 'edit-tags.php?taxonomy=category' ); // 投稿 / カテゴリー.
	if (REMOVE_POST_TAGS)
		remove_submenu_page( 'edit.php', 'edit-tags.php?taxonomy=post_tag' ); // 投稿 / タグ.

	// --- メディア ---
	// remove_menu_page( 'upload.php' ); // メディア
	// remove_submenu_page( 'upload.php', 'upload.php' ); // メディア / ライブラリ.
	// remove_submenu_page( 'upload.php', 'media-new.php' ); // メディア / 新規追加.

	// --- 固定 ---
	// remove_menu_page( 'edit.php?post_type=page' ); // 固定
	// remove_submenu_page( 'edit.php?post_type=page', 'edit.php?post_type=page' ); // 固定 / 固定ページ一覧.
	// remove_submenu_page( 'edit.php?post_type=page', 'post-new.php?post_type=page' ); // 固定 / 新規追加.

	// --- コメント ---
	if (REMOVE_COMMENT)
		remove_menu_page( 'edit-comments.php' );

	// --- 外観 ---
	// remove_menu_page( 'themes.php' ); // 外観
	// remove_submenu_page( 'themes.php', 'themes.php' ); // 外観 / テーマ.
	if (DISALLOW_CUSTOMIZE)
		remove_submenu_page( 'themes.php', 'customize.php?return=' . rawurlencode( $_SERVER['REQUEST_URI'] ) ); // 外観 / カスタマイズ.
	// remove_submenu_page( 'themes.php', 'nav-menus.php' ); // 外観 / メニュー.
	// remove_submenu_page( 'themes.php', 'widgets.php' ); // 外観 / ウィジェット.
	if (DISALLOW_FILE_EDIT)
		remove_submenu_page( 'themes.php', 'theme-editor.php' ); // 外観 / テーマエディタ.

	// --- プラグイン ---
	// remove_menu_page( 'plugins.php' ); // プラグイン
	// remove_submenu_page( 'plugins.php', 'plugins.php' ); // プラグイン / インストール済みプラグイン.
	// remove_submenu_page( 'plugins.php', 'plugin-install.php' ); // プラグイン / 新規追加.
	remove_submenu_page( 'plugins.php', 'plugin-editor.php' ); // プラグイン / プラグインエディタ.

	// --- ユーザー ---
	// remove_menu_page( 'users.php' ); // ユーザー
	// remove_submenu_page( 'users.php', 'users.php' ); // ユーザー / ユーザー一覧.
	// remove_submenu_page( 'users.php', 'user-new.php' ); // ユーザー / 新規追加.
	// remove_submenu_page( 'users.php', 'profile.php' ); // ユーザー / あなたのプロフィール.

	// --- ツール ---
	// remove_menu_page( 'tools.php' ); // ツール
	// remove_submenu_page( 'tools.php', 'tools.php' ); // ツール / 利用可能なツール.
	// remove_submenu_page( 'tools.php', 'import.php' ); // ツール / インポート.
	// remove_submenu_page( 'tools.php', 'export.php' ); // ツール / エクスポート.
	// remove_submenu_page( 'tools.php', 'site-health.php' ); // ツール / サイトヘルス.
	// remove_submenu_page( 'tools.php', 'export_personal_data' ); // ツール / 個人データのエクスポート.
	// remove_submenu_page( 'tools.php', 'remove_personal_data' ); // ツール / 個人データの消去.

	// --- 設定 ---
	// remove_menu_page( 'options-general.php' ); // 設定
	// remove_submenu_page( 'options-general.php', 'options-general.php' ); // 設定 / 一般.
	// remove_submenu_page( 'options-general.php', 'options-writing.php' ); // 設定 / 投稿設定.
	// remove_submenu_page( 'options-general.php', 'options-reading.php' ); // 設定 / 表示設定.
	if (REMOVE_COMMENT)
		remove_submenu_page( 'options-general.php', 'options-discussion.php' ); // 設定 / ディスカッション.
	// remove_submenu_page( 'options-general.php', 'options-media.php' ); // 設定 / メディア.
	// remove_submenu_page( 'options-general.php', 'options-permalink.php' ); // 設定 / メディア.
	// remove_submenu_page( 'options-general.php', 'privacy.php' ); // 設定 / プライバシー.

	// プラグイン（例）
	// remove_menu_page( 'wpcf7' ); // Contact Form 7.
	// remove_menu_page( 'edit.php?post_type=mw-wp-form' ); // MW WP Form.
	// remove_menu_page( 'all-in-one-seo-pack/aioseop_class.php' ); // All In One SEO Pack.
	// remove_submenu_page( 'tools.php', 'aiosp_import' ); // All In One SEO Pack.
	// remove_menu_page( 'wpseo_dashboard' ); // Yoast SEO.
	// remove_menu_page( 'jetpack' ); // Jetpack.
	// remove_menu_page( 'edit.php?post_type=acf-field-group' ); // Advanced Custom Fields.
	// remove_menu_page( 'cptui_main_menu' ); // Custom Post Type UI.
	// remove_menu_page( 'backwpup' ); // BackWPup.
	// remove_menu_page( 'ai1wm_export' ); // All-in-One WP Migration.
	// remove_menu_page( 'advgb_main' ); // Advanced Gutenberg.
	// remove_submenu_page( 'options-general.php', 'tinymce-advanced' ); // TinyMCE Advanced.
	// remove_submenu_page( 'options-general.php', 'table-of-contents' ); // Table of Contents Plus.
	// remove_submenu_page( 'options-general.php', 'duplicatepost' ); // Duplicate Post.
	// remove_submenu_page( 'upload.php', 'ewww-image-optimizer-bulk' ); // EWWWW.
	// remove_submenu_page( 'options-general.php', 'ewww-image-optimizer/ewww-image-optimizer.php' ); // EWWWW.
}
add_action('admin_menu', 'remove_menus', 999);

// remove_customs
function remove_customs() {
	remove_theme_support('custom-header');
	remove_theme_support('custom-background');
}
if (REMOVE_THEME_SUPPORT)
	add_action('after_setup_theme', 'remove_customs');



/**
 * 記事一覧画面の不要な項目を削除
 */
function custom_columns($columns) {
	if (REMOVE_POST_TAGS)
		unset($columns['tags']);

	if (REMOVE_COMMENT)
		unset($columns['comments']);

	return $columns;
}
add_filter('manage_posts_columns', 'custom_columns');
add_filter('manage_pages_columns', 'custom_columns');
