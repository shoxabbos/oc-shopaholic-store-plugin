<?php namespace Shohabbos\Stores\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class Migration105 extends Migration
{
    public function up()
    {
        Schema::table('lovata_shopaholic_products', function($table) {
            $table->integer('store_id')->nullable();
        });
    }

    public function down()
    {
        Schema::table('lovata_shopaholic_products', function($table) {
            $table->dropColumn(['store_id']); 
        });
    }
}