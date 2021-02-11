<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Admin\DepartmentLibrary;
use App\Admin\Department;
use App\Admin\StudentBook;
use App\Admin\LibraryBook;
use Redirect;

class DepartmentLibraryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $department = Department::orderBy('id', 'DESC')->get();
      
        return view('auth.departmentLibrary.index', compact('department'));
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
            'book_code' => 'required',
        ]);
        if($request->category == "p"){
            $checkBookAvailability = LibraryBook::where('book_no', $request->book_code)->first();
            if($checkBookAvailability->book_status == 1)
            {
                $departmentBook = new DepartmentLibrary();
                $departmentBook->book_no = $request->book_code;
                $departmentBook->department_id = $request->department_id;
                $departmentBook->category = $request->category;
                $departmentBook->allocation_date = date('Y-m-d');
                $departmentBook->save();
                if($departmentBook->save())
                {
                    $changeBookStatus = LibraryBook::where('book_no', $request->book_code)->update(['book_status' => 0]);
                }
                return response()->json(['success' => 'Book is Alloted to Department']);
            }
            else{
                return response()->json(['error' => 'Book is not Available']);
            }
        }
        if($request->category == "g")
        {
            $checkBookAvailability = StudentBook::where('book_no', $request->book_code)->first();
            if($checkBookAvailability->book_status == 1)
            {
                $departmentBook = new DepartmentLibrary();
                $departmentBook->book_no = $request->book_code;
                $departmentBook->department_id = $request->department_id;
                $departmentBook->category = $request->category;
                $departmentBook->allocation_date = date('Y-m-d');
                $departmentBook->save();
                if($departmentBook->save())
                {
                    $changeBookStatus = StudentBook::where('book_no', $request->book_code)->update(['book_status' => 0]);
                }
                return response()->json(['success' => 'Book is Alloted to Department']);
            }
            else{
                return response()->json(['error' => 'Book is not Available']);
            }
        }
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function viewDepartmentBook($id, Request $request)
    {
        $department = Department::findorfail($id);
        $departmentBook = DepartmentLibrary::where('department_id', $id)->where('category', '=', 'p')->orderBy('book_no', 'ASC')->get();
        $generalDepartmentBook = DepartmentLibrary::where('department_id', $id)->where('category', '=', 'g')->orderBy('book_no', 'ASC')->get();
        if(request()->ajax()) {
            if($request->category == "g"){
            return datatables()->of($generalDepartmentBook)
            ->addColumn('book_name', function(DepartmentLibrary $department){
                if($department->book_name->book_name){
                return $department->book_name->book_name;
                }
            })
            ->addColumn('action', 'auth.departmentLibrary.action')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }
        }
        if(request()->ajax()) {
            if($request->category1 == "p"){
            return datatables()->of($departmentBook)
            ->addColumn('book_name', function(DepartmentLibrary $department){
                if($department->pustak_pedhi->book_name){
                return $department->pustak_pedhi->book_name;
                }
            })
            ->addColumn('action', 'auth.departmentLibrary.actionP')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
            }
        }
        return view('auth.departmentLibrary.view', compact('department', 'departmentBook', 'generalDepartmentBook'));
    }

    public function getGeneralBook(Request $request)
    {
        $departmentBook = DepartmentLibrary::where('id', $request->bid)->first();
        if (!empty($departmentBook)) 
        {
            $data = array('id' =>$departmentBook->id,'book_no' =>$departmentBook->book_no,'allocation_date'=>$departmentBook->allocation_date
            );
        }else{
            $data =0;
        }
        echo json_encode($data);
    }

    public function updateGeneralBook(Request $request)
    {
        $dBook = DepartmentLibrary::where('id', $request->id)->first();
        // return $departmentBook;
        if($request->book_no != $dBook->book_no)
        {
            $studentBook = StudentBook::where('book_no', $dBook->book_no)->update(['book_status' => 1]);
            $checkBookAvailability = StudentBook::where('book_no', $request->book_no)->first();
            if($checkBookAvailability->book_status == 1)
            {
                $input_data = array (
                    'book_no' => $request->book_no,
                    'allocation_date' => $request->allocation_date,
                );
                $result = DepartmentLibrary::whereId($dBook->id)->update($input_data);
                if($result)
                {
                    $updateBook = StudentBook::where('book_no', $request->book_no)->update(['book_status' => 0]);
                }
                return response()->json(['success' => 'Record Updated Successfully']);
            }
            else{
                return response()->json(['error' => 'Book is not Available']);
            }
        }
        else{
            $input_data = array (
                'book_no' => $dBook->book_no,
                'allocation_date' => $request->allocation_date,
            );
            $result1 = DepartmentLibrary::whereId($dBook->id)->update($input_data);
            if($result1)
            {
                $updateBook = StudentBook::where('book_no', $dBook->book_no)->update(['book_status' => 0]);
            }
            return response()->json(['success' => 'Record Updated Successfully']);
        }    
    }

    public function departmentRecordDelete($id)
    {
        $departmentBook = DepartmentLibrary::findorfail($id);
        if($departmentBook->category == "g"){
            $updateBook = StudentBook::where('book_no', $departmentBook->book_no)->update(['book_status' => 1]);
        }
        if($departmentBook->category == "p"){
            $updateBook = LibraryBook::where('book_no', $departmentBook->book_no)->update(['book_status' => 1]);
        }
        $departmentBook->delete();
        return response()->json(['success' => 'Record Deleted Successfully']);
    }

    public function getPustakBook(Request $request)
    {
        $departmentBook = DepartmentLibrary::where('id', $request->bid)->first();
        if (!empty($departmentBook)) 
        {
            $data = array('id' =>$departmentBook->id,'book_no' =>$departmentBook->book_no,'allocation_date'=>$departmentBook->allocation_date
            );
        }else{
            $data =0;
        }
        echo json_encode($data);
    }

    public function updatePustakBook(Request $request)
    {
        $dBook = DepartmentLibrary::where('id', $request->id)->first();
        // return $departmentBook;
        if($request->book_no != $dBook->book_no)
        {
            $studentBook = LibraryBook::where('book_no', $dBook->book_no)->update(['book_status' => 1]);
            $checkBookAvailability = LibraryBook::where('book_no', $request->book_no)->first();
            if($checkBookAvailability->book_status == 1)
            {
                $input_data = array (
                    'book_no' => $request->book_no,
                    'allocation_date' => $request->allocation_date,
                );
                $result = DepartmentLibrary::whereId($dBook->id)->update($input_data);
                if($result)
                {
                    $updateBook = LibraryBook::where('book_no', $request->book_no)->update(['book_status' => 0]);
                }
                return response()->json(['success' => 'Record Updated Successfully']);
            }
            else{
                return response()->json(['error' => 'Book is not Available']);
            }
        }
        else{
            $input_data = array (
                'book_no' => $dBook->book_no,
                'allocation_date' => $request->allocation_date,
            );
            $result1 = DepartmentLibrary::whereId($dBook->id)->update($input_data);
            if($result1)
            {
                $updateBook = LibraryBook::where('book_no', $dBook->book_no)->update(['book_status' => 0]);
            }
            return response()->json(['success' => 'Record Updated Successfully']);
        } 
    }
}
