<?php

namespace Database\Seeders;

use App\Domains\Account\Enums\AccountStatusEnum;
use App\Domains\Account\Enums\AccountTypeEnum;
use App\Models\Account\Account;
use App\Models\Admin\Admin;
use App\Models\User\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Account::create([
            'id' => 'f809dba0-b0d5-11f0-bfc9-822df4a1815c',
            'user_id' => $user->id,
            'iban' => 'IR000000000000000000001234',
            'type' => AccountTypeEnum::CURRENT_ACCOUNT,
            'status' => AccountStatusEnum::ACTIVE,
            'balance' => 100000000,
        ]);

        Admin::create([
            'firstname' => 'Test Admin',
            'lastname' => 'Test Admin',
        ]);
    }
}
