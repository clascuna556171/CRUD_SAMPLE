<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop existing triggers first to avoid "Trigger already exists" errors
        DB::unprepared("DROP TRIGGER IF EXISTS after_appointment_insert");
        DB::unprepared("DROP TRIGGER IF EXISTS before_appointment_insert");
        DB::unprepared("DROP TRIGGER IF EXISTS after_appointment_complete");
        DB::unprepared("DROP TRIGGER IF EXISTS after_appointment_cancel");
        DB::unprepared("DROP VIEW IF EXISTS View_Appointment_Master_List");

        // 1. Trigger: Increment booked count
        DB::unprepared("
            CREATE TRIGGER after_appointment_insert
            AFTER INSERT ON appointments
            FOR EACH ROW
            BEGIN
                UPDATE schedules
                SET current_booked = current_booked + 1
                WHERE schedule_id = NEW.schedule_id;
            END;
        ");

        // 2. Trigger: Check capacity (MySQL uses IF...THEN and SIGNAL)
        DB::unprepared("
            CREATE TRIGGER before_appointment_insert
            BEFORE INSERT ON appointments
            FOR EACH ROW
            BEGIN
                IF (SELECT current_booked FROM schedules WHERE schedule_id = NEW.schedule_id) >= 
                   (SELECT max_capacity FROM schedules WHERE schedule_id = NEW.schedule_id) THEN
                    SIGNAL SQLSTATE '45000'
                    SET MESSAGE_TEXT = 'Error: This schedule is already at maximum capacity.';
                END IF;
            END;
        ");

        // 3. Trigger: Create invoice on completion
        DB::unprepared("
            CREATE TRIGGER after_appointment_complete
            AFTER UPDATE ON appointments
            FOR EACH ROW
            BEGIN
                IF NEW.status = 'Completed' AND OLD.status <> 'Completed' THEN
                    INSERT INTO invoices (appointment_id, total_amount, payment_status)
                    VALUES (NEW.appointment_id, 500.00, 'Unpaid');
                END IF;
            END;
        ");

        // 4. Trigger: Decrement count on cancellation
        DB::unprepared("
            CREATE TRIGGER after_appointment_cancel
            AFTER UPDATE ON appointments
            FOR EACH ROW
            BEGIN
                IF NEW.status = 'Cancelled' AND OLD.status <> 'Cancelled' THEN
                    UPDATE schedules
                    SET current_booked = current_booked - 1
                    WHERE schedule_id = NEW.schedule_id;
                END IF;
            END;
        ");

        // 5. View: Concatenation fix (CONCAT instead of ||)
        DB::unprepared("
            CREATE VIEW View_Appointment_Master_List AS
            SELECT 
                A.appointment_id,
                A.reference_number,
                A.status AS appointment_status,
                A.booking_timestamp,
                CONCAT(P.first_name, ' ', P.last_name) AS patient_full_name,
                P.contact_number AS patient_phone,
                CONCAT(S.first_name, ' ', S.last_name) AS doctor_name,
                S.specialization AS doctor_field,
                D.department_name,
                Sch.schedule_date,
                Sch.max_capacity,
                Sch.current_booked,
                IFNULL(I.total_amount, 0.00) AS total_bill,
                IFNULL(I.payment_status, 'No Invoice') AS billing_status
            FROM appointments A
            JOIN patients P ON A.patient_id = P.patient_id
            JOIN staff S ON A.assigned_doctor_id = S.staff_id
            JOIN departments D ON S.department_id = D.department_id
            JOIN schedules Sch ON A.schedule_id = Sch.schedule_id
            LEFT JOIN invoices I ON A.appointment_id = I.appointment_id;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP TRIGGER IF EXISTS after_appointment_insert");
        DB::unprepared("DROP TRIGGER IF EXISTS before_appointment_insert");
        DB::unprepared("DROP TRIGGER IF EXISTS after_appointment_complete");
        DB::unprepared("DROP TRIGGER IF EXISTS after_appointment_cancel");
        DB::unprepared("DROP VIEW IF EXISTS View_Appointment_Master_List");
    }
};