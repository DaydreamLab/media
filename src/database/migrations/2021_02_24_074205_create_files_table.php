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
            $table->string('blobName')->nullable();
            $table->string('contentType')->nullable();
            $table->string('extension')->nullable();
            $table->string('size')->nullable();
            $table->string('url')->nullable();
            $table->string('web_url')->nullable();
            $table->text('introtext')->nullable();
            $table->text('description')->nullable();
            $table->unsignedTinyInteger('encrypted')->default(0);
            $table->string('password')->nullable();
            $table->unsignedBigInteger('access')->nullable();
            $table->unsignedBigInteger('ordering')->nullable();
            $table->text('params')->nullable();
            $table->unsignedInteger('locked_by')->nullable();
            $table->unsignedInteger('created_by');
            $table->unsignedInteger('updated_by')->nullable();
            $table->timestamp('locked_at')->nullable();
            $table->timestamp('publish_up')->nullable();
            $table->timestamp('publish_down')->nullable();
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
