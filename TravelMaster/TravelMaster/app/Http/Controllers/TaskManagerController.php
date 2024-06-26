<?php

// Defining the namespace for the controllers in the App\Http directory
namespace App\Http\Controllers;

// Importing the needed classes
use Illuminate\Http\Response;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Services\TaskManagerService;

/**
 * This controller handles all requests related to the Task Manager API.
 * It provides methods for creating, viewing, editing, and deleting tasks.
 * All methods require the user to be authenticated.
 */
class TaskManagerController extends Controller
{
    /**
     * Importing the ApiResponser trait.
     * The ApiResponser trait provides methods for returning JSON responses.
     * It is used to standardize the structure of the JSON responses.
     */
    use ApiResponser;


    protected $taskManagerService; // We're defining a property that holds an instance of the TaskManagerService.

    /**
     * Constructs a new instance of the TaskManagerController class.
     *
     * @param TaskManagerService $taskManagerService The TaskManagerService instance to be used by the controller.
     */
    public function __construct(TaskManagerService $taskManagerService)
    {
        $this->taskManagerService = $taskManagerService;
    }


    /**
     * This function creates a new task using the provided data.
     *
     * @param Request $request The HTTP request containing the task data.
     * @return \Illuminate\Http\JsonResponse The JSON response containing the created task or an error message.
     */
    public function postTask(Request $request)
    {

        // Check if the user is authenticated. If not, return a JSON response with an 'Unauthenticated' error message and a 401 status code.
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        // Get the authenticated user.
        $user = auth()->user();

        // Extract the 'title', 'description', and 'status' fields from the request data.
        $data = $request->only(['title', 'description', 'status']);

        // Calling the 'createTask' method of the 'TaskManagerService' class to create a new task.
        return $this->successResponse($this->taskManagerService->createTask($data), Response::HTTP_CREATED);
    }

    /**
     * This function retrieves all tasks.
     *
     * @param Request $request The HTTP request containing the task data.
     * @return \Illuminate\Http\JsonResponse The JSON response as a list of tasks or an error message.
     */
    public function seeTasks()
    {
        // Check if the user is authenticated. If not, return a JSON response with an 'Unauthenticated' error message and a 401 status code.
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        // Get the authenticated user.
        $user = auth()->user();

        // Calling the 'getTaskList' method of the 'TaskManagerService' class to get the list of tasks.
        return $this->successResponse($this->taskManagerService->getTaskList());
    }

    /**
     * Edit a task by its ID.
     *
     * @param Request $request The HTTP request containing the task data.
     * @param int $id The ID of the task to be edited.
     * @return \Illuminate\Http\JsonResponse The JSON response containing the updated task or an error message.
     */
    public function editTask(Request $request, $id)
    {
        // Check for user authentication, return an error message if not authenticated
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        // Get the authenticated user
        $user = auth()->user();

        // Extract the 'title', 'description', and 'status' fields from the request data.
        $data = $request->only(['title', 'description', 'status']);

        // Calling the 'updateTask' method of the 'TaskManagerService' class to update the task.
        return $this->successResponse($this->taskManagerService->updateTask($data, $id), Response::HTTP_CREATED);
    }

    /**
     * Deletes a task by its ID.
     *
     * @param int $id The ID of the task to be deleted.
     * @return \Illuminate\Http\JsonResponse The JSON response containing the result of the deletion or an error message.
     */
    public function deleteTask($id)
    {
        // Check for user authentication, return an error message if not authenticated
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        // Get the authenticated user
        $user = auth()->user();

        // Calling the 'deleteTask' method of the 'TaskManagerService' class to delete the specified task
        return $this->successResponse($this->taskManagerService->deleteTask($id));
    }
}
