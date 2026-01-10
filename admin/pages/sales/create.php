<?php
// Function untuk generate Invoice Number secara otomatis
// Format Invoice: INV/YYYYMMDD/001 (Contoh: INV/20231025/001)

// 1. Ambil tanggal hari ini dengan format Ymd (TahunBulanTanggal), misal: 20231025
$today = date("Ymd");

// 2. Cari nomor invoice terakhir di database yang dibuat hari ini
// Query: Pilih invoice_number dari tabel sales dimana invoice_number diawali dengan 'INV/TanggalHariIni'
// Urutkan dari yang terbesar (DESC) dan ambil 1 saja
$query = "SELECT invoice_number FROM sales WHERE invoice_number LIKE 'INV/$today%' ORDER BY sale_id DESC LIMIT 1";
$result = mysqli_query($koneksi, $query);
$data = mysqli_fetch_array($result);

// 3. Cek apakah ada data invoice hari ini?
if ($data) {
    // Jika ada, ambil nomor urut terakhirnya
    $last_inv = $data['invoice_number']; // Contoh: INV/20231025/001
    // Ambil 3 digit terakhir dari string invoice
    $number = (int) substr($last_inv, -3); // Hasil: 1
    // Tambahkan 1 untuk invoice baru
    $number++; // Hasil: 2
} else {
    // Jika belum ada penjualan hari ini, mulai dari 1
    $number = 1;
}

// 4. Susun format invoice baru
// sprintf("%03s", $number) gunanya untuk membuat angka menjadi 3 digit (misal 1 jadi 001)
$new_invoice = "INV/" . $today . "/" . sprintf("%03s", $number);


// === PENGAMBILAN DATA MASTER UNTUK DROPDOWN ===

// Ambil semua data customer untuk ditampilkan di pilihan (Select Option)
$q_cust = mysqli_query($koneksi, "SELECT * FROM customers");

// Ambil semua data produk untuk ditampilkan di pilihan saat input belanjaan
$q_prod = mysqli_query($koneksi, "SELECT * FROM products");
?>

<!-- Header Halaman (Judul & Breadcrumb) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <!-- Judul Besar Halaman -->
                <h1 class="m-0">Transaksi Baru</h1>
            </div>
        </div>
    </div>
</div>

<!-- Konten Utama Halaman -->
<div class="content">
    <div class="container-fluid">
        <!-- Form Transaksi: Mengirim data ke action.php dengan parameter act=insert -->
        <!-- Method POST digunakan karena mengirim data transaksi yang banyak/penting -->
        <form action="pages/sales/action.php?act=insert" method="POST">
            <div class="row">
                
                <!-- KOLOM KIRI: Informasi Umum Transaksi (Header) -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <!-- Input: Nomor Invoice (Otomatis & Readonly/Tidak bisa diedit) -->
                            <div class="form-group">
                                <label>Invoice Number</label>
                                <input type="text" class="form-control" name="invoice_number" value="<?php echo $new_invoice; ?>" readonly>
                            </div>
                            
                            <!-- Input: Tanggal Transaksi (Otomatis Hari ini) -->
                            <div class="form-group">
                                <label>Tanggal</label>
                                <input type="text" class="form-control" name="sale_date" value="<?php echo date('Y-m-d H:i:s'); ?>" readonly>
                            </div>
                            
                            <!-- Input: Pilihan Customer -->
                            <div class="form-group">
                                <label>Customer</label>
                                <select class="form-control" name="customer_id" required>
                                    <option value="">-- Pilih Customer --</option>
                                    <?php 
                                    // Looping data customer dari database ke dalam option select
                                    while($c = mysqli_fetch_array($q_cust)) { ?>
                                        <option value="<?php echo $c['customer_id']; ?>"><?php echo $c['name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- KOLOM KANAN: Detail Item Belanjaan -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Keranjang Belanja</h3>
                        </div>
                        <div class="card-body">
                            
                            <!-- Tabel Input Produk Dinamis -->
                            <!-- Menggunakan ID itemTable untuk dimanipulasi oleh Javascript -->
                            <table class="table table-bordered" id="itemTable">
                                <thead>
                                    <tr>
                                        <th>Produk</th>
                                        <th width="100">Qty</th>
                                        <th>Harga (Satuan)</th>
                                        <th>Subtotal</th>
                                        <th>#</th> <!-- Kolom tombol hapus -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Baris Item Pertama (Template) -->
                                    <tr class="item-row">
                                        <td>
                                            <!-- Select Produk -->
                                            <!-- name="products[]" menggunakan array [] karena akan ada banyak produk yang dikirim -->
                                            <!-- onchange="updatePrice(this)" memanggil fungsi JS saat produk dipilih -->
                                            <select class="form-control product-select" name="products[]" onchange="updatePrice(this)" required>
                                                <option value="" data-price="0">-- Pilih Produk --</option>
                                                <?php 
                                                // Reset pointer data produk agar bisa di-loop ulang jika perlu
                                                mysqli_data_seek($q_prod, 0);
                                                while($p = mysqli_fetch_array($q_prod)) { ?>
                                                    <!-- data-price disimpan di atribut option untuk diambil JS nanti -->
                                                    <option value="<?php echo $p['product_id']; ?>" data-price="<?php echo $p['price']; ?>">
                                                        <?php echo $p['product_name']; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        
                                        <!-- Input Quantity (Jumlah Beli) -->
                                        <!-- oninput="calculateRow(this)" menghitung ulang subtotal saat mengetik (realtime) -->
                                        <td><input type="number" class="form-control qty-input" name="qtys[]" value="1" min="1" oninput="calculateRow(this)"></td>
                                        
                                        <!-- Input Harga Satuan (Otomatis terisi JS, Readonly) -->
                                        <td><input type="number" class="form-control price-input" name="prices[]" value="0" readonly></td>
                                        
                                        <!-- Input Subtotal (Harga x Qty, Otomatis terisi JS) -->
                                        <td><input type="number" class="form-control subtotal-input" name="subtotals[]" value="0" readonly></td>
                                        
                                        <!-- Tombol Hapus Baris -->
                                        <td><button type="button" class="btn btn-danger btn-sm remove-row">X</button></td>
                                    </tr>
                                </tbody>
                            </table>
                            
                            <!-- Tombol untuk menambah baris input baru -->
                            <button type="button" class="btn btn-success btn-sm mt-2" onclick="addRow()">+ Tambah Baris</button>
                            
                            <hr>
                            
                            <!-- Area Total Bayar -->
                            <div class="d-flex justify-content-end">
                                <h3>Total: <span id="grandTotal">0</span></h3>
                                <!-- Input hidden untuk mengirim nilai total ke database -->
                                <input type="hidden" name="total" id="inputGrandTotal" value="0">
                            </div>

                            <!-- Pilihan Metode Pembayaran -->
                            <div class="form-group mt-3">
                                <label>Metode Pembayaran</label>
                                <select class="form-control" name="payment_method">
                                    <option value="Cash">Cash</option>
                                    <option value="Transfer">Transfer</option>
                                    <option value="Debit">Debit</option>
                                </select>
                            </div>

                            <!-- Tombol Submit Utama -->
                            <button type="submit" class="btn btn-primary btn-block">Simpan Transaksi</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- === JAVASCRIPT UNTUK LOGIKA DI BROWSER === -->
<script>
// Fungsi 1: Update Harga saat Produk Dipilih
function updatePrice(selectElement) {
    // 1. Ambil harga dari atribut 'data-price' pada option yang sedang dipilih user
    var price = selectElement.options[selectElement.selectedIndex].getAttribute('data-price');
    
    // 2. Cari elemen 'tr' (baris tabel) tempat select ini berada
    var row = selectElement.closest('tr');
    
    // 3. Masukkan harga ke input field harga (class .price-input) di baris tersebut
    row.querySelector('.price-input').value = price;
    
    // 4. Panggil fungsi hitung subtotal
    calculateRow(selectElement);
}

// Fungsi 2: Hitung Subtotal per Baris (Harga x Jumlah)
function calculateRow(element) {
    // 1. Cari baris tempat input berada
    var row = element.closest('tr');
    
    // 2. Ambil nilai harga dan quantity, convert ke Float (angka) agar bisa dikali
    // || 0 artinya jika kosong dianggap 0
    var price = parseFloat(row.querySelector('.price-input').value) || 0;
    var qty = parseFloat(row.querySelector('.qty-input').value) || 0;
    
    // 3. Hitung
    var subtotal = price * qty;
    
    // 4. Tampilkan hasil di input subtotal
    row.querySelector('.subtotal-input').value = subtotal;
    
    // 5. Panggil fungsi hitung Total Keseluruhan
    calculateGrandTotal();
}

// Fungsi 3: Hitung Total Keseluruhan Transaksi
function calculateGrandTotal() {
    var total = 0;
    
    // 1. Cari semua input dengan class .subtotal-input di halaman
    document.querySelectorAll('.subtotal-input').forEach(function(input) {
        // 2. Jumlahkan semua nilainya
        total += parseFloat(input.value) || 0;
    });
    
    // 3. Tampilkan teks total di elemen <span>
    document.getElementById('grandTotal').innerText = total;
    
    // 4. Masukkan nilai total ke input hidden agar terkirim ke database saat disubmit
    document.getElementById('inputGrandTotal').value = total;
}

// Fungsi 4: Tambah Baris Baru (Clone Baris Pertama)
function addRow() {
    var table = document.getElementById('itemTable').getElementsByTagName('tbody')[0];
    var firstRow = table.rows[0]; // Ambil baris pertama sebagai contoh/template
    var newRow = firstRow.cloneNode(true); // Copy baris tersebut
    
    // Reset nilai-nilai input di baris baru agar kosong/default
    newRow.querySelector('.qty-input').value = 1;
    newRow.querySelector('.price-input').value = 0;
    newRow.querySelector('.subtotal-input').value = 0;
    newRow.querySelector('.product-select').selectedIndex = 0; // Reset pilihan produk
    
    // Tambahkan event listener click untuk tombol Hapus di baris baru ini
    newRow.querySelector('.remove-row').onclick = function() {
        // Cek agar tidak menghapus baris terakhir (minimal sisa 1 baris)
        if(table.rows.length > 1) {
            this.closest('tr').remove(); // Hapus baris ini
            calculateGrandTotal(); // Hitung ulang total
        }
    };
    
    // Masukkan baris baru ke tabel
    table.appendChild(newRow);
}

// Event Listener Awal: Untuk tombol hapus di baris pertama (bawaan)
document.querySelector('.remove-row').onclick = function() {
    var table = document.getElementById('itemTable').getElementsByTagName('tbody')[0];
    if(table.rows.length > 1) {
        this.closest('tr').remove();
        calculateGrandTotal();
    }
};
</script>
