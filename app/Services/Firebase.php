<?php

namespace App\Services;

use Exception;
use App\Models\User;
use App\Models\Driver;
use GuzzleHttp\Client;
use App\Models\FirebaseRequestsLogs;
use GuzzleHttp\Exception\GuzzleException;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;

/**
 * Class Firebase
 * @package App\Services
 */
class Firebase
{

    private ?string $token = null;
    private ?string $topic = null;
    private ?string $title = null;
    private ?string $body = null;
    private ?string $image = null;
    private array $data = [];

    public static function init(): Firebase
    {
        return new self();
    }

    public function send($expiry = false, $sound = false): void
    {
        $this->sendToMany([$this->token], $expiry, $sound);
    }

    public function sendToMany($users = [], $expiry = false, $sound = false): void
    {

        $client = new Client();
        $sound = !empty($sound) ? $sound : null;

        $url = 'https://fcm.googleapis.com/v1/projects/taxi-arab-f3c27/messages:send';

        $notification = [
            'title' => $this->title,
            'body'  => $this->body
        ];

        if($this->image) $notification['image'] = $this->image;

        $payload = [
            'notification' => $notification,
        ];

        $payload['android'] = [
            'priority' => "high",
//            'notification' => [
//                'sound' => str_replace('.mp3', '', ($sound ?? 'default.mp3'))
//            ],
            'data' => [
                'sound' => str_replace('.mp3', '', ($sound ?? 'default.mp3'))
            ],
        ];
        $payload['apns'] = [
            'payload' => [
                'aps' => [
                    'alert' => [
                        'title' => $this->title,
                        'body'  => $this->body,
                    ],
                    'sound' => $sound ?? 'default.mp3'
                ]
            ]
        ];

        if($expiry){
            $payload['android']['ttl'] = $expiry . "s";
            $payload['apns']['headers'] = [
                'apns-expiration' => (string) (time() + $expiry),
            ];
        }

        if($this->image){
            $payload['apns']['payload'] = ["media-url" => $this->image];
            $payload['android']['notification'] = ['image' => $this->image];
        }


        if(count($this->data)) $payload['data'] = $this->data;

        if($this->topic){
            $payload['topic'] = $this->topic;
            $this->sendFor($client, $payload, $url);
        }else{
            foreach ($users as $token){
                $payload['token'] = $token;
                if($this->isAndroidToken($token)){
                    $payload['data'] = array_merge($payload['notification'], $this->data);
                    unset($payload['notification']);
                }
                $dataOld = $payload['data'] ?? [];
                if(isset($payload['data'])) $payload['data'] = $this->prepareData($dataOld);
                if(isset($payload['android']['data']))
                    $payload['android']['data'] = $this->prepareData(array_merge($payload['android']['data'], $dataOld));
                $this->sendFor($client, $payload, $url);
            }
        }
//
//        if(count($tokens = $this->androidTokens($users))){
//
//            $notification['sound'] = str_replace('.mp3', '', $notification['sound']);
//            $data = [
//                'data'  => $notification,
//            ];
//
//            if($this->image) $data['imageUrl'] = $this->image;
//            if($expiry) $data['ttl'] = $expiry . "s";
//            if(count($this->data)) $data['data'] = array_merge($data['data'], $this->data);
//
//            if(count($tokens) > 1) $data['registration_ids'] = $this->formatIds($tokens);
//            else $data['to'] = $tokens[0];
//
//            $this->sendFor($client, $data, $url);
//        }

    }

    private function sendFor(Client $client, $payload, $url): void
    {
        try {

            $accessToken = $this->generateAuthKey();
            if(!$accessToken) throw new \Exception("can't generate token");

            $headers = [
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type'  => 'application/json',
            ];

            $client->post($url, [
                'headers' => $headers,
                'json' => [
                    'message' => $payload
                ]
            ]);

            FirebaseRequestsLogs::create([
                'request' => json_encode([
                    'headers' => $headers,
                    'json' => [
                        'message' => $payload
                    ]
                ]),
                'status' => 'success'
            ]);

        } catch (GuzzleException|IdentityProviderException|Exception $e) {
            FirebaseRequestsLogs::create([
                'request' => json_encode([
                    'json' => [
                        'message' => $payload
                    ],
                    'message' => $e->getMessage(),
                ]),
                'status' => 'failed',
            ]);
        }

    }

    public function generateAuthKey(){

        $cred = json_decode(file_get_contents(
            storage_path("firebase/cred.json")
        ));

        $secret = openssl_get_privatekey($cred->private_key);

        $header = json_encode([
            'typ' => 'JWT',
            'alg' => 'RS256'
        ]);

        $time = time();

        $start = $time - 60;
        $end = $start + 3600;

        $payload = json_encode([
            "iss" => $cred->client_email,
            "scope" => "https://www.googleapis.com/auth/firebase.messaging",
            "aud" => "https://oauth2.googleapis.com/token",
            "exp" => $end,
            "iat" => $start
        ]);

        $base64UrlHeader = $this->base64UrlEncode($header);
        $base64UrlPayload = $this->base64UrlEncode($payload);
        openssl_sign($base64UrlHeader . "." . $base64UrlPayload,$signature,
            $secret,
            OPENSSL_ALGO_SHA256);

        $base64UrlSignature = $this->base64UrlEncode($signature);
        $jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;

        $options = [
            'http' => [
                'method'  => 'POST',
                'content' => 'grant_type=urn:ietf:params:oauth:grant-type:jwt-bearer&assertion='.$jwt,
                'header'  => "Content-Type: application/x-www-form-urlencoded"
            ]
        ];
        $context  = stream_context_create($options);
        $responseText = file_get_contents("https://oauth2.googleapis.com/token", false, $context);

        return json_decode($responseText)->access_token ?? false;
    }

    private function isAndroidToken($token): bool
    {
        return User::where('device_token', $token)->where('is_android', true)->count()
            || Driver::where('device_token', $token)->where('is_android', true)->count();
    }

    private function prepareData($payload): object
    {
        $newPayload = [];
        foreach ($payload as $key => $data){
            $newPayload[$key] = is_array($data) || is_object($data) ? json_encode($data) : (string) $data;
        }
        return (object) $newPayload;
    }

    function base64UrlEncode($text): string
    {
        return str_replace(
            ['+', '/', '='],
            ['-', '_', ''],
            base64_encode($text)
        );
    }

    public function setToken(?string $token): Firebase
    {
        $this->token = $token;
        return $this;
    }

    public function setTopic(?string $topic): Firebase
    {
        $this->topic = $topic;
        return $this;
    }

    public function setTitle(?string $title): Firebase
    {
        $this->title = $title;
        return $this;
    }

    public function setBody(?string $body): Firebase
    {
        $this->body = $body;
        return $this;
    }

    public function setImage(?string $image): Firebase
    {
        $this->image = $image;
        return $this;
    }

    public function setData(array $data): Firebase
    {
        $this->data = $data;
        return $this;
    }

}
