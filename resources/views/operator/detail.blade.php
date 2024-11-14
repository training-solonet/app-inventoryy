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
    <!-- resources/views/operator/detail.blade.php -->
    <div class="container mt-4">
        <h2>Detail Peminjaman - {{ $borrow->borrow_id }}</h2>
        <p><strong>Nama Peminjam:</strong> {{ $borrow->borrower_name }}</p>
        <p><strong>Status:</strong> {{ $borrow->status }}</p>
        <p><strong>Tanggal Peminjaman:</strong> {{ \Carbon\Carbon::parse($borrow->borrow_date)->format('d-m-Y') }}</p>
        <p><strong>Tanggal Kembali:</strong>
            {{ $borrow->return_date ? \Carbon\Carbon::parse($borrow->return_date)->format('d-m-Y') : 'Belum Kembali' }}
        </p>

        <h4>Daftar Barang yang Dipinjam:</h4>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Nama Barang</th>
                        <th class="text-center">Kode Barcode</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($borrow->borrowItems as $index => $borrowItem)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td class="text-center">{{ $borrowItem->barang->nama_barang }}</td>
                            <td class="text-center">{{ $borrowItem->barang->kode_barcode }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>




    <script src="{{ asset('assets/js/core/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/perfect-scrollbar.jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/paper-dashboard.min.js?v=2.0.1') }}" type="text/javascript"></script>
</body>

</html>
