<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Services\TaskService;
use App\Traits\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    use Response;

    protected $taskService;

    public function __construct(TaskService $taskService)
    {

        $this->taskService = $taskService;
    }

    public function index()
    {
        $tasks = $this->taskService->list();
        return $this->success(TaskResource::collection($tasks), 'Tasks retrieved successfully');
    }

    public function store(TaskRequest $request): JsonResponse
    {
        $task = $this->taskService->create($request);
        return $this->success(new TaskResource($task), 'Task created successfully', 201);
    }

    public function show(Task $task): JsonResponse
    {
        if ($task->user_id !== Auth::id()) {
            return $this->failed(null, 'Unauthorized access', 403);
        }
        return $this->success(new TaskResource($task), 'Task retrieved successfully');
    }

    public function update(TaskRequest $request, Task $task): JsonResponse
    {
        if ($task->user_id !== Auth::id()) {
            return $this->failed(null, 'Unauthorized access', 403);
        }

        $this->taskService->update($task, $request);
        return $this->success(new TaskResource($task), 'Task updated successfully');
    }

    public function destroy(Task $task): JsonResponse
    {
        if ($task->user_id !== Auth::id()) {
            return $this->failed(null, 'Unauthorized access', 403);
        }

        $this->taskService->delete($task);
        return $this->message('Task deleted successfully');
    }
}



