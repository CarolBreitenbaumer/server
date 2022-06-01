<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class UserController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    // bei Termin teilgenommen, nur Admin
    public function setUserBooking($id){ // admin
        $appointment = Appointment::where('id',$id)->first();
        $appointment->attend = true;
        $appointment->save();
        return $appointment != null ? response()->json("Student hat bei Termin teilgenommen",200): response()->json(false,200);

    }

    public function getInfoforUser(){
        //aktuelle BenutzerID
        $userId = Auth::user()->id;
        //bekommen Datensatz wo benutzer_id mit user_id übereinstimmt
        $student = Student::with('appointments')->where ('id',$userId)->first();

        return $student != null ? response()->json($student,200): response()->json(false,404);

    }

}
