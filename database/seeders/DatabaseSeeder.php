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
        User::factory()->create([
            'name' => 'Borrower1',
            'username' => 'Borrower1',
            'email' => 'b@1',
            'password' => '1',
            'role'=> 'borrower',
        ]);
        User::factory()->create([
            'name' => 'Borrower2',
            'username' => 'Borrower2',
            'email' => 'b@2',
            'password' => '2',
            'role'=> 'borrower',
        ]);

        DB::table('settings')->insert([
        [
            'grade' => 'A',
            'min_score' => 90,
            'max_score' => 100,
            'interest_rate' => 10.00,
            'late_fee_rate' => 2.00,
            'max_tenor_months' => 36,
            'max_loan_amount' => 10000000,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'grade' => 'B',
            'min_score' => 80,
            'max_score' => 89,
            'interest_rate' => 12.00,
            'late_fee_rate' => 3.00,
            'max_tenor_months' => 36,
            'max_loan_amount' => 8000000,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'grade' => 'C',
            'min_score' => 70,
            'max_score' => 79,
            'interest_rate' => 14.00,
            'late_fee_rate' => 4.00,
            'max_tenor_months' => 36,
            'max_loan_amount' => 6000000,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'grade' => 'D',
            'min_score' => 40,
            'max_score' => 69,
            'interest_rate' => 16.00,
            'late_fee_rate' => 5.00,
            'max_tenor_months' => 24,
            'max_loan_amount' => 3000000,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'grade' => 'E',
            'min_score' => 1,
            'max_score' => 39,
            'interest_rate' => 18.00,
            'late_fee_rate' => 6.00,
            'max_tenor_months' => 12,
            'max_loan_amount' => 1000000,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'grade' => 'F',
            'min_score' => 0,
            'max_score' => 0,
            'interest_rate' => 0.00,
            'late_fee_rate' => 0.00,
            'max_tenor_months' => 0,
            'max_loan_amount' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ],
    ]);
    }
}
