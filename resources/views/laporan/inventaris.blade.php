@extends('layout.page')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Laporan Inventaris IT</h1>
    </div>
    <!-- Tambahkan di atas form -->
    <div id="loading" class="d-none text-center py-3">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        <p class="mt-2 mb-0 text-muted">Memuat data...</p>
    </div>
    {{-- Filter --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter Laporan</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ url('/laporan/inventaris') }}">
                <div class="form-group">
                    <label class="font-weight-bold">
                        Pilih Ruangan
                        <small class="text-muted font-weight-normal">(hanya ruangan dengan lebih dari 1 perangkat)</small>
                    </label>
                    <div class="mb-2">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="checkAll">
                            <label class="custom-control-label font-weight-bold text-primary" for="checkAll">
                                Pilih Semua
                            </label>
                        </div>
                    </div>
                    <hr class="mt-1 mb-2">
                    <div class="row">
                        @foreach($ruangan as $ruang)
                        <div class="col-md-3 col-sm-4 col-6 mb-1">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox"
                                    class="custom-control-input ruangan-check"
                                    name="id_ruangan[]"
                                    value="{{ $ruang->id_ruangan }}"
                                    id="ruang_{{ $ruang->id_ruangan }}"
                                    {{ in_array($ruang->id_ruangan, (array) request('id_ruangan', [])) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="ruang_{{ $ruang->id_ruangan }}">
                                    {{ $ruang->nama_ruangan }}
                                    <span class="badge badge-secondary">{{ $ruang->jumlah_perangkat }}</span>
                                </label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary mr-2">
                        <i class="fas fa-filter mr-1"></i> Filter
                    </button>
                    <a href="{{ url('/laporan/inventaris') }}" class="btn btn-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>

    {{-- Card Ruangan --}}
    @if(request()->has('id_ruangan'))

        {{-- Tombol cetak global --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="text-gray-700 font-weight-bold m-0">
                {{ count((array) request('id_ruangan')) }} ruangan dipilih
            </h6>
            <div>
                <a href="#" onclick="bukaLaporan('{{ route('laporan.inventaris.print') }}')"
                   class="btn btn-sm btn-danger mr-1">
                    <i class="fas fa-file-pdf fa-sm mr-1"></i> Cetak PDF
                </a>
                <a href="#" onclick="bukaLaporan('{{ route('laporan.inventaris.excel') }}')"
                   class="btn btn-sm btn-success">
                    <i class="fas fa-file-excel fa-sm mr-1"></i> Export Excel
                </a>
            </div>
        </div>

        {{-- Card per ruangan --}}
        <div class="row">
            @foreach($ruangan as $ruang)
                @if(in_array($ruang->id_ruangan, (array) request('id_ruangan', [])))

                    {{-- Cari terakhir cetak ruangan ini --}}
                    @php
                        $terakhirCetak = $perangkat->firstWhere('id_ruangan', $ruang->id_ruangan)?->terakhir_cetak ?? null;
                        $jumlahPerangkat = $perangkat->where('id_ruangan', $ruang->id_ruangan)->count();
                    @endphp

                    <div class="col-md-4 col-sm-6 mb-4">
                        <div class="card shadow h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center mr-3"
                                         style="width:42px; height:42px; min-width:42px;">
                                        <i class="fas fa-door-open text-white"></i>
                                    </div>
                                    <div>
                                        <h6 class="font-weight-bold mb-0">{{ $ruang->nama_ruangan }}</h6>
                                        <small class="text-muted">{{ $jumlahPerangkat }} perangkat</small>
                                    </div>
                                </div>

                                <div class="border-top pt-2 mb-3">
                                    @if($terakhirCetak)
                                        <small class="text-success">
                                            <i class="fas fa-print mr-1"></i>
                                            Terakhir cetak: <strong>
                                                {{ $terakhirCetak ? \Carbon\Carbon::parse($terakhirCetak)->tz('Asia/Jakarta')->locale('id')->isoFormat('D MMMM YYYY [pkl.] HH:mm [WIB]') : 'Belum pernah'
                                                }}
                                            </strong>
                                        </small>
                                    @else
                                        <small class="text-muted">
                                            <i class="fas fa-clock mr-1"></i>
                                            Belum pernah dicetak
                                        </small>
                                    @endif
                                </div>

                                <button class="btn btn-sm btn-primary btn-block"
                                        id="btn_{{ $ruang->id_ruangan }}"
                                        onclick="lihatDetail({{ $ruang->id_ruangan }})">
                                    <i class="fas fa-table mr-1"></i> Lihat Data
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Tabel detail ruangan ini (tersembunyi dulu) --}}
                    <div class="col-12 mb-4 tabel-detail" id="tabel_{{ $ruang->id_ruangan }}" style="display:none;">
                        <div class="card shadow border-left-primary">
                            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    <i class="fas fa-door-open mr-1"></i> {{ $ruang->nama_ruangan }}
                                </h6>
                                <button class="btn btn-sm btn-light border"
                                        onclick="tutupDetail({{ $ruang->id_ruangan }})">
                                    <i class="fas fa-times mr-1"></i> Tutup
                                </button>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover table-sm mb-0">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>No</th>
                                                <th>Kode Inventaris</th>
                                                <th>Kategori</th>
                                                <th>Alamat IP</th>
                                                <th>Spesifikasi</th>
                                                <th>Terakhir Cetak</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $no = 1; @endphp
                                            @foreach($perangkat as $p)
                                                @if($p->id_ruangan == $ruang->id_ruangan)
                                                <tr>
                                                    <td>{{ $no++ }}</td>
                                                    <td><span class="badge badge-light border">{{ $p->kode_inventaris ?? '-' }}</span></td>
                                                    <td>{{ $p->nama_kategori ?? '-' }}</td>
                                                    <td><code>{{ $p->alamat_ip ?? '-' }}</code></td>
                                                    <td>{{ $p->spesifikasi ?? '-' }}</td>
                                                    <td>
                                                        @if($p->terakhir_cetak)
                                                            <small class="text-success">
                                                                <i class="fas fa-print fa-xs mr-1"></i>{{ \Carbon\Carbon::parse($p->terakhir_cetak)
                                                                ->tz('Asia/Jakarta')
                                                                ->locale('id')
                                                                ->isoFormat('D MMM HH:mm') }}
                                                            </small>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                @endif
            @endforeach
        </div>

    @else
        {{-- Placeholder sebelum filter --}}
        <div class="card shadow mb-4">
            <div class="card-body text-center py-5 text-muted">
                <i class="fas fa-hand-pointer fa-3x mb-3 d-block"></i>
                <h5>Pilih ruangan terlebih dahulu</h5>
                <p class="mb-0">Centang ruangan yang ingin ditampilkan, lalu klik <strong>Filter</strong></p>
            </div>
        </div>
    @endif

</div>

<script>
    document.getElementById('checkAll').addEventListener('change', function () {
        document.querySelectorAll('.ruangan-check').forEach(cb => cb.checked = this.checked);
        submitForm();
    });

    document.querySelectorAll('.ruangan-check').forEach(cb => {
        cb.addEventListener('change', function () {
            // Update check all status
            const semua   = document.querySelectorAll('.ruangan-check').length;
            const dipilih = document.querySelectorAll('.ruangan-check:checked').length;
            document.getElementById('checkAll').checked = semua === dipilih;

            submitForm();
        });
    });

    let submitTimeout;
    function submitForm() {
        const loading = document.getElementById('loading');
        const form = document.querySelector('form');

        // Stabilize sidebar during submit
        $('body').addClass('form-submitting');

        clearTimeout(submitTimeout);
        submitTimeout = setTimeout(() => {
            if (loading) loading.classList.remove('d-none');
            form.submit();
        }, 100);
    }

    // Reset setelah page load
    $(document).ready(function() {
        $('body').removeClass('form-submitting');
    });

    function lihatDetail(idRuangan) {
        const tabel  = document.getElementById('tabel_' + idRuangan);
        const tombol = document.getElementById('btn_' + idRuangan);

        if (tabel.style.display === 'none' || tabel.style.display === '') {
            tabel.style.display = 'block';
            tombol.innerHTML    = '<i class="fas fa-eye-slash mr-1"></i> Sembunyikan';
            tombol.classList.replace('btn-primary', 'btn-secondary');
            tabel.scrollIntoView({ behavior: 'smooth', block: 'start' });
        } else {
            tabel.style.display = 'none';
            tombol.innerHTML    = '<i class="fas fa-table mr-1"></i> Lihat Data';
            tombol.classList.replace('btn-secondary', 'btn-primary');
        }
    }

    function tutupDetail(idRuangan) {
        document.getElementById('tabel_' + idRuangan).style.display = 'none';
    }

    function bukaLaporan(baseUrl) {
        const checked = document.querySelectorAll('.ruangan-check:checked');
        if (checked.length === 0) {
            alert('Pilih minimal 1 ruangan terlebih dahulu.');
            return;
        }
        const params = Array.from(checked)
            .map(cb => 'id_ruangan[]=' + cb.value)
            .join('&');
        window.open(baseUrl + '?' + params, '_blank');
    }
</script>
@endsection
