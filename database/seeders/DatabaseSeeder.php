<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        // 1. SEED DEPARTMENTS
        $departmentNames = ['Cardiology', 'Pediatrics', 'Neurology', 'General Medicine', 'Radiology', 'Surgery', 'ER'];
        $departmentIds = [];

        foreach ($departmentNames as $name) {
            $departmentIds[] = DB::table('departments')->insertGetId([
                'department_name' => $name,
                'description' => "Specialized medical services for $name.",
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 2. SEED STAFF
        $staffIds = [];
        $doctorIds = [];
        $roles = ['Doctor', 'Nurse', 'Admissions Clerk', 'Admin'];

        for ($i = 0; $i < 20; $i++) {
            $role = $faker->randomElement($roles);
            $id = DB::table('staff')->insertGetId([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'role' => $role,
                'specialization' => ($role == 'Doctor') ? $faker->jobTitle : null,
                'department_id' => $faker->randomElement($departmentIds),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $staffIds[] = $id;
            if ($role == 'Doctor') $doctorIds[] = $id;
        }

        // 3. SEED PATIENTS
        $patientIds = [];
        for ($i = 0; $i < 20; $i++) {
            $patientIds[] = DB::table('patients')->insertGetId([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'contact_number' => $faker->numerify('09#########'),
                'medical_history' => $faker->sentence,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 4. SEED SCHEDULES
        $scheduleIds = [];
        for ($i = 0; $i < 20; $i++) {
            $scheduleIds[] = DB::table('schedules')->insertGetId([
                'department_id' => $faker->randomElement($departmentIds),
                'schedule_date' => $faker->dateTimeBetween('now', '+1 month')->format('Y-m-d'),
                'max_capacity' => 10,
                'current_booked' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 5. SEED APPOINTMENTS
        $appointmentIds = [];
        for ($i = 0; $i < 20; $i++) {
            $appointmentIds[] = DB::table('appointments')->insertGetId([
                'reference_number' => 'REF-' . strtoupper(Str::random(6)),
                'patient_id' => $faker->randomElement($patientIds),
                'schedule_id' => $faker->randomElement($scheduleIds),
                'assigned_doctor_id' => $faker->randomElement($doctorIds),
                'processed_by_id' => $faker->randomElement($staffIds),
                'status' => $faker->randomElement(['Pending', 'Confirmed', 'Completed', 'Cancelled']),
                'booking_timestamp' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 6. SEED INVOICES
        // Using each appointment once to satisfy the unique constraint
        foreach ($appointmentIds as $appId) {
            DB::table('invoices')->insert([
                'appointment_id' => $appId,
                'total_amount' => $faker->randomFloat(2, 100, 5000),
                'payment_status' => $faker->randomElement(['Unpaid', 'Paid', 'Partially Paid']),
                'issued_date' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 7. SEED USER ACCOUNTS
        // Admin
        DB::table('user_accounts')->insert([
            'email' => 'admin@hospital.com',
            'password' => Hash::make('password123'),
            'role' => 'Admin',
            'created_at' => now(),
        ]);

        // Staff Logins
        foreach ($staffIds as $sId) {
            DB::table('user_accounts')->insert([
                'email' => "staff{$sId}@hospital.com",
                'password' => Hash::make('password123'),
                'role' => 'Staff',
                'staff_id' => $sId,
                'created_at' => now(),
            ]);
        }
    }
}