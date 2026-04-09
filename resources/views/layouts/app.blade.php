<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voedselbank</title>
</head>
<body style="margin:0; font-family: Arial, sans-serif; background:#f3f4f6;">

    @if(session('success'))
        <div style="max-width:1200px; margin:20px auto 0; background:#dcfce7; color:#166534; padding:14px 18px; border-radius:10px;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="max-width:1200px; margin:20px auto 0; background:#fee2e2; color:#991b1b; padding:14px 18px; border-radius:10px;">
            {{ session('error') }}
        </div>
    @endif

    @yield('content')
</body>
</html>