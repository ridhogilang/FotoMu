<?php

namespace App\Http\Controllers\User;

use App\Models\Foto;
use App\Models\Event;
use App\Models\SimilarFoto;
use Illuminate\Http\Request;
use App\Jobs\CompareFacesJob;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Symfony\Component\Process\Process;
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
        // Ambil foto yang sudah pernah terdeteksi sebagai similar
        $similarPhotos = SimilarFoto::where('user_id', $user->id)->pluck('foto_id')->toArray();

        // Jika belum ada, proses perbandingan dengan Queue
        if (empty($similarPhotos)) {
            foreach (Foto::all() as $foto) {
                $fotoPath = storage_path('app/public/' . $foto->foto);

                // Masukkan job ke dalam queue
                CompareFacesJob::dispatch($user->id, $foto->id, $userPhotoPath, $fotoPath);
            }
        }

        // Ambil foto-foto yang mirip dari database
        $similarPhotos = Foto::whereIn('id', $similarPhotos)->get();

        return view('user.produk', [
            "title" => "Foto Anda",
            'event' => $event,
            "similarPhotos" => $similarPhotos,
        ]);
    }

    public function event($id)
    {
        $encryptId = Crypt::decryptString($id);
        $event = Event::withCount('foto')->find($encryptId);

        return view('user.event', [
            "title" => "Foto Anda",
            'event' => $event,
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
}
