<!DOCTYPE html>
<html>
<head>
    <title>Irish Passport E-mail Notifier</title>
</head>
<body>
<h1>Passport Status Update - Fail Application ID</h1>
<ul>
    @foreach($statusData as $key => $value)
        <li><strong>{{ $key }}:</strong> {{ $value }}</li>
    @endforeach
</ul>
<p>
    Your details have been removed from our database. If you wish to receive notifications again tried with a valid Application ID.
</p>
</body>
</html>
