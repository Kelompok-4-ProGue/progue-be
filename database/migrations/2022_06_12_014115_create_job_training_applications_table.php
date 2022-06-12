<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobTrainingApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_training_applications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('job_training_id');
            $table->uuid('job_finder_id');
            $table->string('motivation_letter');
            $table->string('cv');
            $table->string('portfolio');
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->timestamps();

            $table->foreign('job_training_id')->references('id')->on('job_trainings')->onDelete('cascade');
            $table->foreign('job_finder_id')->references('id')->on('job_finders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_training_applications');
    }
}
