<?php

namespace MrClean\Test;

class BooleanTest extends TestBase
{

	/** @test */

	public function it_will_convert_a_0_to_false()
	{
		$result = $this->cleaner->cleaners(['boolean'])
							->scrub(0);

		$this->assertSame(false, $result);
	}

	/** @test */

	public function it_will_convert_an_empty_string_to_a_false()
	{
		$result = $this->cleaner->cleaners(['boolean'])
							->scrub('');

		$this->assertSame(false, $result);
	}

	/** @test */

	public function it_will_convert_a_whitespace_string_to_a_false()
	{
		$result = $this->cleaner->cleaners(['boolean'])
							->scrub(' ');

		$this->assertSame(false, $result);
	}

	/** @test */

	public function it_will_convert_a_no_to_a_false()
	{
		$result = $this->cleaner->cleaners(['boolean'])
							->scrub('no');

		$this->assertSame(false, $result);
	}

	/** @test */

	public function it_will_convert_an_n_to_a_false()
	{
		$result = $this->cleaner->cleaners(['boolean'])
							->scrub('n');

		$this->assertSame(false, $result);
	}

	/** @test */

	public function it_will_convert_an_false_to_a_false()
	{
		$result = $this->cleaner->cleaners(['boolean'])
							->scrub('false');

		$this->assertSame(false, $result);
	}

	/** @test */

	public function it_will_convert_anything_else_to_a_true()
	{
		$result = $this->cleaner->cleaners(['boolean'])
							->scrub('cool');

		$this->assertSame(true, $result);
	}

}