<?php

namespace MrClean\Scrubber;

class StripCssAttributes extends BaseScrubber {

    /**
     * Attributes to replace
     *
     * @var array $attributes
     */

     protected $attributes = [
         '/ class=("|\')[^("|\')]*("|\')/'      => '',      // class attriutes
         '/ id=("|\')[^("|\')]*("|\')/'         => '',      // class attriutes
         '/ style=("|\')[^("|\')]*("|\')/'      => '',      // style attributes
     ];

    /**
     * Remove the attributes
     *
     * @return boolean
     */

    public function scrub()
    {
        $search = array_keys($this->attributes);
        $replace = array_values($this->attributes);

        return preg_replace($search, $replace, $this->value);
    }

}
