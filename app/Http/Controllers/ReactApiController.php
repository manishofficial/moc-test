<?php

namespace App\Http\Controllers;

use App\Models\ReactApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReactApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = ReactApi::get();

        return response()->json([
            'status' => true,
            'data' => $data,
            'msg' => 'Records found',
        ],200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Respcnonse
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
        $validator = Validator::make( $request->all(),[
            'phone' => 'required|digits:10',
            'store' => 'required',
            'file' => 'required'
        ]);

        if ( $validator->fails() ) {
            return response()->json([
                'status' => false,
                'data' => [],
                'msg' => $validator->errors()
            ]);
        }

        try {
            $input = $request->all();
            $record = ReactApi::where('phone', $request->phone)->first();
            if (empty($record)) {
                if ($image = $request->file('file')) {
                    $logoImg = date('YmdHis') . "." . $image->getClientOriginalExtension();
                    $folder = 'public/'.$request->phone.'/'.$request->store;
                    $request->file->storeAs($folder, $logoImg);
                    $input['file'] = [asset('storage').'/'.$request->phone.'/'.$request->store.'/'.$logoImg];
                }

                ReactApi::create($input);

                return response()->json([
                    'status' => true,
                    'data' => [],
                    'msg' => "Entry creted successful"
                ],200);
            }else {
                $files =  $record->file;
                if ($image = $request->file('file')) {
                    $logoImg = date('YmdHis') . "." . $image->getClientOriginalExtension();
                    $folder = 'public/'.$request->phone.'/'.$request->store;
                    $request->file->storeAs($folder, $logoImg);
                    $files[] = asset('storage').'/'.$request->phone.'/'.$request->store.'/'.$logoImg;
                }

                $record->update(['file'=> $files]);

                return response()->json([
                    'status' => true,
                    'data' => [],
                    'msg' => "Entry found with number so file update successful"
                ],200);
            }
        } catch ( \Exception $e ) {
            return response()->json([
                'status' => false,
                'data' => [],
                'msg' => $e->getMessage()
            ],500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ReactApi  $reactApi
     * @return \Illuminate\Http\Response
     */
    public function show(ReactApi $reactApi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ReactApi  $reactApi
     * @return \Illuminate\Http\Response
     */
    public function edit(ReactApi $reactApi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ReactApi  $reactApi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReactApi $reactApi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ReactApi  $reactApi
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReactApi $reactApi)
    {
        //
    }

    public function search($phone)
    {
        $data = ReactApi::where('phone','like','%'.$phone.'%')->get();
        if (empty($data->count())) {
            return response()->json([
                'status' => false,
                'data' => [],
                'msg' => 'record not found'
            ],200);
        }
        return response()->json([
            'status' => true,
            'data' => $data,
            'msg' => 'record found'
        ],200);
    }
}
