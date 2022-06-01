<?php

namespace App\Http\Controllers;


use App\Models\Angem_Person;
use App\Models\Appointment;
use App\Models\Subject;
use App\Models\Student;
use App\Models\Tutor;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    public function index()
    {
        /* load all appointments with students and subjects*/
        $appointments = Appointment::with(['student', 'subject'])->get();
        return $appointments;
    }


    private function parseRequest(Request $request): Request
    {
        //get data and comvert it - ISO 8601, e.g., "2022-03-11T14:51:00.00Z"
        $date = new \DateTime($request->date);
        $request['date'] = $date;
        return $request;
    }


    // Appointment by ID
    public function findAppointmentById(string $id): Appointment
    {
        $appointment = Appointment::where('id', $id)
            ->with(['student', 'subject'])->first();
        return $appointment;
    }

    //Termin wo man sich anmelden kann
    public function freeAppointments()
    { // public
        $nowDate = Carbon::now();
        // Termin am selben Tag nicht möglich
        return Subject::groupBy("id")
            ->whereDate('date', '>', $nowDate)
            ->with(['student'])->get();
    }

    // Registrierung/Anmeldung zu einen Termin
    public function registerUserAppointment($appointmentId, $users_id)
    { // logged in

        DB::beginTransaction();
        try {
            $appointment = Appointment::where('id', $appointmentId)->first();
            $student = Student::where('users_id', $users_id)->first();

            if (empty($appointment) || empty($student)) {
                return response()->json("Appointment(" . $appointmentId . ") oder User(" . $users_id . ") existiert nicht!", 404);
            }
            if(!empty($appointment['users_id'])){
                return response()->json("Kurs bereits belegt!", 409);
            }
            $appointment->student()->associate($student)->save();
            DB::commit();
            return response()->json("Erfolgreich angemeldet", 201);
        } catch (\Exception $e) {
            //rollback all queries
            DB:: rollBack();
            return response()->json("Das Speichern hat nicht funktioniert. Fehlermeldung:" . $e->getMessage(), 420);
        }
    }

    public function getBookedAppointmentsPast($id)
    {
        try {
            $id = Tutor::where('users_id', $id);
            if ($id == null) {
                return response()->json("Der eingeloggte Benutzer ist kein Tutor.", 420);
            }
            $id = $id->value('id');
            $subject = Appointment::with(['subject'])->whereHas('subject',
                function ($query) use ($id) {
                    $query->where('tutor_id', $id);
                })->whereHas('student')->whereDate('date', '<', now())->get();
            return $subject;
        } catch (\Exception $e) {
            return response()->json("Abfrage nicht erfolgreich: " . $e->getMessage(), 420);
        }
    }


    public function getBookedAppointmentsFuture($id)
    {
        try {
            $id = Tutor::where('users_id', $id);
            if ($id == null) {
                return response()->json("Der eingeloggte Benutzer ist kein Tutor.", 420);
            }
            $id = $id->value('id');
            $subject = Appointment::with(['subject'])->whereHas('subject',
                function ($query) use ($id) {
                    $query->where('tutor_id', $id);
                })->whereHas('student')->whereDate('date', '>=', now())->get();
            return $subject;
        } catch (\Exception $e) {
            return response()->json("Abfrage nicht erfolgreich: " . $e->getMessage(), 420);
        }
    }

    public function getBookedAppointmentsFutureForStudent($id)
    {
        try {
            $student = Student::where('users_id', $id);
            if ($student == null) {
                return response()->json("Der eingeloggte Benutzer ist kein Student.", 420);
            }
            $id = $student->value('id');
            $subject = Appointment::with(['subject'])->where('student_id', $id)->whereDate('date', '>=', now())->get();
            return $subject;
        } catch (\Exception $e) {
            return response()->json("Abfrage nicht erfolgreich: " . $e->getMessage(), 420);
        }
    }

    public function getBookedAppointmentsPastForStudent($id)
    {
        try {
            $id = Student::where('users_id', $id);
            if ($id == null) {
                return response()->json("Der eingeloggte Benutzer ist kein Student.", 420);
            }
            $id = $id->value('id');
            $subject = Appointment::with(['subject'])->where('student_id', $id)->whereDate('date', '<', now())->get();
            return $subject;
        } catch (\Exception $e) {
            return response()->json("Abfrage nicht erfolgreich: " . $e->getMessage(), 420);
        }
    }

}




