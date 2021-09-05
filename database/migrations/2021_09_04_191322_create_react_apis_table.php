<?php

use Facade\Ignition\Tabs\Tab;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReactApisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('react_apis', function (Blueprint $table) {
            $table->id();
            $table->string('phone');
            $table->string('store');
            $table->json('file');
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
        Schema::dropIfExists('react_apis');
    }
}
