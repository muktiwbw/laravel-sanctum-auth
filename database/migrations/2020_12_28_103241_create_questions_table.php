<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->uuid('id')->unique();
            $table->uuid('level_id');
            $table->uuid('case_study_id');
            $table->unsignedTinyInteger('number');
            $table->text('body');
            $table->string('type')->default('MULTIPLE');
            $table->text('essay')->nullable();
            $table->unsignedTinyInteger('score')->nullable();
            $table->timestamps();
            $table->primary('id');
            $table->foreign('level_id')->references('id')->on('levels');
            $table->foreign('case_study_id')->references('id')->on('case_studies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questions');
    }
}
