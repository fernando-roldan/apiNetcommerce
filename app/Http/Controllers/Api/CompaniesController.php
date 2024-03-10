<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Companies;
use Illuminate\Http\Request;

class CompaniesController extends Controller
{
    
    /**
     * Display a listing of the resource.
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Companies::with('tasks.user:id,name')->get();

        $companies = $companies->map(function ($company) {
            return [
                'id' => $company->id,
                'name' => $company->name,
                'tasks' => $company->tasks->map(function ($task) {
                    return [
                        'id' => $task->id,
                        'name' => $task->name,
                        'description' => $task->description,
                        'user' => $task->user->name,
                        'is_completed' => $task->is_completed,
                        'start_at' => $task->start_at,
                        'expired_at' => $task->expired_at,
                    ];
                }),
            ];
        });

        return response()->json($companies);

    }
}
