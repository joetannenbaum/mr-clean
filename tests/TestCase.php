<?php

namespace MrClean\Test;

class TestCase extends \PHPUnit_Framework_TestCase {

    protected $cleaner;

    protected function setUp()
    {
        $this->cleaner = new \MrClean\MrClean;
    }

}