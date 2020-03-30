<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\TranscriptionResultEmail;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Log;

class EmailController extends Controller
{
    public $twilio_domain = "https://api.twilio.com/";
    public function store(Request $request) {
        Log::debug($request);

        $record_url = $request->get('RecordingUrl');
        $transcriptioUrl = $request->get('TranscriptionUrl');
        $sid = $request->get('ACCOUNT_SID');
        $auth_token = $response->get('AUTH_TOKEN');
        $authorization = 'Basic' + base64_encode($sid.':'.'$auth_token');
        $headers = array('Authorization' => $authorization);
        $response = $this->api_call($transcriptioUrl, null, 'GET', $headers);
        Log::debug($response);
        $receiver = "tbattlehunt@zobosolutions.com";
        // Mail::to($receiver)->send(new TranscriptionResultEmail($response));
        return response()->json(['message' => 'Successfully received the record'], 200);
    }
    private function api_call($path, $param_string='', $method='GET', $headers=array()) {
        $method = strtoupper($method);
        $curl = curl_init($path);
        curl_setopt($curl,CURLOPT_VERBOSE,1);
        curl_setopt($curl,CURLOPT_TIMEOUT,15);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FAILONERROR, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,  2);
        curl_setopt($curl, CURLOPT_FORBID_REUSE, true);
        curl_setopt($curl, CURLOPT_DNS_USE_GLOBAL_CACHE, true); // makes calls faster!
        curl_setopt($curl, CURLOPT_DNS_CACHE_TIMEOUT, 86400); // makes calls faster!
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        
        switch($method) {
            case 'GET':
                if($param_string) {
                    if(!is_string($param_string)) $param_string = http_build_query($param_string);
                    $path .= '/'.$param_string;
                }
            break;
            case 'POST':
            break;
        }
        $headers = array_merge(array(
            // 'X-Authorization' => $settings['api_key'],
            // 'X-Requested-With' => 'XMLHttpRequest',
            'Content-Type' => 'application/x-www-form-urlencoded'
        ), $headers);
        $http_headers = array();
        foreach($headers as $header => $value) {
            $http_headers[] = $header.': '.$value;
        }
        if(!empty($http_headers)) curl_setopt($curl, CURLOPT_HTTPHEADER, $http_headers);
        curl_setopt($curl, CURLOPT_URL, $path);
    
        $response = curl_exec($curl);
        $response_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        unset($curl);

        // try {
        //     return $this->api_call_response($response, $response_code);
        // } catch(Exception $exception) {
        //     error_log($exception->getMessage());
        //     return null;
        // }
        return $response;
    }
}
