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
    wlem_register_post_type();
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'wlem_activate');

// プラグイン無効化時の処理
function wlem_deactivate()
{
    flush_rewrite_rules();
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

// 1. CPT登録関数化
function wlem_register_post_type()
{
    register_post_type('live_event', [
        'labels' => [
            'name'                  => __('イベント', 'wp-livehouse-event-manager'),
            'singular_name'         => __('イベント', 'wp-livehouse-event-manager'),
            'add_new_item'          => __('新規イベントを追加', 'wp-livehouse-event-manager'),
            'edit_item'             => __('イベントを編集', 'wp-livehouse-event-manager'),
            'view_item'             => __('イベントを表示', 'wp-livehouse-event-manager'),
            'search_items'          => __('イベントを検索', 'wp-livehouse-event-manager'),
            'not_found'             => __('イベントが見つかりません', 'wp-livehouse-event-manager'),
            'not_found_in_trash'    => __('ゴミ箱にイベントが見つかりません', 'wp-livehouse-event-manager'),
        ],
        'public'       => true,
        'has_archive'  => true,
        'menu_position' => 5,
        'menu_icon'    => 'dashicons-calendar-alt',
        'supports'     => ['title', 'editor', 'thumbnail'],
    ]);
}
add_action('init', 'wlem_register_post_type');

// カスタムタクソノミー「ジャンル」登録
add_action('init', function () {
    register_taxonomy('event_genre', 'live_event', [
        'labels' => [
            'name'          => __('ジャンル', 'wp-livehouse-event-manager'),
            'singular_name' => __('ジャンル', 'wp-livehouse-event-manager'),
            'menu_name'     => __('ジャンル', 'wp-livehouse-event-manager'),
        ],
        'public'       => true,
        'hierarchical' => false,
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
        'event_date'    => ['label' => __('開催日', 'wp-livehouse-event-manager'), 'type' => 'date'],
        'open_time'     => ['label' => __('開場時間', 'wp-livehouse-event-manager'), 'type' => 'time'],
        'start_time'    => ['label' => __('開演時間', 'wp-livehouse-event-manager'), 'type' => 'time'],
        'performer'     => ['label' => __('出演者', 'wp-livehouse-event-manager'), 'type' => 'text'],
        'ticket_price'  => ['label' => __('チケット料金', 'wp-livehouse-event-manager'), 'type' => 'text'],
        'ticket_url'    => ['label' => __('チケットURL', 'wp-livehouse-event-manager'), 'type' => 'url'],
        'streaming_info' => ['label' => __('配信情報', 'wp-livehouse-event-manager'), 'type' => 'text'],
        // 'image_url' はアイキャッチ利用のため削除
    ];
    foreach ($fields as $key => $cfg) {
        $val = get_post_meta($post->ID, $key, true);
        echo '<p><label for="' . $key . '">' . $cfg['label'] . '</label><br/>';
        echo '<input type="' . $cfg['type'] . '" id="' . $key . '" name="' . $key
            . '" value="' . esc_attr($val) . '" style="width:100%;"/></p>';
    }
    // ジャンルドロップダウン
    $term_id = wp_get_post_terms($post->ID, 'event_genre', ['fields' => 'ids'])[0] ?? 0;
    echo '<p><label for="event_genre">' . __('ジャンル', 'wp-livehouse-event-manager') . '</label><br/>';
    wp_dropdown_categories([
        'taxonomy'         => 'event_genre',
        'hide_empty'       => false,
        'name'             => 'event_genre',
        'selected'         => $term_id,
        'show_option_none' => __('選択してください', 'wp-livehouse-event-manager'),
    ]);
    echo '</p>';
}

// 4. メタデータ保存処理
add_action('save_post', function ($post_id) {
    if (
        !isset($_POST['live_event_nonce'])
        || !wp_verify_nonce($_POST['live_event_nonce'], 'save_live_event_meta')
        || (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        || get_post_type($post_id) !== 'live_event'
    ) return;
    $keys = ['event_date', 'open_time', 'start_time', 'performer', 'ticket_price', 'ticket_url', 'streaming_info'];
    foreach ($keys as $key) {
        if (isset($_POST[$key])) {
            update_post_meta($post_id, $key, sanitize_text_field(wp_unslash($_POST[$key])));
        }
    }
    if (isset($_POST['event_genre'])) {
        wp_set_object_terms($post_id, intval($_POST['event_genre']), 'event_genre', false);
    }
});

// 管理一覧カラム追加
add_filter('manage_live_event_posts_columns', function ($cols) {
    $extra = [
        'event_date' => __('開催日', 'wp-livehouse-event-manager'),
        'start_time' => __('開演時間', 'wp-livehouse-event-manager'),
        'performer' => __('出演者', 'wp-livehouse-event-manager'),
    ];
    return array_slice($cols, 0, 2, true) + $extra + array_slice($cols, 2, null, true);
});
add_action('manage_live_event_posts_custom_column', function ($col, $id) {
    if (in_array($col, ['event_date', 'start_time', 'performer'], true)) {
        echo esc_html(get_post_meta($id, $col, true));
    }
}, 10, 2);

// フロント用ショートコード登録: [live_events number="5" genre="" upcoming="1"]
add_shortcode('live_events', 'wlem_live_events_shortcode');
function wlem_live_events_shortcode($atts)
{
    $args = shortcode_atts([
        'number'   => 5,
        'genre'    => '',
        'upcoming' => 1,
    ], $atts, 'live_events');

    $tax_query = [];
    if ($args['genre']) {
        $tax_query[] = [
            'taxonomy' => 'event_genre',
            'field'    => 'slug',
            'terms'    => sanitize_text_field($args['genre']),
        ];
    }
    $meta_query = [];
    if ($args['upcoming']) {
        $meta_query[] = [
            'key'     => 'event_date',
            'value'   => date('Y-m-d'),
            'compare' => '>=',
            'type'    => 'DATE',
        ];
    }

    $q = new WP_Query([
        'post_type'      => 'live_event',
        'posts_per_page' => intval($args['number']),
        'tax_query'      => $tax_query,
        'meta_query'     => $meta_query,
        'orderby'        => ['meta_value' => 'ASC', 'title' => 'ASC'],
        'meta_key'       => 'event_date',
    ]);

    if (! $q->have_posts()) {
        return '<p>' . esc_html__('イベントはありません。', 'wp-livehouse-event-manager') . '</p>';
    }

    $output  = '<ul class="live-events">';
    while ($q->have_posts()) {
        $q->the_post();
        $date   = get_post_meta(get_the_ID(), 'event_date', true);
        $time   = get_post_meta(get_the_ID(), 'start_time', true);
        $thumb  = get_the_post_thumbnail_url(get_the_ID(), 'thumbnail');
        $output .= '<li>';
        if ($thumb) {
            $output .= '<img src="' . esc_url($thumb) . '" alt="' . esc_attr(get_the_title()) . '" /> ';
        }
        $output .= '<a href="' . esc_url(get_permalink()) . '">'
            . esc_html(get_the_title()) . '</a> '
            . '<span class="date">' . esc_html($date) . '</span> '
            . '<span class="time">' . esc_html($time) . '</span>';
        $output .= '</li>';
    }
    wp_reset_postdata();
    $output .= '</ul>';
    return $output;
}

// 6. プラグイン内テンプレートの読み込み
add_filter('template_include', function ($template) {
    if (is_post_type_archive('live_event')) {
        return plugin_dir_path(__FILE__) . 'templates/archive-live_event.php';
    }
    if (is_singular('live_event')) {
        return plugin_dir_path(__FILE__) . 'templates/single-live_event.php';
    }
    return $template;
});

// 7. フロント用 CSS/JS 登録
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('wlem-style', plugin_dir_url(__FILE__) . 'assets/css/style.css');
    wp_enqueue_script('wlem-filter', plugin_dir_url(__FILE__) . 'assets/js/filter.js', ['jquery'], null, true);
    wp_localize_script('wlem-filter', 'WLEM_Ajax', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('wlem_ajax_nonce'),
    ]);
    wp_enqueue_style('wlem-calendar', plugin_dir_url(__FILE__) . 'assets/css/calendar.css');
    wp_enqueue_script('wlem-calendar', plugin_dir_url(__FILE__) . 'assets/js/calendar.js', ['jquery'], null, true);
});

// 8. AJAX イベントフィルタリング
add_action('wp_ajax_wlem_filter_events', 'wlem_filter_events');
add_action('wp_ajax_nopriv_wlem_filter_events', 'wlem_filter_events');
function wlem_filter_events()
{
    check_ajax_referer('wlem_ajax_nonce', 'nonce');
    $month = sanitize_text_field($_POST['month'] ?? '');
    $args = [
        'post_type'      => 'live_event',
        'posts_per_page' => -1,
        'meta_query'     => [
            ['key' => 'event_date', 'value' => $month . '-01', 'compare' => '>=', 'type' => 'DATE'],
            ['key' => 'event_date', 'value' => $month . '-31', 'compare' => '<=', 'type' => 'DATE'],
        ],
    ];
    $q = new WP_Query($args);
    $data = [];
    while ($q->have_posts()) {
        $q->the_post();
        $data[] = [
            'id'    => get_the_ID(),
            'title' => get_the_title(),
            'date'  => get_post_meta(get_the_ID(), 'event_date', true),
            'link'  => get_permalink(),
        ];
    }
    wp_reset_postdata();
    wp_send_json_success($data);
}

// 9. 保存処理にバリデーション追加
add_action('save_post', 'wlem_save_post_validate', 10, 1);
function wlem_save_post_validate($post_id)
{
    if (
        !isset($_POST['live_event_nonce'])
        || !wp_verify_nonce($_POST['live_event_nonce'], 'save_live_event_meta')
        || (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        || get_post_type($post_id) !== 'live_event'
    ) return;

    // 必須チェック
    foreach (['event_date', 'start_time', 'performer'] as $f) {
        if (empty($_POST[$f])) {
            add_filter('redirect_post_location', fn($loc) => add_query_arg('wlem_error', 'missing_' . $f, $loc));
            return;
        }
    }
    // URL形式チェック
    if (!empty($_POST['ticket_url']) && !filter_var($_POST['ticket_url'], FILTER_VALIDATE_URL)) {
        add_filter('redirect_post_location', fn($loc) => add_query_arg('wlem_error', 'invalid_ticket_url', $loc));
        return;
    }
    // ...元のメタ保存処理はここで実行されます...
}

// エラー通知表示
add_action('admin_notices', function () {
    if (!isset($_GET['post']) || !isset($_GET['wlem_error'])) return;
    $screen = get_current_screen();
    if ($screen->post_type !== 'live_event') return;KW
    $msgs = [
        'missing_event_date'   => __('開催日を入力してください。', 'wp-livehouse-event-manager'),
        'missing_start_time'   => __('開演時間を入力してください。', 'wp-livehouse-event-manager'),
        'missing_performer'    => __('出演者を入力してください。', 'wp-livehouse-event-manager'),
        'invalid_ticket_url'   => __('チケットURLの形式が正しくありません。', 'wp-livehouse-event-manager'),
    ];
    $err = sanitize_key($_GET['wlem_error']);
    if (isset($msgs[$err])) {
        echo '<div class="notice notice-error is-dismissible"><p>' . esc_html($msgs[$err]) . '</p></div>';
    }
});

// ショートコード: 月間イベントリスト [livehouse_event_list]
add_shortcode('livehouse_event_list', 'wlem_event_list_shortcode');
function wlem_event_list_shortcode()
{
    $year = date_i18n('Y');
    $select = '<select id="wlem-month-select">';
    for ($m = 1; $m <= 12; $m++) {
        $num = sprintf('%02d', $m);
        $select .= "<option value=\"{$year}-{$num}\">{$num}月</option>";
    }
    $select .= '</select>';
    return '<div class="wlem-list-wrap">' . $select . '<ul id="wlem-events-list"></ul></div>';
}

// ショートコード: 月間カレンダー [livehouse_calendar]
add_shortcode('livehouse_calendar', 'wlem_event_calendar_shortcode');
function wlem_event_calendar_shortcode()
{
    $year   = date_i18n('Y');
    $month  = date_i18n('m');
    $html  = '<div class="wlem-calendar-nav">';
    $html .= '<button data-action="prev">&laquo;</button>';
    $html .= "<span id=\"wlem-cal-month\">{$year}-{$month}</span>";
    $html .= '<button data-action="next">&raquo;</button>';
    $html .= '</div>';
    $html .= '<table class="wlem-calendar" id="wlem-calendar"></table>';
    return $html;
}
