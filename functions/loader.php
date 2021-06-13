<?php
// init
include CONFIG_PATH . '/init.php';


// admin
if (is_admin())
	include ADMIN_PATH . '/admin.php';


// post
include ADMIN_PATH . '/post.php';


// custom_posts
if (USE_CUSTOM_POSTS)
	include CONFIG_PATH . '/custom-posts.php';


// contactform7
if (USE_CONTACTFORM7) {
	require CONFIG_PATH . '/contactform7.php';
}


// functins
require FUNCTIONS_PATH . '/functions.php';


// rewrite_rule
if (ADD_REWRITE_RULE)
	require CONFIG_PATH . '/rewrite_rule.php';
