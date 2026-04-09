@extends('layout.page')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Laporan Data Maintenance</h1>
        <a href="{{ url('/laporan/maintenance/print') }}?{{ http_build_query(request()->all()) }}"
           target="_blank" class="btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-print fa-sm mr-2"></i> Cetak Laporan
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter Laporan</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ url('/laporan/maintenance') }}">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Ruangan</label>
                            <select name="id_ruangan" class="form-control">
                                <option value="">-- Semua Ruangan --</option>
                                @foreach($ruangans as $r)
                                    <option value="{{ $r->id }}" {{ request('id_ruangan') == $r->id ? 'selected' : '' }}>
                                        {{ $r->nama_ruangan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Kategori</label>
                            <select name="id_kategori" class="form-control">
                                <option value="">-- Semua Kategori --</option>
                                @foreach($kategoris as $k)
                                    <option value="{{ $k->id }}" {{ request('id_kategori') == $k->id ? 'selected' : '' }}>
                                        {{ $k->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Dari Tanggal</label>
                            <input type="date" name="dari" class="form-control" value="{{ request('dari') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Sampai Tanggal</label>
                            <input type="date" name="sampai" class="form-control" value="{{ request('sampai') }}">
                        </div>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary mr-2">
                            <i class="fas fa-filter mr-1"></i> Filter
                        </button>
                        <a href="{{ url('/laporan/maintenance') }}" class="btn btn-secondary">Reset</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Data Jadwal & Riwayat Maintenance</h6>
            <span class="badge badge-primary">Total: {{ $maintenances->count() }} data</span>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="tabelMaintenance" width="100%">
                    <thead class="thead-dark">
                        <tr>
                            <th>No</th>
                            <th>ID</th>
                            <th>Kategori</th>
                            <th>Ruangan</th>
                            <th>Nama Teknisi</th>
                            <th>Tanggal</th>
                            <th>Deskripsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($maintenances as $i => $m)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td><code>{{ $m->id }}</code></td>
                            <td>{{ $m->kategori->nama_kategori ?? '-' }}</td>
                            <td>{{ $m->ruangan->nama_ruangan ?? '-' }}</td>
                            <td>{{ $m->nama_teknisi }}</td>
                            <td>{{ \Carbon\Carbon::parse($m->tanggal)->format('d/m/Y') }}</td>
                            <td>{{ $m->deskripsi }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Tidak ada data maintenance</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
