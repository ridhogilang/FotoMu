<?php

namespace App\Http\Controllers\Foto;

use App\Models\Foto;
use App\Models\Event;
use App\Models\Fotografer;
use Illuminate\Http\Request;
use App\Models\DetailPesanan;
use App\Jobs\ProcessWatermarkJob;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class FotoFotograferController extends Controller
{
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
            return 'low';
        }
    }

    public function file_manager(Request $request)
    {
        $fotografer_id = Auth::user()->id;

        // Ambil input dari search bar
        $search = $request->input('search');

        // Query event berdasarkan pencarian
        $events = Event::whereHas('foto', function ($query) use ($fotografer_id) {
            $query->where('fotografer_id', $fotografer_id);
        })
            ->when($search, function ($query, $search) {
                // Tambahkan kondisi pencarian berdasarkan nama event
                $query->where('event', 'LIKE', '%' . $search . '%');
            })
            ->with(['foto' => function ($query) use ($fotografer_id) {
                // Ambil hanya foto dari fotografer yang sedang login
                $query->where('fotografer_id', $fotografer_id);
            }])
            ->get();

        // Hitung total penyimpanan per event
        $eventsWithStorage = $events->map(function ($event) {
            // Totalkan file_size dari semua foto di event ini
            $totalStorage = $event->foto->sum('file_size');

            // Konversi ke format yang sesuai (MB atau GB)
            $event->total_storage_formatted = $this->formatSizeUnits($totalStorage);

            return $event;
        });

        // Hitung total penyimpanan fotografer yang sedang login
        $totalStorage = Foto::where('fotografer_id', $fotografer_id)
            ->sum('file_size');
        $maxStorage = 50 * 1024 * 1024 * 1024; // 50 GB in bytes
        $percentageUsed = ($totalStorage / $maxStorage) * 100;
        $totalStorageFormatted = $this->formatSizeUnits($totalStorage);
        $maxStorageFormatted = $this->formatSizeUnits($maxStorage);

        return view('fotografer.filemanager', [
            "title" => "File Manager",
            "event" => $eventsWithStorage,
            "totalStorage" => $totalStorage,
            "totalStorageFormatted" => $totalStorageFormatted,
            "percentageUsed" => $percentageUsed,
            "maxStorageFormatted" => $maxStorageFormatted,
            "search" => $search // Berikan nilai search ke view agar bisa di tampilkan kembali
        ]);
    }

    public function foto($id)
    {
        $fotografer_id = Auth::user()->id;
        $encryptId = Crypt::decryptString($id);

        $event = Event::where('id', $encryptId)->pluck('event')->first();
        $foto = Foto::where('event_id', $encryptId)->paginate(15);

        $eventAll = Event::all();

        $totalStorage = Foto::where('fotografer_id', $fotografer_id)
            ->sum('file_size');
        $maxStorage = 50 * 1024 * 1024 * 1024; // 50 GB in bytes
        $percentageUsed = ($totalStorage / $maxStorage) * 100;
        $totalStorageFormatted = $this->formatSizeUnits($totalStorage);
        $maxStorageFormatted = $this->formatSizeUnits($maxStorage);

        return view('fotografer.foto', [
            "title" => "Foto - $event",
            "foto" => $foto,
            "event" => $event,
            "eventAll" => $eventAll,
            "totalStorage" => $totalStorage,
            "totalStorageFormatted" => $totalStorageFormatted,
            "percentageUsed" => $percentageUsed,
            "maxStorageFormatted" => $maxStorageFormatted,
        ]);
    }

    public function deleteSelectedPhotos(Request $request)
    {
        $request->validate([
            'foto_id' => 'required',
        ]);

        // Dapatkan semua foto yang dipilih berdasarkan ID
        $fotoIds = $request->input('foto_id');

        // Dapatkan foto berdasarkan ID
        $fotos = Foto::whereIn('id', $fotoIds)->get();

        foreach ($fotos as $foto) {
            // Cek apakah foto_id ada di DetailPesanan
            $isInPesanan = DetailPesanan::where('foto_id', $foto->id)->exists();

            if ($isInPesanan) {
                // Jika ada di DetailPesanan, update kolom is_hapus menjadi true
                $foto->update(['is_hapus' => true]);
            } else {
                // Jika tidak ada di DetailPesanan, hapus foto fisik dan database record
                if (Storage::disk('public')->exists($foto->foto)) {
                    Storage::disk('public')->delete($foto->foto);
                }

                if (Storage::disk('public')->exists($foto->fotowatermark)) {
                    Storage::disk('public')->delete($foto->fotowatermark);
                }
                // Hapus dari database
                $foto->delete();
            }
        }

        return response()->json(['message' => 'Foto Sudah berhasil dihapus'], 200);
    }

    public function getFoto($id)
    {
        // Cari foto berdasarkan ID
        $foto = Foto::find($id);

        // Jika foto tidak ditemukan, kembalikan respon 404
        if (!$foto) {
            return response()->json(['error' => 'Foto tidak ditemukan.'], 404);
        }

        // Kembalikan hanya ID
        return response()->json([
            'id' => $foto->id,
        ]);
    }

    public function updateSelectedPhotos(Request $request)
    {
        // Validasi input
        $request->validate([
            'foto_ids' => 'required', 
            'event_id' => 'required',
            'harga' => 'required',
            'deskripsi' => 'string',
        ]);

        // Ambil semua ID foto yang dipilih
        $fotoIds = $request->input('foto_ids');

        $harga = preg_replace('/[^\d]/', '', $request->input('harga')); 

        // Update data untuk semua foto yang dipilih
        Foto::whereIn('id', $fotoIds)->update([
            'event_id' => $request->input('event_id'),
            'harga' => $harga,
            'deskripsi' => $request->input('deskripsi'),
        ]);

        // Kembalikan respon sukses
        return response()->json(['message' => 'Foto berhasil diupdate.'], 200);
    }


    private function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824) { // Jika lebih besar atau sama dengan 1 GB
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) { // Jika lebih besar atau sama dengan 1 MB
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) { // Jika lebih besar atau sama dengan 1 KB
            return number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            return $bytes . ' bytes';
        } elseif ($bytes == 1) {
            return $bytes . ' byte';
        } else {
            return '0 bytes';
        }
    }
}
