<?php

namespace MrClean\Test;

class TestBase extends \PHPUnit_Framework_TestCase {

    protected $cleaner;

    protected function setUp()
    {
        $this->cleaner = new \MrClean\MrClean;
    }

    protected function tearDown()
    {
    }

    /** @test */

    public function it_does_nothing()
    {
        // sure does
    }

}