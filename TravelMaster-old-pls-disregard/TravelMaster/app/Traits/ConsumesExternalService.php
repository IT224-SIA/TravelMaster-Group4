<?php
 namespace App\Traits;
 
// include the Guzzle Component Library
use GuzzleHttp\Client;
trait ConsumesExternalService
{
    /** 
     * Send a request to any service
     * @return string
     */
    // note form params and headers are optional

    public function performRequest($method, $url, $data = [], $headers = [])
    {
        $client = new Client();

        $options = [
            'headers' => $headers,
        ];

        if (!empty($data)) {
            $options['json'] = $data;
        }

        $response = $client->request($method, $url, $options);

        return json_decode($response->getBody()->getContents(), true);
    }
}