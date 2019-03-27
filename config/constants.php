<?php
//Libraries
define( 'S_BASEPATH'    , dirname( __FILE__ ) );
define( 'S_LIBPATH'     , dirname( __FILE__) . "/lib" );
define( 'S_ASSETSPATH'  , dirname(__FILE__ ) . "/assets" );
define( 'S_CONFIGPATH'  , dirname(__FILE__ ) . "/config" );
define( 'S_DBPATH'      , dirname( __FILE__) . "/database" );
define( 'S_INCPATH'     , dirname( __FILE__) . "/includes" );
define( 'S_VIEWPATH'    , dirname( __FILE__) . "/templates" );


//Plugin
define( 'S_BASE_DIR', plugin_dir_path( __DIR__ ));


//Misc
define( 'S_VERSION', $this->version );
define( 'S_PHP_VERSION', $this->php_version );
