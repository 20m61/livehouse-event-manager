<?php
class Test_Ajax_Endpoint extends WP_UnitTestCase
{
    public function test_filter_events_ajax()
    {
        // create a sample event
        $post_id = $this->factory->post->create([
            'post_type'   => 'live_event',
            'post_status' => 'publish',
        ]);
        update_post_meta($post_id, 'event_date', date('Y-m-d'));
        $_POST = [
            'action' => 'wlem_filter_events',
            'month'  => date('Y-m'),
            'nonce'  => wp_create_nonce('wlem_ajax_nonce'),
        ];
        // capture JSON response
        ob_start();
        wlem_filter_events();
        $json = ob_get_clean();
        $data = json_decode($json, true);
        $this->assertTrue($data['success']);
        $this->assertNotEmpty($data['data']);
    }
}
