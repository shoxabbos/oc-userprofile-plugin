<?php namespace Shohabbos\UserProfile\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateShohabbosUserprofileProfile8 extends Migration
{
    public function up()
    {
        Schema::table('shohabbos_userprofile_profile', function($table)
        {
            $table->string('phone', 22)->nullable()->change();
            $table->string('jobs_address', 191)->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('shohabbos_userprofile_profile', function($table)
        {
            $table->string('phone', 22)->nullable(false)->change();
            $table->string('jobs_address', 191)->nullable(false)->change();
        });
    }
}
