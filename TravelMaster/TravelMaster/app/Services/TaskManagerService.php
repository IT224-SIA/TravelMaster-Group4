<?php

namespace App\Services;

use App\Traits\ConsumesExternalService;

class TaskManagerService
{
    use ConsumesExternalService;

    public $baseUrl;
    public $host;
    public $key;

    public function __construct()
    {
        $this->baseUrl = env('TASKMANAGER_BASE_URL');
        $this->host = env('TASKMANAGER_HOST');
        $this->key = env('TASKMANAGER_KEY');
    }

    public function createTask($data)
    {
        $headers = [
            'X-RapidAPI-Host' => $this->host,
            'X-RapidAPI-Key' => $this->key,
            'Content-Type' => 'application/json',
        ];

        $body = json_encode($data);

        return $this->performRequest('POST', 'https://task-manager-api3.p.rapidapi.com/', $body, $headers);
    }

    public function getTaskList()
    {
        $headers = [
            'X-RapidAPI-Host' => $this->host,
            'X-RapidAPI-Key' => $this->key,
        ];

        return $this->performRequest('GET', $this->baseUrl, [], $headers);
    }

    public function updateTask($data, $id)
    {
        $headers = [
            'X-RapidAPI-Host' => $this->host,
            'X-RapidAPI-Key' => $this->key,
            'Content-Type' => 'application/json',
        ];

        return $this->performRequest('PUT', "{$this->baseUrl}/$id", $data, $headers);
    }

    public function deleteTask($id)
    {
        $headers = [
            'X-RapidAPI-Host' => $this->host,
            'X-RapidAPI-Key' => $this->key,
            'Content-Type' => 'application/json',
        ];

        return $this->performRequest('DELETE', "{$this->baseUrl}/$id", [], $headers);
    }
}
