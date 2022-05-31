<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MessageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Alle Termine zurück liefern
Route::get('appointments',[AppointmentController::class,'index']);
Route::get('subjects/byName/{name}',[SubjectController::class,'findByName']);
Route::get('subjects/byId/{id}',[SubjectController::class,'findSubjectById']);
Route::get('subjects',[SubjectController::class,'getSubjects']);
Route::get('appointments/getBookedAppointmentsPast/{id}',[AppointmentController::class,'getBookedAppointmentsPast']);
Route::get('appointments/getBookedAppointmentsFuture/{id}',[AppointmentController::class,'getBookedAppointmentsFuture']);
Route::get('appointments/getBookedAppointmentsPastForStudent/{id}',[AppointmentController::class,'getBookedAppointmentsPastForStudent']);
Route::get('appointments/getBookedAppointmentsFutureForStudent/{id}',[AppointmentController::class,'getBookedAppointmentsFutureForStudent']);
Route::get('appointments/{id}',[AppointmentController::class,'findAppointmentById']);
Route::get('subjects/search/{searchTerm}',[Controller::class,'findBySearchTerm']);




Route::group(['middleware' => ['api','auth.jwt']], function(){
    Route::post('auth/logout', [AuthController::class,'logout']);
    Route::post('user/registerAppointment/{appointmentId}/{studentId}',[AppointmentController::class,'registerUserAppointment']);
    Route::get('messages/forStudent/{studentId}',[MessageController::class,'getMessagesForStudent']);
    Route::post('messages',[MessageController::class,'save']);
});



Route::group(['middleware' => ['api','auth.jwt', 'auth.admin']], function(){
    Route::post('subjects',[SubjectController::class,'save']);
    Route::put('subjects/{id}',[SubjectController::class,'update']);
    Route::delete('subjects/{id}',[SubjectController::class,'delete']);
    //Teilnahme des Studentens bei Termin
    Route::post('user/setBooking/{id}',[UserController::class,'setUserBooking']);
    Route::get('messages/forTutor/{tutorId}',[MessageController::class,'getMessagesForTutor']);
    Route::post('messages/readMessage/{id}',[MessageController::class,'setMessageReaded']);
    Route::get('subjects/checkName/{id}',[SubjectController::class,'checkName']);

});

Route::post('auth/login',[AuthController::class, 'login']);
