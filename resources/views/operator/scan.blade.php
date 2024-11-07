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
  <meta name="csrf-token" content="{{ csrf_token() }}">
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
                    <div class="card-header">
                        <h4 class="card-title">Peminjaman</h4>
                    </div>
                    <div class="card-body">
                        <form id="borrowForm" action="{{ route('process.borrow') }}" method="POST" class="row">
                            @csrf
                            <div class="col-md-6 mb-3">
                                <label for="barcode" class="form-label">Scan Barcode:</label>
                                <input type="text" id="barcode" name="barcode" class="form-control" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="borrow_date" class="form-label">Tanggal Peminjaman:</label>
                                <input type="datetime-local" id="borrow_date" name="borrow_date" class="form-control" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="borrower_name" class="form-label">Nama Peminjam:</label>
                                <input type="text" id="borrower_name" name="borrower_name" class="form-control" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <button type="submit" class="btn btn-primary">Proses Peminjaman</button>
                            </div>
                        </form>
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
  <script src="../assets/js/paper-dashboard.min.js?v=2.0.1" type="text/javascript"></script>
  <!-- Paper Dashboard DEMO methods, don't include it in your project! -->
  <script src="../assets/demo/demo.js"></script>

  <script>
    // Memastikan input barcode selalu terfokus
    document.getElementById('barcode').focus();

    // Menangani input dari scanner barcode
    document.getElementById('barcode').addEventListener('input', function() {
      this.value = this.value.trim(); // Menghapus spasi yang tidak perlu
    });
  </script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('borrowForm').addEventListener('submit', function (e) {
        e.preventDefault(); // Mencegah submit default
        const form = this;
        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            // Pastikan respons adalah JSON
            if (!response.ok) {
                return response.json().then(errData => {
                    throw new Error(errData.message || 'Kesalahan pada server.');
                });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Peminjaman berhasil
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Peminjaman barang berhasil disimpan!',
                }).then(() => {
                    window.location.href = data.redirect_url; // Arahkan ke halaman recap
                });
            } else {
                // Menangani kasus jika barang sedang dipinjam
                Swal.fire({
                    icon: data.message === 'Barang Sedang Dipinjam' ? 'warning' : 'error',
                    title: data.message === 'Barang Sedang Dipinjam' ? 'Perhatian' : 'Gagal',
                    text: data.message || 'Terjadi kesalahan, coba lagi nanti.',
                });
            }
        })
        .catch(error => {
            console.error('Error:', error); // Debug di konsol
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: error.message || 'Terjadi kesalahan',
            });
        });
    });
</script>




</body>

</html>

