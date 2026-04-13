{{-- resources/views/exports/statistics-report.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Statistics Report</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', 'Segoe UI', Arial, sans-serif;
            background: #fff;
            color: #333;
            font-size: 12px;
            line-height: 1.4;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Header Styles */
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #8cff2e;
        }

        .header h1 {
            font-size: 28px;
            color: #0d0d0d;
            margin-bottom: 8px;
        }

        .header p {
            font-size: 12px;
            color: #666;
        }

        .report-meta {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px solid #eee;
            font-size: 11px;
            color: #888;
        }

        /* Section Styles */
        .section {
            margin-bottom: 30px;
            page-break-inside: avoid;
        }

        .section-title {
            font-size: 18px;
            font-weight: bold;
            color: #0d0d0d;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 2px solid #8cff2e;
            display: inline-block;
        }

        /* KPI Cards */
        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 25px;
        }

        .kpi-card {
            background: linear-gradient(135deg, #f8f9fa 0%, #fff 100%);
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            padding: 15px;
            text-align: center;
        }

        .kpi-value {
            font-size: 28px;
            font-weight: bold;
            color: #8cff2e;
            margin-bottom: 5px;
        }

        .kpi-label {
            font-size: 12px;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .kpi-change {
            font-size: 11px;
            margin-top: 8px;
            padding: 3px 8px;
            border-radius: 20px;
            display: inline-block;
        }

        .kpi-change.positive {
            background: rgba(34, 197, 94, 0.1);
            color: #22c55e;
        }

        .kpi-change.negative {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
        }

        /* Quick Stats */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 25px;
        }

        .stat-card {
            background: #f8f9fa;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            padding: 12px;
            text-align: center;
        }

        .stat-value {
            font-size: 22px;
            font-weight: bold;
            color: #333;
        }

        .stat-label {
            font-size: 11px;
            color: #888;
            margin-top: 5px;
        }

        /* Tables */
        .table-wrapper {
            overflow-x: auto;
            margin-bottom: 20px;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }

        .data-table th {
            background: #f0f0f0;
            padding: 10px 8px;
            text-align: left;
            font-weight: bold;
            border-bottom: 2px solid #ddd;
        }

        .data-table td {
            padding: 8px;
            border-bottom: 1px solid #eee;
        }

        .data-table tr:hover {
            background: #f9f9f9;
        }

        /* Charts */
        .charts-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 25px;
        }

        .chart-container {
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            padding: 15px;
            background: #fff;
        }

        .chart-title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 1px solid #eee;
        }

        /* Simple Bar Chart */
        .simple-bar-chart {
            display: flex;
            align-items: flex-end;
            justify-content: space-around;
            height: 200px;
            gap: 10px;
            padding: 10px 0;
        }

        .bar-wrapper {
            flex: 1;
            text-align: center;
        }

        .bar {
            background: linear-gradient(180deg, #8cff2e, #6ecc24);
            width: 100%;
            max-width: 50px;
            margin: 0 auto;
            border-radius: 6px 6px 0 0;
            transition: height 0.3s;
        }

        .bar-label {
            font-size: 10px;
            color: #888;
            margin-top: 8px;
        }

        .bar-value {
            font-size: 10px;
            font-weight: bold;
            margin-bottom: 4px;
        }

        /* Donut Chart Placeholder */
        .donut-placeholder {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .donut-legend {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 11px;
        }

        .legend-color {
            width: 12px;
            height: 12px;
            border-radius: 50%;
        }

        /* Footer */
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #eee;
            text-align: center;
            font-size: 10px;
            color: #999;
        }

        /* Page Break */
        .page-break {
            page-break-before: always;
        }

        /* Badges */
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: bold;
        }

        .badge-paid {
            background: rgba(34, 197, 94, 0.1);
            color: #22c55e;
        }

        .badge-pending {
            background: rgba(245, 158, 11, 0.1);
            color: #f59e0b;
        }

        .badge-completed {
            background: rgba(34, 197, 94, 0.1);
            color: #22c55e;
        }

        .badge-scheduled {
            background: rgba(59, 130, 246, 0.1);
            color: #3b82f6;
        }
    </style>
</head>
<body>
    <div class="container">
        {{-- Header --}}
        <div class="header">
            <h1>Statistics Report</h1>
            <p>Driving School Management System</p>
            <div class="report-meta">
                <span>Generated on: {{ $exportDate }}</span>
                <span>Report ID: RPT-{{ date('YmdHis') }}</span>
            </div>
        </div>

        {{-- Executive Summary --}}
        <div class="section">
            <h2 class="section-title">Executive Summary</h2>
            <div class="kpi-grid">
                <div class="kpi-card">
                    <div class="kpi-value">{{ number_format($totalRevenue) }} MAD</div>
                    <div class="kpi-label">Total Revenue</div>
                </div>
                <div class="kpi-card">
                    <div class="kpi-value">{{ $totalStudents }}</div>
                    <div class="kpi-label">Total Students</div>
                </div>
                <div class="kpi-card">
                    <div class="kpi-value">{{ $totalSessions }}</div>
                    <div class="kpi-label">Total Sessions</div>
                </div>
                <div class="kpi-card">
                    <div class="kpi-value">{{ number_format($completionRate, 1) }}%</div>
                    <div class="kpi-label">Completion Rate</div>
                </div>
                <div class="kpi-card">
                    <div class="kpi-value">{{ $students->count() }}</div>
                    <div class="kpi-label">Active Students</div>
                </div>
                <div class="kpi-card">
                    <div class="kpi-value">{{ $instructors->count() }}</div>
                    <div class="kpi-label">Total Instructors</div>
                </div>
            </div>
        </div>

        {{-- Quick Statistics --}}
        <div class="section">
            <h2 class="section-title">Quick Statistics</h2>
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-value">{{ $students->where('payment_status', 'Complete')->count() }}</div>
                    <div class="stat-label">Fully Paid Students</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value">{{ $students->where('payment_status', 'Partial')->count() }}</div>
                    <div class="stat-label">Partial Payment</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value">{{ $students->where('payment_status', 'Pending')->count() }}</div>
                    <div class="stat-label">Pending Payment</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value">{{ $sessions->where('status', 'Completed')->count() }}</div>
                    <div class="stat-label">Completed Sessions</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value">{{ $sessions->where('status', 'Scheduled')->count() }}</div>
                    <div class="stat-label">Scheduled Sessions</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value">{{ $vehicles->where('status', 'Active')->count() ?? 0 }}</div>
                    <div class="stat-label">Active Vehicles</div>
                </div>
            </div>
        </div>

        {{-- Revenue Overview --}}
        <div class="section">
            <h2 class="section-title">Revenue Overview</h2>
            <div class="table-wrapper">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Payment Type</th>
                            <th>Total Amount (MAD)</th>
                            <th>Percentage</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $registrationTotal = $payments->where('type', 'Registration')->sum('amount_paid');
                            $sessionTotal = $payments->where('type', 'Session')->sum('amount_paid');
                            $examTotal = $payments->where('type', 'Exam')->sum('amount_paid');
                            $otherTotal = $payments->whereNotIn('type', ['Registration', 'Session', 'Exam'])->sum('amount_paid');
                            $grandTotal = $registrationTotal + $sessionTotal + $examTotal + $otherTotal;
                        @endphp
                        <tr>
                            <td>Registration Fees</td>
                            <td>{{ number_format($registrationTotal) }}</td>
                            <td>{{ $grandTotal > 0 ? number_format(($registrationTotal / $grandTotal) * 100, 1) : 0 }}%</td>
                        </tr>
                        <tr>
                            <td>Session Payments</td>
                            <td>{{ number_format($sessionTotal) }}</td>
                            <td>{{ $grandTotal > 0 ? number_format(($sessionTotal / $grandTotal) * 100, 1) : 0 }}%</td>
                        </tr>
                        <tr>
                            <td>Exam Fees</td>
                            <td>{{ number_format($examTotal) }}</td>
                            <td>{{ $grandTotal > 0 ? number_format(($examTotal / $grandTotal) * 100, 1) : 0 }}%</td>
                        </tr>
                        <tr>
                            <td>Other</td>
                            <td>{{ number_format($otherTotal) }}</td>
                            <td>{{ $grandTotal > 0 ? number_format(($otherTotal / $grandTotal) * 100, 1) : 0 }}%</td>
                        </tr>
                        <tr style="background: #f0f0f0; font-weight: bold;">
                            <td>Total</td>
                            <td>{{ number_format($grandTotal) }}</td>
                            <td>100%</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Students List --}}
        <div class="section page-break">
            <h2 class="section-title">Students List</h2>
            <div class="table-wrapper">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Category</th>
                            <th>Payment Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $student)
                            <tr>
                                <td>{{ $student->id }}</td>
                                <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                                <td>{{ $student->email }}</td>
                                <td>{{ $student->phone }}</td>
                                <td>{{ $student->type }}</td>
                                <td>
                                    <span class="badge badge-{{ strtolower($student->payment_status) }}">
                                        {{ $student->payment_status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center;">No students found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Sessions List --}}
        <div class="section">
            <h2 class="section-title">Sessions Summary</h2>
            <div class="table-wrapper">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Student</th>
                            <th>Instructor</th>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Price (MAD)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sessions->take(20) as $session)
                            <tr>
                                <td>{{ $session->id }}</td>
                                <td>{{ $session->student_name }}</td>
                                <td>{{ $session->instructor_name }}</td>
                                <td>{{ $session->date }}</td>
                                <td>{{ $session->type }}</td>
                                <td>
                                    <span class="badge badge-{{ strtolower(str_replace(' ', '-', $session->status)) }}">
                                        {{ $session->status }}
                                    </span>
                                </td>
                                <td>{{ number_format($session->price) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="text-align: center;">No sessions found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                @if($sessions->count() > 20)
                    <p style="text-align: center; margin-top: 10px; font-size: 11px; color: #888;">
                        Showing 20 of {{ $sessions->count() }} sessions
                    </p>
                @endif
            </div>
        </div>

        {{-- Instructors List --}}
        <div class="section">
            <h2 class="section-title">Instructors Performance</h2>
            <div class="table-wrapper">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Type</th>
                            <th>Sessions</th>
                            <th>Completion Rate</th>
                            <th>Rating</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($instructors as $instructor)
                            <tr>
                                <td>{{ $instructor->id }}</td>
                                <td>{{ $instructor->first_name }} {{ $instructor->last_name }}</td>
                                <td>{{ $instructor->email }}</td>
                                <td>{{ $instructor->type }}</td>
                                <td>{{ $instructor->sessions_count ?? 0 }}</td>
                                <td>{{ number_format($instructor->completion_rate ?? 0, 1) }}%</td>
                                <td>{{ number_format($instructor->rating ?? 0, 1) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="text-align: center;">No instructors found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Payment Methods Summary --}}
        <div class="section">
            <h2 class="section-title">Payment Methods Distribution</h2>
            <div class="table-wrapper">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Payment Method</th>
                            <th>Number of Transactions</th>
                            <th>Total Amount (MAD)</th>
                            <th>Percentage</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $methodStats = [];
                            foreach ($payments as $payment) {
                                $method = $payment->method ?? 'Cash';
                                if (!isset($methodStats[$method])) {
                                    $methodStats[$method] = ['count' => 0, 'amount' => 0];
                                }
                                $methodStats[$method]['count']++;
                                $methodStats[$method]['amount'] += $payment->amount_paid;
                            }
                            $totalAmount = array_sum(array_column($methodStats, 'amount'));
                        @endphp
                        @forelse($methodStats as $method => $stats)
                            <tr>
                                <td>{{ $method }}</td>
                                <td>{{ $stats['count'] }}</td>
                                <td>{{ number_format($stats['amount']) }}</td>
                                <td>{{ $totalAmount > 0 ? number_format(($stats['amount'] / $totalAmount) * 100, 1) : 0 }}%</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align: center;">No payment data available</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Footer --}}
        <div class="footer">
            <p>This report is automatically generated by the Driving School Management System.</p>
            <p>&copy; {{ date('Y') }} All rights reserved.</p>
        </div>
    </div>
</body>
</html>
