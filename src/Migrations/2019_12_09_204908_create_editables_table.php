<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEditablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('editables')) return;

        Schema::create('editables', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->json('data');
            $table->bigInteger('editable_id');
            $table->string('editable_type');
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
        if (!Schema::hasTable('editables')) return;

        Schema::dropIfExists('editables');
    }
}
