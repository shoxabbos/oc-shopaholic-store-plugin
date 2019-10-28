<?php namespace Shohabbos\Stores\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateShohabbosStores extends Migration
{
    public function up()
    {
        Schema::create('shohabbos_stores_', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('name', 191);
            $table->string('type', 191);
            $table->string('link', 191);
            $table->integer('store_id');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('shohabbos_stores_');
    }
}