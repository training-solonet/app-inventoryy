<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/apple-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Rekap Peminjaman</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Fonts and icons -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <!-- CSS Files -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/paper-dashboard.css?v=2.0.1') }}" rel="stylesheet" />
    <link href="{{ asset('assets/demo/demo.css') }}" rel="stylesheet" />
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="">
    <div class="wrapper">
        <div class="sidebar" data-color="white" data-active-color="danger">
            @include('sidebarOPR')
        </div>
        <div class="main-panel">
            <!-- Navbar -->
            @include('navbar')
            <!-- End Navbar -->

            <div class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="card-title">Rekap Peminjaman</h4>
                                <a href="{{ route('scan') }}" class="btn btn-primary mr-4">Pinjam Barang</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class="text-primary">
                                            <th class="text-center">No</th>
                                            <th class="text-center">Nama Barang</th>
                                            <th class="text-center">Gambar</th>
                                            <th class="text-center">Tanggal Peminjaman</th>
                                            <th class="text-center">Nama Peminjam</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Tanggal Kembali</th>
                                            <th class="text-center">Aksi</th>
                                        </thead>
                                        <tbody>
                                            @if(session('borrows'))
                                                @foreach(session('borrows') as $index => $borrow)
                                                    @php
                                                        $barang = \App\Models\Barang::where('kode_barcode', $borrow->barcode)->first();
                                                    @endphp
                                                    <tr>
                                                        <td class="text-center">{{ $index + 1 }}</td>
                                                        <td class="text-center">{{ $barang ? $barang->nama_barang : 'Tidak Ditemukan' }}</td>
                                                        <td class="text-center">
                                                            @if ($barang && $barang->gambar)
                                                                <img src="{{ asset('images/' . $barang->gambar) }}" alt="{{ $barang->nama_barang }}" style="width: 100px; height: auto;">
                                                            @else
                                                                Tidak Ada Gambar
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            {{ \Carbon\Carbon::parse($borrow->borrow_date)->format('d-m-Y') }}<br>
                                                            <small>{{ \Carbon\Carbon::parse($borrow->borrow_date)->format('H:i:s') }}</small>
                                                        </td>
                                                        <td class="text-center">{{ $borrow->borrower_name }}</td>
                                                        <td class="text-center">
                                                            @if($borrow->status == 'Sedang Dipinjam')
                                                                <span class="badge badge-sm border border-danger text-uppercase text-white bg-danger">{{ $borrow->status }}</span>
                                                            @elseif($borrow->status == 'Dikembalikan')
                                                                <span class="badge badge-sm border border-success text-uppercase text-white bg-success">{{ $borrow->status }}</span>
                                                            @else
                                                                <span class="badge badge-sm border border-secondary text-uppercase text-secondary bg-light">{{ $borrow->status }}</span>
                                                            @endif
                                                        </td>
                                                        <td class="text-center tanggal-kembali">
                                                            @if ($borrow->return_date)
                                                                {{ \Carbon\Carbon::parse($borrow->return_date)->format('d-m-Y') }}<br>
                                                                <small>{{ \Carbon\Carbon::parse($borrow->return_date)->format('H:i:s') }}</small>
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            <button class="btn {{ $borrow->status === 'Dikembalikan' ? 'btn-secondary disabled' : 'btn-success complete-return' }}"
                                                                    data-id="{{ $borrow->id }}">
                                                                {{ $borrow->status === 'Dikembalikan' ? 'Dikembalikan' : 'Selesai Pinjam' }}
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="8" class="text-center">Tidak ada data peminjaman.</td>
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

            <!-- Footer -->
            @include('footer')
        </div>
    </div>

    <!-- Core JS Files -->
    <script src="{{ asset('assets/js/core/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/perfect-scrollbar.jquery.min.js') }}"></script>
    <!-- Optional JS -->
    <script src="{{ asset('assets/js/plugins/chartjs.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap-notify.js') }}"></script>
    <!-- Paper Dashboard Main JS -->
    <script src="{{ asset('assets/js/paper-dashboard.min.js?v=2.0.1') }}" type="text/javascript"></script>
    <!-- Custom JS for Demo -->
    <script src="{{ asset('assets/demo/demo.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('.complete-return').on('click', function() {
                var borrowId = $(this).data('id'); // Ambil ID dari button
                $.ajax({
                    url: "{{ route('complete.borrow', ':id') }}".replace(':id', borrowId), // Ganti borrowId dengan ID yang sesuai
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content') // Ambil CSRF token
                    },
                    success: function(response) {
                        // Menampilkan SweetAlert2 dengan informasi tanggal kembali
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Tanggal kembali telah diperbarui: ' + response.return_date,
                            confirmButtonText: 'OK'
                        });

                        // Update tabel dengan tanggal kembali di kolom yang sesuai
                        const returnDateHtml = response.return_date.split(' ').join('<br><small>'); // Pisahkan tanggal dan waktu
                        returnDateHtml = returnDateHtml.replace(' ', '</small>'); // Ubah spasi pertama menjadi <small>

                        // Update tampilan tanggal kembali
                        $('tr').find(`button[data-id="${borrowId}"]`).closest('tr').find('td.tanggal-kembali').html(returnDateHtml);

                        // Update status menjadi 'Dikembalikan'
                        $('tr').find(`button[data-id="${borrowId}"]`).closest('tr').find('span.status-borrow').html('Dikembalikan');

                        // Ubah tombol "Selesai Pinjam" menjadi tidak aktif
                        var button = $('tr').find(`button[data-id="${borrowId}"]`);
                        button.removeClass('btn-success').addClass('btn-secondary disabled'); // Mengganti kelas tombol
                        button.text('Dikembalikan'); // Mengubah teks tombol
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText); // Lihat respons kesalahan
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            text: 'Kesalahan: ' + xhr.responseText,
                            confirmButtonText: 'Tutup'
                        });
                    }
                });
            });
        });
        </script>



</body>

</html>
