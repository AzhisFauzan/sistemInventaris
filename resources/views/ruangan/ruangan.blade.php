@extends('layout.page')
@section("judul","Ruangan")
@section('content')
<div class="row">
    @php
        $icons = [
    'fas fa-clipboard-list',   // ADMISI IGD
    'fas fa-id-card',          // ADMISI RS
    'fas fa-pills',            // FARMASI
    'fas fa-briefcase-medical',// IGD
    'fas fa-cash-register',    // KASIR IGD
    'fas fa-money-bill-wave',  // KASIR RS
    'fas fa-user-md',          // KLINIK KIA/UMUM
    'fas fa-flask',            // LABORATORIUM
    'fas fa-user-nurse',       // NURSE STATION POLI
    'fas fa-stethoscope',      // POLI PENYAKIT DALAM
    'fas fa-baby',             // POLI ANAK
    'fas fa-user-md',          // POLI BEDAH
    'fas fa-brain',            // POLI BEDAH SYARAF
    'fas fa-tooth',            // POLI GIGI
    'fas fa-heartbeat',        // POLI JANTUNG
    'fas fa-brain',            // POLI JIWA
    'fas fa-eye',              // POLI MATA
    'fas fa-brain',            // POLI NEUROLOGI
    'fas fa-female',           // POLI OBGYN
    'fas fa-bone',             // POLI ORTOPEDI
    'fas fa-lungs',            // POLI PARU
    'fas fa-stethoscope',      // POLI PENYAKIT DALAM 2
    'fas fa-wheelchair',       // POLI REHAB MEDIK
    'fas fa-brain',            // POLI SYARAF
    'fas fa-head-side-mask',   // POLI THT
    'fas fa-x-ray',            // RADIOLOGI
    'fas fa-clipboard-check',  // UNIT APM
    'fas fa-baby-carriage',    // UNIT BERSALIN
    'fas fa-procedures',       // UNIT DIALISIS
    'fas fa-hospital',         // UNIT GEMAH RIPAH
    'fas fa-utensils',         // UNIT GIZI
    'fas fa-heart-pulse',      // UNIT ICU
    'fas fa-coins',            // UNIT KEUANGAN
    'fas fa-hospital-user',    // UNIT KIRANA
    'fas fa-file-invoice',     // UNIT KLAIM
    'fas fa-hospital',         // UNIT LEMBAH MANAH
    'fas fa-boxes',            // UNIT LOGISTIK
    'fas fa-hospital',         // UNIT MAHESWARA
    'fas fa-hospital',         // UNIT MIJIL
    'fas fa-procedures',       // UNIT OK
    'fas fa-cogs',             // UNIT OPS
    'fas fa-baby',             // UNIT PERINATAL
    'fas fa-folder-open',      // UNIT TATA USAHA
];
    @endphp

    <div class="col-md-12 mb-4">
        <form method="GET" action="{{ url('ruangan/ruangan') }}" class="d-flex" id="formSearch" style="gap: 6px;">
            <input type="hidden" name="lokasi" value="{{ $lokasi }}">
            <div class="input-group mb-1" id="search_ruangan">
                <div class="position-relative w-100">
                    <i class="fas fa-search position-absolute" style="left: 10px; top: 50%; transform: translateY(-50%); color: #aaa; z-index: 10;"></i>
                    <input type="text" name="search" id="inputSearch" class="form-control form-control-sm"
                        style="padding-left: 30px;"
                        placeholder="Cari nama ruangan..."
                        value="{{ $search }}"
                        autocomplete="off">
                </div>
            </div>
            <div id="clearBtn">
                @if($search)
                    <a href="{{ url('ruangan/ruangan') }}?lokasi={{ $lokasi }}"
                        class="btn btn-sm btn-secondary d-flex align-items-center justify-content-center"
                        style="height: calc(1.5em + .5rem + 2px); width: calc(1.5em + .5rem + 2px); padding: 0;">
                        <i class="fas fa-times"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Wrapper hasil pencarian --}}
    <div id="hasil-ruangan" class="row" style="width:100%; margin:0;">
        @if($search)
            <div class="col-md-12 mb-2">
                <small class="text-muted">
                    Menampilkan {{ $ruangan2->count() }} hasil untuk "<strong>{{ $search }}</strong>"
                </small>
            </div>
        @endif

        @if($ruangan2->isEmpty())
            <div class="col-md-12">
                <div class="alert alert-warning">
                    <i class="fas fa-search me-1"></i>
                    Ruangan "<strong>{{ $search }}</strong>" tidak ditemukan.
                </div>
            </div>
        @else
            @foreach ($ruangan2 as $index => $ruang)
            <div class="col-xl-4 col-md-6">
                <a href="{{ url('perangkat/data_perangkat/' . $ruang->id) }}">
                    <div class="card" style="background-color: white; margin: 10px;">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="h8 mb-0 font-weight-bold text-black-200">{{ $ruang->nama_ruangan }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="{{ $icons[$index % count($icons)] }} fa-2x text-black-200"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        @endif
    </div>
</div>

<script>
    // Paksa sidebar collapsed saat page load
    (function() {
        $("body").addClass("sidebar-toggled");
        $(".sidebar").addClass("toggled");
    })();

    // Paksa sidebar collapsed saat klik card
    document.getElementById('hasil-ruangan').addEventListener('click', function(e) {
        const link = e.target.closest('a[href]');
        if (link) {
            e.preventDefault();
            $(".sidebar").css("transition", "none");
            $("body").addClass("sidebar-toggled");
            $(".sidebar").addClass("toggled");
            setTimeout(function() {
                window.location.href = link.href;
            }, 50);
        }
    });

    const inputSearch = document.getElementById('inputSearch');
    let debounceTimer;

    inputSearch.addEventListener('input', function () {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(function () {
            const search = inputSearch.value;
            const lokasi = document.querySelector('input[name="lokasi"]').value;

            fetch(`{{ url('ruangan/ruangan') }}?search=${encodeURIComponent(search)}&lokasi=${encodeURIComponent(lokasi)}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');

                const newContent = doc.querySelector('#hasil-ruangan');
                if (newContent) {
                    document.getElementById('hasil-ruangan').innerHTML = newContent.innerHTML;
                }

                const newClearBtn = doc.querySelector('#clearBtn');
                if (newClearBtn) {
                    document.getElementById('clearBtn').innerHTML = newClearBtn.innerHTML;
                }

                const url = new URL(window.location);
                if (search) {
                    url.searchParams.set('search', search);
                } else {
                    url.searchParams.delete('search');
                }
                window.history.pushState({}, '', url);
            });
        }, 500);
    });
</script>
@endsection
