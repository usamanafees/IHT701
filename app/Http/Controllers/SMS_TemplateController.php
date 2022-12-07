<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SMS_Templates;
use Auth;

class SMS_TemplateController extends Controller
{
    public function index()
    {
         $sms_template;
            if(in_array("Administrator" , Auth::user()->roles()->pluck('name')->toArray()))
            {
                $sms_template = SMS_Templates::all();
            }else
            {
            $sms_template = SMS_Templates::where('user_id',Auth::user()->id)->get();
            }
                  return view('sms.templates.list',compact('sms_template'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sms.templates.create');
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
            'name' => 'required|unique:sms_templates',
            'template' => 'required'
          ]);

        $sms_template = new SMS_Templates();
        $sms_template->name = $request->name;
        $sms_template->template = $request->template;
        $sms_template->user_id = Auth::user()->id;
        $sms_template->save();

        return redirect()->route('template');
        
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
        $template = SMS_Templates::find($id);
        return view('sms.templates.edit',compact('template'));
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
        $sms_template = SMS_Templates::find($id);

        if($sms_template->name != $request->name){

        	$this->validate($request, [
            'name' => 'required|unique:sms_templates',
          ]);

        }

        $sms_template->name = $request->name;
        $sms_template->template = $request->template;
        $sms_template->user_id = Auth::user()->id;
        $sms_template->save();
        $sms_template->update();

        return redirect()->route('template');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        SMS_Templates::find($id)->delete();
        return redirect()->route('sms_templates');
    }
}
