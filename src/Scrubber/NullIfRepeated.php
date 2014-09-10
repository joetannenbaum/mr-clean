<?php

namespace MrClean\Scrubber;

class NullIfRepeated extends BaseScrubber {

    /**
     * The minimum string length
     * before considering nulling the value
     *
     * @const integer MIN
     */

    const MIN = 2;

    /**
     * If the first_character is the only character in the whole number, null it out
     * e.g. 11111111, 222222, ccccccc, etc
     *
     * @return string|null
     */

    public function scrub()
    {
        $first_character = substr($this->value, 0, 1);

        if (strlen($this->value) > self::MIN && !strlen(str_replace($first_character, '', $this->value)))
        {
            return null;
        }

        return $this->value;
    }

}
