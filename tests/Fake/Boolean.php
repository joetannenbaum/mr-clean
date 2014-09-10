<?php

namespace MrClean\Test\Fake;

use MrClean\Scrubber\BaseScrubber;

class Boolean extends BaseScrubber {

    public function scrub()
    {
        return 'booleaned!';
    }
}