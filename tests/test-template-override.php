<?php
class Test_Template_Override extends WP_UnitTestCase
{
    public function test_template_include_archive()
    {
        // シミュレート
        set_current_screen('edit-live_event');
        add_filter('template_include', '__return_false');
        remove_all_filters('template_include');
        // 本来のフィルタを呼び出す
        $template = apply_filters('template_include', '');
        $this->assertStringContainsString('templates/archive-live_event.php', $template);
    }
}
