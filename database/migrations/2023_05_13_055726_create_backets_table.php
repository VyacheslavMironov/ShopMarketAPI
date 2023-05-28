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
        Schema::create('backets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('users_id')
                ->constrained()
                ->onDelete("CASCADE");
            $table->foreignId('shops_id')
                ->constrained()
                ->onDelete("CASCADE");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('backets');
    }
};
