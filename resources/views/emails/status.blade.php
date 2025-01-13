<!DOCTYPE html>
<html>
<head>
    <title>Passport Status</title>
</head>
<body>
<h1>Passport Status Update</h1>
<ul>
    @foreach($statusData as $key => $value)
        <li><strong>{{ $key }}:</strong> {{ $value }}</li>
    @endforeach
</ul>
</body>
</html>
