<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_units', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description');
            $table->float('ratio', 4, 2);
            $table->unsignedInteger('weight_id');
            $table->unsignedInteger('company_id');
            $table->timestamps();

            $table->foreign('weight_id')->references('id')->on('weight_type')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('company_id')->references('id')->on('company')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_units');
    }
}
