<?php

use App\Database\Schema;
use App\Database\SQL\Blueprint;

class StrataplanFormData
{

    public function up()
    {

        Schema::create( 'Test', function( Blueprint $table ){

            $table->increments( 'id' );
            $table->string( 'name', 128 );
            $table->string( 'email', 128 );

        });

    }

    public function down()
    {

    }

}
