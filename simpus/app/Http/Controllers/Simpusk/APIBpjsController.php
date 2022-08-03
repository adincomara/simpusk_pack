<?php

namespace App\Http\Controllers\Simpusk;

use App\Models\Simpusk\Pcare;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use \LZCompressor\LZString as LZString;

class APIBpjsController extends Controller
{
    public static function decompress($string){
        return \LZCompressor\LZString::decompressFromEncodedURIComponent($string);
    }


    public static function stringDecrypt($string, $stamp){
        $consID 	= env('API_CONSID', '17432'); //customer ID anda
        $secretKey 	= env('API_SECRETKEY', '8uRC52B72D'); //secretKey anda

        // $stamp    = time();

        $key = "".$consID."".$secretKey."".$stamp;
        $encrypt_method = 'AES-256-CBC';

        // hash
        $key_hash = hex2bin(hash('sha256', $key));

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hex2bin(hash('sha256', $key)), 0, 16);

        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key_hash, OPENSSL_RAW_DATA, $iv);
        $data = LZString::decompressFromEncodedURIComponent($output);


        return $data;



        // return APIBpjsController::decompress($output);
    }
    public static function get($url){
        try{
            $uri = env('API_URL');
            $consID 	= env('API_CONSID'); //customer ID anda
            $secretKey 	= env('API_SECRETKEY'); //secretKey anda

            $pcare = Pcare::first();
            $pcareUname = $pcare->username;
            $pcarePWD = $pcare->password;

            $kdAplikasi	= env('API_KDAPLIKASI'); //kode aplikasi
            $user_key = env('API_USER_KEY');

            $stamp    = time();
            // return $stamp;
            $data     = $consID.'&'.$stamp;

            $signature = hash_hmac('sha256', $data, $secretKey, true);
            $encodedSignature = base64_encode($signature);
            $encodedAuthorization = base64_encode($pcareUname.':'.$pcarePWD.':'.$kdAplikasi);
            // return $uri;
            $headers = array(
                        "Accept: application/json",
                        "X-cons-id:".$consID,
                        "X-timestamp: ".$stamp,
                        "X-signature: ".$encodedSignature,
                        "X-authorization: Basic " .$encodedAuthorization,
                        "user_key:".$user_key,
                        "Content-Type: application/json"
                    );
            $ch = curl_init($uri.''.$url);
            // return $uri.''.$url;
            // curl_setopt($ch, CURLOPT_TIMEOUT, 5);
            // curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_SSL_CIPHER_LIST, 'DEFAULT@SECLEVEL=1');
            $data = curl_exec($ch);
            if (curl_errno($ch)) {
                echo curl_error($ch);
            }
            curl_close($ch);

            // header("Content-Type: application/json");
            $data = json_decode($data, true);
            // return $data;
            if(isset($data['metaData'])){
                $api = $data;
                $metadata = $data['metaData'];
            }

            if($metadata['message'] == 'OK' && $metadata['code'] == 200){
                for(;;){
                    $response = APIBpjsController::stringDecrypt($api['response'], $stamp);
                    $result = json_decode($response,true);
                    if($result == null){
                        continue;
                    }else{
                        break;
                    }

                }
            }
            // if(empty($result)){
            //     return self::get($url);
            // }
            $data['metaData'] = $metadata;
            $data['response'] = $result;
            // return $data;
        }catch(\Throwable $th){
            $data['metaData']['code'] = 204;
            $data['metaData']['message'] = 'Error!';
            $data['response'] = 'Error!';
        }
        return $data;
    }

}
