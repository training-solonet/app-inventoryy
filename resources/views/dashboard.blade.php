@extends('template')
@section('content')
<div class="content">
    <div class="container-fluid">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h2 class="font-weight-bold">Dashboard Overview</h2>
                <p class="text-muted">Menampilkan ringkasan data terbaru</p>
            </div>
        </div>

        <!-- Cards -->
        <div class="row">
            <!-- Data Barang -->
            <div class="col-lg-4 col-md-6 col-sm-6 mb-4">
                <div class="card card-stats">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5 col-md-4">
                                <div class="icon-big text-center icon-warning">
                                    <i class="nc-icon nc-globe text-warning"></i>
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers">
                                    <p class="card-category">Data Barang</p>
                                    <p class="card-title">{{ $totalBarangs }}</p>
                                    <div class="progress mt-2">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 60%;" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">60%</div>
                                    </div>
                                    <small class="text-muted">Pencapaian target stok barang</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <hr>
                        <div class="stats">
                            <i class="fa fa-refresh"></i> Diperbarui hari ini
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Petugas -->
            <div class="col-lg-4 col-md-6 col-sm-6 mb-4">
                <div class="card card-stats">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5 col-md-4">
                                <div class="icon-big text-center icon-warning">
                                    <i class="nc-icon nc-vector text-danger"></i>
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers">
                                    <p class="card-category">Data Petugas</p>
                                    <p class="card-title">{{ $totalPetugas }}</p>
                                    <small class="text-muted">Jumlah petugas aktif</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <hr>
                        <div class="stats">
                            <i class="fa fa-clock-o"></i> Update terbaru 1 jam lalu
                        </div>
                    </div>
                </div>
            </div>

            <!-- Barang yang Dipinjam -->
            <div class="col-lg-4 col-md-6 col-sm-6 mb-4">
                <div class="card card-stats">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5 col-md-4">
                                <div class="icon-big text-center icon-warning">
                                    <i class="nc-icon nc-favourite-28 text-primary"></i>
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers">
                                    <p class="card-category">Barang Dipinjam</p>
                                    <p class="card-title">{{ $totalBorrowedItems }}</p>
                                    <small class="text-muted">Total barang yang sedang dipinjam</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <hr>
                        <div class="stats">
                            <i class="fa fa-refresh"></i> Update sekarang
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Content -->
        <div class="row">
            <!-- Progress Bar Section -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Progress Keseluruhan</h5>
                        <p class="card-category">Statistik kinerja dari berbagai aspek</p>
                    </div>
                    <div class="card-body">
                        <p>Barang Terdistribusi</p>
                        <div class="progress mb-3">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 75%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">75%</div>
                        </div>
                        <p>Pengembalian Barang</p>
                        <div class="progress mb-3">
                            <div class="progress-bar bg-info" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">50%</div>
                        </div>
                        <p>Petugas Aktif</p>
                        <div class="progress mb-3">
                            <div class="progress-bar bg-danger" role="progressbar" style="width: 90%;" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100">90%</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informasi Tambahan -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Informasi Tambahan</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><i class="fa fa-check-circle text-success"></i> Total Barang di Gudang</span>
                                <span>{{ $totalBarangs }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><i class="fa fa-user text-info"></i> Petugas Baru Ditambahkan</span>
                                <span>{{ $recentPetugas }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><i class="fa fa-exclamation-triangle text-warning"></i> Barang Kembali Tertunda</span>
                                <span>{{ $pendingReturns }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
