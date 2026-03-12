<?php

use App\Models\SignatureRequest;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('uanataca_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(SignatureRequest::class)->nullable();
            $table->string('token')->nullable();
            $table->string('documento')->nullable();
            $table->string('documento_tipo')->nullable();
            $table->timestamp('fecha_registro')->nullable();
            $table->string('uid')->nullable();
            $table->string('estado')->nullable();
            $table->text('observacion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uanataca_requests');
    }
};
