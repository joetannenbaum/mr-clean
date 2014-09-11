<?php

namespace MrClean\Scrubber;

class Html extends BaseScrubber {

    /**
     * Tags we are allowing
     *
     * @var array $whitelist
     */

    protected $whitelist = [
        'a',
        'p',
        'div',
        'strong',
        'em',
        'b',
        'i',
        'br',
        'ul',
        'ol',
        'li',
        'h1',
        'h2',
        'h3',
        'h4',
        'h5',
        'h6',
    ];

    /**
     * An array of regexes for items to be replaced
     *
     * @var array $replace
     */

    protected $replace = [
        '/<(.*)>[\s]*<\/\1>/'   => '',      // empty tags (no content)
        '/<(.*)>[\s]*<\1>/'     => '<$1>',  // repeated opening tags
        '/<\/(.*)>[\s]*<\/\1>/' => '</$1>', // repeated ending tags
    ];

    /**
     * Clean up the html
     *
     * @return boolean
     */

    public function scrub()
    {
        $this->stripTags();
        $this->removeGarbage();

        return $this->value;
    }

    /**
     * Strip the value of any tags not on the whitelist
     */

    protected function stripTags()
    {
        $this->value = strip_tags($this->value, $this->whitelist());
    }

    /**
     * Remove any bad syntax or empty elements
     */

    protected function removeGarbage()
    {
        $search      = array_keys($this->replace);
        $replace     = array_values($this->replace);
        $this->value = preg_replace($search, $replace, $this->value);
    }

    /**
     * Compile the whitelist as a string full of tags
     *
     * @return    string
     */

    protected function whitelist()
    {
        $tags = array_map([$this, 'toTag'], $this->whitelist);

        return implode('', $tags);
    }

    /**
     * Tagify the string (i.e. wrap it in gt and lt)
     *
     * @param     string $tag
     * @return    string
     */

    protected function toTag($tag)
    {
        return "<{$tag}>";
    }

}
