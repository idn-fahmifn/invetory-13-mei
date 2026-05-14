<x-app-layout>

    <x-slot name="header">

        <div class="flex items-center justify-between">

            <div>

                <h2 class="font-black text-2xl text-slate-800 dark:text-white">
                    Data Lokasi
                </h2>

                <p class="text-sm text-slate-400 mt-1">
                    Management lokasi
                </p>

            </div>

            <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'create-user')"
                class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-2xl font-bold text-sm transition">

                + Tambah lokasi

            </button>

        </div>

    </x-slot>

    <div class="py-10 bg-[#F8FAFC] dark:bg-slate-950 min-h-screen">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                {{-- ALERT --}}
                <div x-data="{ show: true }" x-show="show"
                    class="mb-6 flex items-center justify-between bg-emerald-100 border border-emerald-300 text-emerald-700 px-6 py-4 rounded-2xl">

                    <span class="font-semibold">
                        Data lokasi berhasil ditambahkan
                    </span>

                    <button @click="show = false">
                        ✕
                    </button>

                </div>
            @endif



            {{-- TABLE --}}
            <div
                class="bg-white dark:bg-slate-900 rounded-xl overflow-hidden border border-slate-100 dark:border-slate-800">

                <table class="w-full">

                    <thead class="bg-slate-50 dark:bg-slate-800/50">

                        <tr class="text-xs uppercase tracking-[0.2em] text-slate-400 dark:text-slate-200">

                            <th class="px-8 py-5 text-left">Lokasi</th>
                            <th class="px-8 py-5 text-left">Ukuran</th>
                            <th class="px-8 py-5 text-left">Status</th>
                            <th class="px-8 py-5 text-left">Detail</th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">

                        @forelse($locations as $location)
                            <tr>

                                <td class="px-8 py-6 dark:text-slate-200 font-bold">{{ $location->name }}</td>
                                <td class="px-8 py-6 dark:text-slate-200">{{ $location->email }}</td>
                                <td class="px-8 py-6 dark:text-slate-200">20</td>
                                <td class="px-8 py-6 dark:text-slate-200">
                                    <a href="{{ route('petugas.show', $location->uuid) }}"
                                        class="px-6 py-3 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-indigo-700 hover:to-violet-700 transition-all duration-300 ease-out hover:scale-105 hover:-translate-y-0.5">detail</a>
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td class="px-8 py-6 text-center dark:text-slate-200 font-bold" colspan="4">Data
                                    tidak ditemukan</td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    {{-- MODAL --}}
    <x-modal name="create-user" :show="false" focusable>

        <div class="p-8 dark:bg-slate-900">

            <h2 class="text-2xl font-black mb-6 dark:text-white">
                Tambah Lokasi
            </h2>

            <form action="{{ route('lokasi.store') }}" enctype="multipart/form-data" method="post" class="space-y-5">
                @csrf
                <div>
                    <x-input-label id="namaLokasi" value="Nama Lokasi" />

                    <x-text-input id="namaLokasi" class="block mt-1 w-full" type="text" name="namaLokasi"
                        :value="old('namaLokasi')" required autofocus autocomplete="namaLokasi" />
                    <x-input-error :messages="$errors->get('namaLokasi')" class="mt-2" />
                </div>

                <div>
                    <x-input-label id="penanggungJawab" value="Penanggung Jawab Ruangan" />

                    <select name="penanggungJawab" id="penanggungJawab"
                        class="capitalize block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                        <option value="" disabled>Pilih Petugas</option>
                        @forelse ($users as $user)
                            <option class="" value="{{ $user->id }}" 
                                {{ old('penanggungJawab') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
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
                                    {{ old('size') == $size ? 'checked' : '' }}
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
                                    {{ old('status') == $status ? 'checked' : '' }}
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
                        name="imageLayout" :value="old('imageLayout')" required autofocus autocomplete="imageLayout" />
                    <x-input-error :messages="$errors->get('imageLayout')" class="mt-2" />
                </div>

                <div>
                    <x-input-label id="desc" value="Deskripsi Lokasi" />

                    <textarea name="desc"
                        class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        id="desc">{{ old('desc') }}</textarea>

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
