<?php namespace Shohabbos\Stores\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class Migration1020 extends Migration
{
    public function up()
    {
        Schema::table('users', function($table) {
            $table->string('user_address')->nulable();
        });
    }

    public function down()
    {
        Schema::table('users', function($table) {
            $table->dropColumn(['user_address']); 
        });
    }
}