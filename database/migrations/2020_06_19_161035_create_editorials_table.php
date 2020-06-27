<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEditorialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('editorials', function (Blueprint $table) {
            $table->unsignedInteger('id', true);
            $table->string('name', 60);
            $table->string('image')->nullable();

            $table->unsignedInteger('fk_created_by');
            $table->foreign('fk_created_by')->references('id')->on('users');

            $table->unsignedInteger('fk_updated_by')->nullable();
            $table->foreign('fk_updated_by')->references('id')->on('users');

            $table->softDeletes();

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
        Schema::dropIfExists('editorials');
    }
}
