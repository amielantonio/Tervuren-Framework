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
    public static $routeList = [];

    /**
     * Contains all ajax list that will be added o the backend
     *
     * @var array
     */
    public static $ajaxList = [];

    /**
     * Ajax Factory class
     *
     * @var AjaxFactory
     */
    protected static $ajaxFactory;

    /**
     * Web Instance
     *
     * @return $this
     */
    protected function instance()
    {
        return $this;
    }

    public static function start(AjaxFactory $factory)
    {
        //Check for Instance
        if (self::$instance === null) {
            self::$instance = new self;
        }

        self::$ajaxFactory = new $factory;

        self::$ajaxFactory->create(self::$instance);
    }



    /**
     * Use to register a Route to create a gateway
     *
     * @param $verb
     * @param $namespace
     * @param $route
     * @param $api
     * @param array $settings
     */
    public static function register($verb, $namespace, $route, $api, $settings = [])
    {
        //Check for Instance
        if (self::$instance === null) {
            self::$instance = new self;
        }

        $function = ($api instanceof Closure)
            ? $api
            : self::$instance->setController($api, $verb);

        self::$routeList[] = array_merge(compact('namespace', 'route', 'verb', 'function'), $settings);
    }

    /**
     * Bootstraps the creation of the routes api list and registers it in WordPress init
     *
     */
    public static function run()
    {
        add_action('rest_api_init', function() {
            self::create_gateway(self::$routeList);
        });

    }

    /**
     * Create the API gateway and install it in wordpress
     *
     * @param $routeList
     */
    public static function create_gateway($routeList)
    {
        $controllerPath = "\\App\Http\API\\";

        $callback = new \App\Core\API\Callback();

        foreach($routeList as $list){

            $controller = $controllerPath.$list['function']['controller'];
            $method = $list['function']['method'];
            $controller = new $controller;


            register_rest_route($list['namespace'], $list['route'], [
                'methods' => strtoupper($list['verb']),
                'callback' => function () use($callback, $list, $controller, $method) {
                    //Set the settings
                    $callback->setController($controller);
                    $callback->setMethod($method);
                    $callback->setRequest($_SERVER);

                    json_encode($callback->rest($list['verb']));
                    die();
                }
            ]);
        }
    }

    /**
     * Create a get gateway
     *
     * @param $namespace
     * @param $route
     * @param $api
     * @param array $settings
     */
    public static function get($namespace, $route, $api, $settings = [])
    {
        self::register('get', $namespace, $route, $api, $settings);
    }

    /**
     * Create a post gateway
     *
     * @param $namespace
     * @param $route
     * @param $api
     * @param array $settings
     */
    public static function post($namespace, $route, $api, $settings = [])
    {
        self::register('post', $namespace, $route, $api, $settings);
    }

    /**
     * Create a put gateway
     *
     * @param $namespace
     * @param $route
     * @param $api
     * @param array $settings
     */
    public static function put($namespace, $route, $api, $settings = [])
    {
        self::register('put', $namespace, $route, $api, $settings);
    }

    /**
     * Create a delete gateway
     *
     * @param $namespace
     * @param $route
     * @param $api
     * @param array $settings
     */
    public static function delete($namespace, $route, $api, $settings = [])
    {
        self::register('delete', $namespace, $route, $api, $settings);
    }

    /**
     * Create a resource gateway
     *
     * @param $namespace
     * @param $route
     * @param $api
     * @param array $settings
     */
    public static function resource($namespace, $route, $api, $settings = [])
    {
        $resources = [
            'post' => [
                'verb' => 'post',
                'url' => $route,
                'callback' => 'store',
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
                'url' => $route."/update/(?P<id>\d+)",
                'callback' => 'update',
            ],
            'delete' => [
                'verb' => 'delete',
                'url' => $route."/delete/(?P<id>\d+)",
                'callback' => 'destroy',
            ]
        ];

        foreach ($resources as $verb => $resource) {
            self::register($resource['verb'], $namespace, $resource['url'], "{$api}@{$resource['callback']}");
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
     * Ajax registration method
     *
     * @param $name
     * @param $controller
     * @param bool $nopriv
     */
    public static function ajax( $name, $controller, $nopriv = true)
    {
        // Check if controller is a closure or a string that passes
        // the controller class and the corresponding method that
        // will run the ajax request.
        if($controller instanceof Closure)
        {
            $function = $controller;
        } else {
            $array  = explode( '@', $controller );
            $function = [
                'controller' => $array[0],
                'method' => $array[1]
            ];
        }

        self::$ajaxList[] = compact('name', 'function', 'nopriv');
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