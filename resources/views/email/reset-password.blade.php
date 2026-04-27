<p>Name: {{ $user_name }}</p>
<p>URL : <a href="{{route('password.reset', $token)}}">{{route('password.reset', $token)}}</a></p>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .content {
            padding: 20px;
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    <div class="content">
        <h1>Hello, {{$user_name}}!</h1>
        <p><a href="{{route('password.reset', $token)}}">{{route('password.reset', $token)}}</a></p>
        <p style="color: blue;">Enjoy coding!</p>
    </div>
</body>
</html>
