<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestsTable extends Migration
{
    public function up()
    {
        Schema::create('tests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->nullable();
            $table->longText('description')->nullable();
            $table->integer('duration')->default(0);
            $table->boolean('is_published')->default(0)->nullable();
            $table->integer('pass_score')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }
}