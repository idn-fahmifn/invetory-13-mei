<x-app-layout>

    <x-slot name="header">

        <div class="flex items-center justify-between">

            <div>

                <h2 class="font-black text-2xl text-slate-800 dark:text-white">
                    Detail Petugas
                </h2>

                <p class="text-sm text-slate-400 mt-1">
                    Informasi lengkap petugas inventory
                </p>

            </div>

            <a href="{{ route('petugas.index') }}"
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

                    <div class="flex items-center gap-6 mb-10">

                        <div
                            class="w-24 h-24 rounded-3xl bg-emerald-100 flex items-center justify-center text-3xl font-black text-emerald-600">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        </div>

                        <div>

                            <h2 class="text-3xl font-black text-slate-800 dark:text-white uppercase">
                                {{ $user->name }}
                            </h2>

                            <p class="text-slate-400 mt-1">
                                
                                {{ $user->isAdmin == true ? 'Admin' : 'Petugas Inventory' }}
                            </p>

                        </div>

                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div class="bg-slate-50 dark:bg-slate-800 rounded-lg p-6">

                            <p class="text-sm text-slate-400 mb-2">
                                Email
                            </p>

                            <h3 class="font-black text-slate-700 dark:text-white">
                                {{ $user->email }}
                            </h3>

                        </div>

                        <div class="bg-slate-50 dark:bg-slate-800 rounded-lg p-6">

                            <p class="text-sm text-slate-400 mb-2">
                                Level Petugas
                            </p>

                            <h3 class="font-black text-emerald-500">
                                {{ $user->isAdmin == true ? 'Admin' : 'Petugas Inventory' }}
                            </h3>

                        </div>

                        <div class="bg-slate-50 dark:bg-slate-800 rounded-lg p-6">

                            <p class="text-sm text-slate-400 mb-2">
                                Total Lokasi
                            </p>

                            <h3 class="font-black text-slate-700 dark:text-white">
                                12 Lokasi
                            </h3>

                        </div>

                        <div class="bg-slate-50 dark:bg-slate-800 rounded-lg p-6">

                            <p class="text-sm text-slate-400 mb-2">
                                Bergabung
                            </p>

                            <h3 class="font-black text-slate-700 dark:text-white">
                                {{ $user->created_at->locale('id')->translatedFormat('d F Y') }}
                            </h3>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>
