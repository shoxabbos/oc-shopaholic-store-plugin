<?php namespace Shohabbos\Stores\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateShohabbosStoresOrders4 extends Migration
{
    public function up()
    {
        Schema::table('shohabbos_stores_orders', function($table)
        {
            $table->integer('amount');
        });
    }
    
    public function down()
    {
        Schema::table('shohabbos_stores_orders', function($table)
        {
            $table->dropColumn('amount');
        });
    }
}