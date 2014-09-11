<?php

namespace MrClean\Test;

class CleanKeysTest extends TestCase
{

    /** @test */

    public function it_can_clean_only_one_key()
    {
        $result = $this->cleaner->scrubbers(['name' => ['trim']])
                                ->scrub([
                                    'name' => ' Joe',
                                    'job'  => ' Developer'
                                ]);

        $scrubbed = [
                        'name' => 'Joe',
                        'job'  => ' Developer'
                    ];

        $this->assertSame($scrubbed, $result);
    }

    /** @test */

    public function it_can_clean_several_keys()
    {
        $result = $this->cleaner->scrubbers([
                                        'name' => ['trim'],
                                        'job'  => ['htmlentities'],
                                    ])
                                    ->scrub([
                                        'name' => ' Joe',
                                        'job'  => ' Developer & Such'
                                    ]);

        $scrubbed = [
                        'name' => 'Joe',
                        'job'  => ' Developer &amp; Such'
                    ];

        $this->assertSame($scrubbed, $result);
    }

    /** @test */

    public function it_can_clean_several_keys_in_an_object()
    {
        $result = $this->cleaner->scrubbers([
                                        'name' => ['trim'],
                                        'job'  => ['htmlentities'],
                                    ])
                                    ->scrub((object) [
                                        'name' => ' Joe',
                                        'job'  => ' Developer & Such'
                                    ]);

        $scrubbed = (object) [
                        'name' => 'Joe',
                        'job'  => ' Developer &amp; Such'
                    ];

        $this->assertEquals($scrubbed, $result);
    }

    /** @test */

    public function it_can_run_cleaners_on_all_and_specific_keys()
    {
        $result = $this->cleaner->scrubbers([
                                        'strip_tags',
                                        'name' => ['trim'],
                                        'job'  => ['htmlentities'],
                                    ])
                                    ->scrub([
                                        'name' => ' <strong>Joe</strong>',
                                        'job'  => ' <em>Developer</em> & Such'
                                    ]);

        $scrubbed = [
                        'name' => 'Joe',
                        'job'  => ' Developer &amp; Such'
                    ];

        $this->assertSame($scrubbed, $result);
    }

}
