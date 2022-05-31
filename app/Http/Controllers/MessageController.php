<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Student;
use App\Models\Tutor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{

    public function save(Request $request) : JsonResponse  //admin
    {
        // wenn ein Teilschritt in der Transaktion nicht funktiert hat wird es wieder zurückgesetzt
        DB:: beginTransaction ();
        try {
            //Fach muss nur in der DB angelegt werden
            $message = Message::create( $request ->all());

            DB:: commit ();
            return response()->json( $message ,201);
        }
            //try catch um kontrollierte Fehlerbehandlung zu haben
        catch (\Exception $e ) {
            //rollback all queries
            // wenn es schief läuft machen wir einen rollback
            DB:: rollBack ();
            return response()->json( "das speichern der Message hat nicht funktioniert: " . $e ->getMessage(), 420 );
        }
    }

    public function getMessagesForTutor(string $id) {
        $id = Tutor::where('users_id', $id)->first()->value('id');
        $message = Message::with(['subject'])->where('readed', false)->whereHas('subject',
            function($query) use ($id) {
                $query->where('id', $id);
        })->get();
        return $message;
    }

    public function getMessagesForStudent(string $id){
        $id = Student::where('users_id', $id)->first()->value('id');
        $messages = Message::where('student_id', $id)->get();
        return $messages;
    }

    public function setMessageReaded($id){
        $message = Message::where('id',$id)->first();
        $message->readed = true;
        $message->save();
        return $message != null ? response()->json("Nachricht wurde gelesen.",200): response()->json(false,200);


    }
}
