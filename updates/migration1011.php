<?php namespace Shohabbos\UserProfile\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class Migration1011 extends Migration
{
    public function up()
    {
        Schema::table('users', function($table) {
            $table->text('key')->nullable();
        });
    }

    public function down()
    {
        // Schema::drop('shohabbos_userprofile_table');
    }
}