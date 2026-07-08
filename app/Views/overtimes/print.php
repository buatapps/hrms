<!DOCTYPE html>
<html>
<head>
    <title>SPL - Surat Perintah Lembur</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; color: #000; }
        .container { width: 100%; }
        table { border-collapse: collapse; width: 100%; }
        .bordered td, .bordered th { border: 1px solid #000; padding: 4px; vertical-align: middle; }
        .center { text-align: center; }
        .bold { font-weight: bold; }
        .title { font-size: 14px; font-weight: bold; text-align: center; margin-bottom: 2px; }
        
        @media print {
            body { margin: 0; }
            .no-print { display: none; }
            .page-break { page-break-after: always; }
        }

        .w-5 { width: 5%; } .w-10 { width: 10%; } .w-20 { width: 20%; } 
        .w-25 { width: 25%; } .w-30 { width: 30%; } .w-40 { width: 40%; } .w-16 { width: 16%; } 
    </style>
</head>
<body>

<div class="container">
    

    <?php 
    $chunks = array_chunk($items, 10); 
    foreach ($chunks as $page_index => $page_items) : ?>
    <div class="title">SURAT PERINTAH LEMBUR</div>

    <table class="table table-sm" style="margin-bottom: 5px;">
        <tr>
            <td class="w-30">
                <input type="checkbox" <?php if($overtime->overtime_category_id == 1) echo 'checked'; ?>> Sebelum jam 08.00<br>
                <input type="checkbox" <?php if($overtime->overtime_category_id == 5) echo 'checked'; ?>> Sebelum jam 20.00
            </td>
            <td class="w-30">
                <input type="checkbox" <?php if($overtime->overtime_category_id == 4) echo 'checked'; ?>> Setelah jam 17.10<br>
                <input type="checkbox" <?php if($overtime->overtime_category_id == 3) echo 'checked'; ?>> Setelah jam 05.10
            </td>
            <td class="w-20">
                <input type="checkbox" <?php if($overtime->overtime_category_id == 6) echo 'checked'; ?>> Hari Libur<br>
                <div style="padding-left:22px;">Shift : <?= ($overtime->shift == 'D') ? 'Day' : 'Night' ?></div>
            </td>
            <td class="w-20" style="text-align: right;">Group : <?= $overtime->employee_group ?></td>
        </tr>
    </table>

    <table style="margin-bottom: 2px;">
        <tr>
            <td>Hari / Tanggal : <?= date('d-m-Y') ?></td>
            <td class="center">Bagian : <?= $overtime->division_name ?></td>
            <td style="text-align: right;">Sub Leader : <?= $overtime->sub_leader_name ?></td>
        </tr>
    </table>
        
        <table class="bordered" style="margin-bottom: 5px;">
            <thead>
                <tr class="center bold">
                    <td class="w-5">No</td>
                    <td class="w-10">NIK</td>
                    <td class="w-20">Nama</td>
                    <td class="w-10">Mulai</td>
                    <td class="w-10">Selesai</td>
                    <td class="w-10">Jam</td>
                    <td class="w-25">Tugas</td>
                    <td class="w-10">Sign</td>
                </tr>
            </thead>
            <tbody>
                <?php 
                $i = 1; 
                foreach ($page_items as $item) : ?>
                    <tr>
                        <td class="center"><?= $i++; ?></td>
                        <td><?= $item->employee_id ?></td>
                        <td><?= $item->name ?></td>
                        <td class="center"><?= date('H:i', strtotime($item->start_time)) ?></td>
                        <td class="center"><?= date('H:i', strtotime($item->end_time)) ?></td>
                        <td class="center"><?= $item->duration_hours ?></td>
                        <td><?= $item->task_description ?></td>
                        <td></td>
                    </tr>
                <?php endforeach; ?>
                
                <?php for ($j = count($page_items) + 1; $j <= 10; $j++) : ?>
                <tr>
                    <td class="center"><?= $i++ ?></td>
                    <td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                </tr>
                <?php endfor; ?>
            </tbody>
        </table>

        <table class="bordered" style="margin-top: 2px;">
        <tr class="center">
            <td class="w-16">Diketahui</td><td class="w-16">Diketahui</td><td class="w-16">Diketahui</td><td class="w-16">Disetujui</td><td class="w-16">Dicek oleh</td><td class="w-16">Dicek oleh</td>
        </tr>
        <tr style="height:40px">
            <td><?php if($overtime->current_approval_level == 3) echo '<strong style="color: green;">Approved</strong>'; ?></td>
            <td></td><td></td>
            <td><?php if($overtime->current_approval_level >= 2) echo '<strong style="color: green;">Approved</strong>'; ?></td>
            <td></td><td></td>
        </tr>
        <tr class="center">
            <td>Senior Manager</td><td></td><td></td><td>Asst. Manager</td><td>Supervisor</td><td>Foreman</td>
        </tr>
    </table>

    <div style="margin-top: 2px; display: flex; justify-content: space-between;">
        <table class="bordered" style="width: 16.7%;">
            <tr class="center"><td>Disetujui</td></tr>
            <tr style="height:40px; text-align: center;"><td><?php if($overtime->current_approval_level == 1) echo '<strong style="color: green;">Approved</strong>'; ?></td></tr>
            <tr class="center"><td>Pers & G. Affair</td></tr>
        </table>
        <div style="width: 80%; font-size: 11px;">
            <br><br><b>Catatan:</b><br>
            1. Kertas lembur harus atas sepengetahuan / ditandatangani oleh tingkatan manager sebelum jam 12.00 dan harus dilaporkan ke Personalia dan General Affairs pada hari berikutnya sebelum jam 09.00.<br>
            2. Sign pelaksana diisi sebelum H-OT.
        </div>
    </div>

        <?php if ($page_index < count($chunks) - 1) : ?>
            <div class="page-break"></div>
        <?php endif; ?>

    <?php endforeach; ?>

    
</div>

<script>window.print();</script>
</body>
</html>