<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use GuzzleHttp\Client;
use App\Models\Searches;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Crypt;

class AssetsController extends Controller
{
    public function getAssets()
    {
        $user = User::with('company', 'rol')->where('id', auth()->user()->id)->First();

        $host = env("API_QRADAR");
        $response = Http::withHeaders([
            'Range' => 'items=0-1500',
                ])->withOptions(['verify' => false])->withBasicAuth($user->username, Crypt::decryptString($user->password))->accept('application/json')
                ->get($host.'asset_model/assets?fields=hostnames,interfaces,properties,users&filter=domain_id='.$user->company->domain);


        dd($user);
    }
}
