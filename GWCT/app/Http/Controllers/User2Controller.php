<?php
namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Services\User2Service;

class User2Controller extends Controller
{
    use ApiResponser;

    
    /**
     * The service to consume the User2 Microservice
     * @var User2Service
     */
    public $user2Service;
    /**
     * Create a new controller instance
     * @return void
     */
    public function __construct(User2Service $user2Service)
    {
        $this->user2Service = $user2Service;
    }


    private $request;

    public function getUsers()
    {

    }
    /**
     * Return the list of users
     * @return Illuminate\Http\Response
     */
    public function index()
    {
        return $this->successResponse($this->user2Service->obtainUsers2()); 
    }
    public function add(Request $request)
    {
        return $this->successResponse($this->user2Service->createUser2($request->all(), Response::HTTP_CREATED));
    }
    /**
     * Obtains and show one user
     * @return Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->successResponse($this->user2Service->obtainUser2($id));

    }
    /**
     * Update an existing author
     * @return Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return $this->successResponse($this->user2Service->editUser2($request->all(), $id));
    }
    /**
     * Remove an existing user
     * @return Illuminate\Http\Response
     */
    public function delete($id)
    {
        return $this->successResponse($this->user2Service->deleteUser2($id));
    }

    public function postTask(Request $request)
    {
        return $this->successResponse($this->user2Service->createTask($request->all(), Response::HTTP_CREATED));
    }

    public function seeTasks() {
        return $this->successResponse($this->user2Service->getTaskList());
    }

    public function editTask(Request $request, $id)
    {
        return $this->successResponse($this->user2Service->updateTask($request->all(), $id));
    }
    
    public function deleteTask($id)
    {
        return $this->successResponse($this->user2Service->deleteTask($id));
    }
}

// This is my User2Controller.php file

