<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('seats', function (Blueprint $table) {
        $table->unsignedBigInteger('user_id')->nullable()->after('status');
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
}
};
