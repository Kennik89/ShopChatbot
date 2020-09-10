<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateGreetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('greets', function (Blueprint $table) {
            $table->id();
            $table->string('type')->index();
            $table->string('condition')->index()->nullable();
            $table->text('output');
        });

        $models = array(
            array('type' => 'greet', 'output' => 'Velkommen.'),
            array('type' => 'greet', 'output' => 'Hej.'),
            array('type' => 'greet', 'output' => 'Goddag.'),
            array('type' => 'provideHelp', 'output' => 'Er det noget jeg kan hjælpe med?'),
            array('type' => 'provideHelp', 'output' => 'Har du brug for hjælpen?'),
            array('type' => 'provideHelp', 'output' => 'Søger du efter noget specifikt?'),
            array('type' => 'emptyInput', 'output' => 'Prøv at skrive noget, så kan jeg se om kan jeg hjælpe dig på vejen.'),
            array('type' => 'inStock', 'output' => 'Vi har følgende {0} på lager:'),
            array('type' => 'notInStock', 'output' => '{0} er desværre ikke på lager. Vi beklager'),
            array('type' => 'notSellingThis', 'output' => 'Vi sælger ikke {0} i vores butik.'),
            array('type' => 'category', 'output' => 'Vi sælger følgende produkter i vores butik:'),
            array('type' => 'noInCategory', 'output' => 'Vi sælger desværre ikke produktet, men vi har en masse andre som du kan kigge på.'),
            array('type' => 'goodbye', 'output' => 'Du er velkommen til at skrive til os igen.'),
            array('type' => 'clarify', 'output' => 'Jeg er ikke helt med hvad du mener. Vil du være venligst at forklare igen?'),
        );

        DB::table('greets')->insert($models);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('greets');
    }
}
