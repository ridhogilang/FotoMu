<?php

namespace App\Jobs;

use App\Models\SimilarFoto;
use App\Services\FaceRecognitionService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CompareFacesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $userId;
    protected $fotoId;
    protected $userPhotoPath;
    protected $fotoPath;

    public function __construct($userId, $fotoId, $userPhotoPath, $fotoPath)
    {
        $this->userId = $userId;
        $this->fotoId = $fotoId;
        $this->userPhotoPath = $userPhotoPath;
        $this->fotoPath = $fotoPath;
    }

    public function handle(FaceRecognitionService $faceRecognitionService)
    {
        // Lakukan perbandingan wajah
        $matches = $faceRecognitionService->compareFaces($this->userPhotoPath, $this->fotoPath);

        // Jika cocok, simpan ke tabel SimilarFoto
        if (!empty($matches)) {
            SimilarFoto::updateOrCreate(
                ['user_id' => $this->userId, 'foto_id' => $this->fotoId],
                []
            );
        }
    }
}
