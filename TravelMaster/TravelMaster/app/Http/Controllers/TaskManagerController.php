<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Services\TaskManagerService;

class TaskManagerController extends Controller
{
    use ApiResponser;

    protected $taskManagerService;

    public function __construct(TaskManagerService $taskManagerService)
    {
        $this->taskManagerService = $taskManagerService;
    }

    public function postTask(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $user = auth()->user();

        $data = $request->only(['title', 'description', 'status']);
        return $this->successResponse($this->taskManagerService->createTask($data), Response::HTTP_CREATED);
    }

    public function seeTasks()
    {   
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $user = auth()->user();
        return $this->successResponse($this->taskManagerService->getTaskList());
    }

    public function editTask(Request $request, $id)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $user = auth()->user();
        // return $this->successResponse($this->taskManagerService->updateTask($request->all(), $id));
        $data = $request->only(['title', 'description', 'status']);
        return $this->successResponse($this->taskManagerService->updateTask($data, $id), Response::HTTP_CREATED);
    }

    public function deleteTask($id)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $user = auth()->user();
        return $this->successResponse($this->taskManagerService->deleteTask($id));
    }
}
