<?php

namespace App\Http\Controllers;

use App\Models\Bling;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use stdClass;

class BlingController extends Controller
{
    
    public function connectionBling(Request $request)
    {
        $apikey = "a1e40eb6c370ff68ce1a0cebe340bbde0db405d6ad40e0217ddec6bfce0a2c12e441b606";
        $outputType = "json";
        $url = 'https://bling.com.br/Api/v2/depositos/' . $outputType;
        $retorno = $this->executeGetDeposits($url, $apikey);
        return $retorno;
    }

    function executeGetDeposits($url, $apikey){
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $url . '&apikey=' . $apikey);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, TRUE);
        $response = curl_exec($curl_handle);
        curl_close($curl_handle);
        return $response;
    }

    public function getNotificationStoque(Request $request){
        // dd("chegou");
        $class = new stdClass;
        $blocks = new stdClass;
        $text = new stdClass;

        // dd($request->all()['retorno']['estoques'][0]['estoque']);
        $text->type = 'mrkdwn';
        $text->text = 'Name: *' . $request->all()['retorno']['estoques'][0]['estoque']['nome'] . '*\n\n Email: *' . $request->all()['retorno']['estoques'][0]['estoque']['nome'] . '*';


        $blocks->type = 'section';
        $class->text = $request->all()['retorno']['estoques'][0]['estoque']['nome'];

        // dd($class);

        $data = Http::post('https://hooks.slack.com/services/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', $class);
        return $data;
    }
}
