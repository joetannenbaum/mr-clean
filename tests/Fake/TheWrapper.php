<?php

namespace MrClean\Test\Fake;

use MrClean\Scrubber\BaseScrubber;

class TheWrapper extends BaseScrubber {

    public function scrub()
    {
        return '!' . $this->value . '!';
    }
}