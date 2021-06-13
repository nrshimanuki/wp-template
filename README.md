WP専用ディレクトリ
===

```require_once( dirname( __FILE__ ) . '/wp/wp-blog-header.php' );```

パーマリンクを変更すると .htaccess が書き換えられてしまうので、パーミッションを読み取りのみに変更する
