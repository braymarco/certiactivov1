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
        Schema::create('provider_requests', function (Blueprint $table) {
            $table->id();
            $table->string('endpoint');
            $table->string('request_method');
            $table->string('response_status_code')->nullable();
            $table->text('request');
            $table->text('response')->nullable();
            $table->string('exception')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('provider_requests');
    }
};
