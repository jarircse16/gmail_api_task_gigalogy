<?php

namespace App\Http\Controllers;

use Google_Client;
use Google_Service_Gmail;
use Illuminate\Http\Request;

class GmailController extends Controller
{
    private $client;

    public function __construct()
    {
        $this->client = new Google_Client();
        $this->client->setAuthConfig(storage_path('app/gmail-credentials.json'));
        $this->client->addScope(Google_Service_Gmail::GMAIL_SEND);
    }

    public function sendEmail($to, $subject, $message)
    {
        $this->client->setAccessToken($this->getAccessToken());

        if ($this->client->isAccessTokenExpired()) {
            $this->client->fetchAccessTokenWithRefreshToken($this->client->getRefreshToken());
            $this->saveAccessToken($this->client->getAccessToken());
        }

        $service = new Google_Service_Gmail($this->client);

        $message = $this->createMessage($to, $subject, $message);

        $service->users_messages->send('me', $message);
    }

    private function createMessage($to, $subject, $body)
    {
        $message = new \Google_Service_Gmail_Message();
        $rawMessage = base64_encode("To: $to\r\nSubject: $subject\r\n\r\n$body");
        $message->setRaw($rawMessage);

        return $message;
    }

    private function getAccessToken()
    {
        return json_decode(file_get_contents(storage_path('app/gmail-token.json')), true);
    }

    private function saveAccessToken($token)
    {
        file_put_contents(storage_path('app/gmail-token.json'), json_encode($token));
    }
}
