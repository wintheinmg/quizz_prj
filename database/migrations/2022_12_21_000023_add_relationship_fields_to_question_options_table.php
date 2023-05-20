<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToQuestionOptionsTable extends Migration
{
    public function up()
    {
        Schema::table('question_options', function (Blueprint $table) {
            $table->unsignedBigInteger('question_id')->nullable();
            $table->foreign('question_id', 'question_fk_7734985')->references('id')->on('questions');
            $table->unsignedBigInteger('created_by_id')->nullable();
            $table->foreign('created_by_id', 'created_by_fk_7738820')->references('id')->on('users');
        });
    }
}