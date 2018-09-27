<?php

use App\Database\Schema;
use App\Database\SQL\Blueprint;

class StrataplanFormData
{

    /**
     * Run the Migration
     */
    public function up()
    {
        Schema::create( 'strataplan-form-data', function( Blueprint $table ){

            $table->increments( 'id' );
            $table->string( 'name', 128 );
            $table->string( 'email', 128 );
            $table->primary('id');

        });
    }

    /**
     * Reverse the Migration
     */
    public function down()
    {
        Schema::dropIfExists( 'strataplan-form-data' );
    }

}
