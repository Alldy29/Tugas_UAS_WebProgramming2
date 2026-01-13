<?php
$sale_id = $_GET['id'];

// Ambil Header Transaksi
$sql_header = "SELECT sales.*, customers.name as customer_name FROM sales 
               LEFT JOIN customers ON sales.customer_id = customers.customer_id 
               WHERE sales.sale_id = '$sale_id'";
$query_header = mysqli_query($koneksi, $sql_header);
$header = mysqli_fetch_array($query_header);

// Ambil Detail Items
$sql_detail = "SELECT sales_details.*, products.product_name FROM sales_details 
               LEFT JOIN products ON sales_details.product_id = products.product_id 
               WHERE sales_details.sale_id = '$sale_id'";
$query_detail = mysqli_query($koneksi, $sql_detail);
?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Detail Transaksi</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Detail Sales</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Invoice #<?php echo $header['invoice_number']; ?></h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" onclick="window.print()"><i class="fas fa-print"></i> Print</button>
                    <a href="dashboard.php?page=sales" class="btn btn-tool">Kembali</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <strong>Customer:</strong><br>
                        <?php echo $header['customer_name'] ? $header['customer_name'] : 'Umum'; ?><br>
                        <strong>Tanggal:</strong><br>
                        <?php echo $header['sale_date']; ?>
                    </div>
                    <div class="col-sm-6 text-right">
                        <strong>Metode Pembayaran:</strong><br>
                        <?php echo $header['payment_method']; ?>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th>Harga</th>
                                    <th>Qty</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($item = mysqli_fetch_array($query_detail)) { ?>
                                <tr>
                                    <td><?php echo $item['product_name']; ?></td>
                                    <td><?php echo number_format($item['price'], 0, ',', '.'); ?></td>
                                    <td><?php echo $item['quantity']; ?></td>
                                    <td><?php echo number_format($item['subtotal'], 0, ',', '.'); ?></td>
                                </tr>
                                <?php } ?>
                                <tr>
                                    <td colspan="3" class="text-right"><strong>Grand Total:</strong></td>
                                    <td><strong><?php echo number_format($header['total'], 0, ',', '.'); ?></strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
