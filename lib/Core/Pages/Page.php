<?php


class Page {

    protected $options = [
        'menu' => 'add_menu_page',
        'submenu' => 'add_submenu_page',
        'utility' => 'add_utility_page',
        'dashboard' => 'add_utility_page',
        'posts' => 'add_posts_page',
        'media' => 'add_media_page',
        'pages' => 'add_media_page',
        'comments' => 'add_media_page',
        'theme' => 'add_theme_page',
        'plugins' => 'add_plugins_page',
        'users' => 'add_users_page',
        'management' => 'add_management_page',
        'options' => 'add_options_page'
    ];

    protected $pages = [];

    protected static $instance;

    /**
     * @var array
     */
    protected $creator;

    public function __construct()
    {

    }

    /**
     * Create a page?
     *
     * @param $location
     * @param $name
     * @param $controller
     * @param $settings
     * @return Page
     */
    public static function add( $location, $name, $controller, $settings )
    {
        if ( ! self::$instance ) {
            self::$instance = new self;
        }

//        self::$instance->bindings[$location]();

        if( is_string( $controller )) {
            self::$instance->controller = explode( '@', $controller );
        }

        // run location to create page




        return self::$instance;

    }

    protected function create()
    {

    }

    public static function addMenu( $name, $controller, $settings )
    {
        self::add( 'menu', $name, $controller, $settings );

        return self::$instance;
    }

    public function addSubmenu( $name, $controller, $settings )
    {

    }

    public function addDashboard( $name, $controller, $settings )
    {

    }

    public function addPosts( $name, $controller, $settings )
    {

    }

    public function addUtility( $name, $controller, $settings )
    {

    }

    public function addMedia( $name, $controller, $settings )
    {

    }

    public function addComments( $name, $controller, $settings )
    {

    }

    public function addPages( $name, $controller, $settings )
    {

    }

    public function addUsers( $name, $controller, $settings )
    {

    }

    public function addTheme( $name, $controller, $settings )
    {

    }

    public function addPlugins( $name, $controller, $settings )
    {

    }

    public function addManagement( $name, $controller, $settings )
    {

    }

    public function addOptions( $name, $controller, $settings )
    {

    }

    public function name()
    {

    }

    protected function setController()
    {

    }

    protected function toSlug()
    {

    }

    protected function instance()
    {
        return $this;
    }

    protected function bindAction( $location, $action, $settings )
    {

    }

    protected function getBinding( $key )
    {

    }


}
