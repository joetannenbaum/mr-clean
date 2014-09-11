<?php

namespace MrClean;

/**
 * @method \MrClean\MrClean pre(array $pre)
 * @method \MrClean\MrClean scrubbers(array $scrubbers)
 * @method \MrClean\MrClean post(array $post)
 */

class MrClean {

    /**
     * An array of scrubbers to apply before every cleaner
     *
     * @var array $pre
     */

    protected $pre = [];

    /**
     * An array of scrubbers to apply
     *
     * @var array $scrubbers
     */

    protected $scrubbers = [];

    /**
     * An array of scrubbers to apply after every cleaner
     *
     * @var array $post
     */

    protected $post = [];

    /**
     * Registered cleaner classes
     *
     * @var array $registered
     */

    protected $registered = [];

    /**
     * Clean the value based on the scrubbers specified
     *
     * @param string|array $dirty
     * @return string|array
     */

    public function scrub($dirty)
    {
        $current   = array_merge($this->pre, $this->scrubbers, $this->post);
        $sanitizer = new Sanitizer($current, $this->registered);

        return $sanitizer->sanitize($dirty);
    }

    /**
     * Register class(es) as a cleaner
     *
     * @param string|array $classes
     */

    public function register($classes)
    {
        if (!is_array($classes)) $classes = [$classes];

        foreach ($classes as $class) {
            $short_name = basename(str_replace('\\', '/', $class));
            $this->registered[$short_name] = $class;
        }
    }

    public function __call($requested_method, $arguments)
    {
        if (in_array($requested_method, ['pre', 'post', 'scrubbers']))
        {
           $this->$requested_method = reset( $arguments );

           return $this;
        }

        throw new \BadMethodCallException("Unknown method [{$requested_method}] called.");
    }

}
