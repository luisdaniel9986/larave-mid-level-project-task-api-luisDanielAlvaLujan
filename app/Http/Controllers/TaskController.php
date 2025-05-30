<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\TaskStoreRequest;
use App\Http\Requests\Task\TaskUpdateRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class TaskController extends Controller
{

public function getAll(Request $request){

        $consulta   =   Task::query();
        if($request->filled('title')){
            $consulta->where('title','like','%'.$request->get('title').'%');
        }

        $tasks   =   $consulta->paginate(10);

        return response()->json($tasks);
}

public function store(TaskStoreRequest $request){
        DB::beginTransaction();
        try {

            $data       =   $request->validated();

            $task       =   Task::create($data);

            DB::commit();
            return response()->json(['success'=>true,'message'=>'TAREA CREADA CON ÉXITO','task'=>$task]);

        } catch (Throwable $th) {
            DB::rollBack();
            return response()->json(['success'=>false,'message'=>$th->getMessage()],$th->getCode());
        }
    }

    public function update(TaskUpdateRequest $request,$id){
        DB::beginTransaction();
        try {

            $data       =   $request->validated();
            $task       =   Task::findOrFail($id);

            $task->update($data);

            DB::commit();
            return response()->json(['success'=>true,'message'=>'TAREA ACTUALIZADA CON ÉXITO','task'=>$task]);

        } catch (Throwable $th) {
            DB::rollBack();
            return response()->json(['success'=>false,'message'=>$th->getMessage()],$th->getCode());
        }
    }

    public function getOne($id){
        try {

            $task    =   Task::findOrFail($id);
            return response()->json(['success'=>true,'message'=>'TAREA OBTENIDO CON ÉXITO','task'=>$task]);

        } catch (Throwable $th) {
            return response()->json(['success'=>false,'message'=>$th->getMessage()],$th->getCode());
        }
    }

    public function destroy(int $id){
        DB::beginTransaction();
        try {

            $task            =   Task::findOrFail($id);
            $task->delete();

            DB::commit();
            return response()->json(['success'=>true,'message'=>'TAREA ELIMINADA CON ÉXITO']);

        } catch (Throwable $th) {
            DB::rollBack();
            return response()->json(['success'=>false,'message'=>$th->getMessage()],$th->getCode());
        }
    }
}
