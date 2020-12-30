<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->uuid('id')->unique();
            $table->uuid('answer_sheet_id');
            $table->uuid('question_id');
            $table->string('type');
            $table->string('point', 1)->nullable();
            $table->text('essay')->nullable();
            $table->json('checklist')->nullable();
            $table->timestamps();
            $table->primary('id');
            $table->foreign('answer_sheet_id')->references('id')->on('answer_sheets');
            $table->foreign('question_id')->references('id')->on('questions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('answers');
    }
}
