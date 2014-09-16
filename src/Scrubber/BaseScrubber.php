<?php

namespace MrClean\Scrubber;

abstract class BaseScrubber implements ScrubberInterface {

    /**
     * The string we are scrubbing
     *
     * @var string $value
     */

    public $value;

    /**
     * Apply the options to the Scrubber
     *
     * @param array $options
     */

    public function applyOptions($options)
    {
        $available_options = $this->options();

        foreach ($options as $key => $option) {
            if (array_key_exists($key, $available_options)) {
                $this->$key = $option;
            }
        }
    }

    public function options()
    {
        return [];
    }

}
