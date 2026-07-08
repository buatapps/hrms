<head>
    <meta charset="utf-8" />
    <title><?= 'HRMS | ' . $title; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="buatapps" name="author" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="<?= base_url(); ?>assets/images/favicon.ico">

    <!-- Select2 css -->
    <link href="<?= base_url(); ?>assets/vendor/select2/css/select2.min.css" rel="stylesheet" type="text/css" />

    <!-- Datatables css -->
    <link href="<?= base_url(); ?>assets/vendor/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url(); ?>assets/vendor/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url(); ?>assets/vendor/datatables.net-fixedcolumns-bs5/css/fixedColumns.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url(); ?>assets/vendor/datatables.net-fixedheader-bs5/css/fixedHeader.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url(); ?>assets/vendor/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url(); ?>assets/vendor/datatables.net-select-bs5/css/select.bootstrap5.min.css" rel="stylesheet" type="text/css" />

    <!-- Theme Config Js -->
    <script src="<?= base_url(); ?>assets/js/hyper-config.js"></script>
    <!-- App css -->
    <link href="<?= base_url(); ?>assets/css/app-modern.min.css" rel="stylesheet" type="text/css" id="app-style" />
    <!-- Icons css -->
    <link href="<?= base_url(); ?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />

    <style>
        /* Target td dalam table-striped khusus */
        table>tbody>tr>td.highlight-red {
            background-color: #fff0f0 !important;
            color: #721c24 !important;
            --bs-table-accent-bg: transparent !important;
        }

        table>tbody>tr>td.highlight-green {
            background-color: #d4edda !important;
            color: #155724 !important;
            --bs-table-accent-bg: transparent !important;
        }
    </style>
    <style>
        .table>tbody>tr.table-expired>td,
        .table>tbody>tr.table-expired>th {
            background-color: #f8d7da !important;
            color: #842029 !important;
            box-shadow: inset 0 0 0 9999px #f8d7da !important;
        }

        .table-hover>tbody>tr.table-expired:hover>td,
        .table-hover>tbody>tr.table-expired:hover>th {
            box-shadow: inset 0 0 0 9999px #f1bfc4 !important;
        }
    </style>

</head>