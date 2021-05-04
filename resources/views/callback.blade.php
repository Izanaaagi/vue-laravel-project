<html>
<head>
    <meta charset="utf-8">
    <title>Callback</title>
    <script>
        window.opener.postMessage({
            access_token: "{{ $access_token }}",
            token_type: "{{$token_type}}",
        }, 'https://vue-laravel-social-network-e3si7.ondigitalocean.app/');
        window.close();
    </script>
</head>
<body>
</body>
</html>
