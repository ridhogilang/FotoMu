<?php

namespace App\Http\Controllers\Foto;

use App\Models\Foto;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class FotograferController extends Controller
{
    public function profil()
    {
        $user = Auth::user();

        return view('fotografer.profil', [
            "title" => "Profil",
            "user" => $user,
        ]);
    }

    public function upload()
    {
        $user = Auth::user();
        $event = Event::all();

        return view('fotografer.upload', [
            "title" => "Upload Foto",
            "user" => $user,
            "event" => $event,
        ]);
    }

    public function upload_foto(Request $request)
    {
        // Validasi file yang diupload
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240'
        ]);

        if ($request->file('file')) {
            $file = $request->file('file');
            $tempPath = $file->store('uploads/temp', 'public'); // Simpan file ke lokasi sementara

            return response()->json(['tempPath' => $tempPath, 'filename' => basename($tempPath)]);
        }

        return response()->json(['error' => 'File upload failed'], 422);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'harga' => 'required|numeric',
            'event_id' => 'required|exists:events,id',
            'deskripsi' => 'nullable|string',
            'file_paths' => 'required|array',
            'file_paths.*' => 'string'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if (empty($request->input('file_paths'))) {
            return response()->json(['error' => 'No files were uploaded. Please upload files before saving.'], 422);
        }

        // Pindahkan file dari lokasi sementara ke lokasi permanen dan simpan ke database
        foreach ($request->input('file_paths') as $tempPath) {
            $filename = basename($tempPath);
            $newPath = 'uploads/photos/' . $filename;

            // Pindahkan file
            if (Storage::disk('public')->exists($tempPath)) {
                Storage::disk('public')->move($tempPath, $newPath);

                // Simpan informasi ke database
                Foto::create([
                    'user_id' => auth()->id(), // Pastikan user terautentikasi
                    'event_id' => $request->input('event_id'),
                    'foto' => $newPath,
                    'harga' => $request->input('harga'),
                    'deskripsi' => $request->input('deskripsi'),
                ]);
            }
        }

        $this->clearTempFolder();
        return response()->json(['success' => 'Photos uploaded successfully.']);
    }

    private function clearTempFolder()
    {
        $tempDirectory = 'uploads/temp';
        
        $files = Storage::disk('public')->files($tempDirectory);

        foreach ($files as $file) {
            Storage::disk('public')->delete($file);
        }
    }
}
