<!-- Vendor js -->
<script src="<?= base_url(); ?>assets/js/vendor.min.js"></script>

<!-- Code Highlight js -->
<script src="<?= base_url(); ?>assets/vendor/highlightjs/highlight.pack.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/clipboard/clipboard.min.js"></script>
<script src="<?= base_url(); ?>assets/js/hyper-syntax.js"></script>

<!--  Select2 Plugin Js -->
<script src="<?= base_url(); ?>assets/vendor/select2/js/select2.min.js"></script>

<!-- Datatables js -->
<script src="<?= base_url(); ?>assets/vendor/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/datatables.net-fixedcolumns-bs5/js/fixedColumns.bootstrap5.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/datatables.net-buttons/js/buttons.flash.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/datatables.net-select/js/dataTables.select.min.js"></script>

<!-- Datatable Demo Aapp js -->
<script src="<?= base_url(); ?>assets/js/pages/demo.datatable-init.js"></script>

<!-- Chart Apex -->
<!-- Apex Chart js -->
<script src="<?= base_url(); ?>assets/vendor/apexcharts/apexcharts.min.js"></script>

<!-- Apex Chart Pie Demo js -->
<script src="<?= base_url(); ?>assets/js/pages/demo.apex-pie.js"></script>

<!-- sweetalert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- App js -->
<script src="<?= base_url(); ?>assets/js/app.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        if (window.config) {
            window.config.sidenav.size = "condensed";
            document.documentElement.setAttribute("data-sidenav-size", "condensed");
        }
    });
</script>
<script>
    // CSRF Token dari CodeIgniter
    const csrfName = '<?= csrf_token() ?>';
    const csrfHash = '<?= csrf_hash() ?>';

    $(document).on('change', '.status-select', function() {
        const headerId = $(this).data('id');
        const newStatus = $(this).val();

        $.ajax({
            url: "<?= base_url('overtime/update_status') ?>",
            method: "POST",
            data: {
                id: headerId,
                status: newStatus,
                [csrfName]: csrfHash
            },
            success: function(response) {
                if (response.success) {
                    // Redirect ke halaman form biar session flashdata tampil
                    window.location.href = response.redirect;
                } else {
                    alert("Gagal memperbarui status.");
                }
            },
            error: function(xhr, status, error) {
                alert("AJAX error. Status gagal diperbarui.");
            }
        });
    });
</script>

<script>
    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });
</script>

<script>
    function previewImg() {

        const sampul = document.querySelector('#sampul');
        const imgPreview = document.querySelector('.img-preview');


        const fileSampul = new FileReader();
        fileSampul.readAsDataURL(sampul.files[0]);

        fileSampul.onload = function(e) {
            imgPreview.src = e.target.result;
        }

    }
</script>

<script>
    function fetchRergenciesData(provinces_id) {
        $.ajax({
            url: "<?= site_url('employee/getRegencies'); ?>",
            method: "POST",
            data: {
                cProvinces_id: provinces_id
            },
            success: function(result) {
                let data = JSON.parse(result);
                let output = "<option value=''>&nbsp;</option>";
                for (let row in data) {
                    output += '<option value="' + data[row].id + '">' + data[row].name + '</option>';
                    console.log(data[row].id);
                    console.log(data[row].name);
                }

                // console.log(data);
                document.querySelector("#regenciesID").innerHTML = output;
                // console.log(result);
            }
        });
    }

    function fetchDistrictsData(regencies_id) {
        $.ajax({
            url: "<?= site_url('employee/getDistricts'); ?>",
            method: "POST",
            data: {
                cRegencies_id: regencies_id
            },
            success: function(result) {
                let data = JSON.parse(result);
                let output = "<option value=''>&nbsp;</option>";
                for (let row in data) {
                    output += '<option value="' + data[row].id + '">' + data[row].name + '</option>';
                    console.log(data[row].id);
                    console.log(data[row].name);
                }

                // console.log(data);
                document.querySelector("#districtsID").innerHTML = output;
                // console.log(result);
            }
        });
    }

    function fetchVillagesData(districts_id) {
        $.ajax({
            url: "<?= site_url('employee/getVillages'); ?>",
            method: "POST",
            data: {
                cDistricts_id: districts_id
            },
            success: function(result) {
                let data = JSON.parse(result);
                let output = "<option value=''>&nbsp;</option>";
                for (let row in data) {
                    output += '<option value="' + data[row].id + '">' + data[row].name + '</option>';
                    console.log(data[row].id);
                    console.log(data[row].name);
                }

                // console.log(data);
                document.querySelector("#villagesID").innerHTML = output;
                // console.log(result);
            }
        });
    }
</script>

<script>
    // Kita tangkap event submit pada form, bukan klik tombol
    document.getElementById('form-approve').addEventListener('submit', function(e) {
        
        // 1. Hentikan proses pengiriman form sementara
        e.preventDefault(); 
        
        var form = this; // Simpan referensi form
        
        Swal.fire({
            title: 'Konfirmasi',
            text: "Apakah Anda yakin ingin melakukan approval?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#17a2b8',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Lanjut'
        }).then((result) => {
            if (result.isConfirmed) {
                // 2. Jika user klik Yes, baru kita jalankan submit manual
                form.submit();
            }
        });
    });
</script>
<script>
    document.querySelectorAll('.btn-cancel').forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault();
        var url = this.getAttribute('href');

        Swal.fire({
            title: 'Konfirmasi Pembatalan',
            text: "Anda yakin ingin membatalkan item ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Ya, Batalkan'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    });
});
</script>
