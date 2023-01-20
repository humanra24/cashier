<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('selling_temporary_details', function (Blueprint $table) {
            $table->id();
            $table->string('barcode', 50);
            $table->string('name', 50);
            $table->double('selling_price', 15, 4);
            $table->float('qty');
            $table->bigInteger('user_id');
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
        Schema::dropIfExists('selling_temporary_details');
    }
};
