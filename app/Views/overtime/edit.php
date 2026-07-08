<?= $this->extend('layout/index') ?>

<?= $this->section('content') ?>
<!-- Start Content-->
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-xl-12 col-sm-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('overtime'); ?>">Overtime</a></li>
                        <li class="breadcrumb-item active"><?= $title; ?></li>
                    </ol>
                </div>
                <h4 class="page-title"><?= $title; ?></h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-xl-12 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form class="needs-validation" novalidate action="<?= base_url('overtime/update'); ?>" method="post">
                        <?= csrf_field(); ?>
                        <div class="row">
                            <div class="col-xl-4 col-sm-12">
                                <div class="mb-3">
                                    <input type="hidden" name="id" class="form-control" value="<?= $list_data->id; ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <select name="employee_id" class="form-control select2" data-toggle="select2">
                                        <?php foreach ($employee as $row): ?>
                                            <option value="<?= $row->id; ?>" <?= ($row->id == $list_data->employee_id) ? 'selected' : null; ?>><?= $row->name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Date</label>
                                    <input type="date" class="form-control" name="date" value="<?= $list_data->date; ?>" id="date">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Jobdesk</label>
                                    <textarea name="jobdesk" class="form-control" rows="5"><?= $list_data->jobdesk; ?></textarea>
                                </div>
                            </div>
                            <div class="col-xl-4 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Start Time</label>
                                    <input type="time" class="form-control" name="start_time" value="<?= $list_data->start_time; ?>" id="start_time">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">End Time</label>
                                    <input type="time" class="form-control" name="end_time" value="<?= $list_data->end_time; ?>" id="end_time">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Total Hours</label>
                                    <select class="form-control" name="total_hours" id="total_hours">
                                        <?php for ($i = 0.5; $i <= 24; $i += 0.5): ?>
                                            <option value="<?= $i ?>" <?= ($i == $list_data->total_hours); ?>><?= $i ?> Jam</option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-sm btn-primary">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    const tanggalInput = document.getElementById('date');
    const startTimeInput = document.getElementById('start_time');
    const endTimeInput = document.getElementById('end_time');
    const totalHoursSelect = document.getElementById('total_hours');

    // Saat jam diubah manual
    startTimeInput.addEventListener('input', updateTotalJam);
    endTimeInput.addEventListener('input', updateTotalJam);

    // Set nilai default saat halaman pertama kali dimuat
    window.addEventListener('DOMContentLoaded', function() {
        const today = new Date();
        tanggalInput.valueAsDate = today;

        // panggil dengan timeout juga
        setTimeout(() => {
            setTimeByDate(today);
        }, 10);
    });

    // Fungsi hitung jam lembur
    function hitungTotalJam(start, end) {
        if (!start || !end) return;

        const [startHour, startMin] = start.split(':').map(Number);
        const [endHour, endMin] = end.split(':').map(Number);

        const startDate = new Date(0, 0, 0, startHour, startMin);
        const endDate = new Date(0, 0, 0, endHour, endMin);

        let selisih = (endDate - startDate) / (1000 * 60 * 60);
        if (selisih < 0) selisih += 24;

        return parseFloat(selisih.toFixed(1));
    }

    // Set jam lembur berdasarkan hari (weekday/weekend)
    function setTimeByDate(dateObj) {
        const hari = dateObj.getDay();

        let start = '';
        let end = '';

        if (hari >= 1 && hari <= 5) {
            // Senin–Jumat
            start = '16:30';
            end = '19:30';
        } else {
            // Sabtu/Minggu
            start = '08:00';
            end = '16:30';
        }

        // Set value-nya dulu
        startTimeInput.value = start;
        endTimeInput.value = end;

        // Lalu delay sedikit biar nilainya masuk dulu baru hitung
        setTimeout(() => {
            updateTotalJam();
        }, 10);
    }

    // Update <select> total hours
    function updateTotalJam() {
        const totalJam = hitungTotalJam(startTimeInput.value, endTimeInput.value);
        console.log('Total jam:', totalJam); // 👈 Debug
        if (!totalJam) return;

        for (const option of totalHoursSelect.options) {
            option.selected = (parseFloat(option.value) === totalJam);
        }
    }

    // Saat tanggal dipilih manual
    tanggalInput.addEventListener('change', function() {
        const newDate = new Date(this.value);
        setTimeByDate(newDate);
    });



    // Saat total_hours diganti manual, update end_time
    totalHoursSelect.addEventListener('change', function() {
        const start = startTimeInput.value;
        const total = parseFloat(this.value);

        if (!start || isNaN(total)) return;

        const [startHour, startMin] = start.split(':').map(Number);
        const startDate = new Date(0, 0, 0, startHour, startMin);
        startDate.setMinutes(startDate.getMinutes() + total * 60);

        const jam = String(startDate.getHours()).padStart(2, '0');
        const menit = String(startDate.getMinutes()).padStart(2, '0');
        endTimeInput.value = `${jam}:${menit}`;
    });
</script>

<!-- container -->
<?= $this->endSection() ?>