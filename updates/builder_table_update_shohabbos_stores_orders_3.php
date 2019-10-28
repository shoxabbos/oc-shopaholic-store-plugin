<?php namespace Shohabbos\Stores\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateShohabbosStoresOrders3 extends Migration
{
    public function up()
    {
        Schema::table('shohabbos_stores_orders', function($table)
        {
            $table->integer('user_id')->nullable(false)->unsigned(false)->default(0)->change();
        });
    }
    
    public function down()
    {
        Schema::table('shohabbos_stores_orders', function($table)
        {
            $table->integer('user_id')->nullable()->unsigned()->default(NULL)->change();
        });
    }
}
