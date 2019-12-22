<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class StoreUserPhotos extends Migration
{
    public function up()
    {
        Schema::table('people', function (Blueprint $table) {
            $table->string('photo')->nullable()->default(null);
        });
    }

    public function down()
    {
        Schema::table('people', function (Blueprint $table) {
            $table->dropColumn('photo');
        });
    }
}
