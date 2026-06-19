<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Detail - {{ $faculty->name_of_faculty }}</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        body {
            background: #f4f6f9;
            padding: 20px;
        }
        
        .profile-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 20px;
        }
        
        .info-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            height: 100%;
        }
        
        .info-label {
            font-weight: 600;
            color: #667eea;
            font-size: 12px;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        
        .info-value {
            font-size: 16px;
            color: #333;
            margin-bottom: 15px;
        }
        
        .section-title {
            border-left: 4px solid #667eea;
            padding-left: 15px;
            margin: 20px 0;
            font-size: 20px;
            font-weight: 600;
        }
        
        .badge-status {
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 11px;
            font-weight: 600;
        }
        
        .badge-completed {
            background-color: #d4edda;
            color: #155724;
        }
        
        .badge-ongoing {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .badge-applied {
            background-color: #d1ecf1;
            color: #0c5460;
        }
        
        .stats-box {
            text-align: center;
            padding: 20px;
            background: white;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .stats-number {
            font-size: 36px;
            font-weight: bold;
            color: #667eea;
        }
        
        .chart-container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        @media print {
            body {
                background: white;
                padding: 0;
            }
            .no-print {
                display: none;
            }
            .profile-header {
                background: #667eea;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
        
        .btn-back {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
        }
        
        .btn-back:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 10px rgba(102,126,234,0.3);
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="mb-3 no-print">
            <a href="{{ route('report.faculty-info') }}" class="btn btn-back">
                <i class="fas fa-arrow-left"></i> Back to Reports
            </a>
            <button onclick="window.print()" class="btn btn-secondary float-end">
                <i class="fas fa-print"></i> Print Report
            </button>
        </div>
        
        <!-- Profile Header -->
        <div class="profile-header">
            <div class="row">
                <div class="col-md-8">
                    <h2 class="mb-2">{{ $faculty->name }}</h2>
                    <p class="mb-1"><i class="fas fa-envelope"></i> {{ $faculty->email }}</p>
                    <p class="mb-0"><i class="fas fa-university"></i> {{ optional($faculty->loc)->location }}</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <img src="https://cau.ac.in/wp-content/uploads/2020/12/NewCAULogo.gif" height="80px">
                    <p class="mt-2 mb-0"><small>Member since {{ $faculty->created_at->format('F Y') }}</small></p>
                </div>
            </div>
        </div>
        
        <!-- Statistics Row -->
        <div class="row">
            <div class="col-md-3">
                <div class="stats-box">
                    <div class="stats-number">{{ $faculty->subjects->sum('total_credit') }}</div>
                    <div class="text-muted">Total Credit Hours</div>
                    <small class="text-muted">{{ $faculty->subjects->count() }} Subjects</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-box">
                    <div class="stats-number">{{ $faculty->irProjects->count() }}</div>
                    <div class="text-muted">IR Projects</div>
                    <small class="text-muted">₹{{ number_format($faculty->irProjects->sum('amount'), 2) }}</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-box">
                    <div class="stats-number">{{ $faculty->erProjects->count() }}</div>
                    <div class="text-muted">ER Projects</div>
                    <small class="text-muted">₹{{ number_format($faculty->erProjects->sum('amount'), 2) }}</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-box">
                    <div class="stats-number">₹{{ number_format($faculty->irProjects->sum('amount') + $faculty->erProjects->sum('amount'), 0) }}</div>
                    <div class="text-muted">Total Research Grants</div>
                    <small class="text-muted">IRP + ERP</small>
                </div>
            </div>
        </div>
        
        <div class="row">
            <!-- Subjects Section -->
            <div class="col-lg-6">
                <div class="info-card">
                    <h5 class="section-title">📚 Subjects Offered</h5>
                    @if($faculty->subjects->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Subject</th>
                                        <th>Theory</th>
                                        <th>Practical</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($faculty->subjects as $subject)
                                    <tr>
                                        <td>{{ $subject->subject_name }}</td>
                                        <td>{{ $subject->theory_credit }}</td>
                                        <td>{{ $subject->practical_credit }}</td>
                                        <td><strong>{{ $subject->total_credit }}</strong></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3" class="text-end">Grand Total:</th>
                                        <th>{{ $faculty->subjects->sum('total_credit') }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    @else
                        <p class="text-muted text-center">No subjects added yet</p>
                    @endif
                </div>
            </div>
            
            <!-- Chart Section -->
            <div class="col-lg-6">
                <div class="chart-container">
                    <canvas id="projectChart"></canvas>
                </div>
            </div>
        </div>
        
        <!-- IR Projects Section -->
        <div class="info-card">
            <h5 class="section-title">🔬 Intramural  Research Projects (IRP)</h5>
            @if($faculty->irProjects->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Project Name</th>
                                <th>Sponsoring Agency</th>
                                <th>Year</th>
                                <th>Duration</th>
                                <th>Status</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($faculty->irProjects as $project)
                            <tr>
                                <td><strong>{{ $project->project_name }}</strong></td>
                                <td>{{ $project->sponsoring_agency }}</td>
                                <td>{{ $project->sanctioned_year }}</td>
                                <td>{{ $project->duration }}</td>
                                <td>
                                    <span class="badge-status badge-{{ strtolower($project->status) }}">
                                        {{ $project->status }}
                                    </span>
                                </td>
                                <td>₹{{ number_format($project->amount, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="5" class="text-end">Total IRP Amount:</th>
                                <th>₹{{ number_format($faculty->irProjects->sum('amount'), 2) }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @else
                <p class="text-muted text-center">No IR projects added yet</p>
            @endif
        </div>
        
        <!-- ER Projects Section -->
        <div class="info-card">
            <h5 class="section-title">🌍 Extramural Research Projects (ERP)</h5>
            @if($faculty->erProjects->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Project Name</th>
                                <th>Sponsoring Agency</th>
                                <th>Year</th>
                                <th>Duration</th>
                                <th>Status</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($faculty->erProjects as $project)
                            <tr>
                                <td><strong>{{ $project->project_name }}</strong></td>
                                <td>{{ $project->sponsoring_agency }}</td>
                                <td>{{ $project->sanctioned_year }}</td>
                                <td>{{ $project->duration }}</td>
                                <td>
                                    <span class="badge-status badge-{{ strtolower($project->status) }}">
                                        {{ $project->status }}
                                    </span>
                                </td>
                                <td>₹{{ number_format($project->amount, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="5" class="text-end">Total ERP Amount:</th>
                                <th>₹{{ number_format($faculty->erProjects->sum('amount'), 2) }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @else
                <p class="text-muted text-center">No ER projects added yet</p>
            @endif
        </div>
        
        <!-- Footer -->
        <div class="text-center mt-4 text-muted">
            <p class="mb-0">Report generated on {{ now()->format('F j, Y, g:i a') }}</p>
            <p class="mb-0 small">Central Agricultural University, Imphal - Faculty Information System</p>
        </div>
    </div>
    
    <script>
        // Chart for project distribution
        const ctx = document.getElementById('projectChart').getContext('2d');
        const projectChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['IR Projects', 'ER Projects'],
                datasets: [{
                    label: 'Number of Projects',
                    data: [
                        {{ $faculty->irProjects->count() }},
                        {{ $faculty->erProjects->count() }}
                    ],
                    backgroundColor: [
                        'rgba(102, 126, 234, 0.7)',
                        'rgba(118, 75, 162, 0.7)'
                    ],
                    borderColor: [
                        'rgb(102, 126, 234)',
                        'rgb(118, 75, 162)'
                    ],
                    borderWidth: 1
                }, {
                    label: 'Total Amount (₹)',
                    data: [
                        {{ $faculty->irProjects->sum('amount') }},
                        {{ $faculty->erProjects->sum('amount') }}
                    ],
                    type: 'line',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 2,
                    fill: false,
                    yAxisID: 'y1'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Research Project Distribution'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Number of Projects'
                        }
                    },
                    y1: {
                        position: 'right',
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Amount (₹)'
                        },
                        grid: {
                            drawOnChartArea: false
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>