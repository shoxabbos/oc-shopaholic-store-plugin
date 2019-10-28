<?php namespace Shohabbos\Stores\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateShohabbosStoresOrders2 extends Migration
{
    public function up()
    {
        Schema::table('shohabbos_stores_orders', function($table)
        {
            $table->integer('buyer_id');
        });
    }
    
    public function down()
    {
        Schema::table('shohabbos_stores_orders', function($table)
        {
            $table->dropColumn('buyer_id');
        });
    }
}
