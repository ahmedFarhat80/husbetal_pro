<?php

namespace App\Http\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\App;

class Mobile2000Service
{
    protected $client;
    protected $baseUrl = 'http://server.smson.com/SmsWebService.asmx';

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'timeout'  => 50.0,
        ]);
    }

    public function sendVerificationCode($verificationCode, $phoneNumber)
    {
        $response = $this->client->post('/send', [
            'form_params' => [
                'username' => 'Yone App1',
                'password' => 'bp55eLG6',
                'token' => 'wMd9zEbn0jk3SRwT3vOpYfKD',
                'sender' => 'Yone App',
                'message' => 'Your verification code is: ' . $verificationCode,
                'dst' => $phoneNumber,
                'type' => 'text',
                'coding' => 'default',
                'datetime' => 'now'
            ]
        ]);

        return $response->getBody()->getContents();
    }


    protected function cURL($url, $data)
    {
        $header = array(
            "POST /SmsWebService.asmx/send HTTP/1.1",
            "Host: server.smson.com",
            "Content-Type: application/x-www-form-urlencoded",

            "Content-Length: " . strlen($data),
        );

        $soap_do = curl_init();
        curl_setopt($soap_do, CURLOPT_URL, $url);
        curl_setopt($soap_do, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($soap_do, CURLOPT_TIMEOUT,        10);
        curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($soap_do, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($soap_do, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($soap_do, CURLOPT_POST,           true);
        curl_setopt($soap_do, CURLOPT_POSTFIELDS,     $data);
        curl_setopt($soap_do, CURLOPT_HTTPHEADER,     $header);

        $result = curl_exec($soap_do);

        // Close curl resource to free up system resources
        curl_close($soap_do);

        return $result;
    }

    public static function send($code, $phone)
    {
        $dst            = $phone;
        $url            = "server.smson.com/SmsWebService.asmx/send";
        if (App::getLocale() == 'ar') {
            $message        = "رمز التحقق الخاص بك هو: " . $code;
            $unicode = "unicode";
        } else {
            $message = "Your Verification code: " . $code;
            $unicode = "default";
        }
        $soap_request   = "username=Yone App1&password=bp55eLG6&token=wMd9zEbn0jk3SRwT3vOpYfKD&sender=Yone App&message=" . $message  . "&dst=" . $dst . "&type=text&coding=" . $unicode . "&datetime=now";
        // create object from Class to calling func inside class
        $CodeService = new Mobile2000Service;

        // Send curl
        $output = $CodeService->cURL(
            $url,
            $soap_request
        );
        //dd($output);
        return true;
    }



    public static function send2($message, $phone)
    {
        $dst            = $phone;
        $url            = "server.smson.com/SmsWebService.asmx/send";
        if (App::getLocale() == 'ar') {
            $unicode = "unicode";
        } else {
            $unicode = "default";
        }
        $soap_request   = "username=Yone App1&password=bp55eLG6&token=wMd9zEbn0jk3SRwT3vOpYfKD&sender=Yone App&message=" . $message  . "&dst=" . $dst . "&type=text&coding=" . $unicode . "&datetime=now";
        // create object from Class to calling func inside class
        $CodeService = new Mobile2000Service;

        // Send curl
        $output = $CodeService->cURL(
            $url,
            $soap_request
        );
        //dd($output);
        return true;
    }
}
