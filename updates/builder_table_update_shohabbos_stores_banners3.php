<?php namespace Shohabbos\Stores\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateShohabbosStoresBanners3 extends Migration
{
    public function up()
    {
        Schema::table('shohabbos_stores_banners', function($table)
        {
            $table->string('banner_size', 191);
        });
    }
    
    public function down()
    {
        Schema::table('shohabbos_stores_banners', function($table)
        {
            $table->dropColumn('banner_size');
        });
    }
}