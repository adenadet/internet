<?php

namespace App\Http\Controllers\Api\ToDo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ToDo\Task;

class TaskController extends Controller
{
    public function index()
    {
        return response()->json([
            'tasks' => Task::where('owner_id', auth('api')->id() ?? 1)->orderBy('created_at', 'ASC')->paginate(10),
        ]);
    }

    public function initials()
    {
        return response()->json([
            'tasks' => Task::where('owner_id', 1)->orderBy('created_at', 'ASC')->paginate(10),
        ]);   
    }
    
    public function store(Request $request)
    {
        $task = Task::create([
            'title' => $request->input('title'), 
            'description' => $request->input('description'), 
            'is_done' => $request->input('is_done'), 
            'created_by' => auth('api')->id() ?? 1, 
            'updated_by' => auth('api')->id() ?? 1, 
            'owner_id'  => auth('api')->id() ?? 1,
        ]);
        return response()->json([
            'tasks' => Task::where('owner_id', auth('api')->id() ?? 1)->orderBy('created_at', 'DESC')->paginate(10),
        ]);
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        $task->title = $request->input('title'); 
        $task->description = $request->input('description'); 
        $task->is_done = $request->input('is_done'); 
        $task->created_by = auth('api')->id() ?? 1; 
        $task->updated_by = auth('api')->id() ?? 1; 
        $task->owner_id  = auth('api')->id() ?? 1;

        $task->save();
        
        return response()->json([
            'tasks' => Task::where('owner_id', auth('api')->id() ?? 1)->orderBy('created_at', 'DESC')->paginate(10),
        ]);
    }

    public function destroy($id)
    {
        //
    }
}
