<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Admin\FacultyBT;
use App\Admin\AcademicYear;
use App\Admin\Department;
use Datatables;

class FacultyBTCardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $department = Department::all();
        if(request()->ajax()) 
        {
            // dd($request->academic);
            if($request->department)
            {
                $data = FacultyBT::where('department', $request->department)->get();
            }
            else{
                $data = FacultyBT::all();
                // dd($data);
            }
            return datatables()->of($data)
            ->addColumn('department', function(FacultyBT $facultyBT){
                return $facultyBT->faculty_department->department;
            })
            ->addColumn('action', 'auth.facultyBTCard.action')
            ->rawColumns(['department', 'action'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('auth.facultyBTCard.index', compact( 'department'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'BT_no' => 'required|unique:faculty_b_t_s',
            'name' => 'required', 
            'department' => 'required',
        ]);
        $id = mt_rand(100000,999999);
        $facultyBT = new FacultyBT();
        $facultyBT->BT_no = $request->BT_no;
        $facultyBT->name = $request->name;
        $facultyBT->department = $request->department;
        $facultyBT->designation = $request->designation;
        $facultyBT->save();
        return redirect('/admin/faculty-bt-card')->with('success', 'Faculty BT Card added successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $facultyBT = FacultyBT::findorfail($id);
        $department = Department::all();
        return view('auth.facultyBTCard.edit', compact('facultyBT', 'department'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'BT_no' => 'unique:faculty_b_t_s,BT_no,'.$id,
            'name' => 'required',
            'department' => 'required',
        ]);
        $facultyBT = FacultyBT::findorfail($id);
        $facultyBT->BT_no = $request->BT_no;
        $facultyBT->name = $request->name;
        $facultyBT->department = $request->department;
        $facultyBT->designation = $request->designation;
        $facultyBT->update($request->all());
        return redirect('/admin/faculty-bt-card')->with('success', 'Faculty BT Card updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $facultyBT = FacultyBT::findorfail($id);
        $facultyBT->delete();
        return redirect('/admin/faculty-bt-card')->with('success', 'Faculty BT Card deleted successfully!');
    }
}
