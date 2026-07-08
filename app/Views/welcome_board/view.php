<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        body {
            background-image: url("<?= base_url('assets/images/bg-welcome.jpg'); ?>");
            background-color: #cccccc;
            height: 625px;
            /* You must set a specified height */
            background-position: center;
            /* Center the image */
            background-repeat: no-repeat;
            /* Do not repeat the image */
            background-size: cover;
            /* Resize the background image to cover the entire container */
        }

        .square-1 {
            width: 30%;
            height: auto;
            /* background-color: red; */
            float: left;
        }

        .square-2 {
            float: left;
            width: 70%;
            height: auto;
            /* background-color: blue; */
        }

        .guest {
            padding-top: 1rem;
            text-align: center;
        }

        .guest_name {
            font-size: 18pt;
        }

        .date {
            font-size: 16pt;
        }

        .time {
            font-size: 12pt;
        }

        .topic {
            font-size: 18pt;
        }

        .member {

            font-size: 16pt;
            text-align: center;
        }

        .information {
            font-size: 12pt;
        }

        .divider {
            width: 120px;
            border-top: 1px solid #ccc;
            text-align: center;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <div class="square-1">&nbsp;</div>
    <div class="square-2">
        <div class="guest">
            <img src="<?= base_url('logo_guest/' . $list_data[0]->logo); ?>" height="50" alt=""><br>
            <span class="guest_name"><?= $list_data[0]->name; ?></span><br>
            <span class="date">
                <?php if ($list_data[0]->start_date == $list_data[0]->end_date) {
                    echo date('d-M-Y', strtotime($list_data[0]->start_date));
                } else {
                    echo $list_data[0]->start_date . ' - ' . $list_data[0]->end_date;
                } ?>
            </span><br>
            <span class="time">
                <?= $list_data[0]->start_time . ' - ' . $list_data[0]->end_time; ?>
            </span><br><br>
            <p><span class="topic"><?= $list_data[0]->topic; ?></span></p>
        </div>
        <div class="member">
            <?php foreach ($member as $row) : ?>
                <p>
                <div class="member2">
                    <?= $row->member_guest; ?>
                    <div class="divider"></div>
                    <span class="information"><?= $row->member_information; ?></span>
                </div>
                </p>

            <?php endforeach; ?>
        </div>
    </div>
</body>

</html>