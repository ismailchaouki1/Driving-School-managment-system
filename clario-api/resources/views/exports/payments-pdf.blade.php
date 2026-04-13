<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Payments Report</title>
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
        .summary {
            margin: 15px 0;
            padding: 10px;
            background-color: #f5f5f5;
            border-radius: 5px;
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
        }
        .summary-item {
            text-align: center;
            padding: 5px 15px;
        }
        .summary-label {
            font-size: 11px;
            color: #666;
        }
        .summary-value {
            font-size: 16px;
            font-weight: bold;
            color: #8cff2e;
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
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 9px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Payments Report</h1>
        <p>Generated on: {{ $exportDate }}</p>
    </div>

    <div class="summary">
        <div class="summary-item">
            <div class="summary-value">{{ number_format($totalRevenue, 2) }} DH</div>
            <div class="summary-label">Total Collected</div>
        </div>
        <div class="summary-item">
            <div class="summary-value">{{ number_format($totalPending, 2) }} DH</div>
            <div class="summary-label">Pending Balance</div>
        </div>
        <div class="summary-item">
            <div class="summary-value">{{ $paidCount }}</div>
            <div class="summary-label">Paid</div>
        </div>
        <div class="summary-item">
            <div class="summary-value">{{ $partialCount }}</div>
            <div class="summary-label">Partial</div>
        </div>
        <div class="summary-item">
            <div class="summary-value">{{ $pendingCount }}</div>
            <div class="summary-label">Pending</div>
        </div>
        <div class="summary-item">
            <div class="summary-value">{{ $overdueCount }}</div>
            <div class="summary-label">Overdue</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Reference</th>
                <th>Student Name</th>
                <th>CIN</th>
                <th>Total (DH)</th>
                <th>Paid (DH)</th>
                <th>Remaining (DH)</th>
                <th>Status</th>
                <th>Method</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($payments as $payment)
            <tr>
                <td>{{ $payment->reference }}</td>
                <td>{{ $payment->student_name }}</td>
                <td>{{ $payment->student_cin }}</td>
                <td style="text-align: right">{{ number_format($payment->amount_total, 2) }}</td>
                <td style="text-align: right">{{ number_format($payment->amount_paid, 2) }}</td>
                <td style="text-align: right">{{ number_format($payment->amount_remaining, 2) }}</td>
                <td>{{ $payment->status }}</td>
                <td>{{ $payment->method }}</td>
                <td>{{ $payment->date }}</td>
            </tr>
            @empty
                <tr>
                    <td colspan="9" style="text-align: center">No payments found</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Clario Driving School - Payment Management System</p>
    </div>
</body>
</html>
