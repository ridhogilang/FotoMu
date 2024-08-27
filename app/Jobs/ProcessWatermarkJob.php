<?php

namespace App\Jobs;

use App\Models\Foto;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class ProcessWatermarkJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filePath;
    protected $filePathWatermark;
    protected $fotoId;

    public function __construct($filePath, $filePathWatermark, $fotoId)
    {
        $this->filePath = $filePath;
        $this->filePathWatermark = $filePathWatermark;
        $this->fotoId = $fotoId;
    }

    public function handle()
    {
        Log::info('Handling job for file:', ['file' => $this->filePath]);
        Log::info('Saving to watermark path:', ['file' => $this->filePathWatermark]);

        if (!Storage::disk('public')->exists($this->filePath)) {
            Log::error('File not found:', ['file' => $this->filePath]);
            return;
        }

        if (!file_exists(public_path('/foto/watermark.png'))) {
            Log::error('Watermark file not found:', ['file' => public_path('/foto/watermark.png')]);
            return;
        }

        try {
            if (!Storage::disk('public')->exists('uploads/photoswatermark/')) {
                Storage::disk('public')->makeDirectory('uploads/photoswatermark/');
            }

            // Proses gambar asli dan orientasikan berdasarkan EXIF data
            $image = Image::make(Storage::disk('public')->path($this->filePath))->orientate();

            // Buat watermark dan resize agar sesuai dengan ukuran gambar
            $watermark = Image::make(public_path('/foto/watermark.png'))->resize($image->width(), $image->height());

            // Tambahkan watermark yang menutupi seluruh gambar
            $image->insert($watermark, 'center');

            // Resize untuk mengurangi ukuran hingga mendekati 180KB
            $image->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            // Lakukan kompresi hingga ukuran file mendekati 180KB
            $quality = 75;
            while (strlen((string) $image->encode('jpg', $quality)) > 180 * 1024 && $quality > 10) {
                $quality -= 5;
            }

            // Simpan gambar yang sudah di-resize dan ditambahkan watermark
            $image->save(Storage::disk('public')->path($this->filePathWatermark));
            Log::info('Watermarked image saved successfully:', ['file' => $this->filePathWatermark]);

            // Update path watermark di database
            $foto = Foto::find($this->fotoId);
            if ($foto) {
                $foto->update(['fotowatermark' => $this->filePathWatermark]);
                Log::info('Database updated successfully for photo ID:', ['id' => $foto->id]);
            }

        } catch (\Exception $e) {
            Log::error('Error processing watermark job:', ['error' => $e->getMessage()]);
        }
    }
}
