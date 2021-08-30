<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateAnalyzedTable
 */
class CreateAnalyzedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('analyzed', function (Blueprint $table) {
            $table->id();
            $table->string('filePath');
            $table->dateTime('uploadTime');
            $table->tinyInteger('status');
            $table->string('step', 9)->nullable();
            $table->text('analyzeError')->nullable();
            $table->string('resultPath')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('analyzed');
    }
}
