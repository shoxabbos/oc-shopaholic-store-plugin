<?php namespace Shohabbos\Stores\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateShohabbosStoresOrders extends Migration
{
    public function up()
    {
        Schema::create('shohabbos_stores_orders', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('store_id')->unsigned();
            $table->integer('order_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('amount')->unsigned();
            $table->text('positions', 1000);
            $table->timestamp('created_at')->nulable('NULL');
            $table->timestamp('updated_at')->nulable('NULL');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('shohabbos_stores_orders');
    }
}
