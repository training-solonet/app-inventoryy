<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Rekap Peminjaman</title>
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/paper-dashboard.css?v=2.0.1') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="wrapper">
        <div class="sidebar" data-color="white" data-active-color="danger">
            @include('sidebarOPR')
        </div>
        <div class="main-panel">
            @include('navbar')

            <div class="content">
                <div class="row">
                    <div class="col-md-12">
                        @if ($unreturnedItemsCount > 0)
                            <div class="alert alert-warning alert-dismissible fade show" role="alert"
                                style="background: linear-gradient(to right, #ffeb3b, #ff9800); color: #ffffff; border: none;">
                                <strong>Pengingat!</strong> Ada <strong>{{ $unreturnedItemsCount }}</strong> barang yang
                                belum dikembalikan.
                                Pastikan untuk segera mengembalikan barang tersebut.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="card-title">Rekap Peminjaman</h4>
                                <a href="{{ route('scan') }}" class="btn btn-primary mr-5">Pinjam Barang</a>
                            </div>
                            <div class="card-body">
                                <form method="GET" action="{{ route('recap') }}" class="mb-4">
                                    <div class="row">
                                        <!-- Filter Tanggal Mulai -->
                                        <div class="col-md-2 mt-3">
                                            <input type="date" name="start_date" class="form-control"
                                                value="{{ request()->input('start_date') }}"
                                                placeholder="Tanggal Mulai">
                                        </div>

                                        <!-- Filter Tanggal Akhir -->
                                        <div class="col-md-2 mt-3">
                                            <input type="date" name="end_date" class="form-control"
                                                value="{{ request()->input('end_date') }}" placeholder="Tanggal Akhir">
                                        </div>

                                        <!-- Filter Pencarian -->
                                        <div class="col-md-3 mt-3">
                                            <input type="text" name="search" class="form-control"
                                                value="{{ request()->input('search') }}"
                                                placeholder="Cari berdasarkan Nama Peminjam atau ID Peminjaman">
                                        </div>

                                        <!-- Filter Status -->
                                        <div class="col-md-3 mt-3">
                                            <select name="status" class="form-control">
                                                <option value="Semua"
                                                    {{ request()->input('status') == 'Semua' ? 'selected' : '' }}>Semua
                                                </option>
                                                <option value="Sedang Dipinjam"
                                                    {{ request()->input('status') == 'Sedang Dipinjam' ? 'selected' : '' }}>
                                                    Sedang Dipinjam</option>
                                                <option value="Dikembalikan"
                                                    {{ request()->input('status') == 'Dikembalikan' ? 'selected' : '' }}>
                                                    Dikembalikan</option>
                                            </select>
                                        </div>

                                        <!-- Tombol Filter -->
                                        <div class="col-md-2">
                                            <button type="submit"
                                                class="btn btn-outline-primary text-primary">Filter</button>
                                        </div>
                                    </div>
                                </form>


                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class="text-primary">
                                            <th class="text-center">No</th>
                                            <th class="text-center">No Peminjaman</th>
                                            <th class="text-center">Nama Peminjam</th>
                                            <th class="text-center">Tanggal Peminjaman</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Aksi</th>
                                        </thead>
                                        <tbody>
                                            @if ($borrows->isNotEmpty())
                                                @foreach ($borrows as $index => $borrow)
                                                    <tr>
                                                        <td class="text-center">{{ $borrows->firstItem() + $index }}
                                                        </td>
                                                        <td class="text-center">{{ $borrow->borrow_id }}</td>
                                                        <td class="text-center">{{ $borrow->borrower_name }}</td>
                                                        <td class="text-center">
                                                            {{ \Carbon\Carbon::parse($borrow->borrow_date)->format('d-m-Y, H:i:s') }}
                                                        </td>
                                                        <td class="text-center">
                                                            <span
                                                                class="badge badge-{{ $borrow->borrowItems->where('status', 'Sedang Dipinjam')->isNotEmpty() ? 'danger' : 'success' }}">
                                                                {{ $borrow->borrowItems->where('status', 'Sedang Dipinjam')->isNotEmpty() ? 'Sedang Dipinjam' : 'Dikembalikan' }}
                                                            </span>
                                                        </td>
                                                        <td class="text-center">
                                                            <a href="{{ route('borrow.details', ['borrowId' => $borrow->borrow_id]) }}"
                                                                class="btn btn-info">Lihat Detail</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="6" class="text-center">Tidak ada data peminjaman.
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Pagination -->
                                <div class="d-flex justify-content-center mt-3">
                                    <!-- Pagination links with Bootstrap pagination style -->
                                    <ul class="pagination">
                                        {{ $borrows->links('pagination::bootstrap-4') }}
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @include('footer')
        </div>
    </div>

    <script src="{{ asset('assets/js/core/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/perfect-scrollbar.jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/paper-dashboard.min.js?v=2.0.1') }}" type="text/javascript"></script>

</body>

</html>
