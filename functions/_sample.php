<?php

/**
 * カレンダーの予約投稿機能を無効にする
 */
// function stop_post_status_future_func($data, $postarr) {
// 	if (($data['post_type'] == 'calendar' && $data['post_status'] == 'future') && $postarr['post_status'] == 'publish') {
// 		$data['post_status'] = 'publish';
// 	}
// 	return $data;
// };
// add_filter( 'wp_insert_post_data', 'stop_post_status_future_func', 10, 2 );



/** ========================================
 * パンくず
 */
function breadcrumbs_list() {
	echo '<ol class="bread_list">' . "\n";

	$home = '<li class="bread_item"><a class="bread_link" href="/">TOP</a></li>' . "\n";
	$current_category_name = single_cat_title('', false);
	$post_title = get_the_title();

	if (is_category()) {
		$current_page_data = sanitize_post($GLOBALS['wp_the_query']->get_queried_object());
		$parent_id = $current_page_data->parent;
		$category_list = array();
		// array_unshift($category_list, '<li class="bread_item"><span> &gt; </span><a class="bread_link" href="/news/">お知らせ</a></li>' . "\n");
		while ($parent_id != 0) {
			$parent_category_data = get_category($parent_id);
			$parent_category_slug = $parent_category_data->slug;
			$parent_category_name = $parent_category_data->name;
			$parent_category_link = get_category_link($parent_id);
			array_unshift($category_list, '<li class="bread_item"><span> &gt; </span><a class="bread_link" href="' . $parent_category_link . '">' . $parent_category_name . '</a></li>' . "\n");
			$parent_id = $parent_category_data->parent;
		}
		echo $home;
		foreach($category_list as $category) {
			echo $category;
		}
		echo '<li class="bread_item"><span> &gt; </span><span class="bread_link">' . $current_category_name . '</span></li>' . "\n";

	} elseif (is_archive()) {
		echo $home;
		echo '<li class="bread_item"><span> &gt; </span><span class="bread_link">' . $current_category_name . '</span></li>' . "\n";
		// the_archive_title('<li class="bread_item"><span> &gt; </span><span class="bread_link">', '</span></li>'  . "\n");

	} elseif (is_single()) {
		$category_data = get_the_category();
		$category_data = $category_data[0];
		if (isset($category_data->cat_ID)) {
			$category_id = $category_data->cat_ID;
		}
		$category_list = array();
		while ($category_id != 0) {
			$category_data = get_category( $category_id );
			$category_link = get_category_link( $category_id );
			array_unshift($category_list, '<li class="bread_item"><span> &gt; </span><a class="bread_link" href="' . $category_link . '">' . $category_data->name . '</a></li>' . "\n");
			$category_id = $category_data->parent;
		}
		echo $home;
		foreach($category_list as $category) {
			echo $category;
		}
		echo '<li class="bread_item"><span> &gt; </span><span class="bread_link">' . $post_title . '</span></li>' . "\n";

	} elseif (is_page()) {
		$ancestors_ids = array_reverse(get_post_ancestors(get_the_ID()));
		$category_list = array();
		foreach($ancestors_ids as $ancestors_id){
			array_unshift($category_list, '<li class="bread_item"><span> &gt; </span><a class="bread_link" href="' . get_page_link($ancestors_id) . '">' . get_page($ancestors_id)->post_title . '</a></li>' . "\n");
		}
		echo $home;
		foreach($category_list as $category) {
			echo $category;
		}
		echo '<li class="bread_item"><span> &gt; </span><span class="bread_link">' . $post_title . '</span></li>' . "\n";

	} elseif (is_search()) {
		echo $home;
		echo '<li class="bread_item"><span> &gt; </span><span class="bread_link">「' . get_search_query() . '」の検索結果</span></li>' . "\n";

	} elseif (is_404()) {
		echo $home;
		echo '<li class="bread_item"><span> &gt; </span><span class="bread_link">ページが存在しません</span></li>' . "\n";

	} else {
		echo $home;
	}

	echo '</ol>' . "\n";
}





/** ========================================
 * アーカイブの余計なタイトルを削除
 */
add_filter('get_the_archive_title', function ($title) {
	if (is_category()) {
		$title = single_cat_title('', false);
	} elseif (is_tag()) {
		$title = single_tag_title('', false);
	} elseif (is_tax()) {
		$title = single_term_title('', false);
	} elseif (is_post_type_archive() ){
		$title = post_type_archive_title('', false);
	} elseif (is_date()) {
		$title = get_the_time('Y年n月');
	} elseif (is_search()) {
		$title = '検索結果：' . esc_html(get_search_query(false));
	} elseif (is_404()) {
		$title = '「404」ページが見つかりません';
	} else {
	}
	return $title;
});




/** ========================================
 * カレンダーの予約投稿機能を無効にする
 */
function stop_post_status_future_func($data, $postarr) {
	if (($data['post_type'] == 'calendar' && $data['post_status'] == 'future') && $postarr['post_status'] == 'publish') {
		$data['post_status'] = 'publish';
	}
	return $data;
};
add_filter( 'wp_insert_post_data', 'stop_post_status_future_func', 10, 2 );



/** ========================================
 * カレンダーにイベント表示
 */
function get_cpt_calendar($cpt, $initial = true, $echo = true) {
	global $wpdb, $m, $monthnum, $year, $wp_locale, $posts;

	$cache = array();
	$key = md5( $m . $monthnum . $year );
	if ( $cache = wp_cache_get( 'get_calendar', 'calendar' ) ) {
		if ( is_array($cache) && isset( $cache[ $key ] ) ) {
			if ( $echo ) {
				echo apply_filters( 'get_calendar',  $cache[$key] );
				return;
			} else {
				return apply_filters( 'get_calendar',  $cache[$key] );
			}
		}
	}

	if ( !is_array($cache) )
		$cache = array();

	// Quick check. If we have no posts at all, abort!
	if ( !$posts ) {
		$gotsome = $wpdb->get_var("SELECT 1 as test FROM $wpdb->posts WHERE post_type = '$cpt' AND post_status = 'publish' LIMIT 1");
		if ( !$gotsome ) {
			$cache[ $key ] = '';
			wp_cache_set( 'get_calendar', $cache, 'calendar' );
			return;
		}
	}

	if ( isset($_GET['w']) )
		$w = ''.intval($_GET['w']);

	// week_begins = 0 stands for Sunday
	$week_begins = intval(get_option('start_of_week'));

	// Let's figure out when we are
	if ( !empty($monthnum) && !empty($year) ) {
		$thismonth = ''.zeroise(intval($monthnum), 2);
		$thisyear = ''.intval($year);
	} elseif ( !empty($w) ) {
		// We need to get the month from MySQL
		$thisyear = ''.intval(substr($m, 0, 4));
		$d = (($w - 1) * 7) + 6; //it seems MySQL's weeks disagree with PHP's
		$thismonth = $wpdb->get_var("SELECT DATE_FORMAT((DATE_ADD('{$thisyear}0101', INTERVAL $d DAY) ), '%m')");
	} elseif ( !empty($m) ) {
		$thisyear = ''.intval(substr($m, 0, 4));
		if ( strlen($m) < 6 )
				$thismonth = '01';
		else
				$thismonth = ''.zeroise(intval(substr($m, 4, 2)), 2);
	} else {
		$thisyear = gmdate('Y', current_time('timestamp'));
		$thismonth = gmdate('m', current_time('timestamp'));
	}

	$unixmonth = mktime(0, 0 , 0, $thismonth, 1, $thisyear);
	$last_day = date('t', $unixmonth);

	// Get the next and previous month and year with at least one post
	$previous = $wpdb->get_row("SELECT MONTH(post_date) AS month, YEAR(post_date) AS year
		FROM $wpdb->posts
		WHERE post_date < '$thisyear-$thismonth-01'
		AND post_type = '$cpt' AND post_status = 'publish'
			ORDER BY post_date DESC
			LIMIT 1");
	$next = $wpdb->get_row("SELECT MONTH(post_date) AS month, YEAR(post_date) AS year
		FROM $wpdb->posts
		WHERE post_date > '$thisyear-$thismonth-{$last_day} 23:59:59'
		AND post_type = '$cpt' AND post_status = 'publish'
			ORDER BY post_date ASC
			LIMIT 1");

	/* translators: Calendar caption: 1: month name, 2: 4-digit year */
	// $calendar_caption = _x('%1$s %2$s', 'calendar caption');
	$calendar_caption = _x('%1$s', 'calendar caption');
	$calendar_output = '<table id="wp-calendar" class="event_table">
	<caption>' . sprintf($calendar_caption, $wp_locale->get_month($thismonth), date('Y', $unixmonth)) . 'のイベント情報</caption>
	<thead>
	<tr>';

	$myweek = array();

	for ( $wdcount=0; $wdcount<=6; $wdcount++ ) {
		// $myweek[] = $wp_locale->get_weekday(($wdcount+$week_begins)%7);
		$myweek[] = $wp_locale->get_weekday(($wdcount)%7);
	}

	foreach ( $myweek as $wd ) {
		$day_name = (true == $initial) ? $wp_locale->get_weekday_initial($wd) : $wp_locale->get_weekday_abbrev($wd);
		$wd = esc_attr($wd);
		$calendar_output .= "\n\t\t<th scope=\"col\" title=\"$wd\">$day_name</th>";
	}

	$calendar_output .= '
	</tr>
	</thead>
	';

	$calendar_output .= '

	<tbody>
	<tr>';

	// Get days with posts
	$dayswithposts = $wpdb->get_results("SELECT DISTINCT DAYOFMONTH(post_date)
		FROM $wpdb->posts WHERE post_date >= '{$thisyear}-{$thismonth}-01 00:00:00'
		AND post_type = '$cpt' AND post_status = 'publish'
		AND post_date <= '{$thisyear}-{$thismonth}-{$last_day} 23:59:59'", ARRAY_N);
	if ( $dayswithposts ) {
		foreach ( (array) $dayswithposts as $daywith ) {
			$daywithpost[] = $daywith[0];
		}
	} else {
		$daywithpost = array();
	}

	if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false || stripos($_SERVER['HTTP_USER_AGENT'], 'camino') !== false || stripos($_SERVER['HTTP_USER_AGENT'], 'safari') !== false)
		$ak_title_separator = "\n";
	else
		$ak_title_separator = ', ';

	$ak_titles_for_day = array();
	$ak_post_titles = $wpdb->get_results("SELECT ID, post_title, DAYOFMONTH(post_date) as dom "
		."FROM $wpdb->posts "
		."WHERE post_date >= '{$thisyear}-{$thismonth}-01 00:00:00' "
		."AND post_date <= '{$thisyear}-{$thismonth}-{$last_day} 23:59:59' "
		."AND post_type = '$cpt' AND post_status = 'publish'"
	);
	if ( $ak_post_titles ) {
		foreach ( (array) $ak_post_titles as $ak_post_title ) {

				/** This filter is documented in wp-includes/post-template.php */
				$post_title = esc_attr( apply_filters( 'the_title', $ak_post_title->post_title, $ak_post_title->ID ) );

				if ( empty($ak_titles_for_day['day_'.$ak_post_title->dom]) )
					$ak_titles_for_day['day_'.$ak_post_title->dom] = '';
				if ( empty($ak_titles_for_day["$ak_post_title->dom"]) ) // first one
					$ak_titles_for_day["$ak_post_title->dom"] = $post_title;
				else
					$ak_titles_for_day["$ak_post_title->dom"] .= $ak_title_separator . $post_title;
		}
	}

	// See how much we should pad in the beginning
	// $pad = calendar_week_mod(date('w', $unixmonth)-$week_begins);
	$pad = calendar_week_mod(date('w', $unixmonth));
	if ( 0 != $pad )
		$calendar_output .= "\n\t\t".'<td colspan="'. esc_attr($pad) .'" class="pad">&nbsp;</td>';

	$daysinmonth = intval(date('t', $unixmonth));
	for ( $day = 1; $day <= $daysinmonth; ++$day ) {
		if ( isset($newrow) && $newrow )
			$calendar_output .= "\n\t</tr>\n\t<tr>\n\t\t";
		$newrow = false;

		if ( $day == gmdate('j', current_time('timestamp')) && $thismonth == gmdate('m', current_time('timestamp')) && $thisyear == gmdate('Y', current_time('timestamp')) )
			$calendar_output .= '<td id="today">';
		else
			$calendar_output .= '<td>';

		if ( in_array($day, $daywithpost) ) // any posts today?
				// $calendar_output .= '<a class="event_link" href="' . get_day_link( $thisyear, $thismonth, $day ) . '?post_type='.$cpt.'" title="' . esc_attr( $ak_titles_for_day[ $day ] ) . "\">$day</a>";
				$calendar_output .= '<a class="event_link" href="/calendar/' . esc_attr( $ak_titles_for_day[ $day ] ) . '" title="' . esc_attr( $ak_titles_for_day[ $day ] ) . "\">$day</a>";
		else
			$calendar_output .= $day;
		$calendar_output .= '</td>';

		// if ( 6 == calendar_week_mod(date('w', mktime(0, 0 , 0, $thismonth, $day, $thisyear))-$week_begins) )
		if ( 6 == calendar_week_mod(date('w', mktime(0, 0 , 0, $thismonth, $day, $thisyear))) )
			$newrow = true;
	}

	// $pad = 7 - calendar_week_mod(date('w', mktime(0, 0 , 0, $thismonth, $day, $thisyear))-$week_begins);
	$pad = 7 - calendar_week_mod(date('w', mktime(0, 0 , 0, $thismonth, $day, $thisyear)));
	if ( $pad != 0 && $pad != 7 )
		$calendar_output .= "\n\t\t".'<td class="pad" colspan="'. esc_attr($pad) .'">&nbsp;</td>';

	$calendar_output .= "\n\t</tr>\n\t</tbody>\n\t</table>";

	$cache[ $key ] = $calendar_output;
	wp_cache_set( 'get_calendar', $cache, 'calendar' );

	if ( $echo )
		echo apply_filters( 'get_calendar',  $calendar_output );
	else
		return apply_filters( 'get_calendar',  $calendar_output );

}

function get_cpt_calendar_next($cpt, $initial = true, $echo = true) {
	global $wpdb, $m, $monthnum, $year, $wp_locale, $posts;

	$cache = array();
	$key = md5( $m . ($monthnum + 1) . $year );
	if ( $cache = wp_cache_get( 'get_calendar', 'calendar' ) ) {
		if ( is_array($cache) && isset( $cache[ $key ] ) ) {
			if ( $echo ) {
				echo apply_filters( 'get_calendar',  $cache[$key] );
				return;
			} else {
				return apply_filters( 'get_calendar',  $cache[$key] );
			}
		}
	}

	if ( !is_array($cache) )
		$cache = array();

	// Quick check. If we have no posts at all, abort!
	if ( !$posts ) {
		$gotsome = $wpdb->get_var("SELECT 1 as test FROM $wpdb->posts WHERE post_type = '$cpt' AND post_status = 'publish' LIMIT 1");
		if ( !$gotsome ) {
			$cache[ $key ] = '';
			wp_cache_set( 'get_calendar', $cache, 'calendar' );
			return;
		}
	}

	if ( isset($_GET['w']) )
		$w = ''.intval($_GET['w']);

	// week_begins = 0 stands for Sunday
	$week_begins = intval(get_option('start_of_week'));

	// Let's figure out when we are
	if ( !empty($monthnum) && !empty($year) ) {
		$thismonth = ''.zeroise(intval($monthnum), 2);
		$thisyear = ''.intval($year);
	} elseif ( !empty($w) ) {
		// We need to get the month from MySQL
		$thisyear = ''.intval(substr($m, 0, 4));
		$d = (($w - 1) * 7) + 6; //it seems MySQL's weeks disagree with PHP's
		$thismonth = $wpdb->get_var("SELECT DATE_FORMAT((DATE_ADD('{$thisyear}0101', INTERVAL $d DAY) ), '%m')");
	} elseif ( !empty($m) ) {
		$thisyear = ''.intval(substr($m, 0, 4));
		if ( strlen($m) < 6 )
				$thismonth = '01';
		else
				$thismonth = ''.zeroise(intval(substr($m, 4, 2)), 2);
	} else {
		// $thisyear = gmdate('Y', current_time('timestamp'));
		// $thismonth = gmdate('m', current_time('timestamp'));
		$date_next = new DateTime();
		$date_next->add(new DateInterval('P1M'));
		$thisyear = $date_next->format('Y');
		$thismonth = $date_next->format('m');
	}

	$unixmonth = mktime(0, 0 , 0, $thismonth, 1, $thisyear);
	$last_day = date('t', $unixmonth);

	// Get the next and previous month and year with at least one post
	$previous = $wpdb->get_row("SELECT MONTH(post_date) AS month, YEAR(post_date) AS year
		FROM $wpdb->posts
		WHERE post_date < '$thisyear-$thismonth-01'
		AND post_type = '$cpt' AND post_status = 'publish'
			ORDER BY post_date DESC
			LIMIT 1");
	$next = $wpdb->get_row("SELECT MONTH(post_date) AS month, YEAR(post_date) AS year
		FROM $wpdb->posts
		WHERE post_date > '$thisyear-$thismonth-{$last_day} 23:59:59'
		AND post_type = '$cpt' AND post_status = 'publish'
			ORDER BY post_date ASC
			LIMIT 1");

	/* translators: Calendar caption: 1: month name, 2: 4-digit year */
	// $calendar_caption = _x('%1$s %2$s', 'calendar caption');
	$calendar_caption = _x('%1$s', 'calendar caption');
	$calendar_output = '<table id="wp-calendar" class="event_table">
	<caption>' . sprintf($calendar_caption, $wp_locale->get_month($thismonth), date('Y', $unixmonth)) . 'のイベント情報</caption>
	<thead>
	<tr>';

	$myweek = array();

	for ( $wdcount=0; $wdcount<=6; $wdcount++ ) {
		// $myweek[] = $wp_locale->get_weekday(($wdcount+$week_begins)%7);
		$myweek[] = $wp_locale->get_weekday(($wdcount)%7);
	}

	foreach ( $myweek as $wd ) {
		$day_name = (true == $initial) ? $wp_locale->get_weekday_initial($wd) : $wp_locale->get_weekday_abbrev($wd);
		$wd = esc_attr($wd);
		$calendar_output .= "\n\t\t<th scope=\"col\" title=\"$wd\">$day_name</th>";
	}

	$calendar_output .= '
	</tr>
	</thead>
	';

	$calendar_output .= '

	<tbody>
	<tr>';

	// Get days with posts
	$dayswithposts = $wpdb->get_results("SELECT DISTINCT DAYOFMONTH(post_date)
		FROM $wpdb->posts WHERE post_date >= '{$thisyear}-{$thismonth}-01 00:00:00'
		AND post_type = '$cpt' AND post_status = 'publish'
		AND post_date <= '{$thisyear}-{$thismonth}-{$last_day} 23:59:59'", ARRAY_N);
	if ( $dayswithposts ) {
		foreach ( (array) $dayswithposts as $daywith ) {
			$daywithpost[] = $daywith[0];
		}
	} else {
		$daywithpost = array();
	}

	if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false || stripos($_SERVER['HTTP_USER_AGENT'], 'camino') !== false || stripos($_SERVER['HTTP_USER_AGENT'], 'safari') !== false)
		$ak_title_separator = "\n";
	else
		$ak_title_separator = ', ';

	$ak_titles_for_day = array();
	$ak_post_titles = $wpdb->get_results("SELECT ID, post_title, DAYOFMONTH(post_date) as dom "
		."FROM $wpdb->posts "
		."WHERE post_date >= '{$thisyear}-{$thismonth}-01 00:00:00' "
		."AND post_date <= '{$thisyear}-{$thismonth}-{$last_day} 23:59:59' "
		."AND post_type = '$cpt' AND post_status = 'publish'"
	);
	if ( $ak_post_titles ) {
		foreach ( (array) $ak_post_titles as $ak_post_title ) {

				/** This filter is documented in wp-includes/post-template.php */
				$post_title = esc_attr( apply_filters( 'the_title', $ak_post_title->post_title, $ak_post_title->ID ) );

				if ( empty($ak_titles_for_day['day_'.$ak_post_title->dom]) )
					$ak_titles_for_day['day_'.$ak_post_title->dom] = '';
				if ( empty($ak_titles_for_day["$ak_post_title->dom"]) ) // first one
					$ak_titles_for_day["$ak_post_title->dom"] = $post_title;
				else
					$ak_titles_for_day["$ak_post_title->dom"] .= $ak_title_separator . $post_title;
		}
	}

	// See how much we should pad in the beginning
	// $pad = calendar_week_mod(date('w', $unixmonth)-$week_begins);
	$pad = calendar_week_mod(date('w', $unixmonth));
	if ( 0 != $pad )
		$calendar_output .= "\n\t\t".'<td colspan="'. esc_attr($pad) .'" class="pad">&nbsp;</td>';

	$daysinmonth = intval(date('t', $unixmonth));
	for ( $day = 1; $day <= $daysinmonth; ++$day ) {
		if ( isset($newrow) && $newrow )
			$calendar_output .= "\n\t</tr>\n\t<tr>\n\t\t";
		$newrow = false;

		if ( $day == gmdate('j', current_time('timestamp')) && $thismonth == gmdate('m', current_time('timestamp')) && $thisyear == gmdate('Y', current_time('timestamp')) )
			$calendar_output .= '<td id="today">';
		else
			$calendar_output .= '<td>';

		if ( in_array($day, $daywithpost) ) // any posts today?
				// $calendar_output .= '<a class="event_link" href="' . get_day_link( $thisyear, $thismonth, $day ) . '?post_type='.$cpt.'" title="' . esc_attr( $ak_titles_for_day[ $day ] ) . "\">$day</a>";
				$calendar_output .= '<a class="event_link" href="/calendar/' . esc_attr( $ak_titles_for_day[ $day ] ) . '" title="' . esc_attr( $ak_titles_for_day[ $day ] ) . "\">$day</a>";
		else
			$calendar_output .= $day;
		$calendar_output .= '</td>';

		// if ( 6 == calendar_week_mod(date('w', mktime(0, 0 , 0, $thismonth, $day, $thisyear))-$week_begins) )
		if ( 6 == calendar_week_mod(date('w', mktime(0, 0 , 0, $thismonth, $day, $thisyear))) )
			$newrow = true;
	}

	// $pad = 7 - calendar_week_mod(date('w', mktime(0, 0 , 0, $thismonth, $day, $thisyear))-$week_begins);
	$pad = 7 - calendar_week_mod(date('w', mktime(0, 0 , 0, $thismonth, $day, $thisyear)));
	if ( $pad != 0 && $pad != 7 )
		$calendar_output .= "\n\t\t".'<td class="pad" colspan="'. esc_attr($pad) .'">&nbsp;</td>';

	$calendar_output .= "\n\t</tr>\n\t</tbody>\n\t</table>";

	$cache[ $key ] = $calendar_output;
	wp_cache_set( 'get_calendar', $cache, 'calendar' );

	if ( $echo )
		echo apply_filters( 'get_calendar',  $calendar_output );
	else
		return apply_filters( 'get_calendar',  $calendar_output );

}



/** ========================================
 * カスタムクエリ変数追加
 */
function add_query_vars_filter( $vars ) {
	$vars[] = "calendar_year";
	$vars[] = "calendar_month";
	return $vars;
}
add_filter( 'query_vars', 'add_query_vars_filter' );
