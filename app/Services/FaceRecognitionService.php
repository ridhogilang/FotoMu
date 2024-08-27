<?php

namespace App\Services;

use Aws\Rekognition\RekognitionClient;

class FaceRecognitionService
{
    protected $rekognition;

    public function __construct()
    {
        $this->rekognition = new RekognitionClient([
            'region'  => env('AWS_DEFAULT_REGION'),
            'version' => 'latest',
            'credentials' => [
                'key'    => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ]
        ]);
    }

    public function compareFaces($sourceImage, $targetImage)
    {
        $result = $this->rekognition->compareFaces([
            'SourceImage' => [
                'Bytes' => file_get_contents($sourceImage),
            ],
            'TargetImage' => [
                'Bytes' => file_get_contents($targetImage),
            ],
            'SimilarityThreshold' => 70,
        ]);

        return $result['FaceMatches'];
    }
}
