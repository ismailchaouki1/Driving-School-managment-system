<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sessions Report</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 10px;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #8cff2e;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            color: #333;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #8cff2e;
            color: #0d0d0d;
            font-weight: bold;
        }
        .summary {
            margin-top: 15px;
            padding: 10px;
            background-color: #f5f5f5;
            border-radius: 5px;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 9px;
            color: #666;
        }
        .status-scheduled { color: #3b82f6; }
        .status-completed { color: #10b981; }
        .status-in-progress { color: #f59e0b; }
        .status-cancelled { color: #ef4444; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Sessions Report</h1>
        <p>Generated on: {{ $exportDate }}</p>
    </div>

    <div class="summary">
        <strong>Summary:</strong>
        Total Sessions: {{ $sessions->count() }} |
        Completed: {{ $completedSessions }} |
        Total Revenue: {{ number_format($totalRevenue, 2) }} MAD
    </div>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Time</th>
                <th>Student</th>
                <th>Category</th>
                <th>Instructor</th>
                <th>Type</th>
                <th>Status</th>
                <th>Price</th>
                <th>Payment</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sessions as $session)
            <tr>
                <td>{{ $session->date }}</td>
                <td>{{ substr($session->start_time, 0, 5) }} - {{ substr($session->end_time, 0, 5) }}</td>
                <td>{{ $session->student_name }}</td>
                <td>{{ $session->student_category }}</td>
                <td>{{ $session->instructor_name }}</td>
                <td>{{ $session->type }}</td>
                <td><span class="status-{{ strtolower(str_replace(' ', '-', $session->status)) }}">{{ $session->status }}</span></td>
                <td style="text-align: right">{{ number_format($session->price, 2) }}</td>
                <td>{{ $session->payment_status }}</td>
            </tr>
            @empty
                <tr>
                    <td colspan="9" style="text-align: center">No sessions found</td>
                </tr>
            @endforelse
        </tbody>
     </table>

    <div class="footer">
        <p>Clario Driving School - Session Management System</p>
        <p>This report is system-generated. For any queries, please contact the administrator.</p>
    </div>
</body>
</html>
