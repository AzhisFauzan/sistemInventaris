@extends('layout.page')
@section("judul","Riwayat Maintenance")
@section('content')

<div class="row">
    <div class="col-md-12 mb-3">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="h3 mb-2 text-gray-800">Riwayat Maintenance</h1>
            <a href="{{ url('maintenance/maintenance') }}" class="btn btn-outline-primary btn-sm">
                <i class="fas fa-calendar-alt mr-1"></i> Jadwal Maintenance
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card shadow-sm">
            <div class="card-header">
                <i class="fas fa-history mr-2"></i>Riwayat Maintenance
            </div>
            <div class="card-body">

                <ul class="nav nav-pills mb-3" id="filterKategoriRiwayat">
                    <li class="nav-item">
                        <a class="nav-link active" href="#" data-kategori="all">Semua</a>
                    </li>
                    @foreach($kategoriPerangkat as $namaKategori => $items)
                        @php $kat = $items->first(); @endphp
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-kategori="{{ $kat->id_kategori }}">
                                {{ $namaKategori }}
                                <span class="badge badge-light ml-1">
                                    {{ $riwayat->where('id_kategori', $kat->id_kategori)->count() }}
                                </span>
                            </a>
                        </li>
                    @endforeach
                </ul>

                <div class="table-responsive">
                    <table class="table table-hover" id="tabelRiwayat">
                        <thead class="thead-light">
                            <tr>
                                <th style="width:5%">No</th>
                                <th>Ruangan</th>
                                <th>Perangkat</th>
                                <th>Tanggal</th>
                                <th>Teknisi</th>
                                <th>Deskripsi</th>
                                <th style="width:8%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($riwayat as $i => $item)
                            <tr class="riwayat-row" data-kategori="{{ $item->id_kategori }}">
                                <td>{{ $i + 1 }}</td>
                                <td class="font-weight-bold">{{ $item->nama_ruangan }}</td>
                                <td>
                                    <span class="badge badge-info">{{ $item->nama_kategori }}</span>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y, H:i') }}</td>
                                <td>{{ $item->nama_teknisi ?? '-' }}</td>
                                <td>{{ Str::limit($item->deskripsi, 50) }}</td>
                                <td>
                                    <button class="btn btn-outline-info btn-sm btn-detail-riwayat"
                                        data-id="{{ $item->id_maintenance }}"
                                        data-toggle="modal"
                                        data-target="#modalDetailRiwayat">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                    Belum ada riwayat maintenance.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="text-center text-muted py-4 d-none" id="pesanKosongRiwayat">
                    <i class="fas fa-search fa-2x mb-2 d-block"></i>
                    Tidak ada riwayat untuk kategori ini.
                </div>

            </div>
            <div class="card-footer text-muted" style="font-size:0.85rem;">
                Total: <strong>{{ $riwayat->count() }}</strong> riwayat maintenance
            </div>
        </div>
    </div>
</div>

{{-- Modal Detail --}}
<div class="modal fade" id="modalDetailRiwayat" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">
                    <i class="fas fa-history mr-2"></i>Detail Riwayat Maintenance
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="riwayat-loading" class="text-center py-4">
                    <div class="spinner-border text-info" role="status"></div>
                    <p class="mt-2 text-muted">Memuat data...</p>
                </div>
                <div id="riwayat-content" style="display:none;">
                    <table class="table table-borderless mb-0">
                        <tbody>
                            <tr>
                                <th width="38%" class="text-muted">Ruangan</th>
                                <td>: <span id="r-ruangan">-</span></td>
                            </tr>
                            <tr>
                                <th class="text-muted">Perangkat</th>
                                <td>: <span id="r-kategori">-</span></td>
                            </tr>
                            <tr>
                                <th class="text-muted">Tanggal</th>
                                <td>: <span id="r-tanggal">-</span></td>
                            </tr>
                            <tr>
                                <th class="text-muted">Teknisi</th>
                                <td>: <span id="r-teknisi">-</span></td>
                            </tr>
                            <tr>
                                <th class="text-muted">Deskripsi</th>
                                <td>: <span id="r-deskripsi">-</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div id="riwayat-error" class="alert alert-danger d-none">
                    Gagal memuat data. Silakan coba lagi.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
// Filter Kategori
$(document).on('click', '#filterKategoriRiwayat .nav-link', function(e){
    e.preventDefault();
    $('#filterKategoriRiwayat .nav-link').removeClass('active');
    $(this).addClass('active');

    var kategori = $(this).data('kategori');
    var ada = false;

    $('.riwayat-row').each(function(){
        var match = (kategori === 'all' || $(this).data('kategori') == kategori);
        $(this).toggle(match);
        if(match) ada = true;
    });

    $('#pesanKosongRiwayat').toggleClass('d-none', ada);
});

// Modal Detail
$(document).on('click', '.btn-detail-riwayat', function(){
    var id = $(this).data('id');
    $('#riwayat-loading').show();
    $('#riwayat-content').hide();
    $('#riwayat-error').addClass('d-none');

    $.ajax({
        url: "{{ url('maintenance/detail') }}/" + id,
        method: 'GET',
        success: function(data){
            $('#r-ruangan').text(data.nama_ruangan  ?? '-');
            $('#r-tanggal').text(data.tanggal       ?? '-');
            $('#r-teknisi').text(data.nama_teknisi  ?? '-');
            $('#r-deskripsi').text(data.deskripsi   ?? '-');

            var kategoriHtml = '';
            if(data.kategoris && data.kategoris.length > 0){
                $.each(data.kategoris, function(i, kat){
                    kategoriHtml += '<span class="badge badge-info mr-1">' + kat.nama_kategori + '</span>';
                });
            } else {
                kategoriHtml = '-';
            }
            $('#r-kategori').html(kategoriHtml);

            $('#riwayat-loading').hide();
            $('#riwayat-content').show();
        },
        error: function(){
            $('#riwayat-loading').hide();
            $('#riwayat-error').removeClass('d-none');
        }
    });
});
</script>
@endsection
