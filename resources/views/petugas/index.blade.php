<x-app-layout>

    <x-slot name="header">

        <div class="flex items-center justify-between">

            <div>

                <h2 class="font-black text-2xl text-slate-800 dark:text-white">
                    Data Petugas
                </h2>

                <p class="text-sm text-slate-400 mt-1">
                    Management petugas inventory
                </p>

            </div>

            <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'create-user')"
                class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-2xl font-bold text-sm transition">

                + Tambah Petugas

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
                        Data petugas berhasil ditambahkan
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

                            <th class="px-8 py-5 text-left">Nama</th>
                            <th class="px-8 py-5 text-left">Email</th>
                            <th class="px-8 py-5 text-left">Jumlah Ruangan</th>
                            <th class="px-8 py-5 text-left">Detail</th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">

                        @forelse( $users as $user )
                        <tr>

                            <td class="px-8 py-6 dark:text-slate-200 font-bold">{{ $user->name }}</td>
                            <td class="px-8 py-6 dark:text-slate-200">{{ $user->email }}</td>
                            <td class="px-8 py-6 dark:text-slate-200">20</td>
                            <td class="px-8 py-6 dark:text-slate-200">
                                <a href="{{ route('petugas.show', $user->uuid) }}" class="px-6 py-3 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-indigo-700 hover:to-violet-700 transition-all duration-300 ease-out hover:scale-105 hover:-translate-y-0.5">detail</a>
                            </td>

                        </tr>

                        @empty

                        <tr>
                            <td class="px-8 py-6 text-center dark:text-slate-200 font-bold" colspan="3">Data tidak ditemukan</td>
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
                Tambah Petugas
            </h2>

            <form action="{{ route('petugas.store') }}" method="post" class="space-y-5">
                @csrf
                <div>
                    <x-input-label id="namaPetugas" value="Nama Petugas" />

                    <x-text-input id="namaPetugas" class="block mt-1 w-full" type="text" name="namaPetugas"
                        :value="old('namaPetugas')" required autofocus autocomplete="namaPetugas" />
                    <x-input-error :messages="$errors->get('namaPetugas')" class="mt-2" />
                </div>

                <div>

                    <x-input-label value="Email" />

                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                        :value="old('email')" required autofocus autocomplete="email" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />

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
