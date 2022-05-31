<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct()
    {
        // soll für alles gelten was über den AuthController geht mit außnahme der Login Methode
        // weil wir beim login nicht prüfen wollen ob er eingeloggt ist
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function login()
    {
        //Email und Password aus request auslesen
        $credentials = request(['email', 'password']);
        // Authentifizierungsversuch mit credentials, bei Fehler response
        // select auf user Tabelle, gib etwas zurück wo password und email gleich ist
        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $isAdmin = Auth::user()->isAdmin;
        //Hilfmethode um JWT zusammenzubauen
        return $this->respondWithToken($token, $isAdmin);
    }

    protected function respondWithToken(string $token, $isAdmin)
    {
        //Rückgabewert JSON
        return response()->json([
            //Rückgabe des gesamten JWT Token
            'access_token' => $token,
            //für client wichtig welche Authetifizierungsmethode angewendet wird
            'token_type' => 'bearer',
            //Ablaufen des Token, in 1 Stunde
            'expires_in' => auth()->factory()->getTTL() * 60,
            //isAdmin
            'is_admin' => $isAdmin
        ]);
    }

    //bekommen den Authentifizierten User
    public function me()
    {
        return response()->json(auth()->user());
    }

    // Log the user out (Invalidate the token)
    public function logout()
    {
        //ausloggen
        auth()->logout();
        //Antwort
        return response()->json(['message' => 'Sie haben sich erfolgreich ausgeloggt']);
    }


}
