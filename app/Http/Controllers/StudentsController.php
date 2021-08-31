<?php

namespace App\Http\Controllers;

use App\Models\Students;
use Illuminate\Http\Request;
use App\Models\Universities;

class StudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Students::paginate(5);
        return view('students.index',compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $universities = Universities::all();
        return view('students.create',compact('universities'));
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
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'email|unique:students'
        ]);

        try {
            Students::create($request->all());

            return redirect()->route('students.index')->with('success', 'Student save successfull');
        } catch (\Exception $e) {
            return redirect()->route('students.index')->with('error',$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Students  $students
     * @return \Illuminate\Http\Response
     */
    public function show(Students $students)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Students  $students
     * @return \Illuminate\Http\Response
     */
    public function edit(Students $students, $id)
    {
        $student = $students->where('id',$id)->first();
        $universities = Universities::all();
        return view('students.edit',compact('student','universities'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Students  $students
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Students $students, $id)
    {
        $request->validate([
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'email|unique:students,email,'.$id
        ]);

        try {
            $student = $students->where('id',$id)->first();
            $input = $request->all();

            $student->update($input);

            return redirect()->route('students.index')->with('success', 'Student update successfull');
        } catch (\Exception $e) {
            return redirect()->route('students.index')->with('error',$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Students  $students
     * @return \Illuminate\Http\Response
     */
    public function destroy(Students $students, $id)
    {
        $students->destroy($id);
        return redirect()->route('students.index')->with('success', 'Student delete successfull');;
    }
}
