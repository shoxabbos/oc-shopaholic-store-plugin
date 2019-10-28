<?php namespace Shohabbos\Stores\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateShohabbosStoresStores3 extends Migration
{
    public function up()
    {
        Schema::table('shohabbos_stores_stores', function($table)
        {
            $table->string('banner_name', 191);
            $table->string('banner_link', 191);
            $table->string('banner_type', 191);
        });
    }
    
    public function down()
    {
        Schema::table('shohabbos_stores_stores', function($table)
        {
            $table->dropColumn('banner_name');
            $table->dropColumn('banner_link');
            $table->dropColumn('banner_type');
        });
    }
}