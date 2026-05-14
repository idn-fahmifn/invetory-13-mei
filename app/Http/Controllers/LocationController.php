<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

use App\Models\{Location, User};

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::all();
        $users = User::where('isAdmin', false)->get();

        return view('locations.index', compact('locations', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'namaLokasi' => ['required', 'string', 'min:5', 'max:50'],
            'penanggungJawab' => ['required', 'exists:users,id'],
            'size' => ['required', 'in:small,medium,large'],
            'status' => ['required', 'in:available,close,full,maintenance'],
            'imageLayout' => ['required', 'mimes:png,jpg,jpeg,svg,webp', 'max:2048'],
            'desc' => ['required'],
        ]);

        $simpan = [
            'uuid' => Str::uuid(),
            'user_id' => $request->input('penanggungJawab'),
            'location_name' => $request->input('namaLokasi'),
            'size' => $request->input('size'),
            'status' => $request->input('status'),
            'desc' => $request->input('desc'),
        ];

        if ($request->hasFile('imageLayout')) {
            $gambar = $request->file('imageLayout');
            $path = 'public/images/locations';
            // nama file wajib unique : item_image_20260513103945456.png
            $nama = 'image_layout_location_'.Carbon::now('Asia/Jakarta')->format('Ymdhis').random_int(000, 999).'.'.$gambar->getClientOriginalExtension();
            $simpan['layout_image'] = $nama;

            // simpan ke storage
            // $gambar->storeAs($path, $nama);
        }

        return $simpan;

    }
}
