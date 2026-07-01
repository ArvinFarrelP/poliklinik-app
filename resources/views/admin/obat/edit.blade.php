<x-layouts.app title="Edit Obat">

    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('obat.index') }}" class="flex items-center justify-center w-9 h-9
                  rounded-lg bg-slate-100 hover:bg-slate-200
                  text-slate-600 transition">
            <i class="fas fa-arrow-left text-sm"></i>
        </a>

        <h2 class="text-2xl font-bold text-slate-800">
            Edit Obat
        </h2>
    </div>

    <div class="card bg-base-100 shadow-md rounded-2xl border border-slate-200">
        <div class="card-body p-8">

            <form action="{{ route('obat.update', $obat->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">
                            Nama Obat <span class="text-red-500">*</span>
                        </label>

                        <input type="text" name="nama_obat" value="{{ old('nama_obat', $obat->nama_obat) }}"
                            placeholder="Masukkan nama obat..." class="w-full px-4 py-2 border-2 rounded-lg
                                      focus:border-primary focus:outline-none
                                      @error('nama_obat') border-red-500 @enderror" required>

                        @error('nama_obat')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">
                            Kemasan
                        </label>

                        <input type="text" name="kemasan" value="{{ old('kemasan', $obat->kemasan) }}"
                            placeholder="Contoh: Strip, Botol, Tube..." class="w-full px-4 py-2 border-2 rounded-lg
                                      focus:border-primary focus:outline-none
                                      @error('kemasan') border-red-500 @enderror">

                        @error('kemasan')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">
                            Harga <span class="text-red-500">*</span>
                        </label>

                        <div class="flex items-center border-2 rounded-lg px-4 py-2 focus-within:border-primary">
                            <span class="text-slate-500 text-sm font-semibold mr-2">
                                Rp
                            </span>

                            <input type="number" name="harga" value="{{ old('harga', $obat->harga) }}" min="0" step="1"
                                class="w-full focus:outline-none" required>
                        </div>

                        @error('harga')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">
                            Stok <span class="text-red-500">*</span>
                        </label>

                        <input type="number" name="stok" value="{{ old('stok', $obat->stok) }}" min="0" step="1" class="w-full px-4 py-2 border-2 rounded-lg
                                      focus:border-primary focus:outline-none
                                      @error('stok') border-red-500 @enderror" required>

                        @error('stok')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <div class="flex gap-3">
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-primary
                               hover:bg-primary/90 text-white
                               font-semibold text-sm transition">
                        <i class="fas fa-save mr-1"></i>
                        Update
                    </button>

                    <a href="{{ route('obat.index') }}" class="px-6 py-2.5 rounded-xl bg-slate-100
                              hover:bg-slate-200 text-slate-600
                              font-semibold text-sm transition">
                        Batal
                    </a>
                </div>

            </form>

        </div>
    </div>

</x-layouts.app>
