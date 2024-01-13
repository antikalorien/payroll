<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;

class SentWhatsappController extends Controller
{

    private function getNamaApps()
    {
        return '[HRIS-PAYROLL]';
    }
    
    public function sentWAtoDeveloper($message)
    {
        // sent to developer
        $telephone ='6285941304991';
        $c_apiGuzzle = new API_Guzzle();
        $result_ = $c_apiGuzzle->getServiceWhatsapp($telephone,$message);
    }
    
}
