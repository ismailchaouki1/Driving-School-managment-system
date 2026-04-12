<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Students List</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #8cff2e;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            color: #333;
        }
        .header p {
            margin: 5px 0 0;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
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
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .status-badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
        }
        .status-Complete {
            background-color: #10b981;
            color: white;
        }
        .status-Partial {
            background-color: #f59e0b;
            color: white;
        }
        .status-Pending {
            background-color: #ef4444;
            color: white;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .summary {
            margin-top: 20px;
            padding: 10px;
            background-color: #f5f5f5;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Students Report</h1>
        <p>Generated on: {{ now()->format('F j, Y H:i:s') }}</p>
    </div>

    <div class="summary">
        <strong>Summary:</strong>
        Total Students: {{ $students->count() }} |
        Total Revenue: {{ number_format($students->sum('initial_payment'), 2) }} MAD |
        Complete Payments: {{ $students->where('payment_status', 'Complete')->count() }} |
        Partial Payments: {{ $students->where('payment_status', 'Partial')->count() }} |
        Pending: {{ $students->where('payment_status', 'Pending')->count() }}
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>CIN</th>
                <th>Category</th>
                <th>Phone</th>
                <th>Total (MAD)</th>
                <th>Paid (MAD)</th>
                <th>Status</th>
                <th>Registration Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                <td>{{ $student->cin }}</td>
                <td>{{ $student->type }}</td>
                <td>{{ $student->phone }}</td>
                <td style="text-align: right">{{ number_format($student->total_price, 2) }}</td>
                <td style="text-align: right">{{ number_format($student->initial_payment, 2) }}</td>
                <td>
                    <span class="status-badge status-{{ $student->payment_status }}">
                        {{ $student->payment_status }}
                    </span>
                </td>
                <td>{{ $student->registration_date }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Clario Driving School - Student Management System</p>
        <p>This report is system-generated. For any queries, please contact the administrator.</p>
    </div>
</body>
</html>
