<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Instructors Report</title>
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
        .rating-stars {
            color: #f59e0b;
        }
        .status-active { color: #10b981; font-weight: bold; }
        .status-on-leave { color: #f59e0b; font-weight: bold; }
        .status-inactive { color: #ef4444; font-weight: bold; }
        .status-training { color: #3b82f6; font-weight: bold; }
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
        <h1>Instructors Report</h1>
        <p>Generated on: {{ $exportDate }}</p>
    </div>

    <div class="summary">
        <div class="summary-item">
            <div class="summary-value">{{ $totalInstructors }}</div>
            <div class="summary-label">Total Instructors</div>
        </div>
        <div class="summary-item">
            <div class="summary-value">{{ $activeInstructors }}</div>
            <div class="summary-label">Active</div>
        </div>
        <div class="summary-item">
            <div class="summary-value">{{ number_format($totalSessions) }}</div>
            <div class="summary-label">Total Sessions</div>
        </div>
        <div class="summary-item">
            <div class="summary-value">{{ number_format($totalRevenue / 1000, 1) }}k MAD</div>
            <div class="summary-label">Total Revenue</div>
        </div>
        <div class="summary-item">
            <div class="summary-value">{{ number_format($avgRating, 1) }}/5</div>
            <div class="summary-label">Avg Rating</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Instructor</th>
                <th>Email</th>
                <th>Type</th>
                <th>Status</th>
                <th>Experience</th>
                <th>Students</th>
                <th>Sessions</th>
                <th>Completion</th>
                <th>Rating</th>
                <th>Revenue (MAD)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($instructors as $index => $instructor)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $instructor->first_name }} {{ $instructor->last_name }}</td>
                <td>{{ $instructor->email }}</td>
                <td>{{ $instructor->type }}</td>
                <td><span class="status-{{ strtolower(str_replace(' ', '-', $instructor->status)) }}">{{ $instructor->status }}</span></td>
                <td>{{ $instructor->experience_level }} ({{ $instructor->years_experience }} yrs)</td>
                <td>{{ $instructor->students_count }}</td>
                <td>{{ $instructor->sessions_count }}</td>
                <td>{{ number_format($instructor->completion_rate) }}%</td>
                <td class="rating-stars">{{ number_format($instructor->rating, 1) }}/5</td>
                <td style="text-align: right">{{ number_format($instructor->revenue, 2) }}</td>
            </tr>
            @empty
                <tr>
                    <td colspan="11" style="text-align: center">No instructors found</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Clario Driving School - Instructor Management System</p>
        <p>This report is system-generated. For any queries, please contact the administrator.</p>
    </div>
</body>
</html>
