<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \CBOR\CBOREncoder;
use \ECDSA\Curves;
use \ECDSA\Algorithms;
use \ECDSA\ECDSA;
use \JOSE\JOSEmessage;
use \JOSE\Sign1Message;
use \JOSE\Keys;


use \Mhauri\Base45;

class ScannerQR extends Controller
{
    public function scannerPost() {
        return view('scan');
    }

    public function QRscanner(Request $request){

        $base45 = new Base45;
        $curve = Curves::NIST256p();
        $algo = Algorithms::ES256();

        $publicKey_pem = '-----BEGIN PUBLIC KEY-----
MFkwEwYHKoZIzj0CAQYIKoZIzj0DAQcDQgAEmyxjakLnCiKxnwcK4i7f2eltRZwC
0UYQ8k3/l0ubjRr3l9/tiFVQ3Qf/4DPTbMDY+tylYWoUqiR3/6f1/blurA==
-----END PUBLIC KEY-----';

        $encoded = $base45->decode($request->content);
        $encoded = gzuncompress($encoded);

        $decoded = JOSEmessage::decode($encoded);

        $key = new Keys($publicKey_pem, $decoded->phdr['KID'], $curve, $algo);

        $decoded->key = $key;

        $payload = $decoded->payload;

        $payload = CBOREncoder::decode($payload);

        if($payload['ticket']['et'] > time()){
            $valid = true;
        }else{
            $valid = false;
        }

        return response()->json(['signature'=>$decoded->Verify_Signature(), 'valid'=>$valid, 'payload'=>$payload]);
    }
}
