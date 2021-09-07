<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Rules;
use GuzzleHttp\Client;
use App\Models\Searches;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Crypt;

class SearchesController extends Controller
{
    public function index()
    {
        $user = User::with('company', 'rol')->where('id', auth()->user()->id)->First();
        $cond=[
            'is_deleted' => 0,
            'company_id' => $user->company_id,
            ];
         $searches = Searches::where($cond)->orderBy('description')->get()->toArray();

        return ($searches);

    }

}
