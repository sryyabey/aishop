<!doctype html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Trendyx PayTr Ödeme</title>
    <style>
         body {
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .payment-container {
            margin: 0 auto;
            display: table;
            width: 95%;
            max-width: 768px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        /* Masaüstü büyük ekranlar için */
    @media screen and (min-width: 1200px) {
        .payment-container {
            width: 50%;
        }
    }

    /* Orta boy ekranlar için */
    @media screen and (min-width: 969px) and (max-width: 1199px) {
        .payment-container {
            width: 50%;
        }
    }

    /* Tablet ve küçük masaüstü için */
    @media screen and (min-width: 769px) and (max-width: 968px) {
        .payment-container {
            width: 65%;
        }
    }

    /* Tablet ve daha küçük ekranlar için */
    @media screen and (max-width: 768px) {
        body {
            padding: 10px;
        }
        
        .payment-container {
            width: 95%;
            padding: 10px;
        }
    }
    </style>
</head>
<body>

<div class="payment-container">

    <!-- Ödeme formunun açılması için gereken HTML kodlar / Başlangıç -->
    <script src="https://www.paytr.com/js/iframeResizer.min.js"></script>
    <iframe src="https://www.paytr.com/odeme/guvenli/{{ $token }}" id="paytriframe" frameborder="0" scrolling="no" style="width: 100%;"></iframe>
    <script>iFrameResize({},'#paytriframe');</script>
    <!-- Ödeme formunun açılması için gereken HTML kodlar / Bitiş -->

</div>

</body>
</html>
