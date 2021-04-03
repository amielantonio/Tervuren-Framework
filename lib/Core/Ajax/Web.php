<?php

class Web
{

    /**
     * For singleton Web file list
     *
     * @var Web
     */
    protected static $instance;

    /**
     * Contains all routing list that will be executed to create API gateways
     *
     * @var array
     */
    protected static $routeList = [];

    /**
     * Web Instance
     *
     * @return $this
     */
    protected function instance()
    {
        return $this;
    }

    /**
     * Use to register a Route to create a gateway
     *
     * @param $verb
     * @param $namespace
     * @param $route
     * @param $ajax
     * @param array $settings
     */
    public static function register($verb, $namespace, $route, $ajax, $settings = [])
    {
        //Check for Instance
        if (self::$instance === null) {
            self::$instance = new self;
        }

        $function = ($ajax instanceof Closure)
            ? $ajax
            : self::$instance->setController($ajax, $verb);

        self::$routeList[] = array_merge(compact('namespace', 'route', 'verb', 'function'), $settings);
    }

    public static function run()
    {
//        self::create_gateway(self::$routeList);

        add_action('rest_api_init', function() {
            self::create_gateway(self::$routeList);
        });
    }


    public static function create_gateway($routeList)
    {
        foreach($routeList as $list){
            register_rest_route($list['namespace'], $list['route'], [
                'methods' => strtoupper($list['verb']),
                'callback' => [$list['function']['controller'], $list['function']['method']]
            ]);
        }
    }

    /**
     * Create a get gateway
     *
     * @param $namespace
     * @param $route
     * @param $ajax
     * @param array $settings
     */
    public static function get($namespace, $route, $ajax, $settings = [])
    {
        self::register('get', $namespace, $route, $ajax, $settings);
    }

    /**
     * Create a post gateway
     *
     * @param $namespace
     * @param $route
     * @param $ajax
     * @param array $settings
     */
    public static function post($namespace, $route, $ajax, $settings = [])
    {
        self::register('post', $namespace, $route, $ajax, $settings);
    }

    /**
     * Create a put gateway
     *
     * @param $namespace
     * @param $route
     * @param $ajax
     * @param array $settings
     */
    public static function put($namespace, $route, $ajax, $settings = [])
    {
        self::register('put', $namespace, $route, $ajax, $settings);
    }

    /**
     * Create a delete gateway
     *
     * @param $namespace
     * @param $route
     * @param $ajax
     * @param array $settings
     */
    public static function delete($namespace, $route, $ajax, $settings = [])
    {
        self::register('delete', $namespace, $route, $ajax, $settings);
    }

    /**
     * Create a resource gateway
     *
     * @param $namespace
     * @param $route
     * @param $ajax
     * @param array $settings
     */
    public static function resource($namespace, $route, $ajax, $settings = [])
    {
        $resources = [
            'post' => [
                'verb' => 'post',
                'url' => $route,
                'callback' => '',
            ],
            'index' => [
                'verb' => 'get',
                'url' => $route,
                'callback' => 'index',
            ],
            'get' => [
                'verb' => 'get',
                'url' => "/{$route}/(?P<id>\d+)",
                'callback' => 'show',
            ],
            'put' => [
                'verb' => 'get',
                'url' => $route,
                'callback' => 'update',
            ],
            'delete' => [
                'verb' => 'delete',
                'url' => $route,
                'callback' => 'destroy',
            ]
        ];

        foreach ($resources as $verb => $resource) {
            self::register($resource['verb'], $namespace, $resource['url'], "{$ajax}@{$resource['callback']}");
        }
    }

    /**
     * grou
     *
     * @param $settings
     * @param $callback
     */
    public static function group($settings, $callback)
    {
        $settings = [
            "prefix" => "",
            "middleware" => "",
        ];
    }


    /**
     * Match the registered route for multiple verbs
     */
    public static function match()
    {

    }

    /**
     * Set the controller and method of the Rest API
     *
     * @param $controller
     * @param $verb
     * @return array
     */
    protected function setController($controller, $verb)
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
                'method' => $verb
            ];
        }

        return $control;
    }

    /**
     * Get the array routing list that was registered
     *
     * @return array
     */
    public static function getList()
    {
        return self::$routeList;
    }
}