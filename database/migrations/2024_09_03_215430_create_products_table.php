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
            $table->unsignedBigInteger("user_id")->index();
            $table->unsignedBigInteger("product_category_id")->index();
            $table->string("name",100);
            $table->integer("price");
            $table->integer("qty")->default(1);
            $table->text("desc")->nullable();         
            $table->string("thumbnail")->nullable();   
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
