<?php
    session_start();
    //header('Content-Type: image/png');
    require_once('src/QrCode.php');

    use Endroid\QrCode\QrCode;

    if(isset($_SESSION['qrcode'])){
        $qr = new QrCode();
        $qr
            ->setText($_SESSION['qrcode'])
            ->setSize("200")
            ->render();
    }

?>