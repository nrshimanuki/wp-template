<?php
/**
 * ページ遷移時のリダイレクトを阻止する
 */
function disable_redirect_canonical($redirect_url) {
	if (is_single()) {
		//リクエストURLに「/page/」があれば、リダイレクトしない
		preg_match('/\/paged\//', $redirect_url, $matches);
		if ($matches) {
			$redirect_url = false;
			return $redirect_url;
		}
	}
}
add_filter('redirect_canonical', 'disable_redirect_canonical');



/**
 * rewrite_rule
 */
// add_rewrite_rule('blog/([^0-9][^/]+)/?$', 'index.php?blog_category=$matches[1]', 'top');
// add_rewrite_rule('blog/([^0-9][^/]+)/?/page/?([0-9]{1,})/?$', 'index.php?blog_category=$matches[1]&paged=$matches[2]', 'top');
// add_rewrite_rule('news/([^0-9][^/]+)/?$', 'index.php?news_category=$matches[1]', 'top');
// add_rewrite_rule('news/([^0-9][^/]+)/page/?([0-9]{1,})/?$', 'index.php?news_category=$matches[1]&paged=$matches[2]', 'top');
add_rewrite_rule('sample/([^0-9][^/]+)/?$', 'index.php?sample_category=$matches[1]', 'top');
add_rewrite_rule('sample/([^0-9][^/]+)/?/page/?([0-9]{1,})/?$', 'index.php?sample_category=$matches[1]&paged=$matches[2]', 'top');

// var_dump(get_option('rewrite_rules'));
