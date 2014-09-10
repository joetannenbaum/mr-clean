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
        $registered = $this->isRegistered($scrubber);

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