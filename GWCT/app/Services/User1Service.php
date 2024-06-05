<?php
namespace App\Services;
use App\Traits\ConsumesExternalService;
use GuzzleHttp\Client;


class User1Service {
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
        $this->baseUrl = config('services.users1.base_url');
        $this->host = config('services.users1.host');
        $this->key = config('services.users1.key');

    }

    public function obtainUsers1()
    {
        return $this->performRequest('GET','/users');
    }
   
    /**
     * Create one user using the User1 service
     * @return string
     */
    public function createUser1($data)
    {
        return $this->performRequest('POST', '/users', $data);
    }

    public function obtainUser1($id)
    {
        return $this->performRequest('GET', "/users/{$id}");
    }
    public function editUser1($data, $id)
    {
        return $this->performRequest('PUT', "/users/{$id}", $data);
    }

    /**
     * Remove an existing user
     * @return Illuminate\Http\Response
     */
    public function deleteUser1($id)
    {
        return $this->performRequest('DELETE', "/users/{$id}");
    }

    public function convertIslamic($data) 
    {
        $headers = [
            'X-RapidAPI-Host' => $this->host,
            'X-RapidAPI-Key' => $this->key,
        ];

        return $this->performRequest('GET', "/time/convert-islamic", $data, $headers);
    }

     # Email Authentication API I
    public function sendOTP()
    {
        $headers = [
            'X-RapidAPI-Host' => $this->host,
            'X-RapidAPI-Key' => $this->key,
        ];

        return $this->performRequest('GET', 'https://email-authentication-system.p.rapidapi.com/',[], $headers);
    }

    # Telesign SMS Verify
    public function sendVerificationCode()
    {
        $client = new Client();

        $response = $client->request('POST', $this->baseUrl . '/sms-verification-code', [
            'body' => '{}',
            'headers' => [
                'Content-Type' => 'application/json',
                'x-rapidapi-host' => $this->host,
                'x-rapidapi-key' => $this->apiKey,
            ],
        ]);

        return [
            'status' => $response->getStatusCode(),
            'body' => json_decode($response->getBody(), true)
        ];
    }

    # Email Authentication API II
    public function sendOTPii($recipient, $app)
    {
        $client = new Client();

        $response = $client->request('GET', $this->baseUrl, [
            'query' => [
                'recipient' => $recipient,
                'app' => $app,
            ],
            'headers' => [
                'x-rapidapi-host' => $this->host,
                'x-rapidapi-key' => $this->apiKey,
            ],
        ]);

        return [
            'status' => $response->getStatusCode(),
            'body' => json_decode($response->getBody(), true)
        ];
    }

    # GeoDB Cities
    public function getCountryDetails($countryCode)
    {
        $client = new Client();

        $response = $client->request('GET', $this->baseUrl . "/v1/geo/countries/{$countryCode}", [
            'headers' => [
                'x-rapidapi-host' => $this->host,
                'x-rapidapi-key' => $this->key,
            ],
        ]);

        return [
            'status' => $response->getStatusCode(),
            'body' => json_decode($response->getBody(), true)
        ];
    }

    public function getCountryRegions($countryCode)
    {
        $client = new Client();

        $response = $client->request('GET', $this->baseUrl . "/v1/geo/countries/{$countryCode}/regions", [
            'headers' => [
                'x-rapidapi-host' => $this->host,
                'x-rapidapi-key' => $this->key,
            ],
        ]);

        return [
            'status' => $response->getStatusCode(),
            'body' => json_decode($response->getBody(), true)
        ];
    }

    public function getCountryRegionDetails($countryCode, $regionCode)
    {
        $client = new Client();

        $response = $client->request('GET', $this->baseUrl . "/v1/geo/countries/{$countryCode}/regions/{$regionCode}", [
            'headers' => [
                'x-rapidapi-host' => $this->host,
                'x-rapidapi-key' => $this->key,
            ],
        ]);

        return [
            'status' => $response->getStatusCode(),
            'body' => json_decode($response->getBody(), true)
        ];
    }

    public function getCityDetails($cityId)
    {
        $client = new Client();

        $response = $client->request('GET', $this->baseUrl . "/v1/geo/cities/{$cityId}", [
            'headers' => [
                'x-rapidapi-host' => $this->host,
                'x-rapidapi-key' => $this->key,
            ],
        ]);

        return [
            'status' => $response->getStatusCode(),
            'body' => json_decode($response->getBody(), true)
        ];
    }

    public function getCitiesNearCity($cityId, $radius)
    {
        $client = new Client();

        $response = $client->request('GET', $this->baseUrl . "/v1/geo/cities/{$cityId}/nearbyCities", [
            'query' => [
                'radius' => $radius
            ],
            'headers' => [
                'x-rapidapi-host' => $this->host,
                'x-rapidapi-key' => $this->key,
            ],
        ]);

        return [
            'status' => $response->getStatusCode(),
            'body' => json_decode($response->getBody(), true)
        ];
    }

    public function getCityDistance($fromCityId, $toCityId)
    {
        $client = new Client();

        $response = $client->request('GET', $this->baseUrl . "/v1/geo/cities/{$fromCityId}/distance", [
            'query' => [
                'toCityId' => $toCityId
            ],
            'headers' => [
                'x-rapidapi-host' => $this->host,
                'x-rapidapi-key' => $this->key,
            ],
        ]);

        return [
            'status' => $response->getStatusCode(),
            'body' => json_decode($response->getBody(), true)
        ];
    }

    public function getCityTime($cityId)
    {
        $client = new Client();

        $response = $client->request('GET', $this->baseUrl . "/v1/geo/cities/{$cityId}/time", [
            'headers' => [
                'x-rapidapi-host' => $this->host,
                'x-rapidapi-key' => $this->key,
            ],
        ]);

        return [
            'status' => $response->getStatusCode(),
            'body' => json_decode($response->getBody(), true)
        ];
    }

    public function getPlaceDetails($placeId)
    {
        $client = new Client();

        $response = $client->request('GET', $this->baseUrl . "/v1/geo/places/{$placeId}", [
            'headers' => [
                'x-rapidapi-host' => $this->host,
                'x-rapidapi-key' => $this->key,
            ],
        ]);

        return [
            'status' => $response->getStatusCode(),
            'body' => json_decode($response->getBody(), true)
        ];
    }

    public function getPlacesNearPlace($placeId)
    {
        $client = new Client();

        $response = $client->request('GET', $this->baseUrl . "/v1/geo/places/{$placeId}/nearbyPlaces", [
            'headers' => [
                'x-rapidapi-host' => $this->host,
                'x-rapidapi-key' => $this->key,
            ],
        ]);

        return [
            'status' => $response->getStatusCode(),
            'body' => json_decode($response->getBody(), true)
        ];
    }

    public function getPlaceDistance($placeId, $toPlaceId)
    {   
        $client = new Client();

        $response = $client->request('GET', $this->baseUrl . "/v1/geo/places/{$placeId}/distance", [
            'query' => [
                'toPlaceId' => $toPlaceId
            ],
            'headers' => [
                'x-rapidapi-host' => $this->host,
                'x-rapidapi-key' => $this->key,
            ],
        ]);

        return [
            'status' => $response->getStatusCode(),
            'body' => json_decode($response->getBody(), true)
        ];
    }

    public function getPlaceDateTime($placeId)
    {
        $client = new Client();

        $response = $client->request('GET', $this->baseUrl . "/v1/geo/places/{$placeId}/dateTime", [
            'headers' => [
                'x-rapidapi-host' => $this->host,
                'x-rapidapi-key' => $this->key,
            ],
        ]);

        return [
            'status' => $response->getStatusCode(),
            'body' => json_decode($response->getBody(), true)
        ];
    }

    public function getPlaceTime($placeId)
    {
        $client = new Client();

        $response = $client->request('GET', $this->baseUrl . "/v1/geo/places/{$placeId}/time", [
            'headers' => [
                'x-rapidapi-host' => $this->host,
                'x-rapidapi-key' => $this->key,
            ],
        ]);

        return [
            'status' => $response->getStatusCode(),
            'body' => json_decode($response->getBody(), true)
        ];
    }
}