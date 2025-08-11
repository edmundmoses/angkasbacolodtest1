<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();

            // Link wallet to user (works for both driver & rider accounts)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // If this is specifically a driver wallet, store the driver_id
            $table->foreignId('driver_id')->nullable()->constrained('users')->onDelete('cascade');

            $table->decimal('balance', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wallets');
    }
};
