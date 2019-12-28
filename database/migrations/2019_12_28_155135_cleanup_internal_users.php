<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CleanupInternalUsers extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('password');
            $table->dropColumn('email_verified_at');
            $table->dropColumn('remember_token');
            $table->string('photo')->after('email')->nullable(true);
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('password')->nullable(false);
            $table->timestamp('email_verified_at')->nullable(true);
            $table->string('remember_token', 100)->nullable(true);
            $table->dropColumn('photo');
        });
    }
}
