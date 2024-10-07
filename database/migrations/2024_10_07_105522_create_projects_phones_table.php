<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsPhonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects_phones', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('project_id');
            $table->foreign('project_id')->references('id')->on('projects');
            $table->string('phone');
            $table->boolean('enabled');
            $table->unsignedMediumInteger('entries');
            $table->timestamp('last_entry_date')->nullable();
            $table->timestamps();

            // Индексация
            $table->index(columns: ['project_id', 'created_at']);
            $table->unique(columns: ['phone', 'project_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects_phones');
    }
}
