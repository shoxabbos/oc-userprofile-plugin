<?php namespace Shohabbos\UserProfile\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateShohabbosUserprofileProfile extends Migration
{
    public function up()
    {
        Schema::create('shohabbos_userprofile_profile', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('user_id');
            $table->text('about')->nullable();
            $table->string('info')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('shohabbos_userprofile_profile');
    }
}
