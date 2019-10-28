<?php namespace Shohabbos\Stores\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableDeleteShohabbosStoresOrders extends Migration
{
    public function up()
    {
        Schema::dropIfExists('shohabbos_stores_orders');
    }
    
    public function down()
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
            $table->timestamp('deleted_at')->nullable()->default('NULL');
            $table->timestamp('created_at')->nullable()->default('NULL');
            $table->timestamp('updated_at')->nullable()->default('NULL');
            $table->integer('store_id');
            $table->integer('buyer_id');
        });
    }
}
