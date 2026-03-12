<?php

use App\Enums\FormatoFirma;
use App\Enums\SignatureRequestStatus;
use App\Models\Plan;
use App\Models\PurchaseToken;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('signature_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(PurchaseToken::class)->nullable();
            $table->string('tipo');
            $table->string('tipo_documento');
            $table->string('nro_documento');
            $table->string('codigo_dactilar');
            $table->string('nombres');
            $table->string('apellido1');
            $table->string('apellido2')->nullable();
            $table->date('fecha_nacimiento');
            $table->string('nacionalidad');
            $table->string('sexo');
            $table->string('celular');
            $table->string('email');
            $table->string('celular2')->nullable();
            $table->string('email2')->nullable();
            $table->boolean('con_ruc');
            $table->string('nro_ruc')->nullable();
            //representante legal
            $table->string('empresa')->nullable();
            $table->string('cargo')->nullable();
            //miembro de empresa
            $table->string('unidad')->nullable();
            $table->string('tipo_documento_rl')->nullable();
            $table->string('nro_documento_rl')->nullable();
            $table->string('nombres_rl')->nullable();
            $table->string('apellido1_rl')->nullable();
            $table->string('apellido2_rl')->nullable();

            $table->foreignIdFor(\App\Models\Provincia::class);
            $table->foreignIdFor(\App\Models\Canton::class);
            $table->string('direccion');
            $table->tinyInteger('formato')->default(FormatoFirma::$ARCHIVO);
            $table->foreignIdFor(Plan::class);
            $table->boolean('express')->default(false);
            $table->string('sn_token')->nullable();
            $table->string('token');


            $table->tinyInteger('estado')->default(SignatureRequestStatus::$CREATED);
            $table->string('ip');
            $table->text('provider_response')->nullable();
            $table->boolean('provider_sended')->default(false);

            //Nro. Serial del Token

            $table->timestamp('fecha_requisitos_validados')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('signature_requests');
    }
};
