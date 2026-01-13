<?php
include "../config/koneksi.php";
if (isset($_GET['page'])) {
    $pages = $_GET['page'];

    switch ($pages) {
        case "buku":
            include "pages/buku/view.php";
            break;

        case "anggota":
            include "pages/anggota/view.php";
            break;

        case "addbuku":
            include "pages/buku/create.php";
            break;

        case "editbuku":
            include "pages/buku/edit.php";
            break;

        case "kategori":
            include "pages/kategori/view.php";
            break;

        case "addkategori":
            include "pages/kategori/create.php";
            break;

        case "editkategori":
            include "pages/kategori/edit.php";
            break;

        case "addanggota":
            include "pages/anggota/create.php";
            break;

        case "editanggota":
            include "pages/anggota/edit.php";
            break;

    // Sales Routing
    case 'sales':
        include "pages/sales/view.php";
        break;
    case 'addsale':
        include "pages/sales/create.php";
        break;
    case 'detailsale':
        include "pages/sales/detail.php";
        break;
    }

} else {
    include "pages/home.php";
}
