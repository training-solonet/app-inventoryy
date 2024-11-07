
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    Peminjaman
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
  <!-- CSS Files -->
  <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="../assets/css/paper-dashboard.css?v=2.0.1" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="../assets/demo/demo.css" rel="stylesheet" />
</head>

<body class="">
  <div class="wrapper ">
    <div class="sidebar" data-color="white" data-active-color="danger">


      @include('sidebar')

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

      {{-- footer --}}
      @include('footer')
    </div>
  </div>
  <!--   Core JS Files   -->
  <script src="../assets/js/core/jquery.min.js"></script>
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <!--  Google Maps Plugin    -->
  <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
  <!-- Chart JS -->
  <script src="../assets/js/plugins/chartjs.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="../assets/js/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/paper-dashboard.min.js?v=2.0.1" type="text/javascript"></script><!-- Paper Dashboard DEMO methods, don't include it in your project! -->
  <script src="../assets/demo/demo.js"></script>
</body>

</html>
