<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePageContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page_contents', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug_title',500);
            $table->integer('page_id');
            $table->index('page_id');
            $table->longText('title',5000)->nullable();
            $table->longText('file_name',500)->nullable();
            $table->enum('file_type',['Image', 'Video'])->nullable();
            $table->longText('content',5000)->nullable();
            $table->dateTime('entry_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('page_contents');
    }
}
