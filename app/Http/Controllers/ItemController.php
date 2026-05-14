<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

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
            'namaBarang' => ['required', 'string', 'min:5', 'max:50'],
            'penyimpanan' => ['required', 'exists:locations,id'],
            'status' => ['required', 'in:good,broke,maintenance'],
            'gambarBarang' => ['required', 'mimes:png,jpg,jpeg,svg,webp', 'max:2048'],
            'desc' => ['required'],
            'tanggalPembelian' => ['required', 'date', 'before_or_equal:today']
        ]);

        $simpan = [
            'uuid' => Str::uuid(),
            'location_id' => $request->input('penyimpanan'),
            'item_name' => $request->input('namaBarang'),
            'date_purchase' => $request->input('tanggalPembelian'),
            'status' => $request->input('status'),
            'desc' => $request->input('desc'),
        ];

        if ($request->hasFile('gambarBarang')) {
            $gambar = $request->file('gambarBarang');
            $path = 'public/images/items';
            // nama file wajib unique : item_image_20260513103945456.png
            $nama = 'image_items_'.Carbon::now('Asia/Jakarta')->format('Ymdhis').random_int(000, 999).'.'.$gambar->getClientOriginalExtension();
            $simpan['image'] = $nama;

            // simpan ke storage
            $gambar->storeAs($path, $nama);
        }

        Item::create($simpan);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan');

    }

    public function show($param)
    {
        $item = Item::where('uuid', $param)->firstOrFail();
        $locations = Location::all();
        return view('items.show', compact('locations', 'item'));
    }

    public function update(Request $request, $param)
    {
        $data = Item::where('uuid', $param)->firstOrFail();

        $request->validate([
            'namaBarang' => ['required', 'string', 'min:5', 'max:50'],
            'penyimpanan' => ['required', 'exists:locations,id'],
            'status' => ['required', 'in:good,broke,maintenance'],
            'gambarBarang' => ['mimes:png,jpg,jpeg,svg,webp', 'max:2048'],
            'desc' => ['required'],
            'tanggalPembelian' => ['required', 'date', 'before_or_equal:today']
        ]);

        $simpan = [
            'uuid' => Str::uuid(),
            'location_id' => $request->input('penyimpanan'),
            'item_name' => $request->input('namaBarang'),
            'date_purchase' => $request->input('tanggalPembelian'),
            'status' => $request->input('status'),
            'desc' => $request->input('desc'),
        ];

        if ($request->hasFile('gambarBarang')) {

            $path_lama = 'public/images/items/'.$data->image;

            if ($data->image && Storage::exists($path_lama)) {
                Storage::delete($path_lama);
            }

            $gambar = $request->file('gambarBarang');
            $path = 'public/images/items';
            // nama file wajib unique : item_image_20260513103945456.png
            $nama = 'image_items_'.Carbon::now('Asia/Jakarta')->format('Ymdhis').random_int(000, 999).'.'.$gambar->getClientOriginalExtension();
            $simpan['image'] = $nama;

            // simpan ke storage
            $gambar->storeAs($path, $nama);
        }

        $data->update($simpan);

        return redirect()->route('barang.show', $data->uuid)->with('success', 'Barang berhasil diubah');
    }

    public function destroy($param)
    {
        $data = Item::where('uuid', $param)->firstOrFail();

        $path_lama = 'public/images/items/'.$data->image;

            if ($data->image && Storage::exists($path_lama)) {
                Storage::delete($path_lama);
            }

        $data->delete();

        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus');
    }
}
