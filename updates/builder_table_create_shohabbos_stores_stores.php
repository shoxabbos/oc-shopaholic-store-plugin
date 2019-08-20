<?php namespace Shohabbos\Stores\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateShohabbosStoresStores extends Migration
{
    public function up()
    {
        Schema::create('shohabbos_stores_stores', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->string('address')->nullable();
            $table->string('contacts')->nullable();
            $table->string('legal_name')->nullable();
            $table->string('email')->nullable();
            $table->integer('user_id')->unsigned();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('shohabbos_stores_stores');
    }
}
