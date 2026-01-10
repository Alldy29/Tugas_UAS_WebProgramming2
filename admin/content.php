<?php
include "../config/koneksi.php";
if (isset($_GET['page'])) {
    $pages = $_GET['page'];

    switch ($pages) {
        case "buku":
            include "pages/buku/view.php";
            break;

        case "customers":
            include "pages/customers/view.php";
            break;

        case "addbuku":
            include "pages/buku/create.php";
            break;

        case "editbuku":
            include "pages/buku/edit.php";
            break;

        case "categories":
            include "pages/categories/view.php";
            break;

        case "addcategory":
            include "pages/categories/create.php";
            break;

        case "editcategory":
            include "pages/categories/edit.php";
            break;

        case "addcustomer":
            include "pages/customers/create.php";
            break;

        case "editcustomer":
            include "pages/customers/edit.php";
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
