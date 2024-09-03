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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_id")->index();
            $table->unsignedBigInteger("driver_id")->index();
            $table->string("code",12);
            $table->integer("shipping_cost");
            $table->decimal("from_latitude",10,8)->nullable();
            $table->decimal("from_longitude",11,8)->nullable();
            $table->decimal("to_latitude",10,8)->nullable();
            $table->decimal("to_longitude",11,8)->nullable();
            $table->tinyInteger("status")->default(1)->comment("1 mencari driver|2 proses| 3 pengiriman| 4 selesai| 5 cencel");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
