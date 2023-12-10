<?php
echo "Hello Codedamn!";
?>
<!DOCTYPE html>
<html lang="en">
 
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code</title>
</head>
 
<body>
 
    <?php
    include 'phpqrcode/qrlib.php';
    $text = "codedamn.com";
    QRcode::png($text, 'qrcodes/image.png');
    ?>
 
    <img src="qrcodes/image.png" alt="">
</body>
 
</html>