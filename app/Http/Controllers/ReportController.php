<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\UserMap;
use App\Models\Location;
use App\Models\Subject;
use App\Exports\FacultyExport;
use App\Exports\UserExport;
use App\Exports\LocationExport;
use Maatwebsite\Excel\Facades\Excel;


class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('report/index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function faculties()
    {
        $users = User::where('type','Faculty')->paginate(10);
        //$user_map = MapUser::where();
        return view('report/faculties',[
            'users'=>$users    
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function searchuser(Request $request)
    {
        $users = User::where('type','Faculty')->where('name','LIKE','%'.$request->search.'%')->orWhere('email','LIKE','%'.$request->search.'%')->paginate(10);
        return view('report/faculties',[
            'users'=>$users    
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function location()
    {
        $location = Location::all();
        return view('report/location',[
            'location'=>$location    
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function exportfaculty()
    {
        return Excel::download(new FacultyExport, 'facultiesreport.xlsx');
    }

    /**
     * Update the specified resource in storage.
     */
    public function exportlocation()
    {
        return Excel::download(new LocationExport, 'locationreport.xlsx');
    }
    
    public function exportuser()
    {
        return Excel::download(new UserExport, 'userreport.xlsx');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function users()
    {
        $users = User::where('type','!=','Faculty')->where('type','!=','SU')->paginate(10);
        //$user_map = MapUser::where();
        return view('report/users',[
            'users'=>$users    
        ]);
    }
    
    public function searchuserx(Request $request)
    {
        $users = User::where('type','!=','Faculty')->where('type','!=','SU')->where('name','LIKE','%'.$request->search.'%')->orWhere('email','LIKE','%'.$request->search.'%')->paginate(10);
        return view('report/users',[
            'users'=>$users    
        ]);
    }

    public function facultyinfo(Request $request){
        $query = User::where('type','Faculty')->with(['subjects', 'irProjects', 'erProjects', 'loc']);

        // Search by faculty name or email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by college/location
        if ($request->filled('college')) {
            $college = $request->college;
            $query->whereHas('loc', function ($q) use ($college) {
                $q->where('location', $college);
            });
        }
        
        // Check if export is requested
        if ($request->has('export') && $request->export == 'excel') {
            return Excel::download(new FacultyInfoExport($request), 'faculty-info-' . date('Y-m-d') . '.xlsx');
        }
        
        $faculties = $query->orderBy('created_at', 'desc')->paginate(10);
        $all_users = $query->orderBy('created_at', 'desc')->get();
        // Get unique colleges for dropdown
        $colleges = Location::all();

        return view('report.faculty-info', compact('faculties', 'colleges','all_users'));
    }

    public function show($id)
    {
        // Check if user is admin
        if (Auth::user()->type !== 'SU') {
            abort(403, 'Unauthorized access.');
        }

         $faculty = User::with(['subjects', 'irProjects', 'erProjects'])
                              ->findOrFail($id);

        return view('report.faculty-details', compact('faculty'));
    }
}
