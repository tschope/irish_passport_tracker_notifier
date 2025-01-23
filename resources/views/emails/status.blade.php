<!DOCTYPE html>
<html>
<head>
    <title>Irish Passport E-mail Notifier</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #eee;
            color: #008653;
            padding: 20px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 20px;
        }
        .content h2 {
            font-size: 20px;
            color: #333333;
        }
        .content p {
            margin: 10px 0;
            line-height: 1.5;
            color: #555555;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #999999;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            margin: 20px 0;
            background-color: #008653;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
        }
        p a {
            color: #008653;
        }
        p a.button {
            color: #ffffff;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table th, table td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        table th {
            background-color: #eee;
            color: #555555;
        }
    </style>
</head>
<body>
<div class="container">
    <!-- Header -->
    <div class="header">
        <h1>Passport Status Update</h1>
    </div>

    <!-- Content -->
    <div class="content">
        <h2>Application ID: {{ $statusData['application_id'] }}</h2>
        <p><strong>Estimated Issue Date:</strong> {{ $statusData['estimated_issue_date'] }}</p>
        <p><strong>Last Updated:</strong> {{ $statusData['last_update'] }}</p>
        <p><strong>Progress:</strong> {{ $statusData['progress'] }}%</p>
        <p><strong>Last Update:</strong> {{ $statusData['alert_title'] }}</p>
        <p><strong>Last Message:</strong> {!! $statusData['alert_message'] !!}</p>

        <h3>Status History</h3>
        @if(!empty($statusData['status_history']))
            <table>
                <thead>
                <tr>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Message</th>
                </tr>
                </thead>
                <tbody>
                @foreach($statusData['status_history'] as $status)
                    <tr>
                        <td>{{ $status['date'] }}</td>
                        <td>{{ $status['status'] }}</td>
                        <td>{{ $status['message'] }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <p>No status history available.</p>
        @endif

        @if($statusData['removed'])
            <p>
                <strong>{{ $statusData['removed_message'] }}</strong>
            </p>
        @else
            @if($statusData['progress'] === 100.0)
                <p>
                    <strong>You subscription ended because your passport has been sent to you. Thanks for use our services.</strong>
                </p>
            @else
                <p>
                    If you no longer wish to receive these notifications, you can unsubscribe by clicking the link below:
                </p>
                <p>
                    <a href="{{ url('/unsubscribe/' . $unsubscribeToken) }}" class="button">Unsubscribe</a>
                </p>
            @endif
        @endif
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>*Please note the estimated issue date is an estimate based on current averages – it is not a service delivery guarantee.</p>
    </div>
</div>
</body>
</html>
