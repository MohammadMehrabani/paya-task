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
        Schema::create('account_transactions', function (Blueprint $table) {
            $table->id();

            $table->foreignUuid('account_id')->constrained('accounts');

            $table->unsignedTinyInteger('type');
            $table->unsignedTinyInteger('action');

            $table->morphs('request'); // paya or other implemented transfer requests

            $table->unsignedBigInteger('amount');
            $table->unsignedBigInteger('balance');
            $table->unsignedBigInteger('reserved_balance');

            $table->timestamps();

            $table->unique(['type', 'action', 'request_id', 'request_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_transactions');
    }
};
