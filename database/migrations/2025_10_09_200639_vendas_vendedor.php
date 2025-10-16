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
        Schema::create('vendas_vendedor', function (Blueprint $table) {
            $table->id();
            $table->integer('codigo_vendedor')->nullable(false);
            $table->timestamp('data')->nullable(true);
            $table->integer('mes')->nullable(false);
            $table->integer('ano')->nullable(false);
            $table->decimal('vendido_bruto',15,2)->nullable(false);
            $table->decimal('desconto',15,2)->nullable(false);
            $table->decimal('vendido_liquido',15,2)->nullable(false);
            $table->decimal('devolucao',15,2)->nullable(false);
            $table->decimal('lucro',15,2)->nullable(true);
            $table->decimal('cmv',15,2)->nullable(true);
            $table->decimal('meta',15,2)->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendas_vendedor');
    }
};
