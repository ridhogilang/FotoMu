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
        $event = Event::withCount('foto')->get();
        $user = Auth::user();
        $userPhotoPath = storage_path('app/public/' . $user->foto_depan);
        $similarPhotos = SimilarFoto::where('user_id', $user->id)->pluck('foto_id')->toArray();

        if (empty($similarPhotos)) {
            foreach (Foto::all() as $foto) {
                $fotoPath = storage_path('app/public/' . $foto->foto);

                CompareFacesJob::dispatch($user->id, $foto->id, $userPhotoPath, $fotoPath);
            }
        }

        $similarPhotos = Foto::whereIn('id', $similarPhotos)->get();

        $cartItemIds = Cart::where('user_id', Auth::id())->pluck('foto_id')->toArray();


        return view('user.produk', [
            "title" => "Foto Anda",
            'event' => $event,
            "similarPhotos" => $similarPhotos,
            "cartItemIds" => $cartItemIds,
        ]);
    }

    public function event($id)
    {
        $user = Auth::user();

        $encryptId = Crypt::decryptString($id);
        $event = Event::withCount('foto')->find($encryptId);

        $foto = Foto::Where('event_id', $encryptId)->get();

        $similarPhotosId = SimilarFoto::where('user_id', $user->id)->pluck('foto_id');

        $similarPhotos = Foto::whereIn('id', $similarPhotosId)
            ->where('event_id', $encryptId)
            ->whereHas('similarFoto', function ($query) {
                $query->where('hapus', false);
            })
            ->get();


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
            // Redirect to the event page with encrypted ID
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
}
