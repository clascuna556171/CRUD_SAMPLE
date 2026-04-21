<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
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

        DB::unprepared("
            CREATE TRIGGER before_appointment_insert
            BEFORE INSERT ON appointments
            FOR EACH ROW
            WHEN (SELECT current_booked >= max_capacity FROM schedules WHERE schedule_id = NEW.schedule_id)
            BEGIN
                SELECT RAISE(ABORT, 'Error: This schedule is already at maximum capacity.');
            END;
        ");

        DB::unprepared("
            CREATE TRIGGER after_appointment_complete
            AFTER UPDATE ON appointments
            FOR EACH ROW
            WHEN (NEW.status = 'Completed' AND OLD.status <> 'Completed')
            BEGIN
                INSERT INTO invoices (appointment_id, total_amount, payment_status)
                VALUES (NEW.appointment_id, 500.00, 'Unpaid'); 
            END;
        ");

        DB::unprepared("
            CREATE TRIGGER after_appointment_cancel
            AFTER UPDATE ON appointments
            FOR EACH ROW
            WHEN (NEW.status = 'Cancelled' AND OLD.status <> 'Cancelled')
            BEGIN
                UPDATE schedules
                SET current_booked = current_booked - 1
                WHERE schedule_id = NEW.schedule_id;
            END;
        ");

        DB::unprepared("
            CREATE VIEW View_Appointment_Master_List AS
            SELECT 
                A.appointment_id,
                A.reference_number,
                A.status AS appointment_status,
                A.booking_timestamp,
                P.first_name || ' ' || P.last_name AS patient_full_name,
                P.contact_number AS patient_phone,
                S.first_name || ' ' || S.last_name AS doctor_name,
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
