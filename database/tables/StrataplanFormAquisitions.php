<?php

use App\Database\Schema;
use App\Database\SQL\Blueprint;

class StrataplanFormAquisitions
{

    /**
     * Run the Migration
     */
    public function up()
    {
        Schema::create( 'strataplan_aquisitions', function( Blueprint $table ){

            $table->increments( 'id' );
            $table->string( 'name', 128 );
            $table->string( 'email', 128 );
            $table->text( 'phone' );
            $table->text( 'address' );
            $table->string( 'form_name', 128 );
            $table->string( 'date_filled', 128 );
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
