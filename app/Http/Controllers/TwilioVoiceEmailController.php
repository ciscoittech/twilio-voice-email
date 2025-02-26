<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\TranscriptionResultEmail;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Models\Email\Email;
use Log;

class TwilioVoiceEmailController extends Controller
{
    public $twilio_domain = "https://api.twilio.com/";
    
    public function store(Request $request) {

        $record_url = $request->get('RecordingUrl');
        $transcriptioUrl = $request->get('TranscriptionUrl');
        $sid = $request->get('ACCOUNT_SID');
        $auth_token = $request->get('AUTH_TOKEN');
        $sender = $request->get('Sender');

        //Get authorization token based on SID and AUTH_TOKEN
        $authorization = 'Basic ' . base64_encode($sid.':'.$auth_token);
        $headers = array('Authorization' => $authorization);
        
        //Get transcription result
        $response = $this->api_call($transcriptioUrl, null, 'GET', $headers);
        $responseArray = $this->xmlToArray($response);
        Log::debug($responseArray);

        $email = new Email();
        $email->sender = $request->get('Sender');
        $email->subject = "Test Voice Email";
        $email->body = $responseArray['Transcription']['TranscriptionText'];
        $email->record_url = $record_url;
        $email->save();

        //Send email to owner
        $receiver = "tbattlehunt@zobosolutions.com";
        // Mail::to($receiver)->send(new TranscriptionResultEmail($response['Transcription']['TranscriptionText']));
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
        return $response;
    }
    public function xmlToArray($response) {
        $xml = simplexml_load_string($response, 'SimpleXMLElement', LIBXML_NOCDATA);
        // json
        $json = json_encode($xml);
        // array
        $array = json_decode($json, true);
        return $array;
    }
}
