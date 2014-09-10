<?php

namespace MrClean\Scrubber;

class StripPhoneNumber extends BaseScrubber {

    /**
     * Remove anything not numeric or 'x' (extension) from the string
     *
     * @return string
     */

    public function scrub()
    {
        return preg_replace( '/[^\dx]/', '', $this->value );
    }

}
