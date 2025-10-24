<?php

use App\Domains\TransferRequest\Enums\PayaTransferRequestStatusEnum;
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
        Schema::create('paya_transfer_requests', function (Blueprint $table) {
            $table->id();

            $table->foreignUuid('account_id')->constrained('accounts');

            $table->string('from_sheba_number', 26);
            $table->string('to_sheba_number', 26);

            $table->unsignedTinyInteger('status')->default(PayaTransferRequestStatusEnum::PENDING);

            $table->unsignedBigInteger('amount');

            $table->string('description')->nullable();
            $table->string('note')->nullable();

            $table->nullableMorphs('confirmed_by');
            $table->timestamp('confirmed_at')->nullable();

            $table->nullableMorphs('canceled_by');
            $table->timestamp('canceled_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paya_transfer_requests');
    }
};
