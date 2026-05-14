<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\{Item, Location};

class ItemController extends Controller
{
    public function index()
    {
        $locations = Location::all();
        $items = Item::all();

        return view('items.index', compact('locations', 'items'));
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
            $gambar->storeAs($path, $nama);
        }

        Location::create($simpan);

        return redirect()->route('lokasi.index')->with('success', 'Lokasi berhasil ditambahkan');

    }

    public function show($param)
    {
        $location = Location::where('uuid', $param)->firstOrFail();
        $users = User::where('isAdmin', false)->get();

        return view('locations.show', compact('location', 'users'));
    }

    public function update(Request $request, $param)
    {
        $data = Location::where('uuid', $param)->firstOrFail();
        $request->validate([
            'namaLokasi' => ['required', 'string', 'min:5', 'max:50'],
            'penanggungJawab' => ['required', 'exists:users,id'],
            'size' => ['required', 'in:small,medium,large'],
            'status' => ['required', 'in:available,close,full,maintenance'],
            'imageLayout' => ['mimes:png,jpg,jpeg,svg,webp', 'max:2048'],
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

            $path_lama = 'public/images/locations/'.$data->layout_image;

            if ($data->layout_image && Storage::exists($path_lama)) {
                Storage::delete($path_lama);
            }

            $gambar = $request->file('imageLayout');
            $path = 'public/images/locations';
            // nama file wajib unique : item_image_20260513103945456.png
            $nama = 'image_layout_location_'.Carbon::now('Asia/Jakarta')->format('Ymdhis').random_int(000, 999).'.'.$gambar->getClientOriginalExtension();
            $simpan['layout_image'] = $nama;

            // simpan ke storage
            $gambar->storeAs($path, $nama);
        }

        $data->update($simpan);

        return redirect()->route('lokasi.show', $data->uuid)->with('success', 'Lokasi berhasil diubah');
    }

    public function destroy($param)
    {
        $data = Location::where('uuid', $param)->firstOrFail();

        $path_lama = 'public/images/locations/'.$data->layout_image;

        if ($data->layout_image && Storage::exists($path_lama)) {
            Storage::delete($path_lama);
        }

        $data->delete();

        return redirect()->route('lokasi.index')->with('success', 'Lokasi berhasil dihapus');
    }
}
