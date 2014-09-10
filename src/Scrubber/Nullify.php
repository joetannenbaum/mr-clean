<?php

namespace MrClean\Scrubber;

class Nullify extends BaseScrubber {

    /**
     * If the string doesn't have an actual length, null it out
     *
     * @return string|null
     */

    public function scrub()
    {
        if (!strlen(trim($this->value))) {
            return null;
        }

        return $this->value;
    }

}
