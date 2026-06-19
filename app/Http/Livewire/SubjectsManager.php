<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Subject;
use App\Models\FacultyInfo;
use Illuminate\Support\Facades\Auth;

class SubjectsManager extends Component
{
    public $subjects = [];
    public $facultyInfoId;
    public $subjectName = '';
    public $theoryCredit = 0;
    public $practicalCredit = 0;
    public $totalCredit = 0;

    protected $rules = [
        'subjectName' => 'required|string|max:255',
        'theoryCredit' => 'required|numeric|min:0|max:50',
        'practicalCredit' => 'required|numeric|min:0|max:50',
    ];

    public function mount($facultyInfoId)
    {
        $this->facultyInfoId = Auth::user()->id;
        $this->loadSubjects();
    }

    public function updatedTheoryCredit()
    {
        $this->calculateTotalCredit();
    }

    public function updatedPracticalCredit()
    {
        $this->calculateTotalCredit();
    }

    public function calculateTotalCredit()
    {
        $this->totalCredit = $this->theoryCredit + $this->practicalCredit;
    }

    public function addSubject()
    {
        $this->validate();

        Subject::create([
            'user_id' => Auth::id(),
            'faculty_info_id' => Auth::user()->id,
            'subject_name' => $this->subjectName,
            'theory_credit' => $this->theoryCredit,
            'practical_credit' => $this->practicalCredit,
            'total_credit' => $this->theoryCredit + $this->practicalCredit
        ]);

        $this->reset(['subjectName', 'theoryCredit', 'practicalCredit', 'totalCredit']);
        $this->loadSubjects();
        $this->dispatchBrowserEvent('subject-added', ['message' => 'Subject added successfully!']);
    }

    public function removeSubject($subjectId)
    {
        Subject::where('id', $subjectId)->where('user_id', Auth::id())->delete();
        $this->loadSubjects();
        $this->dispatchBrowserEvent('subject-removed', ['message' => 'Subject removed successfully!']);
    }

    public function loadSubjects()
    {
        $this->subjects = Subject::where('faculty_info_id', $this->facultyInfoId)
            ->where('user_id', Auth::id())
            ->get();
    }

    public function render()
    {
        return view('livewire.subjects-manager');
    }
}