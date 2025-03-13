<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('flights', function (Blueprint $table) {
        $table->time('departure_time')->nullable();
        $table->time('arrival_time')->nullable();
    });
}

public function down()
{
    Schema::table('flights', function (Blueprint $table) {
        $table->dropColumn(['departure_time', 'arrival_time']);
    });
}

};
