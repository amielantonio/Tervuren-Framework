<?php

class Router {

    /**
     * Storage for page information
     *
     *
     * @var array
     */
    public static $pages = [];

    /**
     * Page Instance
     *
     * @var Router
     */
    protected static $instance;

    /**
     * @var \AWC\Core\Router\PageCreator
     */
    protected static $creator;

    /**
     * Storage for web channels
     *
     * @var array
     */
    public static $channels;

    /**
     * @var array
     */
    private static $currentChannel;

    /**
     * @var
     */
    public static $routeChannel = 'route';

    /**
     * Base namespace of the controller
     *
     * @var string
     */
    protected $namespace = "\\AWC\Controller\\";

    /**
     * Router Instance
     *
     * @return $this
     */
    protected function instance()
    {
        return $this;
    }

    public static function start(PageCreator $creator)
    {
        self::$creator = new $creator;
    }

    /**
     * Adds the page to the array
     *
     * @param string $location
     * @param string $title
     * @param Closure|string $controller
     * @param array $settings
     * @return Router
     */
    public static function add( $location, $title, $controller, $settings = [] )
    {
        //Check for Instance
        if( self::$instance === null ) {
            self::$instance = new self;
        }

        $function = ( $controller instanceof Closure )
                        ? $controller
                        : self::$instance->setController( $controller );

        self::$pages[] = array_merge( compact( 'location', 'title', 'function' ), $settings );

        return self::$instance;

    }

    /**
     * Binds the built array to the admin_menu action of Wordpress
     */
    public static function run()
    {
        add_action( 'admin_menu', array( self::$instance, 'create_pages' ) );
    }

    /**
     * Creates the pages that will be binded to Wordpress menu
     *
     * @return bool
     */
    public function create_pages()
    {
         return self::$creator->create( self::$instance ) ;
    }

    /**
     * Create a primary menu on the sidebar of Wordpress Admin
     *
     * @param $name
     * @param $controller
     * @param array $settings
     * @return Router
     */
    public static function addMenu( $name, $controller, $settings = [] )
    {
        self::add( 'menu', $name, $controller, $settings );

        return self::$instance;
    }

    /**
     * Create a submenu under the parent name that was passed
     *
     * @param $parent_name
     * @param $name
     * @param $controller
     * @param array $settings
     * @return Router
     */
    public static function addSubMenu( $parent_name, $name, $controller, $settings = [] )
    {
        self::add( 'submenu',
            $name,
            $controller,
            array_merge(['parent_name' => $parent_name], $settings));

        return self::$instance;
    }

    /**
     * Create a submenu under the Dashboard tab
     *
     * @param $name
     * @param $controller
     * @param array $settings
     */
    public function addDashboard( $name, $controller, $settings = [] )
    {
        self::add( 'dashboard', $name, $controller, $settings );
    }

    /**
     * Create a submenu under the Post tab
     *
     * @param $name
     * @param $controller
     * @param array $settings
     */
    public function addPosts( $name, $controller, $settings = [] )
    {
        self::add( 'posts', $name, $controller, $settings );
    }

    /**
     * Create a submenu under the Settings tab
     *
     * @param $name
     * @param $controller
     * @param array $settings
     */
    public function addUtility( $name, $controller, $settings = [] )
    {
        self::add( 'utility', $name, $controller, $settings );
    }

    /**
     * Create a submenu under the Media Tab
     *
     * @param $name
     * @param $controller
     * @param array $settings
     */
    public function addMedia( $name, $controller, $settings = [] )
    {
        self::add( 'media', $name, $controller, $settings );
    }

    /**
     * Create a submenu under the Comments tab
     *
     * @param $name
     * @param $controller
     * @param array $settings
     */
    public function addComments( $name, $controller, $settings = [] )
    {
        self::add( 'comments', $name, $controller, $settings );
    }

    /**
     * Create a submenu under the Pages tab
     *
     * @param $name
     * @param $controller
     * @param array $settings
     */
    public function addPages( $name, $controller, $settings = [] )
    {
        self::add( 'pages', $name, $controller, $settings );
    }

    /**
     * Create a submenu under the Users tab
     *
     * @param $name
     * @param $controller
     * @param array $settings
     */
    public function addUsers( $name, $controller, $settings = [] )
    {
        self::add( 'users', $name, $controller, $settings );
    }

    /**
     * Create a submenu under the Appearance tab
     *
     * @param $name
     * @param $controller
     * @param array $settings
     */
    public function addTheme( $name, $controller, $settings = [] )
    {
        self::add( 'theme', $name, $controller, $settings );
    }

    /**
     * Create a submenu under the Plugins tab
     *
     * @param $name
     * @param $controller
     * @param array $settings
     */
    public function addPlugins( $name, $controller, $settings = [] )
    {
        self::add( 'plugins', $name, $controller, $settings );
    }

    /**
     * @param $name
     * @param $controller
     * @param array $settings
     */
    public function addManagement( $name, $controller, $settings = [] )
    {
        self::add( 'management', $name, $controller, $settings );
    }

    /**
     * @param $name
     * @param $controller
     * @param array $settings
     */
    public function addOptions( $name, $controller, $settings = [] )
    {
        self::add( 'options', $name, $controller, $settings );
    }

    /**
     * Set Controller and method to array
     *
     * @param $controller
     * @return array
     */
    protected function setController( $controller )
    {
        $method = explode( '@', $controller );

        return [
            'controller' => $method[0],
            'method' => $method[1]
        ];
    }

    public static function setChannel( $channel )
    {
        static::$routeChannel = $channel;
    }

    /**
     * Check of the Router Class is being listened
     *
     * @return bool
     */
    public static function isBeingListened()
    {
        return isset( $_GET[ static::$routeChannel] ) && ! is_null( $_GET[ static::$routeChannel] );
    }

    /**
     * Adds a channel to a specific route
     *
     * @param $verb
     * @param $name
     * @param $controller
     */
    public static function addChannel( $verb, $name, $controller )
    {
        static::$currentChannel = static::$channels[$name][] = compact('verb', 'controller', 'name' );
    }

    /**
     * Get the controller of the router being listened
     *
     * @return mixed
     */
    public static function getController()
    {
        return (static::isBeingListened())
            ? explode( '@', static::$channels[$_GET[ static::$routeChannel ]][0]['controller'] )[0]
            : "" ;
    }


    public static function getMethod()
    {
        return (static::isBeingListened())
            ? explode( '@', static::$channels[$_GET[ static::$routeChannel ]][0]['controller'] )[1]
            : "" ;
    }

    public function redirect( $from, $to, $redirect = 302)
    {

    }

    /**
     * A wrapper for the add Channel with a GET http request
     *
     * @param $name
     * @param $controller
     */
    public function get($name, $controller)
    {
        $verb = "get";
        static::$currentChannel = static::$channels[$name][] = compact('verb', 'controller', 'name' );
    }

    /**
     * A wrapper for the add Channel with a POST http request
     *
     * @param $name
     * @param $controller
     */
    public function post($name, $controller)
    {
        $verb = "post";
        static::$currentChannel = static::$channels[$name][] = compact('verb', 'controller', 'name' );
    }


}
