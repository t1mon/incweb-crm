<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsIpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects_ips', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('project_id');
            $table->foreign('project_id')->references('id')->on('projects');
            $table->string('ip');
            $table->boolean('enabled');
            $table->timestamp('block_until');
            $table->timestamps();

            $table->index(columns: ['project_id', 'created_at']);
            $table->unique(columns: 'ip');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects_ips');
    }
}
