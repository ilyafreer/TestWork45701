<?php

namespace App\Http\Controllers;

use App\Models\Profession;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfessionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            return Profession::all();
        }
        return view('profession');
    }

    /**
     * Show the form for creating a new resource.
     ** @return \Illuminate\Http\Response
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
        $result = false;
        try{
            if(self::isValid($request)){
                $profession = new Profession();
                $profession->fill($request->all());
                $result = $profession->save();
            }
        }catch (QueryException $e){
            $result = false;
        }
        return response()->json(['status'=>$result])->setStatusCode(200);
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
        $profession = Profession::find($id);
        if($profession && self::isValid($request)){
            $profession->fill($request->all());
            $result = $profession->save();
            return response()->json(['status'=>$result])->setStatusCode(200);
        }else{
            return response()->json(['status'=>false])->setStatusCode(200);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $profession = Profession::find($id);
        if($profession)
            $result = $profession->delete();
        else
            $result = false;

        return response()->json(['status'=>$result])->setStatusCode(200);
    }

    /**
     * Проверка валидности данных с клиентской части
     * @param Request $request
     * @return bool
     */
    public static function isValid(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'profession' => 'required|unique:professions|max:255',
            'published' => 'required',
        ]);

        if ($validator->fails()) {
            return false;
        }
        return true;
    }
}
