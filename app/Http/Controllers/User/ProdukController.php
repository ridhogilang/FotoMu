<?php

namespace App\Http\Controllers\User;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;


class ProdukController extends Controller
{
    public function produk()
    {
        $event = Event::withCount('foto')->get();

        return view('user.produk', [
            "title" => "Foto Anda",
            'event' => $event,
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
