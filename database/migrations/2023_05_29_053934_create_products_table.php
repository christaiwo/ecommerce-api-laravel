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
            $table->foreignId('category_id')->constrained()->onUpdate('restrict')->onDelete('cascade');
            $table->string('image')->default('product/product.png');
            $table->string('name')->nullable();
            $table->longText('description');
            $table->float('amount')->nullable();
            $table->integer('total')->nullable();
            $table->integer('sold')->default(0);
            $table->integer('status')->default(1)->comment('0=inactive, 1=active');
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
