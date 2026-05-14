<x-app-layout>

    <x-slot name="header">

        <div class="flex items-center justify-between">

            <div>

                <h2 class="font-black text-2xl text-slate-800 dark:text-white">
                    Detail Lokasi
                </h2>

                <p class="text-sm text-slate-400 mt-1">
                    Informasi lengkap lokasi inventory
                </p>

            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'create-user')"
                    class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-2xl font-bold text-sm transition">
                    + Ubah lokasi
                </button>
                <form action="{{ route('lokasi.destroy', $location->uuid) }}" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit" onclick="return confirm('Yakin mau dihapus?')" class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-2xl font-bold text-sm transition">Hapus Lokasi</button>
                </form>
                <a href="{{ route('lokasi.index') }}"
                    class="bg-slate-200 hover:bg-slate-300 text-slate-700 px-6 py-3 rounded-2xl text-sm text-center font-bold">
                    Kembali
                </a>
            </div>



        </div>

    </x-slot>

    <div class="py-10 bg-[#F8FAFC] dark:bg-slate-950 min-h-screen">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div
                class="bg-white dark:bg-slate-900 rounded-lg overflow-hidden border border-slate-100 dark:border-slate-800">

                <div class="p-10">

                    <div class="mb-10">

                        <h2 class="text-3xl font-black text-slate-800 dark:text-white">
                            {{ $location->location_name }}
                        </h2>

                        <p class="text-slate-400 mt-2">
                            {{ $location->desc }}
                        </p>

                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div class="bg-slate-50 dark:bg-slate-800 rounded-3xl p-6">

                            <p class="text-sm text-slate-400 mb-2">
                                Nama Lokasi
                            </p>

                            <h3 class="font-black text-slate-700 dark:text-white">
                                {{ $location->location_name }}
                            </h3>

                        </div>

                        <div class="bg-slate-50 dark:bg-slate-800 rounded-3xl p-6">

                            <p class="text-sm text-slate-400 mb-2">
                                Ukuran
                            </p>

                            <h3 class="font-black text-slate-700 dark:text-white">
                                {{ $location->size === 'small' ? 'Lokasi Kecil' : ($location->size === 'medium' ? 'Lokasi Sedang' : 'Lokasi Besar') }}
                            </h3>

                        </div>

                        <div class="bg-slate-50 dark:bg-slate-800 rounded-3xl p-6">

                            <p class="text-sm text-slate-400 mb-2">
                                Status
                            </p>

                            <h3 class="font-black text-white">
                                @switch($location->status)
                                    @case('available')
                                        <span class="bg-green-600 rounded-md px-2 py-1 text-xs">Lokasi Tersedia</span>
                                    @break

                                    @case('close')
                                        <span class="bg-red-600 rounded-md px-2 py-1 text-xs">Lokasi Ditutup</span>
                                    @break

                                    @case('full')
                                        <span class="bg-gray-600 rounded-md px-2 py-1 text-xs">Lokasi Penuh</span>
                                    @break

                                    @default
                                        <span class="bg-yellow-600 rounded-md px-2 py-1 text-xs">Lokasi Maintenance</span>
                                @endswitch
                            </h3>

                        </div>

                        <div class="bg-slate-50 dark:bg-slate-800 rounded-3xl p-6">

                            <p class="text-sm text-slate-400 mb-2">
                                Total Barang
                            </p>

                            <h3 class="font-black text-slate-700 dark:text-white">
                                120 Barang
                            </h3>

                        </div>

                    </div>

                    <div class="mt-8">

                        <img src="{{ asset('storage/images/locations/' . $location->layout_image) }}"
                            class="rounded-3xl w-full object-cover" alt="Layout">

                    </div>

                </div>

            </div>

        </div>

    </div>

    <x-modal name="create-user" :show="false" focusable>

        <div class="p-8 dark:bg-slate-900">

            <h2 class="text-2xl font-black mb-6 dark:text-white">
                Ubah Lokasi
            </h2>

            <form action="{{ route('lokasi.update', $location->uuid) }}" enctype="multipart/form-data" method="post" class="space-y-5">
                @csrf
                @method('put')
                <div>
                    <x-input-label id="namaLokasi" value="Nama Lokasi" />

                    <x-text-input id="namaLokasi" class="block mt-1 w-full" type="text" name="namaLokasi"
                        :value="old('namaLokasi', $location->location_name)" required autofocus autocomplete="namaLokasi" />
                    <x-input-error :messages="$errors->get('namaLokasi')" class="mt-2" />
                </div>

                <div>
                    <x-input-label id="penanggungJawab" value="Penanggung Jawab Ruangan" />

                    <select name="penanggungJawab" id="penanggungJawab"
                        class="capitalize block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                        <option value="" disabled>Pilih Petugas</option>
                        @forelse ($users as $user)
                            <option class="" value="{{ $user->id }}"
                                {{ old('penanggungJawab', $location->user_id) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                        @empty
                            <option value="" disabled>Data petugas tidak ada</option>
                        @endforelse

                    </select>

                    <x-input-error :messages="$errors->get('penanggungJawab')" class="mt-2" />
                </div>

                <div class="">
                    <x-input-label value="Size" />

                    <div class="flex gap-6 mt-3">
                        @foreach (['small', 'medium', 'large'] as $size)
                            <label class="flex items-center gap-2">
                                <input type="radio" name="size" value="{{ $size }}"
                                    {{ old('size', $location->size) == $size ? 'checked' : '' }}
                                    class="border-slate-300 text-indigo-600 focus:ring-indigo-500">

                                <span class="capitalize text-slate-600">
                                    {{ $size }}
                                </span>
                            </label>
                        @endforeach
                    </div>

                    <x-input-error :messages="$errors->get('size')" class="mt-2" />
                </div>

                <div class="">
                    <x-input-label value="Status" />

                    <div class="flex flex-wrap gap-6 mt-3">
                        @foreach (['available', 'close', 'full', 'maintenance'] as $status)
                            <label class="flex items-center gap-2">
                                <input type="radio" name="status" value="{{ $status }}"
                                    {{ old('status', $location->status) == $status ? 'checked' : '' }}
                                    class="border-slate-300 text-indigo-600 focus:ring-indigo-500">

                                <span class="capitalize text-slate-600">
                                    {{ $status }}
                                </span>
                            </label>
                        @endforeach
                    </div>

                    <x-input-error :messages="$errors->get('status')" class="mt-2" />

                </div>

                <div>
                    <x-input-label id="imageLayout" value="Desain Lokasi" />

                    <x-text-input id="imageLayout" class="block mt-1 w-full p-6 border" type="file"
                        name="imageLayout" :value="old('imageLayout')" autofocus autocomplete="imageLayout" />
                    <x-input-error :messages="$errors->get('imageLayout')" class="mt-2" />
                </div>

                <div>
                    <x-input-label id="desc" value="Deskripsi Lokasi" />

                    <textarea name="desc"
                        class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        id="desc">{{ old('desc', $location->desc) }}</textarea>

                    <x-input-error :messages="$errors->get('desc')" class="mt-2" />
                </div>


                <div class="flex justify-end gap-3 pt-5">

                    <button type="button" x-on:click="$dispatch('close')"
                        class="px-6 py-3 rounded-2xl text-slate-500 hover:bg-slate-100">

                        Batal

                    </button>

                    <button type="submit"
                        class="bg-emerald-600 hover:bg-emerald-700 text-white px-8 py-3 rounded-2xl font-bold">

                        Simpan

                    </button>

                </div>

            </form>

        </div>

    </x-modal>



</x-app-layout>
