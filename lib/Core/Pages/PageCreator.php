<?php

namespace App\Core\Pages;

use Closure;
use ReflectionMethod;
use App\Core\Pages\Page;

class PageCreator {

    protected $capabilityDefault = "manage_options";

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

    protected $controllerURL = "\\App\\Controller\\";

    public function create( Page $page )
    {
        foreach( $page::$pages as $page ) {

            $this->{'create_'.$page['location']}( $page );

        }
    }

    protected function create_menu( $page )
    {
        if( current_user_can( $page['capability'] ) ){
            return add_menu_page(
                __( $page['title'], 'textdomain' ),
                __( $page['title'], 'textdomain' ),
                isset($page['capability']) ? $page['capability'] : $this->capabilityDefault,
                isset( $page['menu_slug'] ) ? $page['menu_slug'] : $this->toSlug( $page['title'] ),
                $this->setMethod( $page['function'] ),
                isset( $page[''] ),
                5
            );
        }

        return "";
    }

    protected function setMethod( $method )
    {
        if( $method instanceof Closure) {
            return $method;
        }

        $class = new $this->controllerURL.$method['controller'];

        echo $this->controllerURL.$method['controller'];

//        var_dump([ $class, $method['method'] ]);

        return [ $class, $method['method'] ];
    }

    protected function toSlug( $string )
    {
        // replace non letter or digits by -
        $string = preg_replace('~[^\pL\d]+~u', '-', $string);

        // transliterate
        $string = iconv('utf-8', 'us-ascii//TRANSLIT', $string);

        // remove unwanted characters
        $string = preg_replace('~[^-\w]+~', '', $string);

        // trim
        $string = trim($string, '-');

        // remove duplicate -
        $string = preg_replace('~-+~', '-', $string);

        // lowercase
        $string = strtolower($string);

        if (empty($string)) {
            return 'n-a';
        }

        return $string;
    }
}
