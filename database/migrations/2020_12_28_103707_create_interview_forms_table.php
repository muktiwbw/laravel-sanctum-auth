<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInterviewFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interview_forms', function (Blueprint $table) {
            $table->uuid('id')->unique();
            $table->uuid('answer_id');
            $table->string('fullName');
            $table->date('dob');
            $table->string('education');
            $table->string('unit');
            $table->string('position');
            $table->string('interview');
            $table->string('result');
            $table->string('type')->default('SIMULATION');
            $table->timestamps();
            $table->primary('id');
            $table->foreign('answer_id')->references('id')->on('answers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('interview_forms');
    }
}
