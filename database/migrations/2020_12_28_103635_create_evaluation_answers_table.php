<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvaluationAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluation_answers', function (Blueprint $table) {
            $table->uuid('id')->unique();
            $table->uuid('answer_sheet_id');
            $table->uuid('evaluation_id');
            $table->boolean('answer');
            $table->timestamps();
            $table->primary('id');
            $table->foreign('answer_sheet_id')->references('id')->on('answer_sheets');
            $table->foreign('evaluation_id')->references('id')->on('evaluations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evaluation_answers');
    }
}
