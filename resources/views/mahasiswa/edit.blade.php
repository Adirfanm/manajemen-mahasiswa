<x-layouts::app :title="__('Edit Mahasiswa')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">

        {{-- Header --}}
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-xl font-bold text-slate-900">Edit Mahasiswa</h1>
                <p class="mt-1 text-sm text-slate-400">Perbarui data mahasiswa di bawah ini.</p>
            </div>
            <a href="{{ route('mahasiswa.index') }}"
               class="text-sm text-indigo-500 hover:text-indigo-400">← Kembali</a>
        </div>

        {{-- Form Card --}}
        <div class="rounded-xl border border-slate-200 bg-white p-6">

            {{-- Errors --}}
            @if ($errors->any())
                <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-600">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('mahasiswa.update', $mahasiswa['nim']) }}" class="flex flex-col gap-5">
                @csrf
                @method('PUT')

                {{-- NIM --}}
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-semibold text-slate-700">NIM</label>
                    <input type="text" name="nim" value="{{ old('nim', $mahasiswa['nim']) }}"
                           class="rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                </div>

                {{-- Nama --}}
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-semibold text-slate-700">Nama</label>
                    <input type="text" name="nama" value="{{ old('nama', $mahasiswa['nama']) }}"
                           class="rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                </div>

                {{-- Email --}}
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-semibold text-slate-700">Email</label>
                    <input type="email" name="email" value="{{ old('email', $mahasiswa['email']) }}"
                           class="rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                </div>

                {{-- Jurusan --}}
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-semibold text-slate-700">Jurusan</label>
                    <input type="text" name="jurusan" value="{{ old('jurusan', $mahasiswa['jurusan']) }}"
                           class="rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                </div>

                {{-- Semester --}}
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-semibold text-slate-700">Semester</label>
                    <input type="number" name="semester" value="{{ old('semester', $mahasiswa['semester']) }}"
                           min="1" max="14"
                           class="w-32 rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                </div>

                {{-- Actions --}}
                <div class="flex items-center gap-3 border-t border-slate-100 pt-4">
                    <button type="submit"
                            class="rounded-lg bg-indigo-600 px-5 py-2 text-sm font-semibold text-white hover:bg-indigo-500">
                        Update
                    </button>
                    <a href="{{ route('mahasiswa.index') }}"
                       class="rounded-lg border border-slate-200 px-5 py-2 text-sm text-slate-500 hover:text-slate-700">
                        Batal
                    </a>
                </div>

            </form>
        </div>

    </div>
</x-layouts::app>
