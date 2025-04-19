<?php
/*
Plugin Name: Livehouse Event Manager
Description: ライブハウスやイベントスペース向けのWordPressイベント管理プラグイン。月間カレンダー・リスト表示機能を備え、訪問者にイベント情報を効率的に提供します。
Version: 1.0.0
Author: 20m61
Text Domain: wp-livehouse-event-manager
Domain Path: /languages
*/

// ...existing code...

function wlem_activate()
{
    // 必要な初期化処理
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'wlem_activate');

function wlem_deactivate()
{
    // 必要なクリーンアップ処理
    flush_rewrite_rules();
}
register_deactivation_hook(__FILE__, 'wlem_deactivate');

// ...existing code...