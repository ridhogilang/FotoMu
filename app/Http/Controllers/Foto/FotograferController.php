<?php

namespace App\Http\Controllers\Foto;

use App\Models\Foto;
use App\Models\User;
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
        $getUser = User::where('id', Auth::user()->id)->first();


        $foto = Foto::whereHas('fotografer', function ($query) use ($user) {
            $query->where('user_id', $user);
        })
            ->orderBy('created_at', 'desc') 
            ->get();


        return view('fotografer.profil', [
            "title" => "Profil",
            "user" => $user,
            "foto" => $foto,
            "getUser" => $getUser,
        ]);
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
