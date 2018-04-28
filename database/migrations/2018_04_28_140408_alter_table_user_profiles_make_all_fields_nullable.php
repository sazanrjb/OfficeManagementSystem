<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableUserProfilesMakeAllFieldsNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->string('gender')->nullable()->change();
            $table->string('address')->nullable()->change();
            $table->string('contact')->nullable()->change();
            $table->string('profile_picture')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->string('profile_picture')->nullable(false)->change();
            $table->string('contact')->nullable(false)->change();
            $table->string('address')->nullable(false)->change();
            $table->string('gender')->nullable(false)->change();
        });
    }
}
