<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRequirementInJobVacancies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('job_vacancies', function (Blueprint $table) {
            $table->string('description')->after('position');
            $table->string('requirement')->after('description');
            $table->string('additional_requirement')->nullable()->after('requirement');
            $table->enum('category', ['wfh', 'wfo', 'hybrid'])->after('salary')->default('wfh');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('job_vacancies', function (Blueprint $table) {
            //
        });
    }
}
