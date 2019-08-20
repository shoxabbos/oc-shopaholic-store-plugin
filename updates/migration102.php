<?php namespace Shohabbos\Stores\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class Migration102 extends Migration
{
    public function up()
    {
        Schema::table('users', function($table) {
            $table->integer('is_store')->boolean()->default(0);
        });
    }

    public function down()
    {
        Schema::table('users', function($table) {
            $table->dropColumn(['is_store']); 
        });
    }
}