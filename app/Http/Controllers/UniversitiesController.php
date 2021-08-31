<?php

namespace App\Http\Controllers;

use App\Models\Universities;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Mail;

class UniversitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $universities = Universities::paginate(5);
        return view('universities.index',compact('universities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('universities.create');
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
            'name' => 'required|string',
            'email' => 'email|unique:universities',
            'website' => 'url',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|dimensions:min_width=100,min_height=100'
        ]);

        try {
            $input = $request->all();

            if ($image = $request->file('logo')) {
                $logoImg = date('YmdHis') . "." . $image->getClientOriginalExtension();
                $request->logo->storeAs('public', $logoImg);
                $input['image'] = "$logoImg";
            }

            Universities::create($input);
            // 'matrixmtestcandidate@mailinator.com'

            Mail::to('matrixmtestcandidate@yopmail.com')->send(new \App\Mail\UniversityMail($request->name));

            return redirect()->route('universities.index')->with('success', 'university save successfull');
        } catch ( \Exception $e ) {
            return redirect()->route('universities.index')->with('error',$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Universities  $universities
     * @return \Illuminate\Http\Response
     */
    public function show(Universities $universities)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Universities  $universities
     * @return \Illuminate\Http\Response
     */
    public function edit(Universities $universities,$id)
    {
        $university = $universities->where('id',$id)->first();
        return view('universities.edit',compact('university'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Universities  $universities
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Universities $universities, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'email|unique:universities,email,'.$id,
            'website' => 'url',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|dimensions:min_width=100,min_height=100'
        ]);

        try{
            $university = $universities->where('id',$id)->first();
            $input = $request->all();

            if ($image = $request->file('logo')) {
                $logoImg = date('YmdHis') . "." . $image->getClientOriginalExtension();
                $request->logo->storeAs('public', $logoImg);
                $input['logo'] = "$logoImg";
            }

            $university->update($input);

            return redirect()->route('universities.index')->with('success', 'university update successfull');
        } catch ( \Exception $e ) {
            return redirect()->route('universities.index')->with('error',$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Universities  $universities
     * @return \Illuminate\Http\Response
     */
    public function destroy(Universities $universities, $id)
    {
        $universities->destroy($id);
        return redirect()->route('universities.index')->with('success', 'university delete successfull');
    }
}
