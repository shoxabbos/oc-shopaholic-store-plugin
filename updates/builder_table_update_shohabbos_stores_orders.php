<?php namespace Shohabbos\Stores\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateShohabbosStoresOrders extends Migration
{
    public function up()
    {
        Schema::table('shohabbos_stores_orders', function($table)
        {
            $table->integer('store_id');
        });
    }
    
    public function down()
    {
        Schema::table('shohabbos_stores_orders', function($table)
        {
            $table->dropColumn('store_id');
        });
    }
}
