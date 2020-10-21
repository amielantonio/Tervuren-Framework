<?php
namespace AWC\Helpers;

class Menu {


    protected $main = [];

    protected $settings = [];

    protected $subMenu = [];

    public function addSub( $page_title, $menu_title, $controller, $options = [] )
    {
        $this->subMenu[] = [
            'page-title' => $page_title,
            'menu-title' => $menu_title,
            'controller' => $controller,
            'options'    => $options
        ];
    }

    public function addMain( $page_title, $menu_title, $controller, $options = [] )
    {
        $this->main[] = [
            func_get_args()
        ];
    }

    public function addSettings()
    {

    }


    public function create()
    {

    }


    protected function createSubMenu()
    {
        foreach( $this->subMenu as $subMenu ){
            add_submenu_page(
                config( 'plugin.slug', '' ),
                $subMenu[ 'page-title' ],
                $subMenu[ 'menu-title' ],
                $subMenu[''],
                $subMenu['']
            );
        }
    }

    protected function createMenu()
    {

    }

}
