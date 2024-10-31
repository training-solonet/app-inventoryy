<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>
        Barang
    </title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
        name='viewport' />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <!-- CSS Files -->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../assets/css/paper-dashboard.css?v=2.0.1" rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="../assets/demo/demo.css" rel="stylesheet" />

    <style>
        table td, table th {
            padding: 10px 15px; /* Tambahkan padding sesuai kebutuhan */
        }
    </style>
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
                                <h4 class="card-title">Data Barang</h4>
                                <button type="button" class="btn btn-primary mr-4" data-toggle="modal" data-target="#addBarangModal">
                                    <i class="nc-icon nc-simple-add"></i>
                                    &nbsp; Tambah Barang
                                </button>
                            </div>
                            <div class="card-body">
                                @if(session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class=" text-primary">
                                            <th class="text-center">No</th>
                                            <th class="text-center">Nama Barang</th>
                                            <th class="text-center">Gambar</th>
                                            <th class="text-center">Kondisi</th>
                                            <th class="text-center">Jenis</th>
                                            <th class="text-center">Aksi</th>
                                        </thead>
                                        <tbody>
                                            @foreach ($barangs as $index => $barang)
                                            <tr>
                                                <td class="text-center">{{ $index + 1 }}</td>
                                                <td class="text-center">{{ $barang->nama_barang }}</td>
                                                <td class="text-center">
                                                    @if ($barang->gambar)
                                                        <img src="{{ asset('images/' . $barang->gambar) }}" alt="{{ $barang->nama_barang }}" style="width: 100px; height: auto;">
                                                    @else
                                                        Tidak Ada Gambar
                                                    @endif
                                                </td>
                                                <td class="text-center">{{ $barang->kondisi }}</td>
                                                <td class="text-center">{{ $barang->jenis }}</td>
                                                <td class="text-center">
                                                    <a href="#" class="btn btn-info btn-sm" title="Detail" data-toggle="modal" data-target="#detailBarangModal"
                                                    data-nama="{{ $barang->nama_barang }}"
                                                    data-barcode="{{ $barang->barcode }}"
                                                    data-kondisi="{{ $barang->kondisi }}"
                                                    data-jenis="{{ $barang->jenis }}"
                                                    data-gambar="{{ asset('images/' . $barang->gambar) }}"
                                                    data-deskripsi="{{ $barang->deskripsi ?? 'Tidak ada deskripsi' }}">
                                                        <i class="fa fa-eye"></i>
                                                    </a>

                                                    <a href="#" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editBarangModal{{ $barang->id }}" title="Edit">
                                                        <i class="fa fa-edit"></i>
                                                    </a>

                                                    <form action="{{ route('barang.destroy', 1) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this item?');" title="Delete">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Tambah Barang -->
            <div class="modal fade" id="addBarangModal" tabindex="-1" role="dialog" aria-labelledby="addBarangModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <h5 class="modal-title" id="addBarangModalLabel">Tambah Barang</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('barang.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="nama_barang">Nama Barang</label>
                                    <input type="text" class="form-control" id="nama_barang" name="nama_barang" required>
                                </div>
                                <div class="form-group">
                                    <label for="barcode">Barcode</label>
                                    <input type="text" class="form-control" id="barcode" name="barcode" required>
                                </div>
                                <div class="form-group">
                                    <label for="kondisi">Kondisi</label>
                                    <input type="text" class="form-control" id="kondisi" name="kondisi" required>
                                </div>
                                <div class="form-group">
                                    <label for="jenis">Jenis</label>
                                    <select class="form-control" id="jenis" name="jenis" required>
                                        <option value="">Pilih Jenis</option>
                                        <option value="properti">Properti</option>
                                        <option value="perkakas">Perkakas</option>
                                    </select>
                                </div>
                                <div class="form-group-file">
                                    <label for="gambar">Gambar</label>
                                    <input type="file" class="form-control-file" id="gambar" name="gambar" accept="image/*" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Tambah</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            <!-- Modal Edit Barang -->
            @foreach ($barangs as $barang)
            <div class="modal fade" id="editBarangModal{{ $barang->id }}" tabindex="-1" role="dialog" aria-labelledby="editBarangModalLabel" aria-hidden="true">
                <div class="modal-dialog " role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-warning">
                            <h5 class="modal-title" id="editBarangModalLabel">Edit Barang</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('barang.update', $barang->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="nama_barang">Nama Barang</label>
                                    <input type="text" class="form-control" id="nama_barang" name="nama_barang" value="{{ $barang->nama_barang }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="kondisi">Kondisi</label>
                                    <input type="text" class="form-control" id="kondisi" name="kondisi" value="{{ $barang->kondisi }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="jenis">Jenis</label>
                                    <select class="form-control" id="jenis" name="jenis" required>
                                        <option value="properti" {{ $barang->jenis == 'properti' ? 'selected' : '' }}>Properti</option>
                                        <option value="perkakas" {{ $barang->jenis == 'perkakas' ? 'selected' : '' }}>Perkakas</option>
                                    </select>
                                </div>
                                <div class="form-group-file">
                                    <label for="gambar">Gambar</label><br>
                                    @if ($barang->gambar)
                                        <img src="{{ asset('images/' . $barang->gambar) }}" alt="{{ $barang->nama_barang }}" style="width: 100px; height: auto;"><br>
                                    @endif
                                    <input type="file" class="form-control-file mt-2" id="gambar" name="gambar" accept="image/*">
                                    <small>*Unggah jika ingin mengganti gambar</small>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-warning">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach

            <!-- Modal Detail Barang -->
            <div class="modal fade" id="detailBarangModal" tabindex="-1" role="dialog" aria-labelledby="detailBarangModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="detailBarangModalLabel"><strong>Detail Barang</strong></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="text-center">
                                <img id="barangImage" src="" alt="Gambar Barang" class="img-fluid" style="max-height: 200px;">
                            </div>
                            <div class="mt-3">
                                <p><strong>Nama Barang:</strong> <span id="barangNama"></span></p>
                                <p><strong>Barcode:</strong> <span id="barangBarcode"></span></p>
                                <p><strong>Kondisi:</strong> <span id="barangKondisi"></span></p>
                                <p><strong>Jenis:</strong> <span id="barangJenis"></span></p>
                                <p><strong>Deskripsi:</strong> <span id="barangDeskripsi"></span></p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
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

    <script>
        $(document).on('click', '[data-toggle="modal"][data-target="#detailBarangModal"]', function () {
            $('#barangNama').text($(this).data('nama'));
            $('#barangBarcode').text($(this).data('barcode'));
            $('#barangKondisi').text($(this).data('kondisi'));
            $('#barangJenis').text($(this).data('jenis'));
            $('#barangImage').attr('src', $(this).data('gambar'));
            $('#barangDeskripsi').text($(this).data('deskripsi'));
        });
    </script>




</body>

</html>
