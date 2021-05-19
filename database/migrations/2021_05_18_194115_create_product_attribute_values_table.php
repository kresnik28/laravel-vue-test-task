<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductAttributeValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'product_attribute_values',
            function (Blueprint $table) {
                $table->bigInteger('product_id')->unsigned();
                $table->bigInteger('attribute_id')->unsigned();

                $table->string('value');

                $table->foreign('product_id')->references('id')->on('products');
                $table->foreign('attribute_id')->references('id')->on('attributes');
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_attribute_values');
    }
}
