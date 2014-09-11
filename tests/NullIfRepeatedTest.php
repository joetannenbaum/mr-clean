<?php

namespace MrClean\Test;

class NullIfRepeatedTest extends TestCase
{

	/** @test */

	public function it_can_detect_a_string_of_only_one_repeated_character()
	{
		$result = $this->cleaner->scrubbers(['null_if_repeated'])
							->scrub('1111');

		$this->assertEquals(null, $result);
	}

	/** @test */

	public function it_can_determine_when_it_is_not_a_repeated_character()
	{
		$result = $this->cleaner->scrubbers(['null_if_repeated'])
							->scrub('1112');

		$this->assertEquals('1112', $result);
	}

	/** @test */

	public function it_will_ignore_strings_less_than_the_minimum()
	{
		$result = $this->cleaner->scrubbers(['null_if_repeated'])
							->scrub('11');

		$this->assertEquals('11', $result);
	}

}
