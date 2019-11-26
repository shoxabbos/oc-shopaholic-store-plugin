<?php namespace Shohabbos\Stores\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateShohabbosStoresStores6 extends Migration
{
    public function up()
    {
        Schema::table('shohabbos_stores_stores', function($table)
        {
            $table->string('is_category', 191);
            $table->integer('commission')->default(null)->change();
        });
    }
    
    public function down()
    {
        Schema::table('shohabbos_stores_stores', function($table)
        {
            $table->dropColumn('is_category');
            $table->integer('commission')->default(NULL)->change();
        });
    }
}
