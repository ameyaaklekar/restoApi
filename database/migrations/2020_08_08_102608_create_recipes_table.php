<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecipesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->increments('id');
            $table->float('quantity', 5, 2);
            $table->enum('status', ['A','I','D'])->default('A'); //A = Active, I = Inactive, D = Delete
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('unit_id');
            $table->unsignedInteger('stock_id');
            $table->timestamps();

            // $table->foreign('product_id')->references('id')->on('product')
            //     ->onUpdate('cascade')->onDelete('cascade');

            // $table->foreign('unit_id')->references('id')->on('general_units')
            //     ->onUpdate('cascade')->onDelete('cascade');

            // $table->foreign('stock_id')->references('id')->on('stock')
            //     ->onUpdate('cascade')->onDelete('cascade');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recipes');
    }
}
