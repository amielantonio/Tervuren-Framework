<?php

class Shortcode {

    /**
     * Shortcpde Instance
     *
     * @var Shortcode
     */
    protected static $instance;

    /**
     * @var array
     */
    protected static $shortcodeList = [];

    /**
     * @param $tag
     * @param $controller
     */
    public static function register( $tag, $controller )
    {
        //Check for Instance
        if (self::$instance === null) {
            self::$instance = new self;
        }

        $function = ($controller instanceof Closure)
            ? $controller
            : self::$instance->setController($controller);

        self::$shortcodeList[] = array_merge( compact('tag', 'function'));

    }

    /**
     * @param $shortcodeList
     */
    public static function create_shortcode($shortcodeList)
    {
        $controllerPath = "\\App\Http\Controller\\";

        foreach($shortcodeList as $shortcode)
        {
            $controller = $controllerPath.$shortcode['function']['controller'];
            $method = $shortcode['function']['method'];

            add_shortcode($shortcode['tag'], function() use ($controller, $method){
                $controller = new $controller;

                return $controller->$method();
            });
        }
    }

    /**
     *
     */
    public static function run()
    {
        self::create_shortcode(self::$shortcodeList);
    }


    /**
     * Set controller
     *
     * @param $controller
     * @return array
     */
    protected function setController($controller)
    {
        if (strpos($controller, '@') !== false) {
            $method = explode('@', $controller);
            $control = [
                'controller' => $method[0],
                'method' => $method[1]
            ];
        } else {
            $control = [
                'controller' => $controller,
                'method' => "start"
            ];
        }

       return $control;
    }
}