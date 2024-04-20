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
        Schema::create('productos_seleccionados', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedInteger('pedido_id');
            $table->unsignedInteger('producto_id');
            $table->integer('cantidad');
            $table->decimal('precio',10,2);
            $table->foreign('pedido_id')->references('id')->on('pedido');
            $table->foreign('producto_id')->references('id')->on('producto');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos_seleccionados');
    }
};
