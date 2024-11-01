petugas blade:
a<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Peminjaman</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../assets/css/paper-dashboard.css?v=2.0.1" rel="stylesheet" />
    <link href="../assets/demo/demo.css" rel="stylesheet" />
</head>

<body>
    <div class="wrapper">
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
                                <h4 class="card-title">Data Petugas</h4>
                                <button type="button" class="btn btn-primary mr-4" data-toggle="modal" data-target="#addPetugasModal">
                                    <i class="nc-icon nc-simple-add"></i>
                                    &nbsp; Tambah Petugas
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class=" text-primary">
                                            <th class="text-center">No</th>
                                            <th class="text-center">Nama Petugas</th>
                                            <th class="text-center">Username</th>
                                            <th class="text-center">Password</th>
                                            <th class="text-center">Sebagai</th>
                                            <th class="text-center">Aksi</th>
                                        </thead>
                                        <tbody>
                                            @foreach($petugas as $key => $item)
                                            <tr>
                                                <td class="text-center">{{ $key + 1 }}</td>
                                                <td class="text-center">{{ $item->name }}</td>
                                                <td class="text-center">{{ $item->username }}</td>
                                                <td class="text-center">{{ $item->password }}</td>
                                                <td class="text-center">{{ $item->level }}</td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-info btn-sm" title="View">
                                                        <i class="fa fa-eye"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editPetugasModal{{ $item->id }}" title="Edit">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                    <form action="{{ route('petugas.destroy', $item->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this item?');" title="Delete">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>

                                            {{-- Modal Edit Petugas --}}
                                            <div class="modal fade" id="editPetugasModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="editPetugasModalLabel{{ $item->id }}" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editPetugasModalLabel{{ $item->id }}">Edit Petugas</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form action="{{ route('petugas.update', $item->id) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <label for="edit_nama_petugas">Nama Petugas</label>
                                                                    <input type="text" class="form-control" id="edit_nama_petugas" name="nama_petugas" value="{{ $item->name }}" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="edit_username">Username</label>
                                                                    <input type="text" class="form-control" id="edit_username" name="username" value="{{ $item->username }}" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="edit_password">Password</label>
                                                                    <input type="password" class="form-control" id="edit_password" name="password">
                                                                    <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah password.</small>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="edit_level">Sebagai</label>
                                                                    <select class="form-control" id="edit_level" name="level" required>
                                                                        <option value="operator" {{ $item->level == 'operator' ? 'selected' : '' }}>Operator</option>
                                                                        <option value="admin" {{ $item->level == 'admin' ? 'selected' : '' }}>Admin</option>
                                                                        <option value="supervisor" {{ $item->level == 'supervisor' ? 'selected' : '' }}>Supervisor</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                                <button type="submit" class="btn btn-warning">Simpan</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Modal Tambah Petugas --}}
            <div class="modal fade" id="addPetugasModal" tabindex="-1" role="dialog" aria-labelledby="addPetugasModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addPetugasModalLabel">Tambah Petugas</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('petugas.store') }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="nama_petugas">Nama Petugas</label>
                                    <input type="text" class="form-control" id="nama_petugas" name="nama_petugas" required>
                                </div>
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" required>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                                <div class="form-group">
                                    <label for="level">Sebagai</label>
                                    <select class="form-control" id="level" name="level" required>
                                        <option value="">Pilih Level</option>
                                        <option value="operator">Operator</option>
                                        <option value="admin">Admin</option>
                                        <option value="supervisor">Supervisor</option>
                                    </select>
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

            @include('footer')
        </div>
    </div>

    <script src="../assets/js/core/jquery.min.js"></script>
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>
    <script src="../assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
    <script src="../assets/js/paper-dashboard.min.js?v=2.0.1" type="text/javascript"></script>
</body>

</html>
