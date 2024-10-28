<?php

namespace App\Http\Controllers\API;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    use ResponseTrait;
    public function index(){
        $task = Task::get();
        return $this->successResponse("tasks get successfully", $task, 200);
    }

    public function store(Request $request){
       
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'completed' => 'required',
        ]);

        if($validator->fails()){
            return $this->errorResponse('Validation Error', $validator->errors(), 401);       
        }

        Task::create($request->all());

        return $this->successResponse('Task store successfully','', 200);
    }

    public function update(Request $request, $id){
      
        $task = Task::find($id);
        if (!$task) {
            return $this->errorResponse('Task not found','', 404);
        }
       
        $data = $task->update($request->all());

        return $this->successResponse('Task updated successfully', $data, 200);
    }

    public function destroy($id){
        $task =Task::find($id);
        if(!$task){
            return $this->errorResponse("tasks not found", '', 404);
        }
        $task->delete();
        return $this->successResponse("task deleted successfully", '', 200);
    }

    public function filter(Request $request){
        $task = Task::query();
        if($request->completed){
                
            $task->where('completed', $request->completed);
        }
        $data = $task->get();
        return $this->successResponse("task filtered successfully", $data, 200);
    }
}
