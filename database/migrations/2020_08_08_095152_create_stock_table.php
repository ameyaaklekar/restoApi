<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('code');
            $table->float('quantity', 5, 2);
            $table->double('price_per_unit'. 5, 2);
            $table->double('total_price', 5, 2);
            $table->enum('status', ['A','I','D'])->default('A'); //A = Active, I = Inactive, D = Delete
            $table->unsignedInteger('supplier_id');
            $table->unsignedInteger('stock_unit_id');
            $table->timestamps();

            $table->foreign('supplier_id')->references('id')->on('suppliers')
                ->onDelete('cascade');

            $table->foreign('stock_unit_id')->references('id')->on('stock_units')
                ->onDelete('cascade');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock');
    }
}
