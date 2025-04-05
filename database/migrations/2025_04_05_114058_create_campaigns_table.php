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
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('name');
            $table->string('image_url');

            $table->unsignedBigInteger('target_amount_fils');
            $table->unsignedBigInteger('current_amount_fils')->default(0);
            $table->unsignedInteger('percentage_raised')->default(0);

            $table->string('city_area');
            $table->string('country_code', 2);

            $table->unsignedInteger('investors_count')->default(0);
            $table->unsignedBigInteger('investment_multiple_fils');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};
