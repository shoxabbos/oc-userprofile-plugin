<?php namespace Shohabbos\UserProfile\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateShohabbosUserprofileProfile4 extends Migration
{
    public function up()
    {
        Schema::table('shohabbos_userprofile_profile', function($table)
        {
            $table->string('phone', 13)->change();
        });
    }
    
    public function down()
    {
        Schema::table('shohabbos_userprofile_profile', function($table)
        {
            $table->string('phone', 10)->change();
        });
    }
}
