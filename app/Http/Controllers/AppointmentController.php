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
    public function index(){
        /* load all appointments with students and subjects*/
        $appointments = Appointment::with(['student', 'subject'])->get();
        return $appointments;
    }

    // Appointment by ID
    public function findAppointmentById(string $id) : Appointment {
        $appointment = Appointment::where('id', $id)
            ->with(['student', 'subject'])->first();
        return $appointment;
    }

    // Registrierung/Anmeldung zu einen Termin
    public function registerUserAppointment($appointmentId, $student_id){ // logged in
        $userId = Auth::user()->id;
        DB::beginTransaction ();
        try {
            $appointment = Appointment::where('id', $appointmentId)->first();
            if($appointment == null){
                return response()->json("Appointment mit der id $appointmentId existiert nicht", 404);
            }

            $student = Student::where ('id',$student_id)->first();

            $appointment->student()->associate($student)->save();
            DB::commit();
            return response()->json("Erfolgreich angemeldet", 201);
        }
        catch (\Exception $e ) {
            //rollback all queries
            DB:: rollBack ();
            return response()->json( "Das Speichern hat nicht funktioniert. Fehlermeldung:" . $e ->getMessage(), 420 );
        }
    }

    public function getBookedAppointmentsPast($id){
        try{
            $id = Tutor::where('users_id', $id)->first();
            if($id == null){
                return response()->json("Der eingeloggte Benutzer ist kein Tutor.", 420);
            }
            $id= $id->value('id');
            $subject = Appointment::with(['subject'])->whereHas('subject',
                function($query) use ($id) {
                    $query->where('tutor_id', $id);
                })->whereHas('student')->whereDate('date', '<', now())->get();
            return $subject;
        }catch (\Exception $e ) {
            return response()->json("Abfrage nicht erfolgreich: " . $e->getMessage(), 420);
        }
    }

    public function getBookedAppointmentsFuture($id){
        try{
            $id = Tutor::where('users_id', $id)->first();
            if($id == null){
                return response()->json("Der eingeloggte Benutzer ist kein Tutor.", 420);
            }
            $id= $id->value('id');
            $subject = Appointment::with(['subject'])->whereHas('subject',
                function($query) use ($id) {
                    $query->where('tutor_id', $id);
                })->whereHas('student')->whereDate('date', '>=', now())->get();
            return $subject;
        }catch (\Exception $e ) {
            return response()->json("Abfrage nicht erfolgreich: " . $e->getMessage(), 420);
        }
    }

    public function getBookedAppointmentsFutureForStudent($id){
        try{
            $id = Student::where('users_id', $id)->first();
            if($id == null){
                return response()->json("Der eingeloggte Benutzer ist kein Student.", 420);
            }
            $id= $id->value('id');
            $subject = Appointment::with(['subject'])->where('student_id', $id)->whereDate('date', '>=', now())->get();
            return $subject;
        }catch (\Exception $e ) {
            return response()->json("Abfrage nicht erfolgreich: " . $e->getMessage(), 420);
        }
    }

    public function getBookedAppointmentsPastForStudent($id){
        try{
            $id = Student::where('users_id', $id)->first();
            if($id == null){
                return response()->json("Der eingeloggte Benutzer ist kein Student.", 420);
            }
            $id= $id->value('id');
            $subject = Appointment::with(['subject'])->where('student_id', $id)->whereDate('date', '<', now())->get();
            return $subject;
        }catch (\Exception $e ) {
            return response()->json("Abfrage nicht erfolgreich: " . $e->getMessage(), 420);
        }
    }

}




