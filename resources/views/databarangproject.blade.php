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
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../assets/css/paper-dashboard.css?v=2.0.1" rel="stylesheet" />
    <link href="../assets/demo/demo.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        table td,
        table th {
            padding: 10px 15px;
        }

        .btn:hover {
            transform: scale(1.01);
            transition: transform 0.2s;
        }
    </style>
</head>

<body class="">
    <div class="wrapper ">
        <div class="sidebar" data-color="white" data-active-color="danger">
            @include('sidebar')
        </div>
        <div class="main-panel">
            @include('navbar')
            <div class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="card-title">Data Barang</h4>
                                <button type="button" class="btn btn-primary mr-4" data-toggle="modal"
                                    data-target="#addBarangModal">
                                    <i class="nc-icon nc-simple-add"></i>
                                    &nbsp; Tambah Barang
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="input-group no-border">
                                    <input type="text" id="searchInput" class="form-control"
                                        placeholder="Cari berdasarkan nama, kondisi, atau jenis...">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <i class="nc-icon nc-zoom-split"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table" id="barangTable">
                                        <thead class="text-primary">
                                            <th class="text-center">No</th>
                                            <th class="text-center">Nama Barang</th>
                                            <th class="text-center">Gambar</th>
                                            <th class="text-center">Kondisi</th>
                                            <th class="text-center">Quantity</th>
                                            <th class="text-center">Aksi</th>
                                        </thead>
                                        <tbody>
                                            @foreach ($barangProjects as $index => $barang)
                                                <tr>
                                                    <td class="text-center">{{ $index + 1 }}</td>
                                                    <td class="text-center">{{ $barang->nama_barang }}</td>
                                                    <td class="text-center"><img
                                                            src="{{ asset('storage/' . $barang->gambar) }}"
                                                            width="100" height="100"></td>
                                                    <td class="text-center">{{ $barang->kondisi }}</td>
                                                    <td class="text-center">{{ $barang->qty }}</td>
                                                    <td class="text-center">
                                                        <a href="#" class="btn btn-warning" data-toggle="modal"
                                                            data-target="#editBarangModal{{ $barang->id }}">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </a>
                                                        <!-- Tombol hapus barang -->
                                                        <form
                                                            action="{{ route('barang-project.destroy', $barang->id) }}"
                                                            method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger"
                                                                onclick="return confirm('Apakah Anda yakin ingin menghapus barang ini?')">
                                                                <i class="fas fa-trash"></i> Hapus
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
        </div>
    </div>

    <!-- Modal Add Barang -->
    <div class="modal fade" id="addBarangModal" tabindex="-1" role="dialog" aria-labelledby="addBarangModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addBarangModalLabel">Tambah Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('barang-project.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="kode_barcode">Kode Barcode</label>
                            <input type="text" class="form-control" id="kode_barcode" name="kode_barcode"
                                placeholder="Masukkan kode barcode" required>
                        </div>
                        <div class="form-group">
                            <label for="nama_barang">Nama Barang</label>
                            <input type="text" class="form-control" id="nama_barang" name="nama_barang" placeholder="Masukkan nama barang" required>
                        </div>
                        <div class="form-group">
                            <label for="kondisi">Kondisi Barang</label>
                            <select class="form-control" id="kondisi" name="kondisi" required>
                                <option value="Baik">Baik</option>
                                <option value="Rusak">Rusak</option>
                                <option value="Perlu Perbaikan">Perlu Perbaikan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="qty">Quantity Barang</label>
                            <input type="number" class="form-control" id="qty" name="qty"
                            placeholder="Masukkan jumlah barang" required>
                        </div>
                        <div class="form-group-file">
                            <label for="gambar">Gambar Barang</label>
                            <input type="file" class="form-control-file" id="gambar" name="gambar" accept="image/*" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan Barang</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Modal Edit Barang -->
    @foreach ($barangProjects as $barang)
        <div class="modal fade" id="editBarangModal{{ $barang->id }}" tabindex="-1" role="dialog"
            aria-labelledby="editBarangModalLabel{{ $barang->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editBarangModalLabel{{ $barang->id }}">Edit Barang</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('barang-project.update', $barang->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="nama_barang">Nama Barang</label>
                                <input type="text" class="form-control" name="nama_barang"
                                    value="{{ $barang->nama_barang }}" required>
                            </div>
                            <div class="form-group">
                                <label for="gambar">Gambar Barang</label>
                                <input type="file" class="form-control" name="gambar" accept="image/*">
                                <img src="{{ asset('storage/' . $barang->gambar) }}" alt="Gambar Barang"
                                    width="100" class="mt-2">
                            </div>
                            <div class="form-group">
                                <label for="kondisi">Kondisi Barang</label>
                                <select class="form-control" name="kondisi" required>
                                    <option value="Baik" {{ $barang->kondisi == 'Baik' ? 'selected' : '' }}>Baik
                                    </option>
                                    <option value="Rusak" {{ $barang->kondisi == 'Rusak' ? 'selected' : '' }}>Rusak
                                    </option>
                                    <option value="Perlu Perbaikan"
                                        {{ $barang->kondisi == 'Perlu Perbaikan' ? 'selected' : '' }}>Perlu Perbaikan
                                    </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="qty">Quantity</label>
                                <input type="number" class="form-control" name="qty"
                                    value="{{ $barang->qty }}" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    <!-- SweetAlert Success and Error Alerts -->
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Sukses',
                text: '{{ session('success') }}',
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Terjadi Kesalahan',
                text: '{{ session('error') }}',
            });
        </script>
    @endif

    <script>
        function showLoading() {
            Swal.fire({
                title: 'Memproses...',
                text: 'Harap tunggu sebentar',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading()
                }
            });
        }
    </script>


    <!-- Scripts -->
    <script src="../assets/js/core/jquery.min.js"></script>
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>
    <script src="../assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
    <script src="../assets/js/paper-dashboard.js?v=2.0.1" type="text/javascript"></script>

</body>

</html>
