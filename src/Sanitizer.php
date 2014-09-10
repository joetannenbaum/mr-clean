<?php

namespace MrClean;

class Sanitizer {

	/**
	 * The set of cleaners to apply
	 *
	 * @var array $cleaners
	 */

	protected $cleaners = [];

	public function __construct(array $cleaners)
	{
		$this->cleaners = $cleaners;
	}

	/**
	 * Router to correct type of sanitization
	 *
	 * @param array|object|string $dirty
	 * @return array|object|string
	 */

    public function sanitize($dirty)
    {
    	if (is_object($dirty)) {
    		return $this->sanitizeObject($dirty);
    	} elseif (is_array($dirty)) {
    		return $this->sanitizeArray($dirty);
    	} else {
    		return $this->sanitizeString($dirty);
    	}
    }

	/**
	 * Clean a basic array
	 *
	 * @param array $array
	 * @return array
	 */

    protected function sanitizeArray($array)
    {
        foreach ($array as $key => $value) {
            $array[$key] = $this->sanitize($value);
        }

        return $array;
    }

	/**
	 * Clean an object
	 *
	 * @param object $object
	 * @return object
	 */

    protected function sanitizeObject($object)
    {
        foreach ($object as $key => $value) {
            $object->$key = $this->sanitize($value);
        }

        return $object;
    }

    /**
     * Sanitize the string with the current set of cleaners
     *
     * @param string $value
     * @return string
     */

    protected function sanitizeString($value)
    {
        foreach ($this->cleaners as $cleaner) {
            if ($this->isScrubber($cleaner)) {
            	$value = $this->getScrubber($cleaner, $value)->scrub();
           	} elseif (function_exists($cleaner)) {
            	$value = $cleaner($value);
            }
        }

        return $value;
    }

    /**
     * Determines if cleaner is a valid Scrubber
     *
     * @param string $scrubber
     * @return boolean
     */

    protected function isScrubber($scrubber)
    {
    	return class_exists($this->scrubberClassName($scrubber));
    }

    /**
     * Get an instance of the specified Scrubber class
     *
     * @param string $scrubber
     * @param string $value
     * @return \MrClean\Scrubber
     */

    protected function getScrubber($scrubber, $value)
    {
    	$class = $this->scrubberClassName($scrubber);

    	return new $class($value);
    }

    /**
     * Get the full class path for the Scrubber
     *
     * @param string $scrubber
     * @return string
     */

    protected function scrubberClassName($scrubber)
    {
		$scrubber = str_replace(['-', '_'], ' ', $scrubber);
		$scrubber = ucwords($scrubber);

		return 'MrClean\Scrubber\\' . str_replace(' ', '', $scrubber);
    }
}