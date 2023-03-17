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
        Schema::create('line_groups', function (Blueprint $table) {
            $table->id();
            $table->string('group_id', 33)->unique()->comment('Line 群組 ID');
            $table->string('name')->comment('群組名稱');
            $table->integer('count')->default(0)->comment('群組人數');
            $table->string('picture_url')->nullable()->comment('群組頭像');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('line_groups');
    }
};
