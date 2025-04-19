<?php
class Test_Shortcode extends WP_UnitTestCase
{
    public function test_event_list_shortcode_outputs_select_and_ul()
    {
        $out = do_shortcode('[livehouse_event_list]');
        $this->assertStringContainsString('<select id="wlem-month-select">', $out);
        $this->assertStringContainsString('<ul id="wlem-events-list">', $out);
    }
    public function test_event_calendar_shortcode_wrapped_table()
    {
        $out = do_shortcode('[livehouse_calendar]');
        $this->assertStringContainsString('class="wlem-calendar-wrap"', $out);
        $this->assertStringContainsString('id="wlem-calendar"', $out);
    }
}
