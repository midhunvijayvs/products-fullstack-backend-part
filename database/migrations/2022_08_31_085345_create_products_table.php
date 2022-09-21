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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->text('title');  // product title
            $table->text('description');   // description
            $table->text('short_note');   // short notes
            $table->decimal('price', 10, 2); // price
            $table->text('image_public_url');
            $table->text('image_name');
            $table->boolean('vat_applicable');
            $table->decimal('vat_percentage', 10, 2);
            
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
        Schema::dropIfExists('products');
    }
};
