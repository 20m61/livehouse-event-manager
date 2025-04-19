<?php
if (! defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

// ライブイベント投稿をすべて永続削除
$events = get_posts(['post_type' => 'live_event', 'numberposts' => -1, 'post_status' => 'any']);
foreach ($events as $e) {
    wp_delete_post($e->ID, true);
}

// カスタムタクソノミー「event_genre」のターム削除
$terms = get_terms(['taxonomy' => 'event_genre', 'hide_empty' => false]);
if (!is_wp_error($terms)) {
    foreach ($terms as $t) {
        wp_delete_term($t->term_id, 'event_genre');
    }
}

// 追加: プラグインオプション削除
if (get_option('wlem_options') !== false) {
    delete_option('wlem_options');
}
