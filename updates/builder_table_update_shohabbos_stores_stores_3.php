<?php namespace Shohabbos\Stores\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateShohabbosStoresStores3 extends Migration
{
    public function up()
    {
        Schema::table('shohabbos_stores_stores', function($table)
        {
            $table->text('description');
            $table->smallInteger('content');
        });
    }
    
    public function down()
    {
        Schema::table('shohabbos_stores_stores', function($table)
        {
            $table->dropColumn('description');
            $table->dropColumn('content');
        });
    }
}
