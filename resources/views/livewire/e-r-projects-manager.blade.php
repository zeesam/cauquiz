<div>
    <div class="mb-3">
        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#erProjectModal">
            + Add ER Project
        </button>
    </div>

    <div class="table-responsive">
        <table class="table table-sm table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Project Name</th>
                    <th>Sponsoring Agency</th>
                    <th>Year</th>
                    <th>Duration</th>
                    <th>Status</th>
                    <th>Amount</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($projects as $project)
                    <tr>
                        <td>{{ $project->project_name }}</td>
                        <td>{{ $project->sponsoring_agency }}</td>
                        <td>{{ $project->sanctioned_year }}</td>
                        <td>{{ $project->duration }}</td>
                        <td>
                            <span class="badge bg-{{ $project->status == 'Completed' ? 'success' : ($project->status == 'Ongoing' ? 'warning' : 'info') }}">
                                {{ $project->status }}
                            </span>
                        </td>
                        <td>₹{{ number_format($project->amount, 2) }}</td>
                        <td>
                            <button class="btn btn-danger btn-sm" wire:click="removeProject({{ $project->id }})"
                                    onclick="return confirm('Are you sure?')">
                                Remove
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No IR projects added yet</td>
                    </tr>
                @endforelse
            </tbody>
            @if($projects->count() > 0)
                <tfoot class="table-secondary">
                    <tr>
                        <th colspan="5" class="text-end">Total IRP Amount:</th>
                        <th colspan="2">₹{{ number_format($projects->sum('amount'), 2) }}</th>
                    </tr>
                </tfoot>
            @endif
        </table>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="erProjectModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Extramural Research Project</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Project Name</label>
                        <input type="text" class="form-control" wire:model.defer="projectName">
                        @error('projectName') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Sponsoring Agency</label>
                        <input type="text" class="form-control" wire:model.defer="sponsoringAgency">
                        @error('sponsoringAgency') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Sanctioned Year</label>
                            <input type="number" class="form-control" wire:model.defer="sanctionedYear">
                            @error('sanctionedYear') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Duration</label>
                            <input type="text" class="form-control" wire:model.defer="duration" placeholder="e.g., 2 years">
                            @error('duration') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-control" wire:model.defer="status">
                                <option value="Applied">Applied</option>
                                <option value="Ongoing">Ongoing</option>
                                <option value="Completed">Completed</option>
                            </select>
                            @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Amount (₹)</label>
                            <input type="number" step="0.01" class="form-control" wire:model.defer="amount">
                            @error('amount') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" wire:click="addProject" data-bs-dismiss="modal">Add Project</button>
                </div>
            </div>
        </div>
    </div>
</div>