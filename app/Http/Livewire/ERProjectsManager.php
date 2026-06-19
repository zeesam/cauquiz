<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ERProject;
use App\Models\FacultyInfo;
use Illuminate\Support\Facades\Auth;

class ERProjectsManager extends Component
{
    public $projects = [];
    public $facultyInfoId;
    public $projectName = '';
    public $sponsoringAgency = '';
    public $sanctionedYear = '';
    public $duration = '';
    public $status = '';
    public $amount = 0;

    protected function rules(){
        return [
            'projectName' => 'required|string|max:255',
            'sponsoringAgency' => 'required|string|max:255',
            'sanctionedYear'    => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'duration' => 'required|string|max:50',
            'status' => 'required|in:Applied,Ongoing,Completed',
            'amount' => 'required|numeric|min:0',
        ];
    }

    public function mount($facultyInfoId)
    {
        $this->facultyInfoId = $facultyInfoId;
        $this->sanctionedYear = date('Y');
        $this->status = 'Applied';
        $this->loadProjects();
    }

    public function addProject()
    {
        $this->validate();

        ERProject::create([
            'user_id' => Auth::id(),
            'faculty_info_id' => $this->facultyInfoId,
            'project_name' => $this->projectName,
            'sponsoring_agency' => $this->sponsoringAgency,
            'sanctioned_year' => $this->sanctionedYear,
            'duration' => $this->duration,
            'status' => $this->status,
            'amount' => $this->amount
        ]);

        $this->reset(['projectName', 'sponsoringAgency', 'duration', 'amount']);
        $this->sanctionedYear = date('Y');
        $this->status = 'Applied';
        $this->loadProjects();
        $this->dispatchBrowserEvent('project-added', ['message' => 'ER Project added successfully!']);
    }

    public function removeProject($projectId)
    {
        ERProject::where('id', $projectId)->where('user_id', Auth::id())->delete();
        $this->loadProjects();
        $this->dispatchBrowserEvent('project-removed', ['message' => 'ER Project removed successfully!']);
    }

    public function loadProjects()
    {
        $this->projects = ERProject::where('faculty_info_id', $this->facultyInfoId)
            ->where('user_id', Auth::id())
            ->get();
    }

    public function render()
    {
        return view('livewire.e-r-projects-manager');
    }
}