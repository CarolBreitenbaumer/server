<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Subject;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function findBySearchTerm(string $searchTerm){
        $subject = Subject::with(['appointments'])
            //vorher und nachher kann etwas stehen
            ->where('name','LIKE','%'.$searchTerm.'%')
            ->orWhere('description','LIKE','%'.$searchTerm.'%')
            ->orWhereHas('appointments',function ($query) use ($searchTerm){
                $query->where('date','LIKE','%'.$searchTerm.'%')
                    ->orWhere('time','LIKE','%'.$searchTerm.'%')
                    ->orWhere('duration','LIKE','%'.$searchTerm.'%')
                    ->orWhere('place','LIKE','%'.$searchTerm.'%');
            })->get();
        return $subject;
    }

}
