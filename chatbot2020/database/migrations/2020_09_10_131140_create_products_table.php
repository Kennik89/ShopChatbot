<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('type')->index();
            $table->string('name');
            $table->integer('stock');
            $table->string('price');
            $table->string('brand');
            $table->timestamps();
        });

        $models = array(
            array('type' => 'hammer', 'name' => 'AliceHammer', 'stock' => 40, 'price' => '399 DKK', 'brand' => 'Ahammer'),
            array('type' => 'hammer', 'name' => 'BobHammer', 'stock' => 10, 'price' => '850 DKK', 'brand' => 'Bosch'),
            array('type' => 'hammer', 'name' => 'ChristyHammer', 'stock' => 0, 'price' => '80 DKK', 'brand' => 'Contools'),
            array('type' => 'skruetrækker', 'name' => 'AScrew', 'stock' => 0, 'price' => '30 DKK', 'brand' => 'Bosch'),
            array('type' => 'boremaskine', 'name' => 'PowerDrill', 'stock' => 100, 'price' => '3000 DKK', 'brand' => 'Bosch'),
        );

        DB::table('products')->insert($models);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
