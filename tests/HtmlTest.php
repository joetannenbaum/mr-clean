<?php

namespace MrClean\Test;

class HtmlTest extends TestCase
{

    /** @test */

    public function it_will_strip_non_approved_tags()
    {
        $dirty = '<p>This</p><hr /><p>Is separate from this.</p>';

        $result = $this->cleaner->scrubbers(['html'])->scrub($dirty);

        $this->assertSame('<p>This</p><p>Is separate from this.</p>', $result);
    }

    /** @test */

    public function it_will_remove_empty_content_tags()
    {
        $dirty = '<p>This</p><hr /><p></p>';

        $result = $this->cleaner->scrubbers(['html'])->scrub($dirty);

        $this->assertSame('<p>This</p>', $result);
    }

    /** @test */

    public function it_will_remove_repeated_opening_tags()
    {
        $dirty = '<p><p>This</p>';

        $result = $this->cleaner->scrubbers(['html'])->scrub($dirty);

        $this->assertSame('<p>This</p>', $result);
    }


    /** @test */

    public function it_will_remove_repeated_closing_tags()
    {
        $dirty = '<p>This</p></p>';

        $result = $this->cleaner->scrubbers(['html'])->scrub($dirty);

        $this->assertSame('<p>This</p>', $result);
    }

}
