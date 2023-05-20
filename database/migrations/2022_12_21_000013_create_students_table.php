<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->date('date')->nullable();
            $table->string('name');
            $table->string('nrc')->nullable();
            $table->longText('address');
            $table->string('phone_no');
            $table->string('email')->nullable();
            $table->string('acca_student_no')->nullable();
            $table->string('subject')->nullable();
            $table->string('exam_session_period')->nullable();
            $table->string('old_student')->nullable();
            $table->string('which')->nullable();
            $table->string('how_knew_acca')->nullable();
            $table->string('why_choose')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
