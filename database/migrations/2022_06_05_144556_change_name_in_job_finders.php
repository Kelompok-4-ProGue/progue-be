<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeNameInJobFinders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('job_finders', function (Blueprint $table) {
            $table->renameColumn('full_name', 'name');
        });

        Schema::table('companies', function (Blueprint $table) {
            $table->renameColumn('company_name', 'name');
            $table->renameColumn('company_address', 'address');
            $table->renameColumn('company_letter', 'letter');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('job_finders', function (Blueprint $table) {
            //
        });
    }
}
