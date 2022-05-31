<?php

namespace App\Http\Controllers;


use App\Models\Appointment;
use App\Models\Book;
use App\Models\Image;
use App\Models\Subject;
use App\Models\Student;
use App\Models\Tutor;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SubjectController extends Controller
{


    public function save(Request $request) : JsonResponse  //admin
    {
        //Helfermethode um in ein Datumsformat umwandeln dass man es in der DB korrekt speichern kann
        $request = $this ->parseRequest( $request );

        // wenn ein Teilschritt in der Transaktion nicht funktiert hat wird es wieder zurückgesetzt
        DB:: beginTransaction ();
        try {
            //Fach muss nur in der DB angelegt werden
            $subject = Subject::create( $request ->all());


            //save appointments
            if(isset($request['appointments']) && is_array($request['appointments'])){
                foreach($request['appointments'] as $app){
                    $appointment = Appointment::firstOrNew(['date'=>$app['date'],
                        'time'=>date('H:i:s', strtotime('1 hour')),
                        'duration'=>$app['duration'], 'place'=>$app['place']]);
                    $subject->appointments()->save($appointment);
                }
            }

            //mit commit wird transaktion durchgeführt
            DB:: commit ();
            // return a vaild http response - hier passt alles und das neu
            // angelegte Subject wird ausgegeben
            return response()->json( $subject ,201);
        }
            //try catch um kontrollierte Fehlerbehandlung zu haben
        catch (\Exception $e ) {
            //rollback all queries
            // wenn es schief läuft machen wir einen rollback
            DB:: rollBack ();
            return response()->json( "das speichern des Faches hat nicht funktioniert: " . $e ->getMessage(), 420 );
        }
    }

    public function delete (string $id): JsonResponse // admin
    {
        //holen erstes Fach
        $subject = Subject::where ('id', $id)-> first ();

        // hier wird es gelöscht
        if ( $subject != null ) {
            $subject->delete();
        }
        else
            // hier tritt idempodent ein, in beiden Fällen ist Subject nicht in DB
            // wird Exeption geworfen, Fach nicht gefunden
            throw new \Exception ( "Subject konnte nicht gelöscht werden - sie ist nicht vorhanden" );
        return response ()-> json ( 'Subject (' . $id . ') konnte erfolgreich gelöscht werden' , 200 );
    }

    private function parseRequest(Request $request):Request {
        //get data and comvert it - ISO 8601, e.g., "2022-03-11T14:51:00.00Z"
        $date = new \DateTime($request->date);
        $request['date'] = $date;
        return $request;
    }

    //liefert true wenn es SubjectId gibt
    public function checkName(string $name) {
        $subject = Subject::where('name',$name)->first();
        return $subject != null ? response()->json(true,200): response()->json(false,200);
    }

    public function update(Request $request, string $id) : JsonResponse
    {
        DB::beginTransaction();
        try {
            $subject = Subject::with(['appointments'])
                ->where('id', $id)->first();
            if ($subject != null) {
                $request = $this->parseRequest($request);
                $subject->update($request->all());
                //delete all old appointments
                $subject->appointments()->delete();
                // save images
                if(isset($request['appointments']) && is_array($request['appointments'])){
                    foreach($request['appointments'] as $app){
                        $appointment = Appointment::firstOrNew(['date'=>$app['date'],'time'=>$app['time'], 'duration'=>$app['duration'], 'place'=>$app['place']]);
                        $subject->appointments()->save($appointment);
                    }
                }
            }
            DB::commit();
            $subject1 = Subject::with(['appointments'])
                ->where('id', $id)->first();
            // return a vaild http response
            return response()->json($subject1, 201);
        }
        catch (\Exception $e) {
            // rollback all queries
            DB::rollBack();
            return response()->json("Updating appointment failed: " . $e->getMessage(), 420);
        }
    }

    // Subject by ID
    public function findSubjectById(string $id) {
        $subject = Subject::where('id', $id)
            ->with(['tutor', 'appointments','appointments.student'])->first();
        return $subject;
    }

    public function findByName(string $name) : Subject {
        $subject = Subject::where('name', $name)
            ->with(['tutor', 'appointments', 'appointments.student'])
            ->first();
        return $subject;
    }

    //erhält alle Subjectnamen
    public function getSubjects(){ // public
        $subjects = Subject::with(['tutor', 'appointments'])->get();
        return $subjects;
    }





}




