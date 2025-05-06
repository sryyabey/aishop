{{-- Resources/views/shop/iframe.blade.php --}}
@extends('shop::layouts.master')

@section('page_title')
    {{ __('paytr::app.payment.payment') }}
@endsection

@section('content-wrapper')
    <div class="container">
        <div class="paytr-payment-page">
            <div class="paytr-loader">
                {{ __('paytr::app.payment.loading') }}
            </div>

            <script src="https://www.paytr.com/js/iframeResizer.min.js"></script>
            <iframe src="https://www.paytr.com/odeme/guvenli/{{ $token }}" id="paytriframe" frameborder="0" scrolling="no" style="width: 100%;"></iframe>
            <script>iFrameResize({}, '#paytriframe');</script>
        </div>
    </div>

    <style>
        .paytr-payment-page {
            padding: 40px 0;
            max-width: 800px;
            margin: 0 auto;
        }
        .paytr-loader {
            text-align: center;
            padding: 20px;
            font-size: 18px;
            display: none;
        }
    </style>
@endsection

