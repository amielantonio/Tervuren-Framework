<?php

use App\Database\Schema;
use App\Database\SQL\Blueprint;

class StrataplanFormOptions {

    /**
     * Run the Migration
     */
    public function up()
    {
        Schema::create( 'strataplan_form_options', function( Blueprint $table){

            $table->increments( 'id' );
            $table->integer( 'form_id' );
            $table->string( 'ps_no', 128 );
            $table->text( 'address' );
            $table->string( 'options', 128 );
            $table->timestamps();
            $table->primary('id');
        });
    }

    public function down()
    {
        Schema::dropIfExists( 'strataplan-form-data' );
    }
}
