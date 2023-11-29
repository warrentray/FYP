<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = DB::table('user')->pluck('id');

        // Seed attendance records for a month (October in this case)
        $startDate = now()->subMonth()->startOfMonth(); // Start from the beginning of the previous month
        $endDate = now()->subMonth()->endOfMonth(); // End at the end of the previous month

        $currentDate = clone $startDate;

        while ($currentDate <= $endDate) {
            foreach ($users as $userId) {
                // Randomly select sign-in time between 6:00 AM and 6:04 AM
                $signInTime = $currentDate->copy()->setHour(6)->setMinute(rand(0, 3));

                // Randomly select sign-out time between 3:00 PM and 5:00 PM
                $signOutTime = $currentDate->copy()->setHour(rand(15, 17))->setMinute(rand(0, 59));

                // Create attendance record with 'id' starting with 'A' followed by 9 digits
                DB::table('attendance')->insert([
                    'id' => 'A' . str_pad($currentDate->format('md') . rand(00000000, 99999999), 8, '0', STR_PAD_LEFT),
                    'sign_in_time' => $signInTime,
                    'sign_out_time' => $signOutTime,
                    'user_id' => $userId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Move to the next day
            $currentDate->addDay();
        }
    }
}
