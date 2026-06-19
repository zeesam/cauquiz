<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Report - CAU Imphal</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- DataTables -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .report-container {
            max-width: 1400px;
            margin: 0 auto;
        }
        
        .card {
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            margin-bottom: 20px;
        }
        
        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-bottom: none;
            padding: 20px;
        }
        
        .filter-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        
        .stats-card {
            background: white;
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        
        .stats-number {
            font-size: 32px;
            font-weight: bold;
            color: #667eea;
        }
        
        .stats-label {
            color: #666;
            font-size: 14px;
            margin-top: 5px;
        }
        
        .btn-view {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 5px 15px;
            border-radius: 5px;
            font-size: 12px;
        }
        
        .btn-view:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 5px rgba(102,126,234,0.3);
        }
        
        .badge-irp {
            background-color: #e3f2fd;
            color: #1976d2;
        }
        
        .badge-erp {
            background-color: #f3e5f5;
            color: #7b1fa2;
        }
        
        .table-hover tbody tr:hover {
            background-color: #f8f9fa;
            cursor: pointer;
        }
        
        .pagination {
            justify-content: center;
        }
        
        .footer {
            text-align: center;
            padding: 15px;
            background: rgba(255,255,255,0.95);
            border-radius: 10px;
            margin-top: 20px;
        }
        
        @media print {
            body {
                background: white;
                padding: 0;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="report-container">
        <!-- Header -->
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <img src="https://cau.ac.in/wp-content/uploads/2020/12/NewCAULogo.gif" height="60px" class="me-3">
                        <h2 class="d-inline-block mb-0">Faculty Report</h2>
                        <p class="mb-0 mt-2">Central Agricultural University, Imphal</p>
                    </div>
                    <div>
                        <button onclick="window.print()" class="btn btn-light me-2">
                            <i class="fas fa-print"></i> Print
                        </button>
                        <a href="{{ route('report.export', request()->query()) }}" class="btn btn-success">
                            <i class="fas fa-file-excel"></i> Export Excel
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="stats-card">
                    <div class="stats-number">{{ $faculties->total() }}</div>
                    <div class="stats-label">Total Faculties</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card">
                    <div class="stats-number">
                        {{ $faculties->getCollection()->sum(fn($f) => $f->subjects->sum('total_credit')) }}
                    </div>
                    <div class="stats-label">Total Credit Hours</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card">
                    <div class="stats-number">
                        {{ $faculties->sum(function($f) { return $f->irProjects->sum('amount'); }) }}
                    </div>
                    <div class="stats-label">Total IRP Amount (₹)</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card">
                    <div class="stats-number">
                        {{ $faculties->sum(function($f) { return $f->erProjects->sum('amount'); }) }}
                    </div>
                    <div class="stats-label">Total ERP Amount (₹)</div>
                </div>
            </div>
        </div>
        
        <!-- Filter Section -->
        <div class="filter-section no-print">
            <form method="GET" action="{{ route('report.faculty-info') }}" id="filterForm">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Search Faculty</label>
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" 
                                   placeholder="Name, email or department..." 
                                   value="{{ request('search') }}">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Filter by College</label>
                        <select name="college" class="form-control" id="collegeFilter">
                            <option value="">All Colleges</option>

                            @foreach($colleges as $college)
                                <option value="{{ $college->location }}"
                                    {{ request('college') == $college->location ? 'selected' : '' }}>
                                    {{ $college->location }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <label class="form-label">&nbsp;</label>
                        <div>
                            <a href="{{ route('report.faculty-info') }}" class="btn btn-secondary">
                                <i class="fas fa-undo"></i> Reset
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        
        <!-- Faculty Table -->
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Faculty Name</th>
                                <th>Email</th>
                                <th>College</th>
                                <th>Credit Hours</th>
                                <th>IR Projects</th>
                                <th>ER Projects</th>
                                <th>Total Amount</th>
                                <th class="no-print">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($faculties as $index => $faculty)
                            <tr>
                                <td>{{ $faculties->firstItem() + $index }}</td>
                                <td>
                                    <strong>{{ $faculty->name }}</strong><br>
                                    <small class="text-muted">ID: {{ $faculty->id }}</small>
                                </td>
                                <td>{{ $faculty->email }}</td>
                                <td><small>{{ $faculty->loc->location ?? '' }}</small></td>
                                <td>
                                    <span class="badge bg-primary">
                                        {{ $faculty->subjects->sum('total_credit') }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-irp">
                                        {{ $faculty->irProjects->count() }} (₹{{ number_format($faculty->irProjects->sum('amount'), 0) }})
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-erp">
                                        {{ $faculty->erProjects->count() }} (₹{{ number_format($faculty->erProjects->sum('amount'), 0) }})
                                    </span>
                                </td>
                                <td>
                                    <strong>₹{{ number_format($faculty->irProjects->sum('amount') + $faculty->erProjects->sum('amount'), 0) }}</strong>
                                </td>
                                <td class="no-print">
                                    <a href="{{ route('report.show', $faculty->id) }}" class="btn btn-view">
                                        <i class="fas fa-eye"></i> View Details
                                    </a>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center py-5">
                                        <i class="fas fa-database fa-3x text-muted mb-3 d-block"></i>
                                        <p class="mb-0">No faculty records found</p>
                                        <small class="text-muted">Try adjusting your filters</small>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($faculties->hasPages())
                    <div class="p-3">
                        {{ $faculties->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </div>
        <?php
            date_default_timezone_set("Asia/Kolkata");
        ?>
        <!-- Footer -->
        <div class="footer">
            <p class="mb-0">Designed and Developed by <strong>Er. S Govind Singh</strong></p>
            <p class="mb-0 small">System Analyst, Central Agricultural University (CAU), Imphal</p>
            <p class="mb-0 small">Report Generated: {{ now()->format('F j, Y, g:i a') }}</p>
        </div>
    </div>
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    
    <script>
        // Auto-submit on filter change
        document.getElementById('collegeFilter')?.addEventListener('change', function() {
            document.getElementById('filterForm').submit();
        });
        
        // Debounce search
        let searchTimeout;
        document.querySelector('input[name="search"]')?.addEventListener('keyup', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                document.getElementById('filterForm').submit();
            }, 500);
        });
        
        // Initialize DataTable (optional - for enhanced features)
        // You can uncomment this if you want a more advanced table
        /*
        $(document).ready(function() {
            $('.data-table').DataTable({
                pageLength: 10,
                ordering: true,
                searching: false,
                paging: false,
                info: false
            });
        });
        */
    </script>
</body>
</html>