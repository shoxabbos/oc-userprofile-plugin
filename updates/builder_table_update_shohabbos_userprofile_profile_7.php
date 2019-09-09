<?php namespace Shohabbos\UserProfile\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateShohabbosUserprofileProfile7 extends Migration
{
    public function up()
    {
        Schema::table('shohabbos_userprofile_profile', function($table)
        {
            $table->date('birthday')->nullable()->unsigned(false)->default(null)->change();
        });
    }
    
    public function down()
    {
        Schema::table('shohabbos_userprofile_profile', function($table)
        {
            $table->smallInteger('birthday')->nullable()->unsigned(false)->default(null)->change();
        });
    }
}
