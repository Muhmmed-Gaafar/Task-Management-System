<?php

namespace App\Services;

use App\Models\Task;
use App\Http\Requests\TaskRequest;
use Illuminate\Support\Facades\Auth;

class TaskService
{
    public function create(TaskRequest $request)
    {
        return Auth::user()->tasks()->create($request->validated());
    }

    public function update(Task $task, TaskRequest $request)
    {

        $task->update($request->validated());
        return $task;
    }

    public function delete(Task $task)
    {
        $task->delete();
    }

    public function list()
    {
        return Auth::user()->tasks()->paginate();
    }

    public function show(Task $task)
    {
        return $task;
    }
}
