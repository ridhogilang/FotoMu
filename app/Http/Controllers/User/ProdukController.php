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
        $event = Event::withCount('foto')->paginate(8);
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
                $fotoPath = storage_path('app/public/' . $foto->foto);

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
                $query->where('hapus', false);
            })
            ->paginate(8);

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

        $encryptId = Crypt::decryptString($id);
        $event = Event::withCount('foto')->find($encryptId);

        $foto = Foto::where('event_id', $encryptId)->paginate(8);

        $similarPhotosId = SimilarFoto::where('user_id', $user->id)->pluck('foto_id');

        $similarPhotos = Foto::whereIn('id', $similarPhotosId)
            ->where('event_id', $encryptId)
            ->whereHas('similarFoto', function ($query) {
                $query->where('hapus', false);
            })
            ->paginate(8);

        $wishlist = Wishlist::where('user_id',  $user->id)->pluck('foto_id')->toArray();

        $cartItemIds = Cart::where('user_id', Auth::id())->pluck('foto_id')->toArray();

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
            // Return back with an error if password is incorrect
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
            $similarFoto->hapus = true;
            $similarFoto->save();

            return response()->json(['success' => 'Foto berhasil dihapus dari similar_foto.']);
        } else {
            return response()->json(['error' => 'Foto tidak ditemukan.'], 404);
        }
    }

    public function tree()
    {
        return view('user.tree', [
            "title" => "Tree",
        ]);
    }

    public function getEvents()
    {
        // Mengambil semua event dari database
        $events = Event::all();

        // Mengirimkan data event dalam format JSON
        return response()->json($events);
    }
}
