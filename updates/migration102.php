<?php namespace Shohabbos\Stores\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class Migration102 extends Migration
{
    public function up()
    {
        Schema::table('users', function($table) {
            $table->integer('is_store')->boolean()->default(0);
            $table->string('phone')->default('NULL');
            $table->string('profile_status')->default('simple');
            $table->string('user_address')->nulable('NULL');
        });

        Schema::table('lovata_shopaholic_products', function($table) {
            $table->integer('store_id')->nullable('NULL');
        });
    }

    public function down()
    {
        Schema::table('users', function($table) {
            $table->dropColumn('is_store'); 
            $table->dropColumn('phone'); 
            $table->dropColumn('profile_status'); 
            $table->dropColumn('user_address');
        });

        Schema::table('lovata_shopaholic_products', function($table) {
            $table->dropColumn(['store_id']); 
        });
        
    }
}