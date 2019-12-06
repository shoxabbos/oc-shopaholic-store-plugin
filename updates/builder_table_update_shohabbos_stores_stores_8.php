<?php namespace Shohabbos\Stores\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateShohabbosStoresStores8 extends Migration
{
    public function up()
    {
        Schema::table('shohabbos_stores_stores', function($table)
        {
            $table->string('name', 191)->default(null)->change();
            $table->string('address', 191)->default(null)->change();
            $table->string('contacts', 191)->default(null)->change();
            $table->string('legal_name', 191)->default(null)->change();
            $table->string('email', 191)->default(null)->change();
            $table->datetime('created_at')->default(null)->change();
            $table->datetime('updated_at')->default(null)->change();
            $table->datetime('deleted_at')->default(null)->change();
            $table->integer('commission')->default(null)->change();
        });
    }
    
    public function down()
    {
        Schema::table('shohabbos_stores_stores', function($table)
        {
            $table->string('name', 191)->default('\'NULL\'')->change();
            $table->string('address', 191)->default('NULL')->change();
            $table->string('contacts', 191)->default('NULL')->change();
            $table->string('legal_name', 191)->default('NULL')->change();
            $table->string('email', 191)->default('NULL')->change();
            $table->timestamp('created_at')->default('NULL')->change();
            $table->timestamp('updated_at')->default('NULL')->change();
            $table->timestamp('deleted_at')->default('NULL')->change();
            $table->integer('commission')->default(NULL)->change();
        });
    }
}
