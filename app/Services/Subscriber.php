<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class Subscriber
{
    protected $apiUrl;
    protected $token;

    public function __construct()
    {
        $this->apiUrl = config('services.crm_api.url') . 'api';
        $this->token = config('services.crm_api.token');
    }
    private function callApi($method, $uri, $body)
    {
        $response = Http::withToken($this->token)
            ->acceptJson()
            ->$method("{$this->apiUrl}/{$uri}", $body);

        if ($response->failed()) {
            $errorData = $response->json();
            $message = $errorData['message'] ?? 'API request failed.';
            $error = $errorData['error'] ?? null;

            if ($error) {
                $message .= 'errors: ' . json_encode($errorData);
            }

            throw new \Exception($message);
        }

        return $response->json();
    }
    public function createSubscriber($data)
    {
        return $this->callApi('post', "subscriber", $data);
    }
    public function submitEnquiry($subscriberId, $message)
    {
        return $this->callApi('post', "subscriber/{$subscriberId}/enquiry", ['message' => $message]);
    }
}
