<!doctype html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <title>{{ __('Paytr Payment Form') }}</title>
</head>

<body>
    <div style="width: 100%;margin: 0 auto;display: table;">
        <script src="{{ config('paytr.iFrameResizeJS') }}"></script>
        <iframe src="https://www.paytr.com/odeme/guvenli/{{ $token }}" id="paytriframe" frameborder="0"
            scrolling="no" style="width: 100%;"></iframe>
        <script>
            iFrameResize({}, '#paytriframe');
        </script>

    </div>

    <br><br>
</body>

</html>
