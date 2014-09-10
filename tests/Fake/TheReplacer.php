<?php

namespace MrClean\Test\Fake;

use MrClean\Scrubber\BaseScrubber;

class TheReplacer extends BaseScrubber {

    public function scrub()
    {
        return str_replace('s', 'm', $this->value);
    }
}
