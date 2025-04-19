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

// 1. カスタム投稿タイプ登録
add_action('init', function () {
    register_post_type('live_event', [
        'labels' => [
            'name'               => 'イベント',
            'singular_name'      => 'イベント',
            'add_new_item'       => '新規イベントを追加',
            'edit_item'          => 'イベントを編集',
            'view_item'          => 'イベントを表示',
            'search_items'       => 'イベントを検索',
            'not_found'          => 'イベントが見つかりません',
            'not_found_in_trash' => 'ゴミ箱にイベントが見つかりません',
        ],
        'public'       => true,
        'has_archive'  => true,
        'menu_position' => 5,
        'menu_icon'    => 'dashicons-calendar-alt',
        'supports'     => ['title', 'editor', 'thumbnail'],
    ]);
});

// 2. メタボックス追加
add_action('add_meta_boxes', function () {
    add_meta_box(
        'live_event_details',
        'イベント情報',
        'render_live_event_meta',
        'live_event',
        'normal',
        'high'
    );
});

// 3. メタボックス出力コールバック
function render_live_event_meta($post)
{
    wp_nonce_field('save_live_event_meta', 'live_event_nonce');
    $fields = [
        'event_date'     => '開催日',
        'open_time'      => '開場時間',
        'start_time'     => '開演時間',
        'performer'      => '出演者',
        'ticket_price'   => 'チケット料金',
        'ticket_url'     => 'チケットURL',
        'streaming_info' => '配信情報',
        'genre'          => 'ジャンル',
        'image_url'      => '画像URL',
    ];
    foreach ($fields as $key => $label) {
        $value = get_post_meta($post->ID, $key, true);
        echo '<p><label for="' . esc_attr($key) . '">' . esc_html($label) . '</label><br/>';
        echo '<input type="text" id="' . esc_attr($key) . '" name="' . esc_attr($key)
            . '" value="' . esc_attr($value) . '" style="width:100%;" /></p>';
    }
}

// 4. メタデータ保存処理
add_action('save_post', function ($post_id) {
    if (
        !isset($_POST['live_event_nonce'])
        || !wp_verify_nonce($_POST['live_event_nonce'], 'save_live_event_meta')
    ) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (get_post_type($post_id) !== 'live_event') return;

    $keys = [
        'event_date',
        'open_time',
        'start_time',
        'performer',
        'ticket_price',
        'ticket_url',
        'streaming_info',
        'genre',
        'image_url'
    ];
    foreach ($keys as $key) {
        if (isset($_POST[$key])) {
            update_post_meta(
                $post_id,
                $key,
                sanitize_text_field(wp_unslash($_POST[$key]))
            );
        }
    }
});
