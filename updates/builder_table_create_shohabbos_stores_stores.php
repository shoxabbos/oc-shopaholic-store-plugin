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
            $table->integer('commission')->nulable('NULL');
            $table->string('name', 191);
            $table->string('slug', 191);
            $table->text('description')->nulable('NULL');
            $table->text('content')->nulable('NULL');
            $table->string('address', 191)->nulable('NULL');
            $table->string('contacts', 191)->nulable('NULL');
            $table->string('legal_name', 191)->nulable('NULL');
            $table->string('email', 191)->nulable('NULL');
            $table->string('is_category', 191)->nulable('NULL');
            $table->timestamp('created_at')->nulable('NULL');
            $table->timestamp('updated_at')->nulable('NULL');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('shohabbos_stores_stores');
    }
}