<?php

/**
 * contactform7 p,brタグを削除
 */
add_filter('wpcf7_autop_or_not', '__return_false');



/**
 * contactform7 メールアドレス再確認チェック
 */
function wpcf7_validate_email_filter_confrim( $result, $tag ) {
	$type = $tag['type'];
	$name = $tag['name'];
	if ( 'email' == $type || 'email*' == $type ) {
		if (preg_match('/(.*)_confirm$/', $name, $matches)){ //確認用メルアド入力フォーム名を ○○○_confirm
			$target_name = $matches[1];
				$posted_value = trim( (string) $_POST[$name] ); //前後空白の削除
				$posted_target_value = trim( (string) $_POST[$target_name] ); //前後空白の削除
			if ($posted_value != $posted_target_value) {
				$result->invalidate( $tag,"確認用のメールアドレスが一致していません");
			}
		}
	}
	return $result;
}
add_filter( 'wpcf7_validate_email', 'wpcf7_validate_email_filter_confrim', 11, 2 );
add_filter( 'wpcf7_validate_email*', 'wpcf7_validate_email_filter_confrim', 11, 2 );



/**
 * Contact Form 7のエラーメッセージの場所を必要な項目のみ変更
 */
function wpcf7_custom_item_error_position( $items, $result ) {
	// メッセージを表示させたい場所のタグのエラー用のクラス名
	$class = 'wpcf7-custom-item-error';
	// メッセージの位置を変更したい項目名
	$names = array( 'birth', 'month', 'month_day', 'age' );

	// 入力エラーがある場合
	if ( isset( $items['invalidFields'] ) ) {
		foreach ( $items['invalidFields'] as $k => $v ) {
			$orig = $v['into'];
			$name = substr( $orig, strrpos($orig, ".") + 1 );
			// 位置を変更したい項目のみ、エラーを設定するタグのクラス名を差替
			if ( in_array( $name, $names ) ) {
				$items['invalidFields'][$k]['into'] = ".{$class}.{$name}";
			}
		}
	}
	return $items;
}
add_filter('wpcf7_ajax_json_echo', 'wpcf7_custom_item_error_position', 10, 2);
