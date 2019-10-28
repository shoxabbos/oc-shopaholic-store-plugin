<?php namespace Shohabbos\Stores\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class Migration1016 extends Migration
{
    public function up()
    {
        Schema::table('users', function($table) {
            $table->string('phone')->nulable();
        });
    }

    public function down()
    {
        Schema::table('users', function($table) {
            $table->dropColumn(['phone']); 
        });
    }
}