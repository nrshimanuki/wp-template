<?php
/* Settings
======================================*/

/**
 * path
 */
define('FUNCTIONS_PATH', TEMPLATEPATH . '/functions');
define('CONFIG_PATH', FUNCTIONS_PATH . '/config');
define('ADMIN_PATH', FUNCTIONS_PATH . '/admin');


/**
 * init
 */
define('UPDATE_DISABLED', true);
define('REMOVE_WP_HEAD_ITEMS', false);
define('DELETE_WP_JQUERY', false);


/**
 * admin
 */
define('ADD_ADMIN_STYLE', false);
define('REMOVE_FAVICON', false);
define('REMOVE_ADMIN_BAR', false);

// post
define('USE_THUMBNAIL', true);
define('REMOVE_COMMENT', true);
define('REMOVE_POST_TAGS', true);
define('REMOVE_POST_CATEGORY', false);
define('REMOVE_THEME_SUPPORT', true);

// 外観 カスタマイズ非表示
define('DISALLOW_CUSTOMIZE', true);

// 外観 テーマエディタ非表示
define('DISALLOW_FILE_EDIT', true);



/**
 * custom_posts
 */
define('USE_CUSTOM_POSTS', true);
define('CHANGE_POST_LABEL', false);


/**
 * contactform7
 */
define('USE_CONTACTFORM7', true);


/**
 * functins
 */
define('DISABLE_PAGE_WPAUTOP', false);
define('REMOVE_WPAUTOP', true);


/**
 * ADD_REWRITE_RULE
 */
define('ADD_REWRITE_RULE', true);



/* include
======================================*/
require FUNCTIONS_PATH . '/loader.php';
