<?php

use App\Enums\DocumentUpdateStatus;
use App\Models\Document;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('document_updates', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Document::class)->nullable();
            $table->foreignId('previus_document_id')->constrained('documents');
            $table->tinyInteger('status')->default(DocumentUpdateStatus::$CREATED);
            $table->string('token');
            $table->string('comentario')->nullable();
            $table->string('type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_updates');
    }
};
