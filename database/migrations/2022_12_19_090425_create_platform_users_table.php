<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('platform_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->comment('users.id');
            $table->string('platform')->comment('平台');
            $table->string('platform_id')->comment('使用者ID')->unique();
            $table->string('display_name')->comment('名稱');
            $table->string('picture_url')->nullable()->comment('頭像');
            $table->string('status_message')->nullable()->comment('狀態');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['user_id', 'platform']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('platform_users');
    }
};
