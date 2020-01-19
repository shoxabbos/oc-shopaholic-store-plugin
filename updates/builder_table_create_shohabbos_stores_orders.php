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
            $table->string('shipping_price', 191);
            $table->string('payment_method', 191);
            $table->string('shipping_type', 191);
            $table->string('order_number', 191);
            $table->string('client_name', 191);
            $table->string('client_email', 191);
            $table->string('client_phone', 191);
            $table->string('shipping_address', 191);
            $table->integer('product_id');
            $table->integer('quantity');
            $table->string('product_name', 191);
            $table->timestamp('deleted_at')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('shohabbos_stores_orders');
    }
}
