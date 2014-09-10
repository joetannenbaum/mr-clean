<?php

namespace MrClean;

/**
 * @method \MrClean\MrClean pre(array $pre)
 * @method \MrClean\MrClean cleaners(array $cleaners)
 * @method \MrClean\MrClean post(array $post)
 */

class MrClean {

	/**
	 * An array of cleaners to apply before every cleaner
	 *
	 * @var array $pre
	 */

	protected $pre = [];

	/**
	 * An array of cleaners to apply
	 *
	 * @var array $cleaners
	 */

	protected $cleaners = [];

	/**
	 * An array of cleaners to apply after every cleaner
	 *
	 * @var array $post
	 */

	protected $post = [];

    /**
     * Clean the value based on the cleaners specified
     *
     * @param string $value
     * @return string
     */

    public function scrub($dirty)
    {
        $current = array_merge($this->pre, $this->cleaners, $this->post);

        $sanitizer = new Sanitizer($current);

        return $sanitizer->sanitize($dirty);
    }

    public function __call($requested_method, $arguments)
    {
    	if (in_array($requested_method, ['pre', 'post', 'cleaners']))
    	{
    		$this->$requested_method = reset( $arguments );

    		return $this;
    	}
    }

}