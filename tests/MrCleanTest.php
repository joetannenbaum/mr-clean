<?php

namespace MrClean\Test;

class MrCleanTest extends TestCase
{

	/** @test */

	public function it_can_use_a_function_to_clean_a_string()
	{
		$result = $this->cleaner->cleaners(['trim'])
							->scrub(' What is the deal');

		$this->assertEquals('What is the deal', $result);
	}

	/** @test */

	public function it_can_use_a_function_to_clean_an_array()
	{
		$result = $this->cleaner->cleaners(['trim'])
							->scrub([' What is the deal', 'How is it going? ']);

		$this->assertEquals(['What is the deal', 'How is it going?'], $result);
	}

	/** @test */

	public function it_can_use_multiple_functions_to_clean_an_array()
	{
		$result = $this->cleaner->cleaners(['htmlentities', 'trim'])
							->scrub(['This & That ', ' How is it going?']);

		$this->assertEquals(['This &amp; That', 'How is it going?'], $result);
	}

	/** @test */

	public function it_can_use_a_function_to_clean_an_array_of_arrays()
	{
		$result = $this->cleaner->cleaners(['trim'])
							->scrub([
								[' What is the deal', ' How is it going?'],
								[' Who is that?', ' What is up?'],
							]);
		$scrubbed = [
						['What is the deal', 'How is it going?'],
						['Who is that?', 'What is up?'],
					];

		$this->assertEquals($scrubbed, $result);
	}

	/** @test */

	public function it_can_use_a_function_to_clean_an_array_of_objects()
	{
		$result = $this->cleaner->cleaners(['trim'])
							->scrub([
								(object) ['greeting' => 'How is it going?'],
								(object) ['greeting' => 'What is up?'],
							]);
		$scrubbed = [
						(object) ['greeting' => 'How is it going?'],
						(object) ['greeting' => 'What is up?'],
					];

		$this->assertEquals($scrubbed, $result);
	}

	/** @test */

	public function it_can_clean_a_nested_array_of_arrays_with_a_function()
	{
		$result = $this->cleaner->cleaners(['trim'])
							->scrub([
								[
									[' What is the deal', ' How is it going?']
								],
								[
									[' Who is that?', ' What is up?']
								],
							]);
		$scrubbed = [
						[
							['What is the deal', 'How is it going?']
						],
						[
							['Who is that?', 'What is up?']
						],
					];

		$this->assertEquals($scrubbed, $result);
	}

	/** @test */

	public function it_can_clean_a_nested_array_of_mixed_types_with_a_function()
	{
		$result = $this->cleaner->cleaners(['trim'])
							->scrub([
								[
									(object) [
										'greetings' => [' What is the deal', ' How is it going?']
									],
								],
								[
									(object) [
										'greetings' => [' Who is that?', ' What is up?']
									],
								],
							]);
		$scrubbed = [
						[
							(object) [
								'greetings' => ['What is the deal', 'How is it going?']
							]
						],
						[
							(object) [
								'greetings' => ['Who is that?', 'What is up?']
							]
						],
					];

		$this->assertEquals($scrubbed, $result);
	}

	/** @test */

	public function it_alerts_the_user_when_they_call_a_non_existent_method()
	{
		$this->setExpectedException('BadMethodCallException');

		$this->cleaner->somethingThatDoesntExist();
	}
}
