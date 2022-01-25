<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

use \CBOR\CBOREncoder;
use \ECDSA\Curves;
use \ECDSA\Algorithms;
use \ECDSA\ECDSA;
use \JOSE\JOSEmessage;
use \JOSE\Sign1Message;
use \JOSE\Keys;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;


use \Mhauri\Base45;

class GenerateQR extends Controller
{
    public function generateForm() {
        return view('generate');
    }

    public function GenerateId(
        int $length = 10,
        string $keyspace = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'): string {
        if ($length < 1){
            throw new \RangeException("Length must be a positive integer");
        }
        $pieces = [];
        $max = mb_strlen($keyspace, '8bit') - 1;

        for($i = 0; $i < $length; $i++){
            $pieces[] = $keyspace[random_int(0, $max)];
        }

        return implode('', $pieces);
    }

    protected function SetPayload($a){
        $add = 3600*rand(1, 23)+60*rand(1, 59)+rand(1, 59);
        $at = ($add+$a->departure_time);
        $data = [
            'train'=>[
                'v'=>$a->trainID,
                'at'=>(int)$at,
                'dt'=>(int)$a->departure_time,
                'fl'=>(string)$a->from,
                'tl'=>(string)$a->to,
            ],
            'ticket'=>[
                'id'=>$this->GenerateId(12),
                'bt'=>(int)time(),
                'et'=>(int)($at+3600),
                'cl'=>(int)$a->cl,
                'c'=>(int)$a->car,
                's'=>(int)$a->seat,
            ],
            'per'=>[
                'fname'=>$a->fname,
                'sname'=>$a->sname,
            ]
        ];
        return $data;
    }

    public function generatePost(Request $request){
        $validator = Validator::make($request->all(), [
            'departure_time'=>'required',
            'fname'=>'required',
            'sname'=>'required',
        ]);

        if ($validator->passes()) {
            $base45 = new Base45;
            $algo = Algorithms::ES256();
            $curve = Curves::NIST256p();

            $request->departure_time = strtotime($request->departure_time);

            $payload = $this->SetPayload($request);

            $phdr = [
                'Algorithm'=>$algo->name,
                'Curve'=>$curve->nistName,
                'KID'=>$request->key
            ];
            $uhdr = [];

            $pem = '-----BEGIN EC PRIVATE KEY-----
MHcCAQEEIJZMro9ZMzD1Voxq5qbI6lAxt9EdvHjgU/kAc0rKqal1oAoGCCqGSM49
AwEHoUQDQgAEmyxjakLnCiKxnwcK4i7f2eltRZwC0UYQ8k3/l0ubjRr3l9/tiFVQ
3Qf/4DPTbMDY+tylYWoUqiR3/6f1/blurA==
-----END EC PRIVATE KEY-----';

            $message = new Sign1Message($phdr, $uhdr, $payload);
            $key = new Keys($pem, $request->key, $curve, $algo);

            $message->key = $key;

            $encoded = CBOREncoder::encode($message->encode());
            $encoded = gzcompress($encoded, 9);
            $encoded = $base45->encode($encoded);

            $options = new QROptions(
                [
                    'eccLevel'=>QRCode::ECC_Q,
                    'outputType'=>QRCode::OUTPUT_IMAGE_JPG,
                    'version'=>17,
                ]
            );

            $qrcode = (new QRCode($options))->render($encoded);

            //Set the headers;
           
            return response()->json(['QR'=>$qrcode, 'ID'=>$this->GenerateId(12), 'Valid'=>$payload['ticket']['et']]);
        }

        return response()->json(['error'=>$validator->errors()->all()]);
    }
}
