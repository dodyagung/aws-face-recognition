<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Aws\Rekognition\RekognitionClient;

class RecognitionController extends Controller
{
    public function getRecognition(Request $request)
    {
        return redirect('/');
    }

    public function postRecognition(Request $request)
    {
        $options = [
            'version' => env('AWS_VERSION'),
            'region' => env('AWS_REGION'),
            'credentials' => [
                'key' => env('AWS_KEY'),
                'secret' => env('AWS_SECRET'),
            ]
        ];

        $image = file_get_contents($request->image->path());
        $image_base64 = base64_encode($image);

        $rekognition = new RekognitionClient($options);
        $result = $rekognition->DetectFaces([
            'Image' => [
               'Bytes' => $image,
            ],
            'Attributes' => ['ALL'],
        ]);

        return view('result', [
            'result' => $result,
        ]);
    }
}
