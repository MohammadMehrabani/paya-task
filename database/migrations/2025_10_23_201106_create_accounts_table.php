<?php

use App\Domains\Account\Enums\AccountStatusEnum;
use App\Domains\Account\Enums\AccountTypeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('UUID()'));

            $table->string('iban', 26)
                ->default('IR'.str_pad(time(), 24, '0', STR_PAD_LEFT));

            $table->foreignId('user_id')->constrained('users');

            $table->unsignedTinyInteger('type')->default(AccountTypeEnum::CURRENT_ACCOUNT);

            $table->unsignedTinyInteger('status')->default(AccountStatusEnum::ACTIVE);

            $table->unsignedBigInteger('balance')->default(0);
            $table->unsignedBigInteger('reserved_balance')->default(0);

            $table->timestamps();

            $table->unique(['user_id', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
