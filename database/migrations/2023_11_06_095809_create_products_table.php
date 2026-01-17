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
            $table->string('branch');
            $table->string('category');
            $table->string('name');
            $table->string('slog');
            $table->string('price');
            $table->string('discount');
            $table->string('img');
            $table->string('gallery');
            $table->string('sdes');
            $table->string('tags');
            $table->string('des');
            $table->string('ainfo');
            $table->string('colors');
            $table->string('stocks');
            $table->string('review');
            $table->integer('status');
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
