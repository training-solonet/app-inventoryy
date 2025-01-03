<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Peminjaman</title>
    <meta name='viewport'
        content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' />
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../assets/css/paper-dashboard.css?v=2.0.1" rel="stylesheet" />
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
                            <div class="card-header text-center">
                                <h4 class="card-title">Peminjaman</h4>
                            </div>
                            <div class="card-body">
                                <!-- Borrowing Form -->
                                <form id="borrowForm" action="{{ route('process.borrow') }}" method="POST"
                                    onsubmit="processBorrow(event)">
                                    @csrf
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label for="borrow_id" class="form-label">No Peminjaman:</label>
                                            <input type="text" id="borrow_id" name="borrow_id" class="form-control"
                                                value="{{ $borrowId ?? 'BORROW0001' }}" readonly required>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="borrower_name" class="form-label">Nama Peminjam:</label>
                                            <input type="text" id="borrower_name" name="borrower_name"
                                                class="form-control" required>
                                        </div>
                                        <!-- Tanggal Peminjaman (default ke tanggal hari ini) -->
                                        <div class="col-md-4">
                                            <label for="borrow_date" class="form-label">Tanggal Peminjaman:</label>
                                            <input type="datetime-local" id="borrow_date" name="borrow_date" class="form-control" required>
                                        </div>

                                    </div>
                                    <input type="hidden" id="cartData" name="cartData">

                                    <!-- Cart Table -->
                                    <div class="table-responsive mt-4">
                                        <table class="table table-borderless text-center">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Barang</th>
                                                    <th>Gambar</th>
                                                    <th>Kondisi</th>
                                                    <th>Barcode</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody id="cartTableBody">
                                                <!-- Table rows will be added dynamically -->
                                            </tbody>
                                        </table>
                                    </div>


                                    <!-- Proses Peminjaman Button -->
                                    <button type="submit" class="btn btn-success mt-3">Proses Peminjaman</button>
                                </form>

                                <!-- Barcode Input and Add-to-Cart Button -->
                                <!-- Barcode Input (tanpa tombol) -->
                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <label for="barcode" class="form-label">Cari Barang (Scan Barcode):</label>
                                    <input type="text" id="barcode" class="form-control" placeholder="Masukkan barcode">
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

    <!-- Include jQuery, Bootstrap, SweetAlert -->
    <script src="../assets/js/core/jquery.min.js"></script>
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
let cartData = [];
let inputDelay;

// Menggunakan event 'input' pada elemen barcode
document.getElementById('barcode').addEventListener('input', function () {
    const barcodeInput = this;
    const barcode = barcodeInput.value.trim();

    // Pastikan hanya memproses barcode jika ada input
    if (inputDelay) clearTimeout(inputDelay);

    inputDelay = setTimeout(() => {
        if (barcode) {
            const itemExists = cartData.find(item => item.barcode === barcode);
            if (!itemExists) {
                fetch(`/get-item-details/${barcode}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            Swal.fire('Error', 'Barang tidak ditemukan.', 'error');
                        } else {
                            // Cek kondisi barang
                            if (data.condition === 'Rusak' || data.condition === 'Hilang') {
                                Swal.fire(
                                    'Error',
                                    `Barang dengan kondisi ${data.condition} tidak dapat ditambahkan ke keranjang.`,
                                    'error'
                                );
                            } else {
                                // Tambahkan barang ke keranjang
                                cartData.push({
                                    barcode: data.barcode,
                                    name: data.name,
                                    image: data.image,
                                    condition: data.condition
                                });
                                updateCartTable();
                                barcodeInput.value = ''; // Bersihkan input barcode setelah ditambahkan
                                Swal.fire('Success', 'Barang ditambahkan ke keranjang!', 'success');
                            }
                        }
                    })
                    .catch(error => Swal.fire('Error', 'Terjadi kesalahan saat mencari barang.', 'error'));
            } else {
                Swal.fire('Warning', 'Barang sudah ada di keranjang!', 'warning');
            }
        }
    }, 500); // Delay 500ms sebelum memproses
});


// Fungsi untuk memperbarui tabel keranjang
function updateCartTable() {
    const cartTableBody = document.getElementById('cartTableBody');
    cartTableBody.innerHTML = '';
    cartData.forEach((item, index) => {
        const row = `<tr>
            <td>${index + 1}</td>
            <td>${item.name}</td>
            <td><img src="${item.image}" alt="Gambar Barang" style="width:50px;height:50px;"></td>
            <td>${item.condition}</td>
            <td>${item.barcode}</td>
            <td><button type="button" class="btn btn-danger btn-sm" onclick="removeFromCart('${item.barcode}')">Hapus</button></td>
        </tr>`;
        cartTableBody.insertAdjacentHTML('beforeend', row);
    });
    document.getElementById('cartData').value = JSON.stringify(cartData); // Update cart data hidden input
}

// Fungsi untuk menghapus barang dari keranjang
function removeFromCart(barcode) {
    cartData = cartData.filter(item => item.barcode !== barcode);
    updateCartTable();
    Swal.fire('Success', 'Barang dihapus dari keranjang!', 'success');
}

// Set default date to today
document.addEventListener('DOMContentLoaded', function () {
    const borrowDateInput = document.getElementById('borrow_date');
    
    // Mendapatkan tanggal hari ini dalam format yang sesuai untuk input datetime-local (yyyy-mm-ddThh:mm)
    const today = new Date();
    const year = today.getFullYear();
    const month = String(today.getMonth() + 1).padStart(2, '0');
    const day = String(today.getDate()).padStart(2, '0');
    const hours = String(today.getHours()).padStart(2, '0');
    const minutes = String(today.getMinutes()).padStart(2, '0');
    
    const defaultDate = `${year}-${month}-${day}T${hours}:${minutes}`;
    
    // Menetapkan nilai default pada input tanggal
    borrowDateInput.value = defaultDate;
});

    </script>

</body>

</html>
