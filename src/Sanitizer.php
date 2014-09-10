<?php

namespace MrClean;

class Sanitizer {

    /**
     * The set of cleaners to apply
     *
     * @var array $cleaners
     */

    protected $cleaners = [];

    /**
     * Registered cleaner classes
     *
     * @var array $registered
     */

    protected $registered = [];

    public function __construct(array $cleaners, array $registered)
    {
        $this->cleaners   = $cleaners;
        $this->registered = $registered;
    }

    /**
     * Router to correct type of sanitization
     *
     * @param array|object|string $dirty
     * @return array|object|string
     */

    public function sanitize($dirty, $key = null)
    {
        if (is_object($dirty)) {
           return $this->sanitizeObject($dirty);
        } elseif (is_array($dirty)) {
           return $this->sanitizeArray($dirty);
        } else {
           return $this->sanitizeString($dirty, $key);
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
            $array[$key] = $this->sanitize($value, $key);
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
            $object->$key = $this->sanitize($value, $key);
        }

        return $object;
    }

    /**
     * Sanitize the string with the current set of cleaners
     *
     * @param string $value
     * @param string|null $key
     * @return string
     */

    protected function sanitizeString($value, $key)
    {
        return $this->runCleaners($value, $this->cleaners, $key);
    }

    /**
     * Run the array of cleaners on the value, with an optional key to compare against
     *
     * @param string $value
     * @param array $cleaners
     * @param string $key
     * @return string
     */

    protected function runCleaners($value, $cleaners, $key = null)
    {
        foreach ($cleaners as $cleaner_key => $cleaner) {
            // Do we have an array of cleaners for a specific key?
            if (is_array($cleaner)) {
                if ($cleaner_key == $key) {
                    // If it's this key, run them
                    return $this->runCleaners($value, $cleaner);
                } else {
                    // Otherwise, skip them
                    continue;
                }
            }

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
        if ($this->isRegistered($scrubber)) {
            return true;
        }

        return class_exists($this->getScrubberClassName($scrubber));
    }

    /**
     * Check to see if this is a registered cleaner
     *
     * @param string $scrubber
     * @return boolean
     */

    protected function isRegistered($scrubber)
    {
        $class = $this->getScrubberShortClassName($scrubber);

        return array_key_exists($class, $this->registered);
    }

    /**
     * Get the registered cleaner class name
     *
     * @param string $scrubber
     * @return string
     */

    protected function getRegisteredClassName($scrubber)
    {
        $class = $this->getScrubberShortClassName($scrubber);

        return $this->registered[$class];
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
        if ($this->isRegistered($scrubber)) {
            $class = $this->getRegisteredClassName($scrubber);
        } else {
            $class = $this->getScrubberClassName($scrubber);
        }

        return new $class($value);
    }

    /**
     * Get just the base name for the Scrubber class
     *
     * @param string $scrubber
     * @return string
     */

    protected function getScrubberShortClassName($scrubber)
    {
        $scrubber = str_replace(['-', '_'], ' ', $scrubber);
        $scrubber = ucwords($scrubber);

        return str_replace(' ', '', $scrubber);
    }

    /**
     * Get the full class path for the Scrubber
     *
     * @param string $scrubber
     * @return string
     */

    protected function getScrubberClassName($scrubber)
    {

       return 'MrClean\Scrubber\\' . $this->getScrubberShortClassName($scrubber);
    }
}
