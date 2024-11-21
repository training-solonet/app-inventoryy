@extends('template')
@section('content')
<div class="content">
    <div class="container-fluid">
        <!-- Notifikasi -->
        @if ($totalBelumDikembalikan > 0)
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Perhatian!</strong> Terdapat {{ $totalBelumDikembalikan }} barang yang belum dikembalikan. 
                <a href="{{ route('borrow.index') }}" class="alert-link">Lihat detail</a>.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h2 class="font-weight-bold" style="color: rgb(0, 0, 0); font-size: 2.5rem;">
                    Dashboard Overview
                </h2>
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
                                <div class="icon-big text-center text-warning">
                                    <i class="nc-icon nc-globe"></i>
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers">
                                    <p class="card-category">Data Barang</p>
                                    <p class="card-title">{{ $totalBarangs }}</p>
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
                                <div class="icon-big text-center text-danger">
                                    <i class="nc-icon nc-vector"></i>
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers">
                                    <p class="card-category">Data Petugas</p>
                                    <p class="card-title">{{ $totalPetugas }}</p>
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
                                <div class="icon-big text-center text-primary">
                                    <i class="nc-icon nc-favourite-28"></i>
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers">
                                    <p class="card-category">Barang Dipinjam</p>
                                    <p class="card-title">{{ $totalBorrowedItems }}</p>
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

        <div class="row">
            <!-- Barang Rusak -->
            <div class="col-lg-4 col-md-6 col-sm-6 mb-4">
                <div class="card card-stats">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5 col-md-4">
                                <div class="icon-big text-center text-danger">
                                    <i class="nc-icon nc-settings-gear-65"></i>
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers">
                                    <p class="card-category">Barang Rusak</p>
                                    <p class="card-title">{{ $totalRusak }}</p>
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

            <!-- Barang Baik -->
            <div class="col-lg-4 col-md-6 col-sm-6 mb-4">
                <div class="card card-stats">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5 col-md-4">
                                <div class="icon-big text-center text-success">
                                    <i class="nc-icon nc-check-2"></i>
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers">
                                    <p class="card-category">Barang Baik</p>
                                    <p class="card-title">{{ $totalBaik }}</p>
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

            <!-- Barang Belum Dikembalikan -->
            <div class="col-lg-4 col-md-6 col-sm-6 mb-4">
                <div class="card card-stats">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5 col-md-4">
                                <div class="icon-big text-center text-warning">
                                    <i class="nc-icon nc-tile-56"></i>
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers">
                                    <p class="card-category">Belum Dikembalikan</p>
                                    <p class="card-title">{{ $totalBelumDikembalikan }}</p>
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
    </div>
</div>
@endsection
