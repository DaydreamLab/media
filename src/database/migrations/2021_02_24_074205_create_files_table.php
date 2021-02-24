<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid');
            $table->string('name');
            $table->unsignedInteger('category_id')->nullable();
            $table->tinyInteger('state')->default(1);
            $table->string('contentType');
            $table->string('extension');
            $table->string('size');
            $table->string('url');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('access')->nullable();
            $table->unsignedBigInteger('ordering')->nullable();
            $table->unsignedInteger('created_by');
            $table->unsignedInteger('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('files');
    }
}
