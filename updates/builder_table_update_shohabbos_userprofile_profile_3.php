<?php namespace Shohabbos\UserProfile\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateShohabbosUserprofileProfile3 extends Migration
{
    public function up()
    {
        Schema::table('shohabbos_userprofile_profile', function($table)
        {
            $table->string('jobs_address');
            $table->dateTime('birthday')->nullable();
            $table->renameColumn('info', 'social_link');
        });
    }
    
    public function down()
    {
        Schema::table('shohabbos_userprofile_profile', function($table)
        {
            $table->dropColumn('jobs_address');
            $table->dropColumn('birthday');
            $table->renameColumn('social_link', 'info');
        });
    }
}
