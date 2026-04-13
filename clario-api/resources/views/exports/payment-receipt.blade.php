<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Payment Receipt - {{ $payment->reference }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            margin: 30px;
        }
        .receipt {
            max-width: 700px;
            margin: 0 auto;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 10px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #8cff2e;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            color: #8cff2e;
        }
        .title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin: 20px 0;
        }
        .info-row {
            margin: 10px 0;
            padding: 5px;
            border-bottom: 1px solid #eee;
        }
        .info-label {
            font-weight: bold;
            display: inline-block;
            width: 160px;
        }
        .amount {
            font-size: 16px;
            font-weight: bold;
            margin-top: 20px;
            padding-top: 10px;
            border-top: 2px solid #8cff2e;
            text-align: right;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="receipt">
        <div class="header">
            <h1>Clario Driving School</h1>
            <p>Official Payment Receipt</p>
        </div>

        <div class="title">
            PAYMENT RECEIPT
        </div>

        <div class="info-row">
            <span class="info-label">Receipt Number:</span>
            <span>{{ $payment->receipt_number ?? 'N/A' }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Transaction Reference:</span>
            <span>{{ $payment->reference }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Date:</span>
            <span>{{ $payment->date }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Student Name:</span>
            <span>{{ $payment->student_name }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">CIN:</span>
            <span>{{ $payment->student_cin }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Category:</span>
            <span>{{ $payment->category }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Payment Type:</span>
            <span>{{ $payment->type }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Payment Method:</span>
            <span>{{ $payment->method }}</span>
        </div>

        <div class="amount">
            <strong>Amount Paid:</strong> {{ number_format($payment->amount_paid, 2) }} DH
        </div>

        <div class="info-row">
            <span class="info-label">Total Amount:</span>
            <span>{{ number_format($payment->amount_total, 2) }} DH</span>
        </div>
        <div class="info-row">
            <span class="info-label">Remaining Balance:</span>
            <span>{{ number_format($payment->amount_remaining, 2) }} DH</span>
        </div>
        <div class="info-row">
            <span class="info-label">Status:</span>
            <span>{{ $payment->status }}</span>
        </div>

        <div class="footer">
            <p>Thank you for your payment!</p>
            <p>Generated on: {{ now()->format('Y-m-d H:i:s') }}</p>
        </div>
    </div>
</body>
</html>
