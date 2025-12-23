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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->text('cnpj_empresa')->nullable(false);
            $table->integer('codigo_usuario')->nullable(false);
            $table->integer('codigo_vendedor')->nullable(true);
            $table->text('nome')->nullable(false);
            $table->text('email')->nullable(false);
            $table->text('password')->nullable(false);
            $table->text('senha_transacao')->nullable(false);
            $table->timestamp('ultimo_login')->nullable(true);
            $table->text('gerente')->nullable(true);
            $table->text('vendedor')->nullable(true);
            $table->text('recebe_notificacao')->nullable(true);
            $table->bigInteger('ultima_notificacao')->nullable(true);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
