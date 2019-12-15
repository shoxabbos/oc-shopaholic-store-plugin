<?php namespace Shohabbos\Stores\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class Migration102 extends Migration
{
    public function up()
    {
        Schema::table('users', function($table) {
            $table->integer('is_store')->boolean()->default(0);
            $table->string('phone')->nulable();
            $table->string('user_address')->nulable();
        });

        Schema::table('lovata_shopaholic_products', function($table) {
            $table->integer('store_id')->nullable();
        });
    }

    public function down()
    {
        Schema::table('users', function($table) {
            $table->dropColumn('is_store'); 
            $table->dropColumn('phone'); 
            $table->dropColumn('user_address');            
        });

        Schema::table('lovata_shopaholic_products', function($table) {
            $table->dropColumn(['store_id']); 
        });
        
    }
}