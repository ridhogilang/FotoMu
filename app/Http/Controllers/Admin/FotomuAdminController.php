<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Foto;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Models\DetailPesanan;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Intervention\Image\Facades\Image;
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

    public function event()
    {
        $eventAll = Event::all();

        return view('admin.event', [
            "title" => "Kontrol Event",
            "eventAll" => $eventAll
        ]);
    }

    public function event_update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        // Validasi input dengan kondisi khusus
        $rules = [
            'event' => 'required|string|max:255',
            'tanggal' => 'required|date_format:Y-m-d',
            'is_private' => 'required|boolean',
            'deskripsi' => 'nullable|string',
            'lokasi' => 'required|string',
            'foto_cover' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Tidak lagi required secara default
        ];

        // Tambahkan aturan validasi untuk password hanya jika event bersifat private
        if ($request->input('is_private') == 1) {
            $rules['password'] = 'required|string|min:6';
        }

        // Periksa apakah event tidak memiliki foto_cover sebelumnya dan file baru tidak diupload
        if (!$event->foto_cover && !$request->hasFile('foto_cover')) {
            $rules['foto_cover'] = 'required|image|mimes:jpeg,png,jpg|max:2048'; // Required jika tidak ada foto sebelumnya
        }

        // Validasi data input
        $validatedData = $request->validate($rules);

        // Set data event dengan input yang telah divalidasi
        $event->event = $validatedData['event'];
        $event->tanggal = Carbon::parse($validatedData['tanggal']);
        $event->is_private = $validatedData['is_private'];
        $event->deskripsi = $validatedData['deskripsi'] ?? null; // Deskripsi opsional
        $event->lokasi = $validatedData['lokasi'];

        if ($request->hasFile('foto_cover')) {
            // Hapus foto lama jika ada
            if ($event->foto_cover) {
                Storage::delete('public/' . $event->foto_cover);
            }

            // Ambil file foto baru dan buat instance gambar
            $fotoCover = $request->file('foto_cover');
            $image = Image::make($fotoCover->getPathname());

            // Crop gambar menjadi 355x355
            $image->fit(355, 355);

            // Tentukan path folder penyimpanan
            $folderPath = storage_path('app/public/foto_covers'); // Path yang benar
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0755, true); // Buat folder jika belum ada
            }

            // Buat path baru untuk foto cover yang sudah diproses
            $fotoCoverPath = 'foto_covers/' . uniqid() . '.' . $fotoCover->getClientOriginalExtension();

            // Simpan gambar yang sudah di-crop ke folder penyimpanan
            $image->save($folderPath . '/' . basename($fotoCoverPath), 80); // Simpan dengan kualitas 80

            // Simpan path foto cover ke event
            $event->foto_cover = $fotoCoverPath;
        }


        // Simpan password hanya jika event bersifat private
        if ($validatedData['is_private'] == 1) {
            $event->password = bcrypt($validatedData['password']);
        } else {
            $event->password = null; // Jika event public, password dihapus
        }

        // Simpan perubahan pada event ke dalam database
        $event->save();

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Event berhasil diperbarui!');
    }


    public function event_delete(Request $request, $id)
    {
        // Temukan event berdasarkan ID
        $event = Event::findOrFail($id);

        // Ambil foto-foto terkait dengan event
        $fotos = Foto::where('event_id', $event->id)->get();

        // Proses setiap foto
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

                // Hapus foto dari database
                $foto->delete();
            }
        }

        // Jika ada foto cover pada event, hapus file foto cover terkait
        if ($event->foto_cover && Storage::exists('public/' . $event->foto_cover)) {
            Storage::delete('public/' . $event->foto_cover);
        }

        // Hapus event dari database
        $event->delete();

        // Redirect kembali ke halaman event dengan pesan sukses
        return redirect()->back()->with('success', 'Event dan foto terkait berhasil dihapus.');
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
