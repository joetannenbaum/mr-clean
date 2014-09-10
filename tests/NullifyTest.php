<?php

namespace MrClean\Test;

class NullifyTest extends TestCase
{

	/** @test */

	public function it_will_nullify_an_empty_string()
	{
		$result = $this->cleaner->cleaners(['nullify'])
							->scrub('');

		$this->assertSame(null, $result);
	}

	/** @test */

	public function it_will_nullify_a_whitespace_string()
	{
		$result = $this->cleaner->cleaners(['nullify'])
							->scrub(' ');

		$this->assertSame(null, $result);
	}

	/** @test */

	public function it_will_not_nullify_a_non_empty_string()
	{
		$result = $this->cleaner->cleaners(['nullify'])
							->scrub('hi');

		$this->assertSame('hi', $result);
	}

	/** @test */

	public function it_will_not_nullify_an_empty_falsee_string()
	{
		$result = $this->cleaner->cleaners(['nullify'])
							->scrub(0);

		$this->assertSame(0, $result);
	}

}
