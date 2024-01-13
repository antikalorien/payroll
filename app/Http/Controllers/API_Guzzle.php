<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class API_Guzzle extends Controller
{
    private function urlLokaHR()
    {
        $url= 'https://lokahr.salokapark.app/api/';
        // $url = 'http://192.168.0.75:8091/api/';
        return $url;
    }
 
    private function urlWebWhatsapp()
    {
        // server Foonte 
        $url = "https://api.fonnte.com/send";
        // server Saloka
        // $url = "103.164.114.22:8200/SendMessage";
        // lokal
        // $url = "10.10.10.28:8200/SendMessage";
        return $url;
    }
    // --------------------------------------------------------------------------------
    // GET SERVICE
    // server WA
    public function getServiceWhatsapp($telephone,$message)
    {
        try 
        {
            $client = new \GuzzleHttp\Client();

            $url = $this->urlWebWhatsapp();

            $response = $client->request('POST', $this->urlWebWhatsapp(), [
                'headers' => [
                    'Authorization' => '+PkfUaYYGfR1+gRCx9no',
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'target' => $telephone,
                    'message' => $message
                ],
            ]);
            $data = json_decode($response->getBody(), true);
            return $data;
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    // END GET SERVICE
    // -------------------------------------------------------------------------------------------
}
