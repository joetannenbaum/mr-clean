<?php

namespace MrClean\Test;

class StripCssAttributesTest extends TestCase
{

    /** @test */

    public function it_will_strip_css_attributes_with_double_quotes()
    {
        $dirty = '<p style="font-size:11">This</p>';
        $dirty .= '<p class="center">Is separate from this.</p>';
        $dirty .= '<p id="blah">And this.</p>';

        $result = $this->cleaner->scrubbers(['strip_css_attributes'])->scrub($dirty);

        $this->assertSame('<p>This</p><p>Is separate from this.</p><p>And this.</p>', $result);
    }

    /** @test */

    public function it_will_strip_css_attributes_with_single_quotes()
    {
        $dirty = "<p style='font-size:11'>This</p>";
        $dirty .= "<p class='center'>Is separate from this.</p>";
        $dirty .= "<p id='blah'>And this.</p>";

        $result = $this->cleaner->scrubbers(['strip_css_attributes'])->scrub($dirty);

        $this->assertSame('<p>This</p><p>Is separate from this.</p><p>And this.</p>', $result);
    }

}
