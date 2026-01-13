<?php
include "../../../config/koneksi.php";
session_start();

if (isset($_GET['act'])) {
    $act = $_GET['act'];

    if ($act == "insert") {
        $invoice_number = $_POST['invoice_number'];
        $customer_id = $_POST['customer_id'];
        $sale_date = $_POST['sale_date'];
        $total = $_POST['total'];
        $payment_method = $_POST['payment_method'];
        $user_id = $_SESSION['user_id'] ?? 1; // Asumsi ada session user_id, default 1 jika tidak ada

        // 1. Insert ke tabel Sales
        $sql_sales = "INSERT INTO sales (invoice_number, user_id, customer_id, sale_date, total, payment_method) 
                      VALUES ('$invoice_number', '$user_id', '$customer_id', '$sale_date', '$total', '$payment_method')";
        
        if (mysqli_query($koneksi, $sql_sales)) {
            // Ambil ID Sales yang baru saja dibuat
            $sale_id = mysqli_insert_id($koneksi);

            // 2. Loop insert ke tabel Sales Details
            $products = $_POST['products'];
            $qtys = $_POST['qtys'];
            $prices = $_POST['prices'];
            $subtotals = $_POST['subtotals'];

            for ($i = 0; $i < count($products); $i++) {
                $product_id = $products[$i];
                $qty = $qtys[$i];
                $price = $prices[$i];
                $subtotal = $subtotals[$i];

                if (!empty($product_id)) {
                    $sql_detail = "INSERT INTO sales_details (sale_id, product_id, price, quantity, subtotal)
                                   VALUES ('$sale_id', '$product_id', '$price', '$qty', '$subtotal')";
                    mysqli_query($koneksi, $sql_detail);
                }
            }

            $_SESSION['message'] = 'Transaksi Berhasil Disimpan';
            $_SESSION['alert_type'] = 'alert-success';
            $_SESSION['type'] = 'Success';
            mysqli_close($koneksi);
            header('location:../../dashboard.php?page=sales');
            exit;

        } else {
            $_SESSION['message'] = 'Transaksi Gagal: ' . mysqli_error($koneksi);
            $_SESSION['alert_type'] = 'alert-danger';
            $_SESSION['type'] = 'Failed';
            mysqli_close($koneksi);
            header('location:../../dashboard.php?page=addsale');
            exit;
        }
    }
}
