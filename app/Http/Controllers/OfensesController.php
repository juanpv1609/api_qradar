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

class OfensesController extends Controller
{

    public function getOffenses(){
        $user = User::with('company', 'rol')->where('id', auth()->user()->id)->First();

        $host = env("API_QRADAR");
        $response = Http::withHeaders([
            'Range' => 'items=0-9',
                ])->withOptions(['verify' => false])->withBasicAuth($user->username, Crypt::decryptString($user->password))->accept('application/json')
                ->get($host.'siem/offenses?fields=categories,category_count&filter=domain_id='.$user->company->domain.'&sort=-category_count');


        return ($response);


    }
    public function topLogSourceEvents(){
        $user = User::with('company', 'rol')->where('id', auth()->user()->id)->First();
        $today = Carbon::now()->timezone('America/Guayaquil')->valueOf();
        $lastToday = Carbon::now()->timezone('America/Guayaquil')->subDays(3)->valueOf();
        $host = env("API_QRADAR");
        $response = Http::withHeaders([
            'Range' => 'items=0-19',
                ])->withOptions(['verify' => false])->withBasicAuth($user->username, Crypt::decryptString($user->password))->accept('application/json')
                ->get($host.'siem/offenses?fields=log_sources,event_count&filter=domain_id='
                .$user->company->domain.'%20and%20start_time%20between%20'.$lastToday.'%20and%20'.$today.'&sort=-event_count');


        //dd(Carbon::now()->timezone('America/Guayaquil')->valueOf());
        //dd($response);
        return $response;


    }
    public function sourceAddress(){
        $user = User::with('company', 'rol')->where('id', auth()->user()->id)->First();

        $host = env("API_QRADAR");
        $response = Http::withHeaders([
            'Range' => 'items=0-9',
                ])->withOptions(['verify' => false])->withBasicAuth($user->username, Crypt::decryptString($user->password))->accept('application/json')
                ->get($host.'siem/source_addresses?filter=domain_id='.$user->company->domain);


        return ($response);


    }
     public function localDestination(){
        $user = User::with('company', 'rol')->where('id', auth()->user()->id)->First();

        $host = env("API_QRADAR");
        $response = Http::withHeaders([
            'Range' => 'items=0-9',
                ])->withOptions(['verify' => false])->withBasicAuth($user->username, Crypt::decryptString($user->password))->accept('application/json')
                ->get($host.'siem/local_destination_addresses?filter=domain_id='.$user->company->domain);


        return ($response);


    }

    public function offensesRule($qid){
        $user = User::with('company', 'rol')->where('id', auth()->user()->id)->First();

        $host = env("API_QRADAR");
        $response = Http::withOptions(['verify' => false])->withBasicAuth($user->username, Crypt::decryptString($user->password))->accept('application/json')
                ->get($host.'siem/offenses?filter=status=OPEN and rules contains(id='.$qid.')');


        return ($response);


    }
    public function busqueda(){
        $user = User::with('company', 'rol')->where('id', auth()->user()->id)->First();

        $host = env("API_QRADAR");
       $cond=[
            'is_deleted' => 0,
            'company_id' => $user->company_id,
            ];
         $searches = Searches::where($cond)->First();
        $query = `SELECT "sourceIP" AS 'Source IP',SUM("eventCount") AS 'Event Count (Sum)', COUNT(*) AS 'Count'
                    from events
                    where LOGSOURCEGROUPNAME(devicegrouplist) ILIKE `.$searches->like.`
                    and "creEventList"='`.$searches->creEventList.`'
                    GROUP BY "sourceIP" order by "Count" desc LIMIT 10 last 7 days`;

        $response_post = Http::withOptions(['verify' => false])->withBasicAuth($user->username, Crypt::decryptString($user->password))->accept('application/json')
                ->post($host.'ariel/searches?query_expression='.$query);
            //dd($response_post);
        $response = Http::withOptions(['verify' => false])->withBasicAuth($user->username, Crypt::decryptString($user->password))->accept('application/json')
                ->get($host.'ariel/searches/'.$response_post->search_id.'/results');


        return ($response);


    }
    /* public function busqueda($search_id){
        $user = User::with('company', 'rol')->where('id', auth()->user()->id)->First();

        $host = env("API_QRADAR");
        $response = Http::withOptions(['verify' => false])->withBasicAuth($user->username, Crypt::decryptString($user->password))->accept('application/json')
                ->get($host.'ariel/searches/'.$search_id.'/results');


        return ($response);


    } */
    public function haciaIPMAliciosas(Request $request)
    {
        $user = User::with('company', 'rol')->where('id', auth()->user()->id)->First();
        $host = env("API_QRADAR");
        $cond=[
            'is_deleted' => 0,
            'company_id' => $user->company_id,
            ];
         $searches = Searches::where($cond)->First();
        $query = `SELECT "sourceIP" AS 'Source IP',SUM("eventCount") AS 'Event Count (Sum)', COUNT(*) AS 'Count'
                    from events
                    where LOGSOURCEGROUPNAME(devicegrouplist) ILIKE `.$searches->like.`
                    and "creEventList"='`.$searches->creEventList.`'
                    GROUP BY "sourceIP" order by "Count" desc LIMIT 10 last 7 days`;
        $response = Http::withOptions(['verify' => false])->withBasicAuth($user->username, Crypt::decryptString($user->password))->accept('application/json')
                ->post($host.'ariel/searches?query_expression='.$query.'/results');


        return ($response);

    }
}
