<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Modules;

class ModulesController extends Controller
{
   // public function __construct() {
   //      $this->middleware(['auth', 'clearance']);
   //  }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $module = Modules::all();
        return view('Modules.index',compact('module'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Modules.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	$this->validate($request, [
            'name' => 'required|unique:modules',
          ]);

        $module = new Modules();
        $module->name = $request->name;
        $module->save();
        return redirect()->route('modules');
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
        $module = Modules::find($id);
        return view('Modules.edit',compact('module'));
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
        $module = Modules::find($id);
        if($module->name != $request->name){
        	$this->validate($request, [
            'name' => 'required|unique:modules',
          ]);
        }
        $module->name = $request->name;
        $module->update();

        return redirect()->route('modules');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Modules::find($id)->delete();
        return redirect()->route('modules');
    }

}
