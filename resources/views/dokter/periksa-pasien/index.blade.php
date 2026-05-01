<x-layouts.app title="Periksa Pasien">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-slate-800">
            Periksa Pasien
        </h2>
    </div>

    {{-- Alert Flash Message --}}
    @if (session('message'))
    <div class="alert alert-{{ session('type') ?? 'success' }} mb-4 rounded-xl shadow-sm" role="alert">
        <i class="fas fa-{{ session('type') == 'danger' ? 'circle-xmark' : 'circle-check' }}"></i>
        <span>{{ session('message') }}</span>
    </div>
    @endif

    {{-- Card --}}
    <div class="card bg-base-100 shadow-md rounded-2 border">
        <div class="card-body p-0">

            <div class="overflow-x-auto">
                <table class="table table-zebra w-full">

                    {{-- Head --}}
                    <thead class="bg-slate-100 text-slate-500 text-xs uppercase tracking-wider">
                        <tr>
                            <th class="px-6 py-4">ID</th>
                            <th class="px-6 py-4">Pasien</th>
                            <th class="px-6 py-4">Keluhan</th>
                            <th class="px-6 py-4">No Antrian</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>

                    {{-- Body --}}
                    <tbody>
                        @forelse ($daftarPasien as $dp)
                        <tr class="hover:bg-slate-50 transition">

                            <td class="px-6 py-4 text-slate-500">
                                {{ $loop->iteration }}
                            </td>

                            <td class="px-6 py-4 font-semibold text-slate-800">
                                {{ $dp->pasien->nama }}
                            </td>

                            <td class="px-6 py-4 text-slate-500">
                                {{ $dp->keluhan }}
                            </td>

                            <td class="px-6 py-4 text-slate-500">
                                {{ $dp->no_antrian }}
                            </td>

                            <td class="px-6 py-4 text-right">
                                @if ($dp->periksas->isNotEmpty())
                                <span
                                    class="badge bg-green-100 text-green-700 border border-green-200 rounded-lg px-3 py-1 text-xs font-semibold">
                                    <i class="fas fa-circle-check mr-1"></i>Sudah Diperiksa
                                </span>
                                @else
                                <a href="{{ route('periksa-pasien.create', $dp->id) }}"
                                    class="btn btn-sm bg-amber-500 hover:bg-amber-600 text-white border-none rounded-lg px-4">
                                    <i class="fas fa-stethoscope"></i>
                                    Periksa
                                </a>
                                @endif
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-14 text-slate-400">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <i class="fas fa-inbox text-3xl"></i>
                                    <span>Tidak ada data pasien periksa</span>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>
    </div>

    <script>
    setTimeout(() => {
        const alert = document.querySelector('.alert');
        if (alert) {
            alert.classList.remove('show');
            alert.classList.add('fade');
            setTimeout(() => alert.remove(), 200);
        }
    }, 2000);
    </script>

</x-layouts.app>
