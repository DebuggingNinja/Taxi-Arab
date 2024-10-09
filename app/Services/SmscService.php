<?php


namespace App\Services;

use Illuminate\Support\Facades\Http;


class SmscService
{
    protected $apiUrl, $apiUser, $apiPass;

    function __construct()
    {
        $this->apiUrl = env('SMS_PROVIDER_URL', 'http://82.212.81.40:8080/websmpp/sendSMS');
        $this->apiUser = env('SMS_PROVIDER_USER', '');
        $this->apiPass = env('SMS_PROVIDER_PASS', '');
    }
    public function send($phoneNumber, $message)
    {
        // Build the GET parameters
        $queryParams = http_build_query([
            'user' =>  $this->apiUser,
            'pass' =>  $this->apiPass,
            'sid' => env('APP_NAME', ""),
            'mno' => $phoneNumber,
            'type' => '1',
            'text' => $message,
        ]);

        // Combine the base URL and parameters
        return Http::get($this->apiUrl  . '?' . $queryParams);
    }
}
