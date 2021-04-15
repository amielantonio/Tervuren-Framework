<?php

namespace App\Core\Shortcodes;

abstract class ShortcodeController {

    /**
     * User attributes that are passed by the shortcode interface
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * Base attributes that are set and can be modified based on user input
     *
     * @var array
     */
    protected $baseAttributes = [];

    /**
     * @param array $attributes
     * @return mixed
     */
    protected function handler($attributes = [])
    {
        $this->setAttributes($this->baseAttributes, $attributes);
    }

    /**
     * @return mixed
     */
    abstract public function render();

    /**
     * Set attributes
     *
     * @param $baseAttributes
     * @param $attributes
     */
    protected function setAttributes($baseAttributes, $attributes)
    {
        $this->attributes = shortcode_atts($baseAttributes, $attributes);
    }

    protected function getAttributes()
    {
        return $this->attributes;
    }


    /**
     * Starts the shortcodes
     *
     * @param array $attribs
     */
    public function start($attribs = [])
    {
        $this->handler($attribs);
        $this->render();
    }

}