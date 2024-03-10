<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tasks;
use Carbon\Carbon;
use Illuminate\Console\View\Components\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {   

        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'name' => 'required|string',
            'description' => 'required|string',
            'user_id' => 'required|exists:users,id'
        ]);

        $userId = $request->user_id;

        $userTasks = Tasks::where('user_id', $userId)->where('is_completed', false)->count();

        if($userTasks >= 5) {

            return response()->json(['error' => 'Usuario con 5 tareas']);
        }
        
        $task = Tasks::create([
            'company_id' => $request->company_id,
            'name' => $request->name,
            'description' => $request->description,
            'user_id' => $request->user_id,
            'is_completed' => false,
            'start_at'  => now(),
            'expired_at' => null,
        ]);
        
        $formattedResponse = [
            'id' => $task->id,
            'name' => $task->name,
            'description' => $task->description,
            'user' => $task->user->name,
            'company' => [
                'id' => $task->company->id,
                'name' => $task->company->name,
            ]
        ];

        return response()->json($formattedResponse, 201);
    }
}
