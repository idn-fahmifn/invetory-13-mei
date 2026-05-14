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

            <a href="{{ route('lokasi.index') }}"
                class="bg-slate-200 hover:bg-slate-300 text-slate-700 px-6 py-3 rounded-2xl text-sm font-bold">

                Kembali

            </a>

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

                            <h3 class="font-black text-emerald-500">
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

                        <img src="{{ asset('storage/images/locations/' . $location->layout_image) }}" class="rounded-3xl w-full object-cover" alt="Layout">

                    </div>

                </div>

            </div>

        </div>

    </div>



</x-app-layout>
