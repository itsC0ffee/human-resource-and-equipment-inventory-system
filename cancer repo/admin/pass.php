<?php
require_once '../phpqrcode/qrlib.php';

// The data to encode
$data = 'Hello, World!';

// The file name to save the QR code as
$filename = 'qrcode.png';

// The error correction level to use
$level = QR_ECLEVEL_L;

// The size of each QR code module (pixel)
$size = 10;

// The margin around the QR code (module)
$margin = 4;

// Generate the QR code
QRcode::png($data, $filename, $level, $size, $margin);
?>