<?php
class Test_REST_API extends WP_UnitTestCase
{
    public function test_live_event_is_rest()
    {
        $pt = get_post_type_object('live_event');
        $this->assertTrue($pt->show_in_rest);
    }
    public function test_event_genre_is_rest()
    {
        $tx = get_taxonomy('event_genre');
        $this->assertTrue($tx->show_in_rest);
    }
}
