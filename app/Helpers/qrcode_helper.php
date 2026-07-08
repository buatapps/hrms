<?php

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

if (!function_exists('render_qrcode')) {
    function render_qrcode(string $data): string
    {
        $options = new QROptions([
            'outputType' => QRCode::OUTPUT_IMAGE_PNG,
            'eccLevel'   => QRCode::ECC_L,
            'scale'      => 3,
        ]);
        $qrcode = new QRCode($options);
        $pngData = $qrcode->render($data);
        return $pngData;
    }
}
