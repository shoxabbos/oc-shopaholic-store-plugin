<?php namespace Shohabbos\Stores\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateShohabbosStoresStores7 extends Migration
{
    public function up()
    {
        Schema::table('shohabbos_stores_stores', function($table)
        {
            $table->string('name', 191)->default('NULL')->change();
            $table->integer('commission')->default(null)->change();
        });
    }
    
    public function down()
    {
        Schema::table('shohabbos_stores_stores', function($table)
        {
            $table->string('name', 191)->default(null)->change();
            $table->integer('commission')->default(NULL)->change();
        });
    }
}
