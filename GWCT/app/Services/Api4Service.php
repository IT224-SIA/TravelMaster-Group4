<?php
namespace App\Services;
use App\Traits\ConsumesExternalService;

class Api4Service {
    use ConsumesExternalService;
    /**
     * The base url to consume the User1 Service
     * @var string
     */
    public $baseUrl;
    public $host;
    public $key;

    public function __construct()
    {
        $this->baseUrl = config('services.api4.base_url');
        $this->host = config('services.api4.host');
        $this->key = config('services.api4.key');

    }

    public function translate($data)
    {
        $headers = [
            'Accept-Encoding' => 'application/gzip',
            'Content-Type' => 'application/json',
            'x-rapidapi-host' => $this->host,
            'x-rapidapi-key' => $this->key,
        ];

        return $this->performRequest('POST', "/language/translate", $data, $headers);

    }
}