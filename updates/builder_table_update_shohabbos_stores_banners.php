<?php namespace Shohabbos\Stores\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateShohabbosStoresBanners extends Migration
{
    public function up()
    {
        Schema::rename('shohabbos_stores_', 'shohabbos_stores_banners');
    }
    
    public function down()
    {
        Schema::rename('shohabbos_stores_banners', 'shohabbos_stores_');
    }
}