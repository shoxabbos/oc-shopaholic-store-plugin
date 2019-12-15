<?php namespace Shohabbos\Stores\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateShohabbosStoresBanners extends Migration
{
    public function up()
    {
        Schema::create('shohabbos_stores_banners', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('store_id')->unsigned();
            $table->string('name', 191);
            $table->string('type', 191);
            $table->string('link', 191);
            $table->string('banner_size', 191);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('shohabbos_stores_banners');
    }
}