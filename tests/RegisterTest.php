<?php

namespace MrClean\Test;

class RegisterTest extends TestCase
{

    /** @test */

    public function it_can_register_a_new_cleaner_as_a_string()
    {
        $this->cleaner->register('MrClean\Test\Fake\TheReplacer');

        $result = $this->cleaner->cleaners(['the_replacer'])
                                ->scrub('This is just full of some esses.');

        $this->assertSame('Thim im jumt full of mome emmem.', $result);
    }

    /** @test */

    public function it_can_register_a_new_cleaner_as_an_array()
    {
        $this->cleaner->register([
                'MrClean\Test\Fake\TheReplacer',
                'MrClean\Test\Fake\TheWrapper',
            ]);

        $result = $this->cleaner->cleaners(['the_replacer', 'the_wrapper'])
                                ->scrub('This is just full of some esses.');

        $this->assertSame('!Thim im jumt full of mome emmem.!', $result);
    }

    /** @test */

    public function it_can_overwrite_a_default_scrubber()
    {
        $this->assertTrue(class_exists('MrClean\Scrubber\Boolean'));

        $this->cleaner->register([
                'MrClean\Test\Fake\Boolean',
            ]);

        $result = $this->cleaner->cleaners(['boolean'])
                                ->scrub('This is just full of some esses.');

        $this->assertSame('booleaned!', $result);
    }

}
