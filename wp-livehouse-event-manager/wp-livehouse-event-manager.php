<?php
/*
Plugin Name: Livehouse Event Manager
Description: ライブハウス向けイベント管理プラグインのベース。
Version: 0.1.0
Author: 20m61
Text Domain: wp-livehouse-event-manager
Domain Path: /languages
*/

// セキュリティ: 直接アクセス防止
if (! defined('ABSPATH')) {
    exit;
}

// プラグイン有効化時の処理
function wlem_activate()
{
    // 必要な初期化処理
}
register_activation_hook(__FILE__, 'wlem_activate');

// プラグイン無効化時の処理
function wlem_deactivate()
{
    // 必要なクリーンアップ処理
}
register_deactivation_hook(__FILE__, 'wlem_deactivate');

// 管理画面メニュー追加サンプル
add_action('admin_menu', function () {
    add_menu_page(
        'Livehouse Event Manager',
        'Livehouse Events',
        'manage_options',
        'wlem_main',
        'wlem_settings_page',
        'dashicons-calendar-alt'
    );
});

function wlem_settings_page()
{
    echo '<div class="wrap"><h1>Livehouse Event Manager 設定</h1><p>ここに設定ページの内容を追加します。</p></div>';
}

// 国際化対応
function wlem_load_textdomain()
{
    load_plugin_textdomain('wp-livehouse-event-manager', false, dirname(plugin_basename(__FILE__)) . '/languages');
}
add_action('plugins_loaded', 'wlem_load_textdomain');
