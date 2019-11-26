<?php namespace Shohabbos\Stores\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateShohabbosStoresStores2 extends Migration
{
    public function up()
    {
        Schema::table('shohabbos_stores_stores', function($table)
        {
            $table->string('slug');
        });
    }
    
    public function down()
    {
        Schema::table('shohabbos_stores_stores', function($table)
        {
            $table->dropColumn('slug');
        });
    }
}