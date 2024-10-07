<?php

namespace App\Http\Controllers\Admin;

use App\Models\Foto;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Models\DetailPesanan;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class FotomuAdminController extends Controller
{
    public function fotomu_kontrol(Request $request)
    {
        // Ambil input dari search bar
        $search = $request->input('search');

        // Query semua event tanpa filter fotografer_id
        $events = Event::when($search, function ($query, $search) {
            // Tambahkan kondisi pencarian berdasarkan nama event
            $query->where('event', 'LIKE', '%' . $search . '%');
        })
            ->with('foto') // Include semua foto terkait
            ->get();

        // Hitung total penyimpanan per event
        $eventsWithStorage = $events->map(function ($event) {
            // Totalkan file_size dari semua foto di event ini
            $totalStorage = $event->foto->sum('file_size');

            // Konversi ke format yang sesuai (MB atau GB)
            $event->total_storage_formatted = $this->formatSizeUnits($totalStorage);

            return $event;
        });

        // Hitung total penyimpanan semua fotografer
        $totalStorage = Foto::sum('file_size');
        $maxStorage = 50 * 1024 * 1024 * 1024; // 50 GB in bytes
        $percentageUsed = ($totalStorage / $maxStorage) * 100;
        $totalStorageFormatted = $this->formatSizeUnits($totalStorage);
        $maxStorageFormatted = $this->formatSizeUnits($maxStorage);

        return view('admin.fotokontrol', [
            "title" => "Foto Kontrol",
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
        $encryptId = Crypt::decryptString($id);
    
        // Fetch event name
        $event = Event::where('id', $encryptId)->pluck('event')->first();
    
        // Fetch photos related to the event without filtering by fotografer_id
        $foto = Foto::where('event_id', $encryptId)->paginate(15);
    
        // Fetch all events for dropdown or other use in the view
        $eventAll = Event::all();
    
        // Calculate total storage for all photos (no filter by fotografer_id)
        $totalStorage = Foto::sum('file_size');
        $maxStorage = 50 * 1024 * 1024 * 1024; // 50 GB in bytes
        $percentageUsed = ($totalStorage / $maxStorage) * 100;
        $totalStorageFormatted = $this->formatSizeUnits($totalStorage);
        $maxStorageFormatted = $this->formatSizeUnits($maxStorage);
    
        // Return the view with all data
        return view('admin.fotoevent', [
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
    
    public function AdmindeleteSelectedPhotos(Request $request)
    {
        $request->validate([
            'foto_id' => 'required',
        ]);

        // Dapatkan semua foto yang dipilih berdasarkan ID
        $fotoIds = $request->input('foto_id');

        // Dapatkan foto berdasarkan ID
        $fotos = Foto::whereIn('id', $fotoIds)->get();

        foreach ($fotos as $foto) {
            Log::info('Memproses foto dengan ID:', ['foto_id' => $foto->id, 'foto' => $foto->foto, 'fotowatermark' => $foto->fotowatermark]);
        
            // Cek apakah foto_id ada di DetailPesanan
            $isInPesanan = DetailPesanan::where('foto_id', $foto->id)->exists();
        
            if ($isInPesanan) {
                // Jika ada di DetailPesanan, update kolom is_hapus menjadi true
                $foto->update(['is_hapus' => true]);
            } else {
                // Jika tidak ada di DetailPesanan, hapus foto fisik dan database record
                if ($foto->foto && Storage::disk('public')->exists($foto->foto)) {
                    Storage::disk('public')->delete($foto->foto);
                }
        
                if ($foto->fotowatermark && Storage::disk('public')->exists($foto->fotowatermark)) {
                    Storage::disk('public')->delete($foto->fotowatermark);
                }
                // Hapus dari database
                $foto->delete();
            }
        }

        return response()->json(['message' => 'Foto Sudah berhasil dihapus'], 200);
    }

    public function event()
    {
        $eventAll = Event::all();

        return view('admin.event', [
            "title" => "Kontrol Event",
            "eventAll" => $eventAll
        ]);
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
