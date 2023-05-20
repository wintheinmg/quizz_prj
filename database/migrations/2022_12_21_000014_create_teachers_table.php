<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeachersTable extends Migration
{
    public function up()
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->date('date_of_birth');
            $table->integer('age');
            $table->string('parent_name');
            $table->longText('parent_occupation')->nullable();
            $table->string('nation_and_religion');
            $table->string('nrc')->unique();
            $table->string('contact_no');
            $table->longText('address');
            $table->date('start_date_of_employment');
            $table->longText('attended_courses')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
