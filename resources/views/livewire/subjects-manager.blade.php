<div>
    <div class="mb-3">
        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#subjectModal">
            + Add New Subject
        </button>
    </div>

    <div class="table-responsive">
        <table class="table table-sm table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Subject Name</th>
                    <th>Theory Credit</th>
                    <th>Practical Credit</th>
                    <th>Total Credit</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($subjects as $subject)
                    <tr>
                        <td>{{ $subject->subject_name }}</td>
                        <td>{{ $subject->theory_credit }}</td>
                        <td>{{ $subject->practical_credit }}</td>
                        <td><strong>{{ $subject->total_credit }}</strong></td>
                        <td>
                            <button class="btn btn-danger btn-sm" wire:click="removeSubject({{ $subject->id }})" 
                                    onclick="return confirm('Are you sure?')">
                                Remove
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No subjects added yet</td>
                    </tr>
                @endforelse
            </tbody>
            @if($subjects->count() > 0)
                <tfoot class="table-secondary">
                    <tr>
                        <th colspan="3" class="text-end">Total Credit Hours:</th>
                        <th colspan="2">{{ $subjects->sum('total_credit') }}</th>
                    </tr>
                </tfoot>
            @endif
        </table>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="subjectModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Subject</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Subject Name</label>
                        <input type="text" class="form-control" wire:model.defer="subjectName">
                        @error('subjectName') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Theory Credit</label>
                            <input type="number" step="0.5" class="form-control" wire:model.defer="theoryCredit">
                            @error('theoryCredit') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Practical Credit</label>
                            <input type="number" step="0.5" class="form-control" wire:model.defer="practicalCredit">
                            @error('practicalCredit') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" wire:click="addSubject" data-bs-dismiss="modal">Add Subject</button>
                </div>
            </div>
        </div>
    </div>
</div>