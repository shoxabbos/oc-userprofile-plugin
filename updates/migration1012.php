<?php namespace Shohabbos\UserProfile\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class Migration1012 extends Migration
{
    public function up()
    {
        Schema::table('users', function($table) {
            $table->boolean('leader')->nullable();
        });
    }

    public function down()
    {
        // Schema::drop('shohabbos_userprofile_table');
    }
}