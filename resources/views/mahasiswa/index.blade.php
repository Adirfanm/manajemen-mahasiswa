<x-layouts::app :title="__('Mahasiswa')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">

        {{-- Stat Cards --}}
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="rounded-xl border border-slate-200 bg-white p-5">
                <p class="text-xs font-semibold uppercase tracking-widest text-slate-400">Total Mahasiswa</p>
                <p class="mt-1 text-3xl font-bold text-slate-900">142</p>
                <p class="mt-1 text-xs text-slate-400">Terdaftar aktif</p>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-5">
                <p class="text-xs font-semibold uppercase tracking-widest text-slate-400">Semester Berjalan</p>
                <p class="mt-1 text-3xl font-bold text-slate-900">5</p>
                <p class="mt-1 text-xs text-slate-400">Tahun akademik 2025/2026</p>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-5">
                <p class="text-xs font-semibold uppercase tracking-widest text-slate-400">Jurusan</p>
                <p class="mt-1 text-3xl font-bold text-slate-900">7</p>
                <p class="mt-1 text-xs text-slate-400">Program studi tersedia</p>
            </div>
        </div>

        {{-- Main Panel --}}
        <div class="flex flex-col gap-6 rounded-xl border border-slate-200 bg-white p-6">

            {{-- Top Bar --}}
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <h1 class="text-xl font-bold text-slate-900">Manajemen Data Mahasiswa</h1>
                </div>
                <a href="{{ route('mahasiswa.create') }}"
                    class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">
                    + Tambah Mahasiswa
                </a>
            </div>

            {{-- Flash & Errors --}}
            @if (session('success'))
                <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                    ✓ {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-600">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            {{-- Filter Form --}}
            <form method="GET" action="{{ route('mahasiswa.index') }}" class="flex flex-wrap items-center gap-3">
                <input type="text" name="keyword" value="{{ $keyword }}"
                    placeholder="Cari NIM, nama, email, atau jurusan…"
                    class="flex-1 min-w-[200px] rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-400">

                <select name="search_method"
                    class="rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                    <option value="linear" {{ $searchMethod === 'linear' ? 'selected' : '' }}>Linear Search</option>
                    <option value="sequential" {{ $searchMethod === 'sequential' ? 'selected' : '' }}>Sequential Search
                    </option>
                    <option value="binary" {{ $searchMethod === 'binary' ? 'selected' : '' }}>Binary Search by NIM
                    </option>
                </select>

                <select name="sort_method"
                    class="rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                    <option value="none" {{ $sortMethod === 'none' ? 'selected' : '' }}>Tanpa Sorting
                    </option>
                    <option value="bubble_nama" {{ $sortMethod === 'bubble_nama' ? 'selected' : '' }}>Bubble Sort by
                        Nama</option>
                    <option value="selection_nim" {{ $sortMethod === 'selection_nim' ? 'selected' : '' }}>Selection
                        Sort by NIM</option>
                    <option value="merge_semester" {{ $sortMethod === 'merge_semester' ? 'selected' : '' }}>Merge Sort
                        by Semester</option>
                </select>

                <button type="submit"
                    class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">
                    Terapkan
                </button>
                <a href="{{ route('mahasiswa.index') }}"
                    class="rounded-lg border border-slate-200 px-4 py-2 text-sm text-slate-500 hover:text-slate-700">
                    Reset
                </a>
            </form>

            @if ($searchTime !== null)
                <p>Waktu pencarian:
                    <strong>{{ number_format($searchTime, 6) }} ms</strong>
                </p>
            @endif

            {{-- Pointer Simulation --}}
            <div class="rounded-lg border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-500">
                @if ($pointerSample)
                    Pointer Array — Data pertama:
                    <strong class="text-indigo-600">
                        {{ $pointerSample['nim'] }} – {{ $pointerSample['nama'] }}
                    </strong>
                @else
                    Belum ada data untuk ditunjukkan.
                @endif
            </div>

            {{-- Data Table --}}
            <div class="overflow-x-auto rounded-lg border border-slate-200">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wider text-slate-400">
                        <tr>
                            <th class="px-4 py-3 text-left">NIM</th>
                            <th class="px-4 py-3 text-left">Nama</th>
                            <th class="px-4 py-3 text-left">Email</th>
                            <th class="px-4 py-3 text-left">Jurusan</th>
                            <th class="px-4 py-3 text-left">Semester</th>
                            <th class="px-4 py-3 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($data as $row)
                            <tr class="transition-colors hover:bg-slate-50">
                                <td class="px-4 py-3 font-mono font-semibold text-indigo-600">{{ $row['nim'] }}</td>
                                <td class="px-4 py-3 text-slate-800">{{ $row['nama'] }}</td>
                                <td class="px-4 py-3 text-slate-500">{{ $row['email'] }}</td>
                                <td class="px-4 py-3 text-slate-600">{{ $row['jurusan'] }}</td>
                                <td class="px-4 py-3">
                                    <span
                                        class="rounded-full bg-violet-100 px-2.5 py-0.5 text-xs font-semibold text-violet-700">
                                        {{ $row['semester'] }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('mahasiswa.edit', $row['nim']) }}"
                                            class="rounded-md border border-slate-200 px-3 py-1 text-xs text-slate-600 hover:border-indigo-400 hover:text-indigo-600">
                                            Edit
                                        </a>
                                        <form action="{{ route('mahasiswa.destroy', $row['nim']) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                onclick="return confirm('Yakin ingin menghapus data ini?')"
                                                class="rounded-md border border-red-200 px-3 py-1 text-xs text-red-500 hover:border-red-400 hover:text-red-600">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-10 text-center text-slate-400">
                                    Belum ada data mahasiswa.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Time Complexity --}}
            <div>
                <p class="mb-3 text-xs font-bold uppercase tracking-widest text-indigo-500">
                    Estimasi Time Complexity
                </p>
                <div class="overflow-x-auto rounded-lg border border-slate-200">
                    <table class="w-full text-sm">
                        <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wider text-slate-400">
                            <tr>
                                <th class="px-4 py-3 text-left">Fitur</th>
                                <th class="px-4 py-3 text-left">Algoritma</th>
                                <th class="px-4 py-3 text-left">Time Complexity</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-2.5 text-slate-600">Pencarian umum</td>
                                <td class="px-4 py-2.5 text-indigo-500">Linear Search</td>
                                <td class="px-4 py-2.5 font-mono text-green-600">O(n)</td>
                            </tr>
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-2.5 text-slate-600">Pencarian berurutan</td>
                                <td class="px-4 py-2.5 text-indigo-500">Sequential Search</td>
                                <td class="px-4 py-2.5 font-mono text-green-600">O(n)</td>
                            </tr>
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-2.5 text-slate-600">Pencarian NIM</td>
                                <td class="px-4 py-2.5 text-indigo-500">Binary Search</td>
                                <td class="px-4 py-2.5 font-mono text-green-600">O(log n)</td>
                            </tr>
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-2.5 text-slate-600">Pengurutan nama</td>
                                <td class="px-4 py-2.5 text-indigo-500">Bubble Sort</td>
                                <td class="px-4 py-2.5 font-mono text-amber-500">O(n²)</td>
                            </tr>
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-2.5 text-slate-600">Pengurutan NIM</td>
                                <td class="px-4 py-2.5 text-indigo-500">Selection Sort</td>
                                <td class="px-4 py-2.5 font-mono text-amber-500">O(n²)</td>
                            </tr>
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-2.5 text-slate-600">Pengurutan semester</td>
                                <td class="px-4 py-2.5 text-indigo-500">Merge Sort</td>
                                <td class="px-4 py-2.5 font-mono text-green-600">O(n log n)</td>
                            </tr>
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-2.5 text-slate-600">Tambah data</td>
                                <td class="px-4 py-2.5 text-indigo-500">Append + simpan file</td>
                                <td class="px-4 py-2.5 font-mono text-green-600">O(n)</td>
                            </tr>
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-2.5 text-slate-600">Hapus data</td>
                                <td class="px-4 py-2.5 text-indigo-500">Filter + simpan file</td>
                                <td class="px-4 py-2.5 font-mono text-green-600">O(n)</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-layouts::app>
