<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMicropostsFavorites extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('favorites', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('microposts_id');
            $table->timestamps();
            
            //外部キー制約をかける
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('microposts_id')->references('id')->on('microposts')->onDelete('cascade');
            
            // user_idとmicroposts_idの組み合わせの重複を許さない
            $table->unique(['user_id', 'microposts_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('favorites');
    }
}
