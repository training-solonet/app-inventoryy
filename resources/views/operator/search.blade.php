<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Search Peminjaman</title>
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
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="card-title">Pencarian Barang Dipinjam</h4>
                            </div>
                            <div class="card-body">
                                <form method="GET" action="{{ route('search') }}" class="mb-4">
                                    <div class="row">
                                        <!-- Filter Tanggal Mulai -->
                                        <div class="col-md-3 mt-3">
                                            <input type="date" name="start_date" class="form-control" value=""
                                                placeholder="Tanggal Mulai">
                                        </div>

                                        <!-- Filter Tanggal Akhir -->
                                        <div class="col-md-3 mt-3">
                                            <input type="date" name="end_date" class="form-control" value=""
                                                placeholder="Tanggal Akhir">
                                        </div>

                                        <!-- Filter Pencarian -->
                                        <div class="col-md-4 mt-3">
                                            <input type="text" name="search" class="form-control" value=""
                                                placeholder="Cari berdasarkan Nama Peminjam atau ID Peminjaman atau Nama Barang / Kode Barcode">
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
                                            <th class="text-center">Nama Barang</th>
                                            <th class="text-center">Gambar</th>
                                            <th class="text-center">Barcode</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Nama Peminjam</th>
                                            <th class="text-center">Tanggal Peminjaman</th>
                                            <th class="text-center">Tanggal Kembali</th>
                                        </thead>
                                        <tbody>
                                            @forelse ($borrows as $borrow)
                                                @foreach ($borrow->borrowItems as $index => $borrowItem)
                                                    <tr>
                                                        <td class="text-center">
                                                            {{ $borrowItem->barang->nama_barang ?? 'N/A' }}</td>
                                                        <td class="text-center">
                                                            <img src="{{ asset('images/' . $borrowItem->barang->gambar) }}"
                                                                alt="Gambar" style="width: 50px;">
                                                        </td>
                                                        <td class="text-center">{{ $borrowItem->barcode }}</td>
                                                        <td class="text-center">
                                                            @if ($borrowItem->status === 'Sedang Dipinjam')
                                                                <span class="badge bg-danger text-white">Sedang Dipinjam</span>
                                                            @elseif ($borrowItem->status === 'Dikembalikan')
                                                                <span class="badge bg-success text-white">Dikembalikan</span>
                                                            @else
                                                                <span class="badge bg-secondary text-white">N/A</span>
                                                            @endif
                                                        </td>

                                                        <td class="text-center">{{ $borrow->borrower_name ?? 'N/A' }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ \Carbon\Carbon::parse($borrow->borrow_date)->format('d-m-Y') ?? 'N/A' }}<br>
                                                            {{ \Carbon\Carbon::parse($borrow->borrow_date)->format('H:i') ?? 'N/A' }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $borrowItem->return_date ? \Carbon\Carbon::parse($borrowItem->return_date)->format('d-m-Y') : '-' }}<br>
                                                            {{ $borrowItem->return_date ? \Carbon\Carbon::parse($borrowItem->return_date)->format('H:i') : '' }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @empty
                                                <tr>
                                                    <td colspan="7" class="text-center">Tidak ada data peminjaman
                                                        yang ditemukan.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

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


    <script>
        $(document).ready(function () {
            // Ambil CSRF Token
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Fungsi untuk menjalankan pencarian
            function fetchBorrows() {
                let search = $('input[name="search"]').val();
                let start_date = $('input[name="start_date"]').val();
                let end_date = $('input[name="end_date"]').val();

                $.ajax({
                    url: "{{ route('search') }}",
                    method: "GET",
                    data: {
                        search: search,
                        start_date: start_date,
                        end_date: end_date
                    },
                    success: function (data) {
                        $('tbody').html(data);
                    },
                    error: function () {
                        Swal.fire("Error", "Gagal memuat data.", "error");
                    }
                });
            }

            // Jalankan pencarian saat mengetik atau mengubah filter
            $('input[name="search"], input[name="start_date"], input[name="end_date"]').on('keyup change', function () {
                fetchBorrows();
            });
        });
    </script>




</body>

</html>
