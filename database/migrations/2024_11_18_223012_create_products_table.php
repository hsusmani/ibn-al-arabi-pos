<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image')->nullable();
            $table->json('price');
            $table->integer('sku');
            $table->float('cost')->nullable();
            $table->string('barcode')->nullable();
            $table->float('weight')->nullable();
            $table->string('cover')->nullable();
            $table->integer('edition')->nullable();
            $table->string('author')->nullable();
            $table->string('dimensions')->nullable();
            $table->integer('pages')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
