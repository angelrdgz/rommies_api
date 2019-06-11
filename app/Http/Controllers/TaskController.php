<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use App\Team;
use App\Task;
use App\TaskAssigned;
use Validator;
use DB;

class TaskController extends Controller
{
    public function index(Request $request)
    {

    	$user = $request->user();
        $assignations = TaskAssigned::where('user_id', $user->id)->get();
        $data = [];
    	foreach ($assignations as $key => $assignation) {
            $task = Task::where('id', $assignation->task_id)->where('completed',0)->first();
             if(!is_null($task)){
               foreach ($task->roomies as $key => $roomie) {
                   $roomie->user;
               }
                array_push($data, $task);
             }
             //$assignation->task = Task::where("id", $assignation->task_id)->first();
             //$assignation->roomies = User::where("id", $assignation->user_id)->first();
    	} 
    	return response()->json(['status'=>1,'data'=>$data,'message'=>'Tasks founded']);

    }

    public function store(Request $request)
    {

    	$user = $request->user();

    	$validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required|min:30|max:250',
            'roomies'=>'required'
        ]);
        if($validator->fails()) {
            return response()->json([
                'status' => 'error', 
                'message' => $validator->messages()
            ]);
        }

        $task = new Task();
        $task->team_id = $user->team_id;
        $task->user_id = $user->id;
        $task->title = $request->title;
        $task->description = $request->description;
        $task->schedule = $request->schedule;
        $task->date = $request->team_id;
        $task->save();

        if(count($request->roomies) > 0){
            foreach ($request->roomies as $key => $roomie) {
                $assigment = new TaskAssigned();
                $assigment->task_id = $task->id;
                $assigment->user_id = $roomie;
                $assigment->save();
            }
        }

        return response()->json(['status'=>1,'message'=>'Task stored','data'=>$task]);
    }

    public function show(Request $request, $id)
    {
        $task = Task::find($id);
        
        foreach($task->roomies as $roomie){
            $roomie->user;
        }

    	return response()->json(['status'=>1,'data'=>$task,'message'=>'Task founded']);
    }
    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required|min:30|max:250',
            'roomies'=>'required'
        ]);
        if($validator->fails()) {
            return response()->json([
                'status' => 'error', 
                'message' => $validator->messages()
            ]);
        }

        $task = Task::find($id);
        $task->title = $request->title;
        $task->description = $request->description;
        $task->schedule = $request->schedule;
        $task->date = $request->team_id;
        $task->save();

        $task->roomies()->delete();

        if(count($request->roomies) > 0){
            foreach ($request->roomies as $key => $roomie) {
                $assigment = new TaskAssigned();
                $assigment->task_id = $id;
                $assigment->user_id = $roomie;
                $assigment->save();
            }
        }

        return response()->json(['status'=>1,'message'=>'Task stored','data'=>$task]);
    }

    public function destroy(Request $request, $id)
    {
        $task = Task::find($id);
        $task->completed = 1;
        $task->save();

        return response()->json(['status'=>1,'message'=>'Task deleted']);
    }
}
