<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompetenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('competencies', function (Blueprint $table) {
            $table->uuid('id')->unique();
            $table->uuid('interview_form_id');
            $table->string('competency');
            $table->unsignedTinyInteger('score');
            $table->text('evidence')->nullable();
            $table->timestamps();
            $table->primary('id');
            $table->foreign('interview_form_id')->references('id')->on('interview_forms');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('competencies');
    }
}
