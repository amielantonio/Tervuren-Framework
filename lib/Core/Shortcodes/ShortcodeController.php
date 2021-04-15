<?php

namespace App\Core\Shortcodes;

abstract class ShortcodeController {

    protected $attributes = [];

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
     *
     */
    public function start()
    {
        $this->handler();
        $this->render();
    }


}