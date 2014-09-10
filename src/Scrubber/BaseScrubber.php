<?php

namespace MrClean\Scrubber;

abstract class BaseScrubber implements ScrubberInterface {

    /**
     * The string we are scrubbing
     *
     * @var string $value
     */

    protected $value;

    public function __construct($value)
    {
        $this->value = $value;
    }
}