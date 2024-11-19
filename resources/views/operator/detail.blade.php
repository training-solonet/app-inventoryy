<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Detail Peminjaman</title>
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/paper-dashboard.css?v=2.0.1') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #0c00ad;
        }

        .table-responsive {
            width: 100%;
        }

        .table {
            width: 100% !important;
            table-layout: fixed;
        }

        .table th,
        .table td {
            padding: 12px;
            font-size: 16px;
        }

        .table th {
            text-align: center;
            font-weight: 600;
            /* Lebih tebal untuk header */
        }

        .table td {
            text-align: center;
            font-weight: 400;
            /* Regular untuk konten */
        }
    </style>
</head>

<body>
    <div class="container col-md-10 mt-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Detail Peminjaman - {{ $borrow->borrow_id }}</h4>
                <a href="{{ route('recap') }}" class="btn btn-primary">Kembali Ke Recap</a>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p><strong>Nama Peminjam:</strong> {{ $borrow->borrower_name }}</p>
                        <p><strong>Tanggal Peminjaman:</strong>
                            {{ \Carbon\Carbon::parse($borrow->borrow_date)->format('d-m-Y') }}</p>
                    </div>
                    <div class="col-md-6">
                    </div>
                </div>

                <h5>Daftar Barang yang Dipinjam:</h5>
                <div class="table-responsive">
                    <table class="table">
                        <thead class="text-primary">
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Nama Barang</th>
                                <th class="text-center">Gambar</th>
                                <th class="text-center">Kondisi</th>
                                <th class="text-center">Barcode</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Tanggal Kembali</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($borrow)
                                @if ($borrow->borrowItems && $borrow->borrowItems->isNotEmpty())
                                    @foreach ($borrow->borrowItems as $index => $borrowItem)
                                        <tr>
                                            <td class="text-center">{{ $index + 1 }}</td>
                                            <td class="text-center">{{ $borrowItem->barang->nama_barang }}</td>
                                            <td class="text-center">
                                                <img src="{{ asset('images/' . $borrowItem->barang->gambar) }}"
                                                    alt="Gambar Barang" width="50">
                                            </td>
                                            <td class="text-center">
                                                <span class="badge {{ $borrowItem->kondisi == 'Rusak' ? 'badge-danger' : 'badge-success' }} px-2 py-1 font-weight-semibold" style="font-size: 0.95em;">
                                                    {{ $borrowItem->kondisi }}
                                                </span>
                                            </td>

                                            <td class="text-center">{{ $borrowItem->barcode }}</td>
                                            <td class="text-center">
                                                <span
                                                    class="badge badge-{{ $borrowItem->status == 'Sedang Dipinjam' ? 'danger' : 'success' }}">
                                                    {{ $borrowItem->status }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                {{ $borrowItem->return_date ? \Carbon\Carbon::parse($borrowItem->return_date)->format('d-m-Y, H:i:s') : '-' }}
                                            </td>
                                            <td class="text-center">
                                                @if ($borrowItem->status == 'Sedang Dipinjam')
                                                    <button type="button" class="btn btn-success btn-sm"
                                                        onclick="returnItem({{ $borrowItem->id }})">
                                                        Kembalikan
                                                    </button>
                                                @else
                                                    <span class="text-success">Sudah Dikembalikan</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="8" class="text-center">Tidak ada barang yang dipinjam.</td>
                                    </tr>
                                @endif
                            @else
                                <tr>
                                    <td colspan="8" class="text-center">Peminjaman tidak ditemukan.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/core/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/perfect-scrollbar.jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/paper-dashboard.min.js?v=2.0.1') }}" type="text/javascript"></script>

    <script>
        function returnItem(itemId) {
            Swal.fire({
                title: 'Apakah barang ini dikembalikan dengan kondisi?',
                input: 'select',
                inputOptions: {
                    'Baik': 'Baik',
                    'Rusak': 'Rusak'
                },
                inputPlaceholder: 'Pilih kondisi',
                showCancelButton: true,
                confirmButtonText: 'Lanjut',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    const condition = result.value;
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: `Barang akan dikembalikan dengan kondisi ${condition}.`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Kembalikan!',
                        cancelButtonText: 'Batal'
                    }).then((confirmResult) => {
                        if (confirmResult.isConfirmed) {
                            const form = document.createElement('form');
                            form.action = `/borrow/${itemId}/return`;
                            form.method = 'POST';

                            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
                            const csrfInput = document.createElement('input');
                            csrfInput.type = 'hidden';
                            csrfInput.name = '_token';
                            csrfInput.value = csrfToken;
                            form.appendChild(csrfInput);

                            const methodInput = document.createElement('input');
                            methodInput.type = 'hidden';
                            methodInput.name = '_method';
                            methodInput.value = 'PATCH';
                            form.appendChild(methodInput);

                            const conditionInput = document.createElement('input');
                            conditionInput.type = 'hidden';
                            conditionInput.name = 'condition';
                            conditionInput.value = condition;
                            form.appendChild(conditionInput);

                            document.body.appendChild(form);
                            form.submit();
                        }
                    });
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#3085d6'
                });
            @endif
        });
    </script>

</body>

</html>
