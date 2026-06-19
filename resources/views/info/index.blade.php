@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Main Card -->
                <div class="card">
                    <div class="card-header text-center">
                        <img src="https://cau.ac.in/wp-content/uploads/2020/12/NewCAULogo.gif" height="80px" class="mb-2">
                        <h3 class="mb-0">Faculty Information System</h3>
                        <p class="mb-0 opacity-75">Central Agricultural University, Imphal</p>
                        <p class="mb-0 opacity-75">Information Provided by Dr. Narmada Hidangmayum</p>
                    </div>
                    
                    <div class="card-body">
                       Name: {{$user->name}}
                    </div>
                </div>
                
                <!-- Subjects, IRP, ERP Tabs -->
                @if(isset($user))
                    <div class="card">
                        <div class="card-header">
                            <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="subjects-tab" data-bs-toggle="tab" data-bs-target="#subjects" type="button" role="tab">
                                        <i class="fas fa-book"></i> Subjects Offered
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="irp-tab" data-bs-toggle="tab" data-bs-target="#irp" type="button" role="tab">
                                        <i class="fas fa-flask"></i> IRP Details
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="erp-tab" data-bs-toggle="tab" data-bs-target="#erp" type="button" role="tab">
                                        <i class="fas fa-microscope"></i> ERP Details
                                    </button>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="subjects" role="tabpanel">
                                    @livewire('subjects-manager', ['facultyInfoId' => $user->id])
                                </div>
                                <div class="tab-pane fade" id="irp" role="tabpanel">
                                    @livewire('i-r-projects-manager', ['facultyInfoId' => $user->id])
                                </div>
                                <div class="tab-pane fade" id="erp" role="tabpanel">
                                    @livewire('e-r-projects-manager', ['facultyInfoId' => $user->id])
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                
                <!-- My Submissions Table
                @if(isset($user) && $user->subjects->count() > 0)
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-chart-line"></i> My Academic Summary</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="card bg-primary text-white">
                                        <div class="card-body">
                                            <h6 class="card-title">Total Credit Hours</h6>
                                            <h3>{{ $user->total_credit_hours ?? " " }}</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="card bg-success text-white">
                                        <div class="card-body">
                                            <h6 class="card-title">IR Projects</h6>
                                            <h3>{{ $facultyInfo->irp_count ?? "" }} (₹{{ number_format(optional($facultyInfo)->total_irp, 2) }})</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="card bg-info text-white">
                                        <div class="card-body">
                                            <h6 class="card-title">ER Projects</h6>
                                            <h3>{{ $facultyInfo->erp_count ?? "" }} (₹{{ number_format(optional($facultyInfo)->total_erp, 2) }})</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                 -->
            </div>
        </div>
    </div>
    
    <!-- Scripts -->
    
    <script>
        
        // Livewire event listeners
        Livewire.on('subject-added', (data) => {
            // Optionally show toast notification
        });
        
        Livewire.on('project-added', (data) => {
            // Optionally show toast notification
        });
    </script>
@endsection