<?php

namespace App\Http\Controllers\User;

use App\Models\Cart;
use App\Models\Foto;
use App\Models\Event;
use App\Models\Wishlist;
use App\Models\SimilarFoto;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Jobs\CompareFacesJob;
use Illuminate\Support\Carbon;
use App\Jobs\CompareEventFacesJob;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Intervention\Image\Facades\Image;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Storage;
use App\Services\FaceRecognitionService;
use Symfony\Component\Process\Exception\ProcessFailedException;




class ProdukController extends Controller
{
    protected $faceRecognitionService;

    public function __construct(FaceRecognitionService $faceRecognitionService)
    {
        $this->faceRecognitionService = $faceRecognitionService;
    }

    public function produk()
    {
        $user = Auth::user();

        if (is_null($user->foto_depan)) {
            return redirect()->route('user.formfotodepan');
        }

        $event = Event::withCount('foto')->paginate(8, ['*'], 'event_page');
        $eventAll = Event::all();
        $user = Auth::user();
        $userPhotoPath = storage_path('app/public/' . $user->foto_depan);
        $similarPhotosIds = SimilarFoto::where('user_id', $user->id)->pluck('foto_id')->toArray();

        $comparedPhotoIds = DB::table('user_foto_comparisons')
            ->where('user_id', $user->id)
            ->where('is_compared', true)
            ->pluck('foto_id')->toArray();

        // Ambil foto yang belum diproses oleh user ini
        $newPhotos = Foto::whereNotIn('id', $comparedPhotoIds)->get();

        if ($newPhotos->isNotEmpty()) {
            foreach ($newPhotos as $foto) {
                // $fotoPath = storage_path('app/public/' . $foto->foto);
                $fotoPath = storage_path('app/public/' . $foto->fotowatermark);

                // Dispatch job untuk foto yang belum diproses
                CompareFacesJob::dispatch($user->id, $foto->id, $userPhotoPath, $fotoPath);

                // Simpan status bahwa foto ini telah diproses untuk user ini
                DB::table('user_foto_comparisons')->insert([
                    'user_id' => $user->id,
                    'foto_id' => $foto->id,
                    'is_compared' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // Get the similar photos with pagination (8 items per page)
        $similarPhotos = Foto::whereIn('id', $similarPhotosIds)
            ->whereHas('similarFoto', function ($query) {
                $query->where('is_hapus', false);
            })
            ->whereHas('event', function ($query) {
                $query->where('is_private', false); // Hanya event yang tidak private
            })
            ->paginate(8, ['*'], 'similar_page');


        $cartItemIds = Cart::where('user_id', Auth::id())->pluck('foto_id')->toArray();

        return view('user.produk', [
            "title" => "Foto Anda",
            'event' => $event,
            "eventAll" => $eventAll,
            "similarPhotos" => $similarPhotos,
            "cartItemIds" => $cartItemIds,
        ]);
    }

    public function search(Request $request)
    {
        $query = $request->get('query', '');

        // Search for events based on the query
        $events = Event::where('event', 'LIKE', "%{$query}%")
            ->distinct()
            ->get();

        // Encrypt the event ID before sending it to the frontend
        $events->each(function ($event) {
            $event->encrypted_id = Crypt::encryptString($event->id);
            $event->plain_id = $event->id; // Add the plain ID
        });

        // Return data in JSON format
        return response()->json($events);
    }

    public function event($id)
    {
        $user = Auth::user();

        // Dekripsi ID event
        $encryptId = Crypt::decryptString($id);
        $event = Event::withCount('foto')->find($encryptId);

        // Foto berdasarkan event_id
        $foto = Foto::where('event_id', $encryptId)->paginate(8, ['*'], 'semua_page');

        // Foto yang serupa yang sudah dibandingkan
        $similarPhotosId = SimilarFoto::where('user_id', $user->id)->pluck('foto_id');

        $similarPhotos = Foto::whereIn('id', $similarPhotosId)
            ->where('event_id', $encryptId)
            ->whereHas('similarFoto', function ($query) {
                $query->where('is_hapus', false);
            })
            ->paginate(8, ['*'], 'similar_page');

        // Foto yang ada di wishlist
        $wishlist = Wishlist::where('user_id',  $user->id)->pluck('foto_id')->toArray();

        // Foto yang ada di keranjang
        $cartItemIds = Cart::where('user_id', Auth::id())->pluck('foto_id')->toArray();

        // Ambil foto yang sudah dibandingkan sebelumnya oleh user
        $comparedPhotoIds = DB::table('user_foto_comparisons')
            ->where('user_id', $user->id)
            ->where('is_compared', true)
            ->pluck('foto_id')
            ->toArray();

        // Ambil foto-foto dari event yang belum dibandingkan
        $newPhotos = Foto::where('event_id', $encryptId)
            ->whereNotIn('id', $comparedPhotoIds)
            ->get();

        if ($newPhotos->isNotEmpty()) {
            foreach ($newPhotos as $foto) {
                // $fotoPath = storage_path('app/public/' . $foto->foto);
                $fotoPath = storage_path('app/public/' . $foto->fotowatermark);
                $userPhotoPath = storage_path('app/public/' . $user->foto_depan);

                // Dispatch job for each photo comparison
                CompareEventFacesJob::dispatch($user->id, $foto->id, $userPhotoPath, $fotoPath);

                // Tandai foto ini telah diproses
                DB::table('user_foto_comparisons')->insert([
                    'user_id' => $user->id,
                    'foto_id' => $foto->id,
                    'is_compared' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        return view('user.event', [
            "title" => "Foto Anda",
            'event' => $event,
            "similarPhotos" => $similarPhotos,
            "semuaFoto" => $foto,
            "wishlist" => $wishlist,
            "cartItemIds" => $cartItemIds,
        ]);
    }



    public function checkPassword(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        // Check if password is correct
        if (Hash::check($request->input('password'), $event->password)) {
            return redirect()->route('user.event', ['id' => Crypt::encryptString($event->id)]);
        } else {
            return back()->with('toast_error', 'Password event anda salah, silahkan hubungi panitia fotografer anda!');
        }
    }

    public function HapusSimilar(Request $request)
    {
        $request->validate([
            'foto_id' => 'required',
        ]);

        $similarFoto = SimilarFoto::where('user_id', Auth::id())->where('foto_id', $request->foto_id)->first();

        if ($similarFoto) {
            $similarFoto->is_hapus = true;
            $similarFoto->save();

            return response()->json(['success' => 'Foto berhasil dihapus dari FotoMu.']);
        } else {
            return response()->json(['error' => 'Foto tidak ditemukan.'], 404);
        }
    }

    public function PulihkanSimilar(Request $request)
    {
        $request->validate([
            'foto_id' => 'required',
        ]);

        $similarFoto = SimilarFoto::where('user_id', Auth::id())->where('foto_id', $request->foto_id)->first();

        if ($similarFoto) {
            $similarFoto->is_hapus = false;  // Set is_hapus to false
            $similarFoto->save();

            return response()->json(['success' => 'Foto berhasil dipulihkan.']);
        } else {
            return response()->json(['error' => 'Foto tidak ditemukan.'], 404);
        }
    }


    public function tree()
    {
        $events = Event::all();
        $encryptedEvents = [];

        foreach ($events as $event) {
            $coords = explode(',', $event->lokasi);
            $latitude = isset($coords[0]) ? floatval($coords[0]) : null;
            $longitude = isset($coords[1]) ? floatval($coords[1]) : null;

            $deskripsi = implode(' ', array_slice(explode(' ', $event->deskripsi), 0, 10));
            $formattedTanggal = Carbon::parse($event->tanggal)->format('d F Y');

            $encryptedEvents[] = [
                'event' => $event->event,
                'deskripsi' => $deskripsi,
                'tanggal' => $formattedTanggal,
                'lokasi' => $event->lokasi,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'id' => Crypt::encryptString($event->id),
                'is_private' => $event->is_private,
            ];
        }

        return view('user.tree', [
            "title" => "Tree",
            "events" => $encryptedEvents,
        ]);
    }


    public function getEvents()
    {
        // Mengambil semua event dari database
        $events = Event::all();

        // Mengirimkan data event dalam format JSON
        return response()->json($events);
    }

    public function konten_terhapus()
    {
        $user = Auth::user();

        $similarPhotosIds = SimilarFoto::where('user_id', $user->id)->pluck('foto_id')->toArray();

        $similarPhotos = Foto::whereIn('id', $similarPhotosIds)
            ->whereHas('similarFoto', function ($query) {
                $query->where('is_hapus', true);
            })
            ->paginate(8, ['*'], 'similar_page');

        return view('user.deletefoto', [
            "title" => "Konten Terhapus",
            "foto" => $similarPhotos,
        ]);
    }
}
