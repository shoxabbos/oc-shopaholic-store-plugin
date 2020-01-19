<?php namespace Shohabbos\Stores\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateShohabbosStoresOrders2 extends Migration
{
    public function up()
    {
        Schema::create('shohabbos_stores_orders', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('store_id')->unsigned();
            $table->integer('order_id')->unsigned();
            $table->integer('position_id')->unsigned();
            $table->integer('user_id')->nullable()->unsigned();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('shohabbos_stores_orders');
    }
}
