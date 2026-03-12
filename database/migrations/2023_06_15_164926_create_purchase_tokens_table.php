<?php

use App\Enums\PurchaseTokenStatus;
use App\Models\Plan;
use App\Models\SignatureRequest;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('purchase_tokens', function (Blueprint $table) {
            $table->id();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('token');
            $table->string('tx_id');
            $table->foreignIdFor(Plan::class);
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(SignatureRequest::class)->nullable();

            $table->tinyInteger('status')->default(PurchaseTokenStatus::$CREATED);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_tokens');
    }
};
