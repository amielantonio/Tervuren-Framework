<?php

class PageCreator {

    protected $capabilityDefault = "manage_options";

    /**
     * Controller Namespace
     *
     * @var string
     */
    protected $controllerURL = "\App\Controller\\";

    public function create(Router $page )
    {
        foreach( $page::$pages as $page ) {
            $this->{'create_'.$page['location']}( $page );
        }

        return true;
    }

    protected function create_menu( $page )
    {
        $capability = isset($page['capability']) ? $page['capability'] : $this->capabilityDefault;

        if( current_user_can( $capability ) ){
            return add_menu_page(
                __( $page['title'], 'textdomain' ),
                __( $page['title'], 'textdomain' ),
                isset($page['capability']) ? $page['capability'] : $this->capabilityDefault,
                isset( $page['menu_slug'] ) ? $page['menu_slug'] : $this->toSlug( $page['title'] ),
                $this->setMethod( $page['function'] ),
                isset( $page['icon_url'] ) ? $page['icon_url'] : "",
                5
            );
        }

        return "";
    }

    protected function create_submenu( $page )
    {
        $capability = isset($page['capability']) ? $page['capability'] : $this->capabilityDefault;
        $parent_slug = $this->toSlug( $page['parent_name'] );

        if( current_user_can( $capability ) ){
            return add_submenu_page(
                $parent_slug,
                __($page['title'], 'textdomain' ),
                __($page['title'], 'textdomain' ),
                isset($page['capability']) ? $page['capability'] : $this->capabilityDefault,
                isset( $page['menu_slug'] ) ? $page['menu_slug'] : $this->toSlug( $page['title'] ),
                $this->setMethod( $page['function'] )
            );
        }

        return "";
    }

    /**
     * Sets the method to be used for the menu
     *
     * @param $method
     * @return array | Closure
     */
    protected function setMethod( $method )
    {
        if( $method instanceof Closure) {
            return $method;
        }

        $setClass =  $this->controllerURL.$method['controller'];

        $class = new $setClass;

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
