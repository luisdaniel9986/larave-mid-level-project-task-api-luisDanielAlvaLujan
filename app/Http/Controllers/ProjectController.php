<?php

namespace App\Http\Controllers;

use App\Http\Requests\Project\ProjectStoreRequest;
use App\Http\Requests\Project\ProjectUpdateRequest;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class ProjectController extends Controller
{
    public function getAll(Request $request){

        $consulta   =   Project::query();
        if($request->filled('name')){
            $consulta->where('name','like','%'.$request->get('name').'%');
        }

        $projects   =   $consulta->paginate(10);

        return response()->json($projects);
    }

    
    public function store(ProjectStoreRequest $request){
        DB::beginTransaction();
        try {

            $data       =   $request->validated();

            $project    =   Project::create($data);

            DB::commit();
            return response()->json(['success'=>true,'message'=>'PROJECT CREATE SUCCESSFULL','project'=>$project],201);

        } catch (Throwable $th) {
            DB::rollBack();
            return response()->json(['success'=>false,'message'=>$th->getMessage()],$th->getCode());
        }
    }

    public function update(ProjectUpdateRequest $request,$id){
        DB::beginTransaction();
        try {

            $data       =   $request->validated();
            $project    =   Project::findOrFail($id);

            $project->update($data);

            DB::commit();
            return response()->json(['success'=>true,'message'=>'PROJECT ACTUALIZADO CON ÉXITO','project'=>$project]);

        } catch (Throwable $th) {
            DB::rollBack();
            return response()->json(['success'=>false,'message'=>$th->getMessage()],$th->getCode());
        }
    }

    public function getOne($id){
        try {

            $project    =   Project::findOrFail($id);
            return response()->json(['success'=>true,'message'=>'PROJECT OBTENIDO CON ÉXITO','project'=>$project]);

        } catch (Throwable $th) {
            return response()->json(['success'=>false,'message'=>$th->getMessage()],$th->getCode());
        }
    }

    public function destroy(int $id){
        DB::beginTransaction();
        try {

            $project            =   Project::findOrFail($id);
            $project->status    =   'INACTIVE';
            $project->update();

            DB::commit();
            return response()->json(['success'=>true,'message'=>'PROJECT ELIMINADO CON ÉXITO']);

        } catch (Throwable $th) {
            DB::rollBack();
            return response()->json(['success'=>false,'message'=>$th->getMessage()],$th->getCode());
        }
    }
}
