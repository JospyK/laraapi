<?php

namespace App\Http\Controllers\API;

use App\Models\Task;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\Task as TaskResource;
use Validator;

class TaskController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get all task
        $tasks = Task::all();
        return $this->handleResponse(TaskResource::collection($tasks), "Liste de toutes les taches.");
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTaskRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTaskRequest $request)
    {
        // validate data
        $validate_data = Validator::make($request->all(), [
            "nom" => 'required',
            "delai" => 'required|after:now',
        ]);

        if($validate_data->fails()){
            return $this->handleError($validate_data->errors());
        }

        // save task
        //$task = Task::create($request->all());

        $task = Task::create([
            "nom" => $request->nom,
            "delai" => $request->delai,
            "description" => $request->description,
            "user_id" => 1,
        ]);

        // return response
        return $this->handleResponse(new TaskResource($task), 'Tache ajoutée');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        $task = Task::find($task->id);
        if(is_null($task)){
            return $this->handleError('Tache non trouvée!');
        }
        return $this->handleResponse(new TaskResource($task), 'Votre tache');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTaskRequest  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task = Task::find($task->id);
        // validate data
        $validate_data = Validator::make($request->all(), [
            "nom" => 'required',
            "delai" => 'required',
        ]);
        if($validate_data->fails()){
            return $this->handleError($validate_data->errors());
        }

        // update task
        $task->nom = $request->nom;
        $task->description = $request->description;
        $task->delai = $request->delai;

        // return response
        return $this->handleResponse(new TaskResource($task), 'Tache modifée');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $task = Task::find($task->id);
        $task->delete();
        return $this->handleResponse([], 'Tache supprimée');
    }

}
