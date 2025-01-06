<?php

namespace App\Http\Controllers\Foto;

use App\Models\Foto;
use App\Models\User;
use App\Models\Event;
use App\Models\Fotografer;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Jobs\ProcessWatermarkJob;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Intervention\Image\Facades\Image;
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

    public function update_user(Request $request)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nowa' => 'required|numeric',
        ]);

        // Get the currently authenticated user
        $user = Auth::user();

        // Update the user's data
        $user->name = $validated['name'];
        $user->nowa = $validated['nowa'];

        // Save the updated user
        $user->save();

        // Redirect with a success message
        return redirect()->back()->with('success', 'Data updated successfully');
    }

    public function event_tambah(Request $request)
    {
        // dd($request);
        // Validasi input
        $rules = [
            'event' => 'required|string|max:255',
            'tanggal' => 'required|date_format:Y-m-d',
            'flexRadioDefault' => 'required|in:false,true',
            'lokasi' => 'required|string',
            'deskripsi' => 'required|string',
            'foto_cover' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Validasi untuk foto_cover
        ];

        // Jika radio button adalah "private", tambahkan validasi untuk password
        if ($request->input('flexRadioDefault') === 'true') {
            $rules['password'] = 'required|string|min:6';
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

        // Upload dan crop foto_cover jika ada
        $fotoCoverPath = null;
        if ($request->hasFile('foto_cover')) {
            $fotoCover = $request->file('foto_cover');
            $image = Image::make($fotoCover->getPathname());
        
            $image->fit(355, 355);
        
            // Tentukan path penyimpanan
            $folderPath = storage_path('app/public/foto_covers'); // Path yang benar
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0755, true); // Buat folder jika belum ada
            }
        
            $fotoCoverPath = 'foto_covers/' . uniqid() . '.' . $fotoCover->getClientOriginalExtension();
            $image->save($folderPath . '/' . basename($fotoCoverPath), 80); // Simpan dengan kualitas 80
        }

        // Simpan data ke database
        Event::create([
            'event' => $request->input('event'),
            'tanggal' => $formattedDate,
            'is_private' => $request->input('flexRadioDefault') === 'true',
            'lokasi' => $request->input('lokasi'),
            'password' => $request->input('flexRadioDefault') === 'true' ? bcrypt($request->input('password')) : null,
            'deskripsi' => $request->input('deskripsi'),
            'foto_cover' => $fotoCoverPath, // Simpan path foto_cover
        ]);

        // Redirect atau tampilkan pesan sukses
        return redirect()->back()->with('success', 'Event created successfully!');
    }


    public function tree()
    {
        // Ambil data event
        $events = Event::all();
        $encryptedEvents = [];

        // Enkripsi ID untuk setiap event
        foreach ($events as $event) {

            $deskripsi = implode(' ', array_slice(explode(' ', $event->deskripsi), 0, 10));
            $formattedTanggal = Carbon::parse($event->tanggal)->format('d F Y');

            $encryptedEvents[] = [
                'event' => $event->event,
                'deskripsi' => $deskripsi,
                'tanggal' => $formattedTanggal,
                'lokasi' => $event->lokasi,
                'id' => Crypt::encryptString($event->id),
                'is_private' => $event->is_private,
            ];
        }
        return view('fotografer.tree', [
            "title" => "Tree",
            "events" => $encryptedEvents,
        ]);
    }
}
