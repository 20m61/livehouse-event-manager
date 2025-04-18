<?php
// アンインストール時の処理
if (! defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}
// ここにデータベースやオプションの削除処理を記述できます
// 例: delete_option('wlem_options');