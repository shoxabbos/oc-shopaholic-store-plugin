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
            $table->integer('user_id')->unsigned();
            $table->integer('store_id')->unsigned();
            $table->integer('commission')->nullable();
            $table->string('name', 191);
            $table->string('slug', 191);
            $table->text('description')->nullable();
            $table->text('content')->nullable();
            $table->string('address', 191)->nullable();
            $table->string('contacts', 191)->nullable();
            $table->string('legal_name', 191)->nullable();
            $table->string('email', 191)->nullable();
            $table->string('is_category', 191)->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('shohabbos_stores_stores');
    }
}