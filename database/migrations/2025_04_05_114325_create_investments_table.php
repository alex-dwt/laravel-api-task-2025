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
        Schema::create('investments', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedBigInteger('amount_fils');
            $table->foreignId('campaign_id')->constrained('campaigns');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investments');
    }
};
