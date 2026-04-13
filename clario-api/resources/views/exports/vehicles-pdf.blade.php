<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Vehicles Report</title>
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
        }
        .summary-item {
            text-align: center;
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
        .status-active {
            color: #10b981;
            font-weight: bold;
        }
        .status-maintenance {
            color: #f59e0b;
            font-weight: bold;
        }
        .status-inactive {
            color: #ef4444;
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
        <h1>Fleet Management Report</h1>
        <p>Generated on: {{ $exportDate }}</p>
    </div>

    <div class="summary">
        <div class="summary-item">
            <div class="summary-value">{{ $totalVehicles }}</div>
            <div class="summary-label">Total Vehicles</div>
        </div>
        <div class="summary-item">
            <div class="summary-value">{{ $activeVehicles }}</div>
            <div class="summary-label">Active</div>
        </div>
        <div class="summary-item">
            <div class="summary-value">{{ $maintenanceVehicles }}</div>
            <div class="summary-label">In Maintenance</div>
        </div>
        <div class="summary-item">
            <div class="summary-value">{{ number_format($totalValue / 1000, 1) }}k MAD</div>
            <div class="summary-label">Total Value</div>
        </div>
        <div class="summary-item">
            <div class="summary-value">{{ number_format($totalMileage / 1000, 1) }}k km</div>
            <div class="summary-label">Total Mileage</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Vehicle</th>
                <th>Plate</th>
                <th>Category</th>
                <th>Year</th>
                <th>Mileage (km)</th>
                <th>Status</th>
                <th>Insurance Expiry</th>
                <th>Next Maintenance</th>
                <th>Instructor</th>
                <th>Sessions</th>
                <th>Value (MAD)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($vehicles as $index => $vehicle)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $vehicle->brand }} {{ $vehicle->model }}</td>
                <td>{{ $vehicle->plate }}</td>
                <td>{{ $vehicle->category }}</td>
                <td>{{ $vehicle->year }}</td>
                <td>{{ number_format($vehicle->mileage) }}</td>
                <td>
                    <span class="status-{{ strtolower($vehicle->status) }}">
                        {{ $vehicle->status }}
                    </span>
                </td>
                <td>{{ $vehicle->insurance_expiry ?? 'N/A' }}</td>
                <td>{{ $vehicle->next_maintenance ?? 'N/A' }}</td>
                <td>{{ $vehicle->assigned_instructor ?? '—' }}</td>
                <td>{{ $vehicle->sessions_count }}</td>
                <td>{{ number_format($vehicle->current_value ?? $vehicle->purchase_price ?? 0) }}</td>
            </tr>
            @empty
                <tr>
                    <td colspan="12" style="text-align: center">No vehicles found</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Clario Driving School - Fleet Management System</p>
        <p>This report is system-generated. For any queries, please contact the administrator.</p>
    </div>
</body>
</html>
