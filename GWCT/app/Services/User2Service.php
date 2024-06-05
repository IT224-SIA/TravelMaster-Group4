<?php
namespace App\Services;
use App\Traits\ConsumesExternalService;

class User2Service{
    use ConsumesExternalService;
    /**
     * The base url to consume the User2 Service
     * @var string
     */
    public $baseUrl;
    public $host;
    public $key;
    public function __construct()
    {
        $this->baseUrl = config('services.api2.base_url');
        $this->host = config('services.api2.host');
        $this->key = config('services.api2.key');
    }

    public function obtainUsers2()
    {
        return $this->performRequest('GET','/users');
    }
   
    /**
     * Create one user using the User2 service
     * @return string
     */
    public function createUser2($data)
    {
        return $this->performRequest('POST', '/users', $data);
    }

    public function obtainUser2($id)
    {
        return $this->performRequest('GET', "/users/{$id}");
    }
    public function editUser2($data, $id)
    {
        return $this->performRequest('PUT', "/users/{$id}", $data);
    }

    /**
     * Remove an existing user
     * @return Illuminate\Http\Response
     */
    public function deleteUser2($id)
    {
        return $this->performRequest('DELETE', "/users/{$id}");
    }

    public function createTask($data)
    {
        $headers = [
            'X-RapidAPI-Host' => $this->host,
            'X-RapidAPI-Key' => $this->key,
            'Content-Type' => 'application/json',
        ];

        return $this->performRequest('POST', 'https://task-manager-api3.p.rapidapi.com/', $data, $headers);
    }


    public function getTaskList()
    {
        $headers = [
            'X-RapidAPI-Host' => $this->host,
            'X-RapidAPI-Key' => $this->key,
        ];

        return $this->performRequest('GET','https://task-manager-api3.p.rapidapi.com/',[], $headers);
    }

    public function updateTask($data, $id)
    {
        $endpoint = "/$id"; // Assuming $id is the task ID

        $headers = [
            'X-RapidAPI-Host' => $this->host,
            'X-RapidAPI-Key' => $this->key,
            'Content-Type' => 'application/json',
        ];
    
        return $this->performRequest('PUT', "https://task-manager-api3.p.rapidapi.com$id", $data, $headers);
    }

    public function deleteTask($id)
    {
        $endpoint = "/$id";

        $headers = [
            'X-RapidAPI-Host' => $this->host,
            'X-RapidAPI-Key' => $this->key,
            'Content-Type' => 'application/json',
        ];

        return $this->performRequest('DELETE', "https://task-manager-api3.p.rapidapi.com$id", [],$headers);

    }

}

// This is my User2Service.php file: