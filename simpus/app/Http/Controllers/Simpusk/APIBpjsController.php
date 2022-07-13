<?php

namespace App\Http\Controllers\Simpusk;

use App\Models\Simpusk\Pasien;
use Illuminate\Http\Request;

class APIBpjsController extends Controller
{
    public static function decompress($string){
        return \LZCompressor\LZString::decompressFromEncodedURIComponent($string);
    }

    public static function stringDecrypt($string){
        // return $string;
        $consID 	= env('API_CONSID', '17432'); //customer ID anda
        $secretKey 	= env('API_SECRETKEY', '8uRC52B72D'); //secretKey anda

        $stamp    = time();

        $key = "".$consID."".$secretKey."".$stamp;
        $encrypt_method = 'AES-256-CBC';

        // hash
        $key_hash = hex2bin(hash('sha256', $key));

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hex2bin(hash('sha256', $key)), 0, 16);

        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key_hash, OPENSSL_RAW_DATA, $iv);
        return \LZCompressor\LZString::decompressFromEncodedURIComponent($output);

        // return APIBpjsController::decompress($output);
    }
    public static function get($url){
        $uri = env('API_URL_PCARE', 'https://apijkn-dev.bpjs-kesehatan.go.id/pcare-rest-dev/');
        $consID 	= env('API_CONSID', '17432'); //customer ID anda
        $secretKey 	= env('API_SECRETKEY', '8uRC52B72D'); //secretKey anda

        $pcareUname = env('API_PCAREUNAME', '0159092404'); //username pcare
        $pcarePWD 	= env('API_PCAREPWD', '0159092404@1Pkm'); //password pcare anda

        $kdAplikasi	= env('API_KDAPLIKASI', '095'); //kode aplikasi
        $user_key = env('API_USER_KEY', 'a7582d46575ed19b5e7c954201d7d9fa');

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
        return $data;
    }
}
