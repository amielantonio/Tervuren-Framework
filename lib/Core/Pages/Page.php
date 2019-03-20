<?php
namespace App\Core\Pages;

use Closure;
use App\Core\Pages\PageCreator;

class Page {


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
     * @var Page
     */
    protected static $instance;

    /**
     * @var \App\Core\Pages\PageCreator
     */
    protected $creator;

    /**
     * Page constructor.
     */
    public function __construct()
    {
        $this->creator = new PageCreator();
    }

    /**
     * Create a page?
     *
     * @param string $location
     * @param string $title
     * @param Closure|string $controller
     * @param array $settings
     * @return Page
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

    public static function create()
    {
        add_action( 'admin_menu', array( self::$instance, 'create_pages' ) );
    }

    public function create_pages()
    {
         return self::$instance->creator->create( self::$instance ) ;
    }


    public static function addMenu( $name, $controller, $settings = [] )
    {
        self::add( 'menu', $name, $controller, $settings );

        return self::$instance;
    }

    public function addSubmenu( $parent_name, $name, $controller, $settings = [] )
    {
        self::add( 'submenu' );
    }

    public function addDashboard( $name, $controller, $settings = [] )
    {

    }

    public function addPosts( $name, $controller, $settings = [] )
    {

    }

    public function addUtility( $name, $controller, $settings = [] )
    {

    }

    public function addMedia( $name, $controller, $settings = [] )
    {

    }

    public function addComments( $name, $controller, $settings = [] )
    {

    }

    public function addPages( $name, $controller, $settings = [] )
    {

    }

    public function addUsers( $name, $controller, $settings = [] )
    {

    }

    public function addTheme( $name, $controller, $settings = [] )
    {

    }

    public function addPlugins( $name, $controller, $settings = [] )
    {

    }

    public function addManagement( $name, $controller, $settings = [] )
    {

    }

    public function addOptions( $name, $controller, $settings = [] )
    {

    }

    public function name( $name )
    {
        echo $name;
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
