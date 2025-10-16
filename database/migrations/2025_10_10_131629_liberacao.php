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

        Schema::create('liberacao', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('numero_venda')->nullable(false);
            $table->integer('codigo_vendedor')->nullable(false);
            $table->bigInteger('cliente_numero')->nullable(false);
            $table->text('cliente_razao')->nullable(false);
            $table->text('cliente_fantasia')->nullable(false);
            $table->decimal('venda_total',15,2)->nullable(false);
            $table->text('motivo_liberacao')->nullable(false);
            $table->integer('usuario_liberou')->nullable(true);
            $table->text('obs_liberacao')->nullable(true);
            $table->timestamps();

        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('liberacao');
    }
};
