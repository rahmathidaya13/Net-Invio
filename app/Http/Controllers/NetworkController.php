<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\NetworkHelper;

class NetworkController extends Controller
{
    public function networkStatus()
    {
        $ping = NetworkHelper::getPingToInternet('8.8.8.8');
        return response()->json([
            'ping' => $ping,
            'target' => '8.8.8.8',
        ]);
    }
}
