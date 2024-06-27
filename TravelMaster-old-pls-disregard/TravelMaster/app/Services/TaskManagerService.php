<?php

// Defining namespace
namespace App\Services;

// Using trait to consume external service
use App\Traits\ConsumesExternalService;


/**
 * This class provides a service for managing tasks. It uses the `ConsumesExternalService` trait to make HTTP requests to an external API.
 * It has methods for creating, updating, and deleting tasks, as well as retrieving a list of tasks.
 */
class TaskManagerService
{
    // Using the ConsumesExternalService trait
    use ConsumesExternalService;

    // Declaring variables for the API base URL, host, and key
    public $baseUrl;
    public $host;
    public $key;

    /**
     * Constructor for initializing base URL, host, and key for the Task Manager Service.
     */
    public function __construct()
    {
        $this->baseUrl = env('TASKMANAGER_BASE_URL');
        $this->host = env('TASKMANAGER_HOST');
        $this->key = env('TASKMANAGER_KEY');
    }


    /**
     * Creates a new task by sending a POST request to the Task Manager API.
     *
     * @param array $data The data for the new task.
     * @return mixed The response from the API.
     */
    public function createTask($data)
    {
        // Defining the headers
        $headers = [
            'X-RapidAPI-Host' => $this->host,
            'X-RapidAPI-Key' => $this->key,
            'Content-Type' => 'application/json',
        ];

        // Sending the POST request to the API, passing base URL, data, and headers
        // and storing the response in a variable
        $response = $this->performRequest('POST', $this->baseUrl, $data, $headers);

        // Returning the response
        return $response;
    }


    /**
     * Retrieves a list of tasks from the Task Manager API.
     *
     * @return mixed The response from the API.
     */
    public function getTaskList()
    {
        // Defining the headers
        $headers = [
            'X-RapidAPI-Host' => $this->host,
            'X-RapidAPI-Key' => $this->key,
        ];

        // Sending the GET request to the API and passing base URL and headers
        return $this->performRequest('GET', $this->baseUrl, [], $headers);
    }


    /**
     * Updates a task by sending a PUT request to the Task Manager API.
     *
     * @param array $data The data for the updated task.
     * @param int $id The ID of the task to be updated.
     * @return mixed The response from the API.
     */
    public function updateTask($data, $id)
    {
        // Defining the headers
        $headers = [
            'X-RapidAPI-Host' => $this->host,
            'X-RapidAPI-Key' => $this->key,
            'Content-Type' => 'application/json',
        ];

        // Sending the PUT request to the API and passing base URL, headers, and data
        // and storing the response in a variable
        $response = $this->performRequest('PUT', "{$this->baseUrl}/$id", $data, $headers);

        // Returning the response
        return $response;
    }


    /**
     * Deletes a task by sending a DELETE request to the Task Manager API.
     *
     * @param int $id The ID of the task to be deleted.
     * @return mixed The response from the API.
     */
    public function deleteTask($id)
    {
        // Defining the headers
        $headers = [
            'X-RapidAPI-Host' => $this->host,
            'X-RapidAPI-Key' => $this->key,
            'Content-Type' => 'application/json',
        ];

        // Sending the DELETE request to the API and passing base URL and headers
        return $this->performRequest('DELETE', "{$this->baseUrl}/$id", [], $headers);
    }
}
