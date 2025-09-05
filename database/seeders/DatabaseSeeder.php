<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin Utang Dong',
            'username' => 'admin',
            'email' => 'a@a',
            'password' => '1',
            'role'=> 'admin'
        ]);

        $users = [];
        for ($i = 1; $i <= 10; $i++) {
            $users[] = [
                'name' => "User $i",
                'username'=> "user". Str::random(6),
                'email' => "user$i@example.com",
                'password' => Hash::make('password'),
                'role' => $i <= 2 ? 'borrower' : 'lender',
                'status' => 'unverified',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('users')->insert($users);

        // -------------------------------
        // Lenders (10)
        // -------------------------------
        $lenders = [];
        for ($i = 1; $i <= 10; $i++) {
            $lenders[] = [
                'user_id' => $i,
                'company' => "Company $i",
                'balance' => rand(5000000, 20000000),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('lenders')->insert($lenders);

        // -------------------------------
        // Loans (10)
        // -------------------------------
        $loans = [];
        for ($i = 1; $i <= 10; $i++) {
            $loans[] = [
                'user_id' => $i,
                'amount' => rand(100000, 1000000),
                'tenor' => rand(1, 12),
                'purpose' => "Purpose of loan $i",
                'status' => 'request',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('loans')->insert($loans);

        // -------------------------------
        // Offers (10)
        // -------------------------------
        $offers = [];

for ($i = 1; $i <= 10; $i++) {
    $amount = rand(100000, 1000000);
    $interest = rand(5, 15);

    $offers[] = [
        'loan_id' => $i,
        'lender_id' => rand(1, 10),
        'interest_rate' => $interest,
        'amount' => $amount,
        'repayment_amount' => $amount + ($amount * $interest / 100),
        'created_at' => now(),
        'updated_at' => now(),
    ];
}

DB::table('offers')->insert($offers);


        // -------------------------------
        // Repayments (10)
        // -------------------------------
        $repayments = [];
        for ($i = 1; $i <= 10; $i++) {
            $repayments[] = [
                'loan_id' => $i,
                'amount_paid' => rand(50000, 100000),
                'paid_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('repayments')->insert($repayments);
    }
}
