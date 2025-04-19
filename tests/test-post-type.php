<?php
class Test_Post_Type extends WP_UnitTestCase
{
    public function test_live_event_post_type_exists()
    {
        $this->assertTrue(post_type_exists('live_event'));
    }
    public function test_live_event_has_archive_support()
    {
        $pt = get_post_type_object('live_event');
        $this->assertTrue($pt->has_archive);
    }
}
