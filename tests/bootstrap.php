<?php
// WP PHPUnit テスト環境の読み込み
require_once getenv('WP_TESTS_DIR') . '/includes/functions.php';
tests_add_filter('muplugins_loaded', function () {
    require __DIR__ . '/../wp-livehouse-event-manager/wp-livehouse-event-manager.php';
});
require getenv('WP_TESTS_DIR') . '/includes/bootstrap.php';
