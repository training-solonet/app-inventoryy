<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Detail Peminjaman</title>
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/paper-dashboard.css?v=2.0.1') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .bg-light-blue {
            background-color: #4a45f7;
        }

        .btn-primary {
            background: linear-gradient(135deg, #000000, #0088ff);
            border: none;
            font-weight: bold;
            transition: all 0.2s ease-in-out;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #3b5998, #192f4d);
            transform: scale(1.05);
        }
    </style>
</head>

<body class="bg-light-blue">
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="text-white">Detail Peminjaman</h4>
            <a href="{{ route('recap') }}" class="btn btn-primary">Kembali ke Rekap</a>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="text-primary">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Nama Barang</th>
                                        <th class="text-center">Tanggal Peminjaman</th>
                                        <th class="text-center">Nama Peminjam</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Tanggal Kembali</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($items->isNotEmpty())
                                        @foreach ($borrow->items as $index => $item)
                                            <tr>
                                                <td class="text-center">{{ $index + 1 }}</td>
                                                <td class="text-center">{{ $item->nama_barang }}</td>
                                                <td class="text-center">
                                                    {{ \Carbon\Carbon::parse($borrow->borrow_date)->format('d-m-Y') }}
                                                </td>
                                                <td class="text-center">{{ $borrow->borrower_name }}</td>
                                                <td class="text-center">
                                                    <span
                                                        class="badge badge-{{ $borrow->status == 'Sedang Dipinjam' ? 'danger' : 'success' }}">
                                                        {{ $borrow->status }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    @if ($borrow->status == 'Sedang Dipinjam')
                                                        <form
                                                            action="{{ route('complete.borrow', ['id' => $borrow->borrow_id]) }}"
                                                            method="POST">
                                                            @csrf
                                                            <button type="submit" class="btn btn-success">Selesai
                                                                Pinjam</button>
                                                        </form>
                                                    @else
                                                        {{ \Carbon\Carbon::parse($borrow->return_date)->format('d-m-Y') }}
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" class="text-center">Tidak ada barang yang dipinjam.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/core/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/perfect-scrollbar.jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/paper-dashboard.min.js?v=2.0.1') }}" type="text/javascript"></script>
</body>

</html>
