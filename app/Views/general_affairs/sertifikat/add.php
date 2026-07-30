<?= $this->extend('layout/index') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12 col-sm-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('general_affairs/sertifikat'); ?>">Sertifikat</a></li>
                        <li class="breadcrumb-item active"><?= $title; ?></li>
                    </ol>
                </div>
                <h4 class="page-title"><?= $title; ?></h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form class="needs-validation" novalidate action="<?= base_url('general_affairs/sertifikat_save'); ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field(); ?>
                        <div class="row">
                            <div class="col-xl-4 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Employee</label>
                                    <select name="employee_id" class="form-select select2" data-toggle="select2" required>
                                        <?php foreach ($employee as $row): ?>
                                            <option value="<?= $row->id; ?>"><?= strtoupper($row->name); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Tipe Sertifikat</label>
                                    <div class="d-flex gap-2">
                                        <select name="tipe_sertifikat_id" class="form-select select2 flex-grow-1" data-toggle="select2" required>
                                            <option value="">-- Select --</option>
                                            <?php foreach ($tipe_sertifikat as $row): ?>
                                                <option value="<?= $row->id; ?>"><?= $row->tipe_sertifikat; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <button type="button" class="btn btn-success flex-shrink-0" data-bs-toggle="modal" data-bs-target="#modalTipeSertifikat">
                                            <i class="mdi mdi-plus me-1"></i> Tipe
                                        </button>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Masa Berlaku</label>
                                    <input type="date" class="form-control" name="masa_berlaku" value="<?= old('masa_berlaku'); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">File</label>
                                    <input type="file" class="form-control" name="file">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-sm btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTipeSertifikat" tabindex="-1" role="dialog" aria-labelledby="modalTipeSertifikatLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalTipeSertifikatLabel">Tipe Sertifikat</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Tipe Sertifikat</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="tipeSertifikatInput" placeholder="Enter tipe sertifikat">
                        <input type="hidden" id="tipeSertifikatEditId" value="">
                        <button type="button" class="btn btn-primary" id="tipeSertifikatSaveBtn" onclick="saveTipeSertifikat()">Save</button>
                    </div>
                </div>
                <table class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tipe Sertifikat</th>
                            <th class="text-center">Edit</th>
                            <th class="text-center">Delete</th>
                        </tr>
                    </thead>
                    <tbody id="tipeSertifikatList">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
function loadTipeSertifikat() {
    fetch('<?= base_url('general_affairs/tipe_sertifikat_list'); ?>')
        .then(res => res.json())
        .then(data => {
            let html = '';
            data.forEach((row, i) => {
                html += `<tr>
                    <td>${i + 1}</td>
                    <td>${row.tipe_sertifikat}</td>
                    <td class="text-center">
                        <a href="javascript:void(0)" onclick="editTipeSertifikat(${row.id}, '${row.tipe_sertifikat.replace(/'/g, "\\'")}')" class="action-icon text-info"><i class="mdi mdi-pencil"></i></a>
                    </td>
                    <td class="text-center">
                        <a href="javascript:void(0)" onclick="deleteTipeSertifikat(${row.id})" class="action-icon text-danger"><i class="mdi mdi-delete"></i></a>
                    </td>
                </tr>`;
            });
            document.getElementById('tipeSertifikatList').innerHTML = html;
        });
}

function saveTipeSertifikat() {
    const input = document.getElementById('tipeSertifikatInput');
    const editId = document.getElementById('tipeSertifikatEditId').value;
    const value = input.value.trim();
    if (!value) return;

    const url = editId ? '<?= base_url('general_affairs/tipe_sertifikat_update'); ?>' : '<?= base_url('general_affairs/tipe_sertifikat_save'); ?>';
    const formData = new FormData();
    formData.append('tipe_sertifikat', value);
    formData.append(csrfName, csrfHash);
    if (editId) formData.append('id', editId);

    fetch(url, { method: 'POST', body: formData })
        .then(res => res.json())
        .then((result) => {
            if (result.status === 'success') {
                input.value = '';
                document.getElementById('tipeSertifikatEditId').value = '';
                document.getElementById('tipeSertifikatSaveBtn').textContent = 'Save';
                loadTipeSertifikat();
                location.reload();
            } else {
                alert(result.message || 'Error saving data');
            }
        })
        .catch(err => alert('Error: ' + err));
}

function editTipeSertifikat(id, tipe) {
    document.getElementById('tipeSertifikatInput').value = tipe;
    document.getElementById('tipeSertifikatEditId').value = id;
    document.getElementById('tipeSertifikatSaveBtn').textContent = 'Update';
    document.getElementById('tipeSertifikatInput').focus();
}

function deleteTipeSertifikat(id) {
    if (!confirm('delete?')) return;
    fetch('<?= base_url('general_affairs/tipe_sertifikat_delete'); ?>/' + id)
        .then(res => res.json())
        .then(() => {
            loadTipeSertifikat();
            location.reload();
        });
}

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('modalTipeSertifikat').addEventListener('show.bs.modal', loadTipeSertifikat);
});
</script>
<?= $this->endSection() ?>
