<?php

namespace MrClean\Test;

class ArgumentsTest extends TestCase
{

    /** @test */

    public function it_will_accept_and_apply_arguments_for_a_class()
    {
        $result = $this->cleaner->scrubbers(['html' => ['whitelist' => ['p']]])
                                        ->scrub('<p><strong>Hi there.</strong></p>');

        $this->assertSame('<p>Hi there.</p>', $result);
    }

}
