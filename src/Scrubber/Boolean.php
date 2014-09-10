<?php

namespace MrClean\Scrubber;

class Boolean extends BaseScrubber {

    /**
     * Strings that should evaluate as false
     *
     * @var array $falses
     */

    protected $falses = [
                            'no',
                            'n',
                            'false',
                        ];

    /**
     * Convert the string to a boolean
     *
     * @return boolean
     */

    public function scrub()
    {
        $this->value = strtolower(trim($this->value));

        if (empty($this->value)) {
            return false;
        }

        return !in_array($this->value, $this->falses);
    }

}
