<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("Anda berhasil login sebagai admin!") }}
                    <div class="mt-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">Manajemen Konten:</h3>
                        <ul>
                            <li>
                                <a href="{{ route('admin.posts.index') }}" class="text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-600">
                                    Kelola Artikel/Berita
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.categories.index') }}" class="text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-600">
                                    Kelola Kategori
                                </a>
                            </li>
                            {{-- --- TAMBAHKAN BARIS INI --- --}}
                            <li>
                                <a href="{{ route('admin.users.index') }}" class="text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-600">
                                    Kelola Pengguna
                                </a>
                            </li>
                            {{-- --- Akhir Tambahan --- --}}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>