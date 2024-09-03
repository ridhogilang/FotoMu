<?php

namespace App\Http\Controllers\Foto;

use App\Models\Foto;
use App\Models\Event;
use App\Models\Fotografer;
use Illuminate\Http\Request;
use App\Jobs\ProcessWatermarkJob;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class FotograferController extends Controller
{
    public function profil()
    {
        $user = Auth::id();

        $foto = Foto::whereHas('fotografer', function ($query) use ($user) {
            $query->where('user_id', $user);
        })->get();

        return view('fotografer.profil', [
            "title" => "Profil",
            "user" => $user,
            "foto" => $foto,
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
            'harga' => 'required|numeric|min:0',
            'event_id' => 'required|exists:events,id',
            'deskripsi' => 'nullable|string',
            'file_paths' => 'required|array',
            'file_paths.*' => 'string',
            'file_sizes' => 'required|array',
            'file_sizes.*' => 'integer'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if (empty($request->input('file_paths'))) {
            return response()->json(['error' => 'No files were uploaded. Please upload files before saving.'], 422);
        }

        $fotografer = Fotografer::where('user_id', auth()->id())->first();

        if (!$fotografer) {
            return response()->json(['error' => 'No photographer associated with this user.'], 422);
        }

        // Debug: Cek data yang diterima
        Log::info('Received file paths:', $request->input('file_paths'));
        Log::info('Received file sizes:', $request->input('file_sizes'));

        foreach ($request->input('file_paths') as $index => $tempPath) {
            $filename = basename($tempPath);
            $newPath = 'uploads/photos/' . $filename;
            $newPathWatermark = 'uploads/photoswatermark/' . $filename;

            if (Storage::disk('public')->exists($tempPath)) {
                $fileSize = $request->input('file_sizes')[$index];
                $resolusi = $this->determineResolution($fileSize);
                Storage::disk('public')->move($tempPath, $newPath);

                $foto = Foto::create([
                    'fotografer_id' => $fotografer->id,
                    'event_id' => $request->input('event_id'),
                    'foto' => $newPath,
                    'fotowatermark' => null,
                    'harga' => $request->input('harga'),
                    'deskripsi' => $request->input('deskripsi'),
                    'file_size' => $fileSize,
                    'resolusi' => $resolusi,
                ]);

                ProcessWatermarkJob::dispatch($newPath, $newPathWatermark, $foto->id);
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

    private function determineResolution($fileSize)
    {
        // Ukuran file dalam MB
        $fileSizeMB = $fileSize / (1024 * 1024);

        if ($fileSizeMB >= 1 && $fileSizeMB <= 3) {
            return 'low';
        } elseif ($fileSizeMB >= 4 && $fileSizeMB <= 6) {
            return 'medium';
        } elseif ($fileSizeMB >= 7 && $fileSizeMB <= 10) {
            return 'high';
        } else {
            return 'low'; // Menggunakan 'low' sebagai fallback daripada 'unknown'
        }
    }

    public function event_tambah(Request $request)
    {
        // Validasi input
        $rules = [
            'event' => 'required|string|max:255',
            'tanggal' => 'required|date_format:Y-m-d',
            'flexRadioDefault' => 'required|in:false,true',
            'lokasi' => 'required|string',
            'deskripsi' => 'required|string',
        ];

        // Jika radio button adalah "private", tambahkan validasi untuk password
        if ($request->input('flexRadioDefault') === 'true') {
            $rules['password'] = 'required|string|min:6'; // Menambahkan validasi untuk password
        }

        $request->validate($rules);

        // Format tanggal
        $tanggal = $request->input('tanggal');
        $formattedDate = $tanggal . ' 00:00:00'; // Tambahkan waktu default jika hanya tanggal yang diberikan

        // Cek apakah ada event dengan nama dan tanggal yang sama
        $existingEvent = Event::where('event', $request->input('event'))
            ->where('tanggal', $formattedDate)
            ->first();

        if ($existingEvent) {
            return redirect()->back()->with('toast_error', 'Event sudah ada, tidak bisa ditambahkan kembali!');
        }

        // Simpan data ke database
        Event::create([
            'event' => $request->input('event'),
            'tanggal' => $formattedDate,
            'is_private' => $request->input('flexRadioDefault') === 'true',
            'lokasi' => $request->input('lokasi'),
            'password' => $request->input('flexRadioDefault') === 'true' ? bcrypt($request->input('password')) : null,
            'deskripsi' => $request->input('deskripsi'),
        ]);

        // Redirect atau tampilkan pesan sukses
        return redirect()->back()->with('success', 'Event created successfully!');
    }
}
